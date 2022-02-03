<?php

namespace Controllers;

abstract class AbstractController
{
   protected object $model;
   protected string $modelName;

   public function __construct()
   {
      $this->model = new $this->modelName();
   }

   public function redirect(?array $url = null)
   {
      return \App\Response::redirect($url);
   }

   public function render(string $template, array $donnees)
   {
      return \App\View::render($template, $donnees);
   }

   public function getUser()
   {
      return \Models\User::findCurrentUser();
   }
}
