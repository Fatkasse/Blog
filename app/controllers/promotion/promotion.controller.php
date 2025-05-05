<?php
namespace App\Controllers\Promotion;
require_once __DIR__ ."/../../models/promotion/promotion.model.php";
require_once __DIR__ ."/../controller.php";
require_once __DIR__ ."/../../models/statistique/stats.model.php";
use App\Enums\SESSION;
use App\Enums\NAME_FUNCTION;
use App\Enums\VALIDATOR;

use function App\Controllers\BaseControllers\redirect_to;
use function App\Controllers\BaseControllers\runder_view;
use function App\Controllers\BaseControllers\runder_single_views;


function runder_promotion(){

    global $SessionService;

    $action = $SessionService[SESSION::REQUETE->value]('action',"default");

    match($action){
        "changer_status" => changer_status(),
        "rechercher_grid" => rechercher_par_nom_grid(),
        "rechercher_liste" => rechercher_par_nom_liste(),
        "lister" => liste_promotions(),
        "creation_page" => creation_page(),
        "ajouter" => ajouter_promotions(),
        "affectation"  =>  affectation(),
        default => grid_promotions() ,
    };
}

function liste_promotions(): void {
    global $PromotionServices, $SessionService, $LoginService, $StatistiqueService, $ReferentielServices;
    
    $promotions_all = $PromotionServices[NAME_FUNCTION::LISTE_PROMOTIONS->value]();
    
    $status_filter = $SessionService[SESSION::GET->value]('status', '');
    $query = $SessionService[SESSION::GET->value]('query', '');
    $referentiel_filter = $SessionService[SESSION::GET->value]('referentiel', '');
    
    if ($status_filter === 'active' || $status_filter === 'inactive') {
        $promotions_all = array_filter($promotions_all, function($promo) use ($status_filter) {
            return $promo['status'] === $status_filter;
        });
    }
    
    if (!empty($query)) {
        $promotions_all = array_filter($promotions_all, function($promo) use ($query) {
            return stripos($promo['nom'], $query) !== false;
        });
    }
    
    if (!empty($referentiel_filter)) {
        $promotions_all = array_filter($promotions_all, function($promo) use ($referentiel_filter) {
            if (isset($promo['referentiels']) && is_array($promo['referentiels'])) {
                return in_array($referentiel_filter, $promo['referentiels']);
            }
            return false;
        });
    }
    
    $promotions_all = array_values($promotions_all);
    
    usort($promotions_all, function($a, $b) {
        if ($a['status'] === 'active' && $b['status'] !== 'active') return -1;
        if ($a['status'] !== 'active' && $b['status'] === 'active') return 1;
        return strcmp($a['nom'], $b['nom']);
    });
    
    $par_page = 4;
    $total_promotions = count($promotions_all);
    $total_pages = max(1, ceil($total_promotions / $par_page));
    
    $page = $SessionService[SESSION::GET->value]('page', '1');
    $page_actuelle = is_numeric($page) ? (int)$page : 1;
    $page_actuelle = max(1, min($total_pages, $page_actuelle));
    
    $actives_count = count(array_filter($promotions_all, function($promo) {
        return $promo['status'] === 'active';
    }));
    
    $promotions = [];
    
    if ($status_filter !== 'inactive' && $actives_count > 0) {
        $actives = array_filter($promotions_all, function($promo) {
            return $promo['status'] === 'active';
        });
        
        $promotions = array_merge($promotions, array_values($actives));
    }
    
    $remaining_slots = $par_page - count($promotions);
    
    if ($remaining_slots > 0) {
        $inactives = array_filter($promotions_all, function($promo) {
            return $promo['status'] !== 'active';
        });
        
        $inactives_start = ($page_actuelle - 1) * $remaining_slots;
        
        $inactives_to_show = array_slice(array_values($inactives), $inactives_start, $remaining_slots);
        $promotions = array_merge($promotions, $inactives_to_show);
    }
    
    $inactives_count = count(array_filter($promotions_all, function($promo) {
        return $promo['status'] !== 'active';
    }));
    
    if ($actives_count > 0 && $status_filter !== 'inactive') {
        $total_pages = max(1, ceil($inactives_count / $remaining_slots));
    }
    
    $pages = range(1, $total_pages);
    
    $start_index = ($page_actuelle - 1) * $par_page + 1;
    $end_index = min($start_index + count($promotions) - 1, $total_promotions);
    
    $pagination = [
        'page_actuelle' => $page_actuelle,
        'total_pages' => $total_pages,
        'precedente' => $page_actuelle > 1 ? $page_actuelle - 1 : null,
        'suivante' => $page_actuelle < $total_pages ? $page_actuelle + 1 : null,
        'pages' => $pages,
        'start' => $total_promotions > 0 ? $start_index : 0,
        'end' => $end_index,
        'total' => $total_promotions,
        'par_page' => $par_page,
    ];
    
    $user = $LoginService[NAME_FUNCTION::RECUPERER_USER->value]();
    $stats = $StatistiqueService[NAME_FUNCTION::CALCULER_STATISTIQUES_PROMOTION_ACTIVE->value]();
    $nomPromoActive = $StatistiqueService[NAME_FUNCTION::RECUPERER_NOM_PROMO_ACTIVE->value]();
    $referentiels = $ReferentielServices[NAME_FUNCTION::LISTER_REFERENTIELS->value]();
    
    runder_view("base.layout.php", "promotions/list.promotion.php", [
        'promotions' => $promotions,
        'pagination' => $pagination,
        'user' => $user,
        'stats' => $stats,
        'nomPromoActive' => $nomPromoActive,
        'status_filter' => $status_filter,
        'query' => $query,
        'referentiel_filter' => $referentiel_filter,
        'referentiels' => $referentiels,
        'current_action' => 'lister'
    ]);
}

