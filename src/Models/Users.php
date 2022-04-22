<?php

namespace App\Models;

use App\Core\Interfaces\IDataBase;


class Users
{

    private IDatabase $database;
    public function __construct(IDatabase $database)
    {
        $this->database = $database;
    }

    public function login($user, $password)
    {

        $userEscape = $this->database->escape($user);
        $passwordEscape = $this->database->escape($password);
        $sql = "SELECT * FROM agent WHERE agent_name='$userEscape' AND password='$passwordEscape'";
        $result = $this->database->executeSQL($sql);
        return array_shift($result);
    }

    private function createUsername($name, $surname)
    {
        $firtsLettersName = substr($name, 0, 2);
        $splitSurname = explode(" ", $surname);
        $firstSurname = substr($splitSurname[0], 0, 2);
        $secondSurname = substr($splitSurname[1], 0, 2);

        $username = ($firtsLettersName + $firstSurname + $secondSurname);
        return $username;
    }

    

    public function register($data)
    {
        $name = $this->database->escape($data["name"]);
        $surname = $this->database->escape($data["surname"]);
        $username = $this->createUsername($name, $surname);
        $password = $this->database->escape($data["password"]);
        $passwordCrypted = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO usuarios ('Nombre','Apellidos','Username','Password','Admin') VALUES ('" . $name . "','" . $surname . "','" . $username . "','" . $passwordCrypted . "'," . $data["admin"] . ")";
        return $this->database->actionSQL($sql);
    }

    public function checkAdmin($id)
    {
        $sql = "SELECT 'Admin' from usuarios WHERE Id_Usuario=$id";
        return $this->database->executeSQL($sql);
    }
}
