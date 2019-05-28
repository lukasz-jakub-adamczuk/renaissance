<?php

// include cupHelper

echo 'generate...' . "<br>";

use Aya\Helper\CupGenerator;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/bootstrap.php';

// echo DB_SOURCE;

$cupGenerator = new CupGenerator();
$cupGenerator->generate(13);


echo 'generated...' . "<br>";