<?php

namespace App\Models;

use App\Core\Interfaces\IDataBase;
use Exception;
use PDO;

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

        $sql = "SELECT `Password` FROM usuarios WHERE `username`='$userEscape'";
        $response = $this->database->executeSQL($sql);
        $resultQuery = array_shift($response);

        if (!empty($resultQuery)) {
            return password_verify(base64_encode(
                hash('sha256', $passwordEscape, true)
            ), $resultQuery["Password"]);
        } else {
            echo json_encode(array("message" => "No existe ningun usuario con el nombre introducido "));
        }
    }

    public function getUserByUsername($username)
    {
        $sql = "SELECT `idUser`,`name`,`surname`,`username`,`admin` FROM usuarios WHERE `username`='$username'";
        $response = $this->database->executeSQL($sql);
        return array_shift($response);
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
        $usernameLower = strtolower($username);
        $sql = "SELECT `username` FROM usuarios WHERE `username` LIKE '" . $usernameLower . "%'";
        $response = $this->database->executeSQLAll($sql);
        if (empty($response)) return $usernameLower;
        if (count($response) > 0) {
            $finalUsername = $usernameLower;
            $countNumber = 0;
            foreach ($response as $value) {
                $initialUsername = $usernameLower;
                if (in_array($finalUsername, $value)) {
                    $countNumber++;
                    $finalUsername = $initialUsername . $countNumber;
                } else {
                    $finalUsername = $usernameLower;
                }
            }
            return $finalUsername;
        } else {
            return $usernameLower;
        }
    }

    public function register($data)
    {
        $name = $this->database->escape($data["name"]);
        $surname = $this->database->escape($data["surname"]);
        $username = $this->createUsername($name, $surname);
        $password = "Cambiame123";
        $passwordCrypted = password_hash(base64_encode(hash('sha256', $password, true)), PASSWORD_DEFAULT);
        $isAdmin = $data["admin"] ? 1 : 0;
        $sql = "INSERT INTO usuarios (`name`,`surname`,`username`,`Password`,`admin`) VALUES ('" . $name . "','" . $surname . "','" . $username . "','" . $passwordCrypted . "'," . $isAdmin . ")";
        return $this->database->actionSQL($sql);
    }

    public function checkAdmin($id)
    {
        $sql = "SELECT `admin` from usuarios WHERE `idUser`=$id";
        $result = $this->database->executeSQL($sql);
        return array_shift($result);
    }


    public function changePassword($newPassword, $idUser)
    {
        // $oldPassword = $this->database->escape($data["oldPassword"]);
        $newPassword = $this->database->escape($newPassword);
        $passwordCrypted = password_hash(base64_encode(hash('sha256', $newPassword, true)), PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET `Password`='" . $passwordCrypted . "' WHERE `idUser`=" . $idUser . "";
        return $this->database->actionSQL($sql);
    }

    public function checkPasswordUser($oldPassword, $username)
    {
        // $passwordHash = password_hash(base64_encode(hash('sha256', $password, true)), PASSWORD_DEFAULT);
        $sql = "SELECT `Password` FROM usuarios WHERE `username`='$username'";
        $response = $this->database->executeSQL($sql);
        $resultQuery = array_shift($response);
        if (count($resultQuery) !== 1) return throw new Exception("No existe ningun usuario con el nombre introducido");
        return password_verify(base64_encode(
            hash('sha256', $oldPassword, true)
        ), $resultQuery["Password"]);
    }

    public function getAllUsers()
    {
        $sql = "SELECT `idUser`,`name`,`surname`,`username`,`admin` FROM usuarios";
        return $this->database->executeSQL($sql);
    }

    public function updateAdminUser($id)
    {
        $sql = "UPDATE usuarios SET `admin`=true WHERE `idUser`=$id";
        return $this->database->actionSQL($sql);
    }

    public function deleteUser($idUser)
    {
        $sql = "DELETE FROM usuarios WHERE `idUser`=$idUser";
        return $this->database->actionSQL($sql);
    }
}
