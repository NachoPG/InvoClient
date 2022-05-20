<?php

namespace App\Controllers;

use App\Models\Users;
use App\Core\DataBase;
use Exception;

class UserController extends BaseController
{

    public function registerUser($idUserAdmin)
    {
        $userModel = new Users(new DataBase);
        $data = json_decode(file_get_contents('php://input'));
        $arrayDataUser = array("name" => $data->name, "surname" => $data->surname, "admin" => $data->admin);
        $this->verifyToken();
        $response = $userModel->checkAdmin($idUserAdmin);
        $result = $response["admin"] === "1" ? true : false;
        if ($result) {
            if ($userModel->register($arrayDataUser)) {
                $this->sendOutput(json_encode(array("message" => "Se ha registrado correctamente")), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
            } else {
                $strErrorDesc = 'Something went wrong!';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
            }
        } else {
            $strErrorDesc = 'Forbidden.';
            $strErrorHeader = 'HTTP/1.1 403 Internal Server Error';
            $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
        }
    }

    public function loginUser()
    {
        $userModel = new Users(new DataBase);
        $data = json_decode(file_get_contents('php://input'));
        if ($userModel->login($data->username, $data->password)) {
            $response = $userModel->getUserByUsername($data->username);
            $token = $this->generateToken($response);
            $this->sendOutput(json_encode(array("message" => "Login Correcto", "token" => $token, "idUser" => $response["idUser"], "admin" => $response["admin"])), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } else {
            $strErrorDesc = 'Login Incorrect';
            $strErrorHeader = 'HTTP/1.1 401';
            $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
        }
    }

    public function changePassword()
    {
        $userModel = new Users(new DataBase);
        $data = json_decode(file_get_contents('php://input'));
        $this->verifyToken();
        //Hacer la verificacion de contraseña desde el controlador
        // $arrayDataUser = array("idUser" => $data->idUser, "oldPassword" => $data->oldPassword, "username" => $data->username);
        if ($userModel->checkPasswordUser($data->oldPassword, $data->username)) {
            if ($userModel->changePassword($data->newPassword, $data->idUser)) {
                $this->sendOutput(json_encode(array("message" => 'Se ha cambiado correctamente la password')), array('HTTP/1.1 204 NOT CONTENT'));
            } else {
                $strErrorDesc = 'Error: No se ha podido cambiar la password';
                $strErrorHeader = 'HTTP/1.1 404 Internal Server Error';
                $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
            }
        } else {
            $strErrorDesc = 'Error la introducir la contraseña actual';
            $strErrorHeader = 'HTTP/1.1 404 Internal Server Error';
            $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
        }
    }

    public function getAllUsers($idUserAdmin)
    {
        $userModel = new Users(new DataBase);
        $this->verifyToken();
        $response = $userModel->checkAdmin($idUserAdmin);
        $result = $response["admin"] === "1" ? true : false;
        if ($result) {
            $resultData = $userModel->getAllUsers();
            $this->sendOutput(json_encode($resultData), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } else {
            $strErrorDesc = 'Forbidden.';
            $strErrorHeader = 'HTTP/1.1 403 Internal Server Error';
            $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
        }
    }

    public function updateAdminUser($idUserAdmin, $idUser)
    {
        $userModel = new Users(new DataBase);
        $this->verifyToken();
        $response = $userModel->checkAdmin($idUserAdmin);
        $result = $response["admin"] === "1" ? true : false;
        if ($result) {
            if ($userModel->updateAdminUser($idUser)) {
                $this->sendOutput(json_encode(array("message" => "Se ha actualizado a Admin el usuario")), array('Content-Type: application/json', 'HTTP/1.1 204 NOT_CONTENT'));
            } else {
                $strErrorDesc = 'Error. No se ha podido actualizar!';
                $strErrorHeader = 'HTTP/1.1 404 Internal Server Error';
                $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
            }
        } else {
            $strErrorDesc = 'Forbidden.';
            $strErrorHeader = 'HTTP/1.1 403 Internal Server Error';
            $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
        }
    }

    public function deleteUser($idUserAdmin, $idUser)
    {
        $userModel = new Users(new DataBase);
        $this->verifyToken();
        $response = $userModel->checkAdmin($idUserAdmin);
        $result = $response["admin"] === "1" ? true : false;
        if ($result) {
            try {
                $userModel->deleteUser($idUser);
                $this->sendOutput(json_encode(array("message" => "Se ha eliminado con Exito")), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
            } catch (Exception $e) {
                $this->sendOutput(json_encode(array("message" => $e->getMessage())), array('HTTP/1.1 500 Internal Server Error'));
            }
        } else {
            $strErrorDesc = 'Forbidden.';
            $strErrorHeader = 'HTTP/1.1 403 Internal Server Error';
            $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
        }
    }
}
