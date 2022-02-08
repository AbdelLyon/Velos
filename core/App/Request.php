<?php

namespace App;

class Request
{
   private function getRequest(array $methode, string $param): string | array | int| bool
   {
      if ($param && !empty($methode[$param])) {
         if (ctype_digit($methode[$param]) || \gettype($methode[$param]) === "array") return $methode[$param];
         else return htmlspecialchars($methode[$param]);
      } else {
         return \false;
      }
   }

   public function get(string $param = null): string | int | bool
   {
      return $this->getRequest($_GET, $param);
   }

   public function post(string $param = null): string | int | bool
   {
      return $this->getRequest($_POST, $param);
   }

   public function file(string $param = null): array | bool
   {
      return $this->getRequest($_FILES, $param);
   }

   public function cookie($param): string
   {
      return $this->getRequest($_COOKIE, $param);
   }
}
