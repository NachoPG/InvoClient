<?php

namespace App\Controllers;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;



class BaseController
{
    public function sendOutput($data, $httpHeaders = array())
    {
        header_remove('Set-Cookie');
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }

        // $error = json_last_error_msg();
        // var_dump($error);

        echo $data;
        exit;
    }

    protected function generateToken($dataUser)
    {
        $issuer_claim = "InvoClient API";
        $audience_claim = "Web";
        $issuedat_claim = time();
        $expire_claim = $issuedat_claim + (3600 * 24); // 1 day
        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "exp" => $expire_claim,
            "data" => array(
                "idUser" => $dataUser["idUser"],
                "firstname" => $dataUser["name"],
                "lastname" => $dataUser["surname"],
                "username" => $dataUser["username"]
            )
        );

        return JWT::encode($token, 'SECRET_KEY', 'HS256');
    }

    protected function verifyToken()
    {
        if (empty($_SERVER['HTTP_AUTHORIZATION'])) {
            $this->sendOutput(json_encode(array("message" => "Access denied. Not header authorization found")), array('Content-Type: application/json', 'HTTP/1.0 403 Bad Request'));
            exit;
        }

        if (!preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
            $this->sendOutput(json_encode(array('Token not found in request')), array('Content-Type: application/json', 'HTTP/1.0 400 Bad Request'));
            exit;
        }

        $tokenJwt = $matches[1];
        if ($tokenJwt) {
            try {
                JWT::decode($tokenJwt, new Key('SECRET_KEY', 'HS256'));
            } catch (Exception $e) {
                http_response_code(403);
                $this->sendOutput(json_encode(array(
                    "message" => "Access denied.",
                    "error" => $e->getMessage()
                )), array('Content-Type: application/json'));
                exit;
            }
        } else {
            // No token was able to be extracted from the authorization header
            header('HTTP/1.0 400 Bad Request');
            exit;
        }
    }
}
