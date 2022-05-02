<?php

namespace App\Models;

use App\Core\Interfaces\IDataBase;
use Exception;

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

        $sql = "SELECT `Password` FROM usuarios WHERE `Username`='$userEscape'";
        $response = $this->database->executeSQL($sql);
        $resultQuery = array_shift($response);

        if (!empty($resultQuery)) {
            return password_verify(base64_encode(
                hash('sha256', $passwordEscape, true)
            ), $resultQuery["Password"]);
        } else {
            echo "No existe ningun usuario con el nombre introducido ";
        }
    }

    private function createUsername($name, $surname)
    {
        $firtsLettersName = substr($name, 0, 2);
        $splitSurname = explode(" ", $surname);
        $firstSurname = substr($splitSurname[0], 0, 2);
        $secondSurname = substr($splitSurname[1], 0, 2);
        $username = ($firtsLettersName . $firstSurname . $secondSurname);
        $usernameWithNumber = $this->isValidUsername($username);
        return strtolower($usernameWithNumber);
    }

    private function isValidUsername($username)
    {
        $sql = "SELECT Username FROM usuarios WHERE Username='" . $username . "'";
        $response = $this->database->executeSQL($sql);
        $resultQuery = array_shift($response);


        if (count($resultQuery) > 0) {
            $usernameFound = false;
            $countNumber = 0;
            $initialUsername = $username;
            while (!$usernameFound) {
                $countNumber++;
                $username = $initialUsername . $countNumber;
                if (in_array($username, $resultQuery)) {
                    $usernameFound = false;
                } else {
                    $usernameFound = true;
                }
            }
        } else {
            $usernameFound = true;
        }

        return $username;
    }

    public function register($data)
    {
        $name = $this->database->escape($data["name"]);
        $surname = $this->database->escape($data["surname"]);
        $username = $this->createUsername($name, $surname);
        $password = $this->database->escape($data["password"]);
        $passwordCrypted = password_hash(base64_encode(hash('sha256', $password, true)), PASSWORD_DEFAULT);
        // $isAdmin = $data["admin"] ? 1 : 0;
        $sql = "INSERT INTO usuarios (`Nombre`,`Apellidos`,`Username`,`Password`,`Admin`) VALUES ('" . $name . "','" . $surname . "','" . $username . "','" . $passwordCrypted . "'," . $$data["admin"] ? 1 : 0 . ")";
        return $this->database->actionSQL($sql);
    }

    public function checkAdmin($id)
    {
        $sql = "SELECT `Admin` from usuarios WHERE Id_Usuario=$id";
        return $this->database->executeSQL($sql);
    }

    public function changePassword($data)
    {
        $oldPassword = $this->database->escape($data["oldPassword"]);
        $newPassword = $this->database->escape($data["newPassword"]);
        if (!$this->checkPasswordUser($oldPassword, $data["username"])) return throw new Exception("Error: Password is not correct");
        $passwordCrypted = password_hash(base64_encode(hash('sha256', $newPassword, true)), PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET `Password`='" . $passwordCrypted . "' WHERE `Id_Usuario`=" . $data["idUser"] . "";
        return $this->database->actionSQL($sql);
    }

    private function checkPasswordUser($oldPassword, $username)
    {
        // $passwordHash = password_hash(base64_encode(hash('sha256', $password, true)), PASSWORD_DEFAULT);
        $sql = "SELECT `Password` FROM usuarios WHERE `Username`='$username'";
        $response = $this->database->executeSQL($sql);
        $resultQuery = array_shift($response);
        if (count($resultQuery) !== 1) return throw new Exception("No existe ningun usuario con el nombre introducido");

        return password_verify(base64_encode(
            hash('sha256', $oldPassword, true)
        ), $resultQuery["Password"]);
    }
}
