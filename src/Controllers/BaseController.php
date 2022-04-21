<?php

namespace App\Controllers;


class BaseController
{
    protected function sendOutput($data, $httpHeaders = array())
    {
        header_remove('Set-Cookie');

        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }

        echo $data;
        exit;
    }
}
