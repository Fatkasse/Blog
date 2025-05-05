<?php
namespace App\Route;
require_once __DIR__ ."/../controllers/login/login.controller.php";
require_once __DIR__ ."/../controllers/referentiel/referentiel.controller.php";
require_once( __DIR__ . '/../controllers/apprenant/apprenant.controller.php');

use App\Enums\SESSION;
use function App\Controllers\Promotion\runder_promotion;
use function App\Controllers\Login\runder_login;
use function App\Controllers\referentiel\runder_referentiel;
use function App\Controllers\Apprenant\runder_apprenant;
use App\Controllers;

function  render_menu():void{
   
    global  $SessionService;

    $menu =  $SessionService[SESSION::REQUETE->value]('menu','');
    match($menu){
        "referentiel" => runder_referentiel(),
        "promotion" => runder_promotion(),
        "creation_page" => runder_creation_page(),
        "apprenant" => runder_apprenant(),
        default=> runder_login(),
    };
}