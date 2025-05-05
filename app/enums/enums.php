<?php
namespace App\Enums;

enum NAME_FUNCTION : string  {
    case SE_CONNECTER =  'se_connecter';
    case LISTE_PROMOTIONS = 'liste_promotions';
    case AJOUTER_PROMOTIONS = "ajouter_promotion";
    case JSON_TO_ARRAY = "json_to_array";
    case ARRAY_TO_JSON = "array_to_json";
    case LISTER_REFERENTIELS = "lister_referentiel";
    case AJOUTER_REFERENTIEL = "ajouter_referentiel";
    case LISTER_REFERENTIELS_PROMO_ACTIVE = "lister_referentiels_promo_active";
    case AFFECTER_REFERENTIEL_PROMOTION = "affecter_referentiel_promotion";
    case LISTER_PROMOTIONS_ACTIVES = "lister_promotion_active";
    case RECHERCHER_PROMO_PAR_NOM   = "rechercher_promo_par_nom";
    case CHANGER_STATUS_PROMOTION = "changer_status_promotion";
    case RECHERCHER_REFS_PAR_NOM = "rechercher_toutes_referentiels_par_nom";
    case RECHERCHER_REF_PAR_NOM = "rechercher_ref_par_nom";
    case RECHERCHER_REF_EN_COURS_PAR_NOM = "rechercher_ref_en_cours_par_nom";
    case RECUPERER_USER = "recuper_user";
    case GET_STATS = 'get_statisque';
    case CALCULER_STATISTIQUES_PROMOTION_ACTIVE = "calculer_statistique_promotion_active";
    case RECUPERER_NOM_PROMO_ACTIVE = "nom_promo_active";
    case NOMBRE_APPRENANTS = 'nombre_apprenants';


}

enum VALIDATOR : string {
    case VALIDATE_LOGIN = "validate_login";
    case VALIDATE_PASSWORD = "validate_password";
    case VALIDATE_LOGIN_FORM = 'validate_login_form';
    case VALIDATE_DATE = "validate_date";
    case VALIDATE_NOM_PROMOTION = "validate_nom";
    case VALIDATE_PHOTO = "validate_photo";
    case VALIDATE_PROMOTION_FORM = "validate_promotion_form";
    case VALIDATE_REFERENTIEL_FORM = "validate_referentiel_form";
    case VALIDATE_NOM_REREFENTIEL =  "validate_nom_referentiel";
    case VALIDATE_DESCRIPTION ="validate_description";
    case VALIDATE_CAPACITE = "validate_capacite";
    case VALIDATE_SESSION = 'validate_session';
    case VALIDATE_APPRENANTS = "validate_apprenants";
    case VALIDATE_AFFECTER_REF = "validate_affecter_ref";

}


enum SESSION: string {
    case REQUETE = 'get_requete';
    case POST = 'get_post';
    case GET = 'get_get';
    case FILE = 'get_file';
}

enum  MESSAGE_ERREUR: string{
   
    
    case CHAMP_OBLIGATOIRE = "cha;p_required";
    case CARACTERE_MINIMUM = "caractere_minimun";
    case NOM_EXISTE = "nom_existe";
    case DATE_DEBUT_OBLIGATOIRE = "date_debut_required";
    case DATE_FIN_OBLIGATOIRE = "date_fin_required";
    case FORMAT_DATE = "date-format";
    case DATE_DEBUT_INFERIEUR = "date_debut_inferieur";
    case PHOTO_OBLIGATOIRE = "photo_required";
    case PHOTO_TYPE = "photo_type";
    case TAILLE_PHOTO = "photo_size";
    case LOGIN_OR_PASSWORD_INCORRECTE= "wrong password";
    
}
