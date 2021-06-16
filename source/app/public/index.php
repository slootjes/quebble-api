<?php

require_once __DIR__.'/../bootstrap.php';

$output = [];
foreach ($quebble->loadWorkdays() as $workday) {
    $output[] = $workday->toArray();
}

header('Content-Type: application/json');
echo json_encode($output);
