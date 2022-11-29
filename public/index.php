<?php

use App\Connection\DatabaseConnection;

include dirname(__DIR__) . '../vendor/autoload.php';
include dirname(__DIR__) . '../config/database.php';

session_start();

$rotas = require dirname(__DIR__) . '../config/rotas.php';

$url = $_SERVER["REQUEST_URI"];
$rota = explode("?", $url)[0];

if(!isset($rotas[$rota])){
    echo 'Erro 404';
    exit;
}

$controller = $rotas[$rota]['controller'];
$method = $rotas[$rota]['method'];

(new $controller)->$method();