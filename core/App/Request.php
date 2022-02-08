<?php

namespace App;

class Request
{

   private string $methode;
   private string $path;

   function __construct()
   {
      $this->methode = $_SERVER['REQUEST_METHOD'];
      $this->path = $_SERVER['REQUEST_URI'];
   }


   public function test($methode, $param)
   {
      if ($param && !empty($methode[$param])) {
         if (ctype_digit($methode[$param]) || \gettype($methode[$param]) === "array") return $methode[$param];
         else return htmlspecialchars($methode[$param]);
      } else {
         return \false;
      }
   }

   public function get(string $param = null)
   {
      return $this->test($_GET, $param);
   }

   public function post(string $param = null)
   {
      return $this->test($_POST, $param);
   }

   public function file(string $param = null)
   {
      return $this->test($_FILES, $param);
   }

   public function cookie($param)
   {
      return $this->test($_COOKIE, $param);
   }
}