function grid_promotions(): void {
    global $PromotionServices, $SessionService, $LoginService, $StatistiqueService;
    
    $promotions_all = $PromotionServices[NAME_FUNCTION::LISTE_PROMOTIONS->value]();
    
    $status_filter = $SessionService[SESSION::GET->value]('status', '');
    $query = $SessionService[SESSION::GET->value]('query', '');
    
    if ($status_filter === 'active' || $status_filter === 'inactive') {
        $promotions_all = array_filter($promotions_all, function($promo) use ($status_filter) {
            return $promo['status'] === $status_filter;
        });
    }
    
    if (!empty($query)) {
        $promotions_all = array_filter($promotions_all, function($promo) use ($query) {
            return stripos($promo['nom'], $query) !== false;
        });
    }
        $promotions_all = array_values($promotions_all);
    
    usort($promotions_all, function($a, $b) {
        if ($a['status'] === 'active' && $b['status'] !== 'active') return -1;
        if ($a['status'] !== 'active' && $b['status'] === 'active') return 1;
        return strcmp($a['nom'], $b['nom']);
    });
    
    $par_page = 5;
    $total_promotions = count($promotions_all);
    $total_pages = max(1, ceil($total_promotions / $par_page));
    
    $page = $SessionService[SESSION::GET->value]('page', '1');
    $page_actuelle = is_numeric($page) ? (int)$page : 1;
    $page_actuelle = max(1, min($total_pages, $page_actuelle));
    
    $actives_count = count(array_filter($promotions_all, function($promo) {
        return $promo['status'] === 'active';
    }));
    
    $promotions = [];
    
    if ($status_filter !== 'inactive' && $actives_count > 0) {
        $actives = array_filter($promotions_all, function($promo) {
            return $promo['status'] === 'active';
        });
        
        $promotions = array_merge($promotions, array_values($actives));
    }
    
    $remaining_slots = $par_page - count($promotions);
    
    if ($remaining_slots > 0) {
        $inactives = array_filter($promotions_all, function($promo) {
            return $promo['status'] !== 'active';
        });
        
        $inactives_start = ($page_actuelle - 1) * $remaining_slots;
        
        $inactives_to_show = array_slice(array_values($inactives), $inactives_start, $remaining_slots);
        $promotions = array_merge($promotions, $inactives_to_show);
    }
    
    $pages = range(1, $total_pages);
    
    $start_index = ($page_actuelle - 1) * $par_page + 1;
    $end_index = min($start_index + count($promotions) - 1, $total_promotions);
    
    $pagination = [
        'page_actuelle' => $page_actuelle,
        'total_pages' => $total_pages,
        'precedente' => $page_actuelle > 1 ? $page_actuelle - 1 : null,
        'suivante' => $page_actuelle < $total_pages ? $page_actuelle + 1 : null,
        'pages' => $pages,
        'start' => $total_promotions > 0 ? $start_index : 0,
        'end' => $end_index,
        'total' => $total_promotions,
        'par_page' => $par_page,
    ];
    
    $user = $LoginService[NAME_FUNCTION::RECUPERER_USER->value]();
    $stats = $StatistiqueService[NAME_FUNCTION::CALCULER_STATISTIQUES_PROMOTION_ACTIVE->value]();
    $nomPromoActive = $StatistiqueService[NAME_FUNCTION::RECUPERER_NOM_PROMO_ACTIVE->value]();
    
    runder_view("base.layout.php", "promotions/grid.promotion.php", [
        'promotions' => $promotions,
        'pagination' => $pagination,
        'user' => $user,
        'stats' => $stats,
        'nomPromoActive' => $nomPromoActive,
        'status_filter' => $status_filter,
        'query' => $query,
        'current_action' => 'grid'
    ]);
}

