<?php
namespace App\Core\Interfaces;

interface IDataBase{
    public function executeSQL($sql);
    public function actionSQL($sql);
    public function escape($value);
}