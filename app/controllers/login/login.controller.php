<?php 

namespace App\Controllers\Login;

require_once __DIR__ . '/../../models/login/login.model.php';
require_once __DIR__ . "/../controller.php";
require_once __DIR__ . "/../error.controller.php";

use App\Enums\MESSAGE_ERREUR;
use App\Enums\SESSION;
use App\Enums\NAME_FUNCTION;
use App\Enums\VALIDATOR;


use function App\Controllers\BaseControllers\runder_single_views;

use function App\Controllers\Promotion\grid_promotions;

use function App\Controllers\errors\add_error;

function runder_login() {
    global $SessionService;
    $action =  $SessionService[SESSION::REQUETE->value]('action','');

    match ($action) {
        "login" => login(),
        "forgot_password" => runder_single_views('login/forgot_password.html.php'),
        "reset_password" => reset_password(),
        default => runder_single_views('login/login.html.php', [
            'errors' => [],
            'old' => [],
        ]),
    };
}

function login() {
    global $LoginService, $ValidatorService, $SessionService;
     
    $username = $SessionService[SESSION::POST->value]('login','');
    $password = $SessionService[SESSION::POST->value]('password','');

    if (!$ValidatorService[VALIDATOR::VALIDATE_LOGIN_FORM->value]($username, $password)) {
        return runder_single_views('login/login.html.php', [
            'errors' => $GLOBALS['errors'],
            'old' => ['login' => $username],
        ]);
    }

    if ($LoginService[NAME_FUNCTION::SE_CONNECTER->value]($username, $password)) {
        return  grid_promotions();
    } else {
        // add_error('login', "Nom d'utilisateur ou mot de passe incorrect.");
        add_error('login', message(MESSAGE_ERREUR::LOGIN_OR_PASSWORD_INCORRECTE->value));
        return runder_single_views('login/login.html.php', [
            'errors' => $GLOBALS['errors'],
            'old' => ['login' => $username],
        ]);
    

    }
}

function reset_password() {
    global $SessionService, $JsonService;

    $login = $SessionService[SESSION::POST->value]('login', '');
    $newPassword = $SessionService[SESSION::POST->value]('new_password', '');

    $data = $JsonService[NAME_FUNCTION::JSON_TO_ARRAY->value]();
    $users = $data["users"];

    $foundKey = array_search($login, array_column($users, 'login'));

    if ($foundKey !== false) {
        $users[$foundKey]["password"] = $newPassword;
        $data["users"] = $users;

        $JsonService[NAME_FUNCTION::ARRAY_TO_JSON->value]($data);

        return runder_single_views('login/login.html.php', [
            'errors' => [],
            'old' => ['login' => $login],
        ]);
    } else {
        add_error('login', "Utilisateur non trouvé.");
        return runder_single_views('login/forgot_password.html.php', [
            'errors' => $GLOBALS['errors']
        ]);
    }
}