function creation_page():void{
    global $ReferentielServices;
    $referentiels = $ReferentielServices[NAME_FUNCTION::LISTER_REFERENTIELS->value]();

    
    runder_view("base.layout.php", "promotions/form.promotion.php", [
        'referentiels' => $referentiels ,
    ]);
   
}


function affecter():void{
    global $ReferentielServices;
    $referentiels = $ReferentielServices[NAME_FUNCTION::LISTER_REFERENTIELS->value]();

    
    runder_view("base.StatistiqueServiceStatistiqueServiceStatistiqueService.php", "referentiel/form.referentiel.php", [
        'referentiels' => $referentiels ,
    ]);
   
}

function ajouter_promotions(){
    global $SessionService, $PromotionServices, $ValidatorService, $ReferentielServices;

    $nom = $SessionService[SESSION::POST->value]("nom", "");
    $dateDebut = $SessionService[SESSION::POST->value]("date-debut", "");
    $dateFin = $SessionService[SESSION::POST->value]("date-fin", "");
    $status = "inactive";
    $refText = $SessionService[SESSION::POST->value]("referentiel", []);
    $refs = [];
    
    $allReferentiels = $ReferentielServices[NAME_FUNCTION::LISTER_REFERENTIELS->value]();
    
    if (!empty($refText) && is_array($refText)) {
        foreach ($refText as $refNom) {
            $match = array_filter($allReferentiels, fn($ref) => strcasecmp($ref['nom'], $refNom) === 0);
            if (!empty($match)) {
                $refs[] = array_values($match)[0]['nom'];
            }
        }
    }

    $photoPath = $ValidatorService[VALIDATOR::VALIDATE_PROMOTION_FORM->value]($nom, $dateDebut, $dateFin);

    if ($photoPath !== null) {
        $apprenants = 0;
        $PromotionServices[NAME_FUNCTION::AJOUTER_PROMOTIONS->value]($nom, $dateDebut, $dateFin, $photoPath, $status, $refs, $apprenants);
        redirect_to('index.php?menu=promotion');
        exit;
    } else {
        $referentiels = $ReferentielServices[NAME_FUNCTION::LISTER_REFERENTIELS->value]();
        runder_single_views("promotions/form.promotion.php", [
            "old" => compact("nom", "dateDebut", "dateFin"),
            "referentiels" => $referentiels
        ]);
    }
}
function rechercher_par_nom_grid() {
    global $PromotionServices, $SessionService, $LoginService, $StatistiqueService;
    
    $query = isset($_GET['query']) ? trim($_GET['query']) : '';
    $status_filter = isset($_GET['status']) ? trim($_GET['status']) : '';
    
    $promotions_all = $PromotionServices[NAME_FUNCTION::LISTE_PROMOTIONS->value]();
    
    if (!empty($query)) {
        $promotions_all = array_filter($promotions_all, function($promo) use ($query) {
            return stripos($promo['nom'], $query) !== false;
        });
    }
    
    if ($status_filter === 'active' || $status_filter === 'inactive') {
        $promotions_all = array_filter($promotions_all, function($promo) use ($status_filter) {
            return $promo['status'] === $status_filter;
        });
    }
    
    usort($promotions_all, function($a, $b) {
        if ($a['status'] === 'active' && $b['status'] !== 'active') return -1;
        if ($a['status'] !== 'active' && $b['status'] === 'active') return 1;
            return strcmp($a['nom'], $b['nom']);
    });
    
    $promotions_all = array_values($promotions_all);
    
    $par_page = 3;
    $total_promotions = count($promotions_all);
    $total_pages = ceil($total_promotions / $par_page);
    $page = $SessionService[SESSION::GET->value]('page', '');
    $page_actuelle = isset($page) && is_numeric($page) ? (int)$page : 1;
    $page_actuelle = max(1, min($total_pages, $page_actuelle));
    
    $start_index = ($page_actuelle - 1) * $par_page;
    $promotions = array_slice($promotions_all, $start_index, $par_page);
    
    $pages = range(1, $total_pages);
    
    $pagination = [
        'page_actuelle' => $page_actuelle,
        'total_pages' => $total_pages,
        'precedente' => $page_actuelle > 1 ? $page_actuelle - 1 : null,
        'suivante' => $page_actuelle < $total_pages ? $page_actuelle + 1 : null,
        'pages' => $pages,
        'start' => $total_promotions > 0 ? $start_index + 1 : 0,
        'end' => min($start_index + $par_page, $total_promotions),
        'total' => $total_promotions,
        'par_page' => $par_page,
    ];
    
    $user = $LoginService[NAME_FUNCTION::RECUPERER_USER->value]();
    $stats = $StatistiqueService[NAME_FUNCTION::CALCULER_STATISTIQUES_PROMOTION_ACTIVE->value]();
    $nomPromoActive = $StatistiqueService[NAME_FUNCTION::RECUPERER_NOM_PROMO_ACTIVE->value]();
    
    runder_view("base.layout.php", "promotions/grid.promotion.php", [
        'promotions' => $promotions,
        'pagination' => $pagination,
        'user' => $user,
        'stats' => $stats,
        'nomPromoActive' => $nomPromoActive,
        'status_filter' => $status_filter,
        'query' => $query,
    ]);
}

