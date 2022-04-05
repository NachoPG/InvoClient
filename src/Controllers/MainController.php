<?php 

namespace App\Controllers;

use App\Core\DataBase;
use App\Models\Tareas;
use App\Views\ListadoTareas;

class MainController
{
 public function listadoTarea(){
    $tareas = new Tareas(new Database);
    $view = new ListadoTareas($tareas->findAll());
 }
}