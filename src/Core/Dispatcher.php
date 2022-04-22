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
        $this->currentRequest = $request;
        $this->dispatch();
    }
    private function dispatch()
    {
        $baseControler = new BaseController();

        if (isset($this->routeList[$this->currentRequest->getRoute()])) {
            $controllerClass = "App\\Controllers\\" . $this->routeList[$this->currentRequest->getRoute()]["controller"];
            $controller =  new $controllerClass;
            $action = $this->routeList[$this->currentRequest->getRoute()]["action"];
            $controller->$action(...$this->currentRequest->getParams());
        } else {
            $baseControler->sendOutput('', array('HTTP/1.1 404 Not Found'));
        }
    }
}
