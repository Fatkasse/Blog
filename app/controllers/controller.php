<?php
// controller.php
namespace App\Controllers\BaseControllers;

require_once __DIR__ . '/../services/session.service.php';
require_once __DIR__ .'/../services/validator.service.php';
require_once __DIR__ .'/error.controller.php';
require_once __DIR__ .'/../controllers/promotion/promotion.controller.php';
require_once __DIR__ . '/../controllers/apprenant/apprenant.controller.php';


function runder_view(string $layout, string $view, array $data = []):void {
    extract($data);
    require_once __DIR__ . "/../views/layout/$layout";
    require_once __DIR__ . "/../views/$view";
}

function runder_single_views(string $view, array $data = []):void {
    extract($data);
    require_once __DIR__ . "/../views/$view";
}


function redirect_to(string $url) {
    header("Location: $url");
    exit;
}
