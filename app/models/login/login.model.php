<?php

require_once __DIR__ ."/../model.php";
use App\Enums\NAME_FUNCTION;




$LoginService = [

    NAME_FUNCTION::SE_CONNECTER->value => function (string $login, string $password): bool {
        global $JsonService;
    
        $data = $JsonService[NAME_FUNCTION::JSON_TO_ARRAY->value]();
        $users = $data["users"];
    
        $match = array_values(array_filter($users, fn($user) => $user["login"] === $login && $user["password"] === $password));
    
        if (!empty($match)) {
            $_SESSION['profil'] = $match[0]["profil"];
            $_SESSION['user_login'] = $match[0]['login'];
            return true;
        }
    
        return false;
    },
    
    
    NAME_FUNCTION::RECUPERER_USER->value => function(): array {
        global $JsonService;
    
        if (!isset($_SESSION['user_login'])) {
            return [];
        }
    
        $data = $JsonService[NAME_FUNCTION::JSON_TO_ARRAY->value]();
        $users = $data["users"];
    
        $userMatch = array_values(array_filter($users, fn($user) => $user['login'] === $_SESSION['user_login']));
    
        return $userMatch[0] ?? [];
    }
    
    
    

];

