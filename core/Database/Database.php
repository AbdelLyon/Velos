<?php

namespace Database;

class Database
{
   private static $instance = null;

   /**
    * Retourne un objet \PDO pour intéragir avec la base de données
    * @return \PDO 
    */

   public static function getPdo(): \PDO
   {
      $dsn = 'mysql:host=localhost;dbname=magasinVelo;charset=utf8';
      $user = 'root';
      $pwd = 'majax69';

      try {
         if (self::$instance === null) {
            self::$instance = new \PDO($dsn, $user, $pwd, [
               \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
               \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ
            ]);
         }
      } catch (\PDOException $e) {
         print_r("error : $e");
      }
      return self::$instance;
   }
}