function rechercher_par_nom_liste() {
    global $PromotionServices, $SessionService, $LoginService, $StatistiqueService, $ReferentielServices;
    
    $query = isset($_GET['query']) ? trim($_GET['query']) : '';
    $status_filter = isset($_GET['status']) ? trim($_GET['status']) : '';
    $referentiel_filter = isset($_GET['referentiel']) ? trim($_GET['referentiel']) : '';
    
    $promotions_all = $PromotionServices[NAME_FUNCTION::LISTE_PROMOTIONS->value]();
    
    if (!empty($query)) {
        $promotions_all = array_filter($promotions_all, function($promo) use ($query) {
            return stripos($promo['nom'], $query) !== false;
        });
    }
    
    if ($status_filter === 'active' || $status_filter === 'inactive') {
        $promotions_all = array_filter($promotions_all, function($promo) use ($status_filter) {
            return $promo['status'] === $status_filter;
        });
    }
    
    if (!empty($referentiel_filter)) {
        $promotions_all = array_filter($promotions_all, function($promo) use ($referentiel_filter) {
            if (isset($promo['referentiels']) && is_array($promo['referentiels'])) {
                return in_array($referentiel_filter, $promo['referentiels']);
            }
            return false;
        });
    }
    
    usort($promotions_all, function($a, $b) {
        if ($a['status'] === 'active' && $b['status'] !== 'active') return -1;
        if ($a['status'] !== 'active' && $b['status'] === 'active') return 1;
            return strcmp($a['nom'], $b['nom']);
    });
    
    $promotions_all = array_values($promotions_all);
    
    $par_page = 4;
    $total_promotions = count($promotions_all);
    $total_pages = ceil($total_promotions / $par_page);
    $page = $SessionService[SESSION::GET->value]('page', '');
    $page_actuelle = isset($page) && is_numeric($page) ? (int)$page : 1;
    $page_actuelle = max(1, min($total_pages, $page_actuelle));
    
    $start_index = ($page_actuelle - 1) * $par_page;
    $promotions = array_slice($promotions_all, $start_index, $par_page);
    
    $pages = range(1, $total_pages);
    
    $pagination = [
        'page_actuelle' => $page_actuelle,
        'total_pages' => $total_pages,
        'precedente' => $page_actuelle > 1 ? $page_actuelle - 1 : null,
        'suivante' => $page_actuelle < $total_pages ? $page_actuelle + 1 : null,
        'pages' => $pages,
        'start' => $total_promotions > 0 ? $start_index + 1 : 0,
        'end' => min($start_index + $par_page, $total_promotions),
        'total' => $total_promotions,
        'par_page' => $par_page,
    ];
    
    $user = $LoginService[NAME_FUNCTION::RECUPERER_USER->value]();
    $stats = $StatistiqueService[NAME_FUNCTION::CALCULER_STATISTIQUES_PROMOTION_ACTIVE->value]();
    $nomPromoActive = $StatistiqueService[NAME_FUNCTION::RECUPERER_NOM_PROMO_ACTIVE->value]();
    $referentiels = $ReferentielServices[NAME_FUNCTION::LISTER_REFERENTIELS->value]();
    
    runder_view("base.layout.php", "promotions/list.promotion.php", [
        'promotions' => $promotions,
        'pagination' => $pagination,
        'user' => $user,
        'stats' => $stats,
        'nomPromoActive' => $nomPromoActive,
        'status_filter' => $status_filter,
        'query' => $query,
        'referentiel_filter' => $referentiel_filter,
        'referentiels' => $referentiels,
        'current_action' => 'rechercher_liste'
    ]);
}
    function changer_status(): void {
        global $PromotionServices;
        $nom = $_GET['nom'] ?? true;
    
        if ($nom) {
            $PromotionServices[NAME_FUNCTION::CHANGER_STATUS_PROMOTION->value]($nom);
        }
    
        header("Location: index.php?menu=promotion");
        exit;
    }

    function migrer_data_promotions() {
        global $JsonService;
        $data = $JsonService[NAME_FUNCTION::JSON_TO_ARRAY->value]();
        
        foreach ($data['promotions'] as &$promotion) {
            if (!isset($promotion['apprenants'])) {
                $promotion['apprenants'] = 0; 
            }
        }
        
        $JsonService[NAME_FUNCTION::ARRAY_TO_JSON->value]($data);
    }
    
    
    
    