<?php

namespace App\Controllers;

use App\Models\Users;
use App\Core\DataBase;

class UserController extends BaseController
{

    public function registerUser()
    {
        $userModel = new Users(new DataBase);
        $data = json_decode(file_get_contents('php://input'));
        $arrayDataUser = array("name" => $data->name, "surname" => $data->surname, "password" => $data->password, "admin" => $data->admin);

        if ($userModel->register($arrayDataUser)) {
            $this->sendOutput(json_encode("Se ha insertado correctamente"), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } else {
            $strErrorDesc = 'Something went wrong!';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            $this->sendOutput(json_encode($strErrorDesc), array($strErrorHeader));
        }
    }

    public function loginUser()
    {
        $userModel = new Users(new DataBase);
        $data = json_decode(file_get_contents('php://input'));
        if ($userModel->login($data->username, $data->password)) {
            $this->sendOutput(json_encode("Login Correcto"), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } else {
            $strErrorDesc = 'Login Incorrecto';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            $this->sendOutput(json_encode($strErrorDesc), array($strErrorHeader));
        }
    }

    public function changePassword()
    {
        $userModel = new Users(new DataBase);
        $data = json_decode(file_get_contents('php://input'));
        $arrayDataUser = array("idUser" => $data->idUser, "oldPassword" => $data->oldPassword, "newPassword" => $data->newPassword, "username" => $data->username);
        if ($userModel->changePassword($arrayDataUser)) {
            $this->sendOutput("Se ha modificado correctamente la contraseña", array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } else {
            $strErrorDesc = 'Error al modificar la contraseña';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            $this->sendOutput($strErrorDesc, array($strErrorHeader));
        }
    }
}
