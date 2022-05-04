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

        echo $data;
        exit;
    }

    protected function generateToken($dataUser)
    {
        $issuer_claim = "LOCALHOST API"; // this can be the servername
        $audience_claim = "THE_AUDIENCE";
        $issuedat_claim = time(); // issued at
        $expire_claim = $issuedat_claim + (3600 * 24); // expire time in seconds
        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "exp" => $expire_claim,
            "data" => array(
                "id" => $dataUser["Id_Usuario"],
                "firstname" => $dataUser["Nombre"],
                "lastname" => $dataUser["Apellidos"],
                "username" => $dataUser["Username"]
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
