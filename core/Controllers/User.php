<?php

namespace Controllers;

use Models\User as ModelUser;

class User extends AbstractController
{
   protected object $model;
   protected string $modelName = ModelUser::class;
   public string $error = '';

   /**
    * inscription 
    * @return void
    */

   public function signUp()
   {
      $username = null;
      $email = null;
      $password = null;
      $displayName = null;

      if ($_SERVER['REQUEST_METHOD'] === "POST") {
         if ((!empty($_POST['username'])))  $username = htmlspecialchars($_POST['username']);
         if (!empty($_POST['email'])) $email = htmlspecialchars($_POST['email']);
         if (!empty($_POST['password'])) $password = htmlspecialchars($_POST['password']);
         if (!empty($_POST['display_name'])) $displayName = htmlspecialchars($_POST['display_name']);

         if (!$username  || !$email || !$password || !$displayName) {
            $this->error = 'Veuillez renseigner tous les champs!';
         } else {
            $user = $this->model->fetchOneUser($username);
            if ($user) {
               $this->error = 'utilisateur existe dejà!';
            } else {
               if (!$user) $this->error;
               $user = new ModelUser();
               $user->setUserName($username);
               $user->setEmail($email);
               $user->setPassword($password);
               $user->setDisplayName($displayName);
               $user = $user->register($user);
            }
         }
      }

      $error = $this->error;
      $pageTitle = "Nouveau utilisateur";
      $this->render("users/signup", compact('pageTitle', 'error'));
   }

   /**
    * connexion 
    * @return void
    */

   public function signIn()
   {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $username = null;
         if (!empty($_POST['username'])) $username = $_POST['username'];
         if (!empty($_POST['password'])) $password = $_POST['password'];

         if (!$username || !$password) {
            $this->error = 'Veuillez renseigner tous les champs!';
         } else {
            $user = $this->model->fetchOneUser($username);
            if (!$user) {
               $this->error = 'utilisateur et\ou mot de passe incorrect';
            } else {
               $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);
               if (password_verify($password, $user->getPassword())) {
                  $this->model->login($user->getId());
                  $this->redirect();
               } else {
                  $this->error = 'Mot de passe invalide!';
               }
            }
         }
      }

      $pageTitle = "S'identifier";
      $error = $this->error;
      $this->render("users/signin", compact('pageTitle', 'error'));
   }

   /**
    * déconnexion 
    * @return void
    */

   public function signOut()
   {
      $sessionId = $_COOKIE['session'] ?? '';
      if ($sessionId) $this->model->logout($sessionId);

      $this->redirect([
         "type" => "user",
         "action" => "signin",
      ]);
   }
}
