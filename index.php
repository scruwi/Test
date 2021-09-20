<?php

namespace App;

use App\Controller\PageController;

require_once 'vendor/autoload.php';

$index = new PageController();
try {
    echo $index->index();
} catch (\JsonException $e) {
}