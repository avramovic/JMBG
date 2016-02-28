<?php

require_once __DIR__ . '/vendor/autoload.php'; // Autoload files using Composer autoload

use Avram\JMBG\JMBG;

$jmbg = new JMBG();

$number = '1905983710332';

$jmbg->setJMBG($number);

echo '<pre>';
print_r($jmbg->getInfo());
