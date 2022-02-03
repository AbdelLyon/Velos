<?php

namespace App;

class Response
{
   /**
    *  redirige vers l'url passée en parametre
    * @param string $url
    * @return void
    */

   public static function redirect(?array $params = null): void
   {
      $url = "/";
      if ($params) {
         $url = "?";
         foreach ($params as $key => $value)  $url .= "$key=$value&";
      }
      header("Location: $url");
      exit();
   }
}
