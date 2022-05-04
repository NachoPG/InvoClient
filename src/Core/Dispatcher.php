<?php

namespace App\Core;

use App\Core\Interfaces\IRequest;
use App\Core\Interfaces\IRoutes;
use App\Controllers\BaseController;

class Dispatcher
{
    private $routeList;
    private IRequest $currentRequest;
    public function __construct(IRoutes $routeCollection, IRequest $request)
    {
        $this->routeList = $routeCollection->getRoutes();
        $this->currentRequest =  $request;
        // var_dump($this->currentRequest);
        $this->dispatch();
    }
    private function dispatch()
    {
        $baseControler = new BaseController();

        // var_dump($this->currentRequest->getRoute());
        // var_dump($this->currentRequest->getParams());
        // die();
        $routeApi = "/api" . $this->currentRequest->getRoute();
        if (isset($this->routeList[$routeApi])) {
            $controllerClass = "App\\Controllers\\" . $this->routeList[$routeApi]["controller"];
            $controller =  new $controllerClass;
            $action = $this->routeList[$routeApi]["action"];
            $controller->$action(...$this->currentRequest->getParams());
        } else {
            $baseControler->sendOutput('', array('HTTP/1.1 404 Not Found'));
        }
    }
}
