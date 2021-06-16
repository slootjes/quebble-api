<?php

use Symfony\Component\Dotenv\Dotenv;
use App\Service\Quebble;

require_once __DIR__.'/vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env.local');

$quebble = new Quebble($_ENV['USERNAME'], $_ENV['PASSWORD']);
