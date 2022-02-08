<?php

namespace Controllers;

use App\Request;

abstract class AbstractController
{
   protected object $model;
   protected string $modelName;
   protected object $request;
   // protected string $requestName;


   public function __construct()
   {
      $this->model = new $this->modelName();
      $this->request = new Request();
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

   public function json($response)
   {
      return \App\Response::json($response);
   }
}
