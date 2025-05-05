<?php
namespace App\Validators;
require_once __DIR__ ."/../enums/enums.php";
require_once __DIR__ ."/../translate/fr/message.fr.php";
use App\Enums\MESSAGE_ERREUR;
use App\Enums\VALIDATOR;
use App\Enums\NAME_FUNCTION;
use App\Enums\SESSION;

use function App\Controllers\errors\add_error;
use function App\Controllers\errors\clear_errors;
use function App\Controllers\errors\has_errors;


$ValidatorService = [

    VALIDATOR::VALIDATE_LOGIN_FORM->value => function(string $login, string $password): bool {
        clear_errors();
        global $ValidatorService;

        $ValidatorService[VALIDATOR::VALIDATE_LOGIN->value]($login);
        
        $ValidatorService[VALIDATOR::VALIDATE_PASSWORD->value]($password);
   
        
        return !has_errors();
    },

    VALIDATOR::VALIDATE_APPRENANTS->value => function (string $apprenants) {
        if (!ctype_digit($apprenants) && $apprenants !== '') {
            add_error('apprenants', message(MESSAGE_ERREUR::FORMAT_NOMBRE->value, "apprenants"));
        } elseif ($apprenants !== '' && (int)$apprenants < 0) {
            add_error('apprenants', "Le nombre d'apprenants ne peut pas être négatif.");
        }
    },
    
    VALIDATOR::VALIDATE_PROMOTION_FORM->value => function(string $nom, string $dateDebut, string $dateFin): ?string {
        global $ValidatorService, $SessionService;
        clear_errors();
        
        $ValidatorService[VALIDATOR::VALIDATE_NOM_PROMOTION->value]($nom);
        $ValidatorService[VALIDATOR::VALIDATE_DATE->value]($dateDebut, $dateFin);
        
        $apprenants = $SessionService[SESSION::POST->value]("apprenants", "0");
        $ValidatorService[VALIDATOR::VALIDATE_APPRENANTS->value]($apprenants);
        
        $photoPath = $ValidatorService[VALIDATOR::VALIDATE_PHOTO->value]();
        
        return has_errors() ? null : $photoPath;
    },


    VALIDATOR::VALIDATE_REFERENTIEL_FORM->value => function(string $nom, string $description, string $capacite, string $nombreSession): ?string {
        global $ValidatorService;
        clear_errors();

        $ValidatorService[VALIDATOR::VALIDATE_NOM_REREFENTIEL->value]($nom);
        $ValidatorService[VALIDATOR::VALIDATE_DESCRIPTION->value]($description);
        $ValidatorService[VALIDATOR::VALIDATE_CAPACITE->value]($capacite);
        $ValidatorService[VALIDATOR::VALIDATE_SESSION->value]($nombreSession);

        $photoPath = $ValidatorService[VALIDATOR::VALIDATE_PHOTO->value]();
    
        return has_errors() ? null : $photoPath;
    },



    VALIDATOR::VALIDATE_LOGIN->value => function($login){
        if (empty($login)) {
            add_error('login', message(MESSAGE_ERREUR::CHAMP_OBLIGATOIRE->value,"login"));
        } elseif (strlen($login) < 3) {
            add_error('login', message(MESSAGE_ERREUR::CARACTERE_MINIMUM->value,"login",3));
        }
    },

    VALIDATOR::VALIDATE_PASSWORD->value => function(string $password){
        if (empty($password)) {
            add_error('password', message(MESSAGE_ERREUR::CHAMP_OBLIGATOIRE->value,"password"));
        } elseif (strlen($password) < 6) {
            add_error('password', message(MESSAGE_ERREUR::CARACTERE_MINIMUM->value,"password",6));
        }
    },

    

    VALIDATOR::VALIDATE_NOM_PROMOTION->value => function (string $nom)  {
        global $PromotionServices;
        if (empty($nom)) {
            add_error('nom', message(MESSAGE_ERREUR::CHAMP_OBLIGATOIRE->value,"nom"));

        } elseif (strlen($nom) < 3) {
            add_error('nom', message(MESSAGE_ERREUR::CARACTERE_MINIMUM->value,'nom',3));
        } else {
        
            $exists = $PromotionServices[NAME_FUNCTION::RECHERCHER_PROMO_PAR_NOM->value]($nom);
            if ($exists) {
                add_error('nom', message(MESSAGE_ERREUR::NOM_EXISTE->value));
            }
        }
    },

    VALIDATOR::VALIDATE_DATE->value => function(string $dateDebut, string $dateFin):void{
        $dateDebutObj = \DateTime::createFromFormat('d/m/Y', $dateDebut);
        $dateFinObj = \DateTime::createFromFormat('d/m/Y', $dateFin);

    
       
        if (empty($dateDebut)) {
            add_error('date-debut', message(MESSAGE_ERREUR::CHAMP_OBLIGATOIRE->value,"date fin"));
        } elseif (!$dateDebutObj || $dateDebutObj->format('d/m/Y') !== $dateDebut) {
            add_error('date-debut', message(MESSAGE_ERREUR::FORMAT_DATE->value));
        }
    
       
        if (empty($dateFin)) {
            add_error('date-fin', message(MESSAGE_ERREUR::CHAMP_OBLIGATOIRE->value,'date fin '));
        } elseif (!$dateFinObj || $dateFinObj->format('d/m/Y') !== $dateFin) {
            add_error('date-fin', message(MESSAGE_ERREUR::FORMAT_DATE->value));
        }
    
        
        if ($dateDebutObj && $dateFinObj && $dateDebutObj > $dateFinObj) {
            add_error('date-debut', message(MESSAGE_ERREUR::DATE_DEBUT_INFERIEUR->value));
        }
    },

    VALIDATOR::VALIDATE_PHOTO->value => function(): ?string {
        global $SessionService;
        $photoFile = $SessionService[SESSION::FILE->value]("photo");
    
        if (isset($photoFile) && $photoFile['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $photoFile['tmp_name'];
            $fileSize = $photoFile['size'];
            $fileType = mime_content_type($fileTmpPath);
            
            $allowedTypes = ['image/jpeg', 'image/png'];
    
            if (!in_array($fileType, $allowedTypes)) {
                add_error('photo', message(MESSAGE_ERREUR::PHOTO_TYPE->value));
                return null;
            }
    
            if ($fileSize > 2 * 1024 * 1024) {
                add_error('photo', message(MESSAGE_ERREUR::TAILLE_PHOTO->value));
                return null;
            }
    
            $fileName = basename($photoFile['name']);
            $destination = "../assets/images/promotions/$fileName";
            $absolutePath = __DIR__ . "/../assets/images/promotions/$fileName";
            if (!is_dir(dirname($absolutePath))) {
                mkdir(dirname($absolutePath), 0755, true);
            }
    
            if (move_uploaded_file($fileTmpPath, $absolutePath)) {
                return $destination; 
            } else {
                add_error('photo', "Échec lors du déplacement de la photo.");
                return null;
            }
    
        } else {
            add_error('photo', message(MESSAGE_ERREUR::CHAMP_OBLIGATOIRE->value, "photo"));
            return null;
        }
    },

   
    VALIDATOR::VALIDATE_NOM_REREFENTIEL->value => function (string $nom)  {
        global $ReferentielServices;
        if (empty($nom)) {
            add_error('nom', message(MESSAGE_ERREUR::CHAMP_OBLIGATOIRE->value,"nom"));

        } elseif (strlen($nom) < 3) {
            add_error('nom', message(MESSAGE_ERREUR::CARACTERE_MINIMUM->value,'nom',3));
        } else {
        
            $exists = $ReferentielServices[NAME_FUNCTION::RECHERCHER_REF_PAR_NOM->value]($nom);
            if ($exists) {
                add_error('nom', message(MESSAGE_ERREUR::NOM_EXISTE->value));
            }
        }
    },

    VALIDATOR::VALIDATE_DESCRIPTION->value => function (string $description) {
        if (empty($description)) {
            add_error('description', message(MESSAGE_ERREUR::CHAMP_OBLIGATOIRE->value,'description'));
        } elseif (strlen($description)< 15){
            add_error('description', message(MESSAGE_ERREUR::CARACTERE_MINIMUM->value,"description", 10));
        }
    },

    VALIDATOR::VALIDATE_CAPACITE->value => function (string $capacite) {
        if (empty($capacite)) {
            add_error('capacite', message(MESSAGE_ERREUR::CHAMP_OBLIGATOIRE->value,"capacite "));
        } elseif (!ctype_digit($capacite)) {
            add_error('capacite', 'La capacité doit être un entier.');
        }
    },

    VALIDATOR::VALIDATE_SESSION->value => function (string $nombreSession) {
        if(empty($nombreSession)){
            add_error( 'nombre-session', message(MESSAGE_ERREUR::CHAMP_OBLIGATOIRE->value,"nombre de session "));
        }
    },

    VALIDATOR::VALIDATE_AFFECTER_REF->value => function (string $libelle){
        if(empty($libelle)){
            add_error('libelle',message(MESSAGE_ERREUR::CHAMP_OBLIGATOIRE->value,"libelle referentiel"));
        }

    }




];

