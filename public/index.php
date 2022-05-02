<?php
require_once "../vendor/autoload.php";

use App\Core\Dispatcher;
use App\Core\Request;
use App\Core\RouteCollection;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

$routes = new RouteCollection();
$request = new Request();
$dispatcher = new Dispatcher($routes, $request);
