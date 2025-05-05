<?php

namespace App\Controllers\Apprenant;

use function App\Models\Apprenant\getAllApprenants;

require_once __DIR__ . '/../../models/apprenant/apprenant.model.php';

function runder_apprenant(): void {
    $apprenants = getAllApprenants();
    require_once __DIR__ . '/../../views/apprenant/list.apprenant.php';
}
