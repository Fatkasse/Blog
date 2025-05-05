<?php

namespace App\Models\Apprenant;

function getAllApprenants(): array {
    $file = __DIR__ . '/../../../data/apprenants.json';
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true);
}
