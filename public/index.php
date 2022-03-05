<?php
set_time_limit(1200);

use App\Controller\CardsController;
use Core\Auth\DatabaseAuth;
use Core\Database\Database;

define('ROOT', dirname(__DIR__));

require ROOT . '/app/App.php';
App::load();

$app = App::getInstance();

$p = 'cards.index';
if (isset($_GET['p'])) {
    $p = $_GET['p'];
}


$p = explode('.', $p);

$action = @$p[1];
$controllerPath = '\App\Controller\\' . ucfirst($p[0]) . 'Controller';

if ($p[0] === 'admin') {
    $action = @$p[2];
    $controllerPath = '\App\Controller\Admin\\' . ucfirst($p[1]) . 'Controller';
}

if (empty($action)) {
    $action = 'index';
}

$controller = new $controllerPath();
$controller->$action();