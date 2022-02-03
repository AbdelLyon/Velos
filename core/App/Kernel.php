<?php

namespace App;

class Kernel
{
   public static function run()
   {
      $controllerName = 'Velo';
      $action = 'index';

      if (!empty($_GET['type']))  $controllerName = ucfirst($_GET['type']);
      if (!empty($_GET['action']))  $action = $_GET['action'];

      $controllerName = "Controllers\\$controllerName";
      $controller = new $controllerName();
      $controller->$action();
   }
}
