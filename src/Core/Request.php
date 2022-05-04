<?php

namespace App\Core;

use App\Core\Interfaces\IRequest;

class Request implements IRequest
{
    private $route;
    private $params;
    function __construct()
    {
        $rawRoute = $_SERVER["REQUEST_URI"];
        $rawRouteElements = explode("/", $rawRoute);
        $this->route = "/" . $rawRouteElements[2];
        $this->params = array_slice($rawRouteElements, 3);
    }

    /**
     * Get the value of route
     */
    public function getRoute()
    {
        // var_dump($this->route);

        return $this->route;
    }

    /**
     * Get the value of params
     */
    public function getParams()
    {
        // var_dump($this->params);

        return $this->params;
    }
}
