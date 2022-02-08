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
      if ($_SERVER['REQUEST_METHOD'] === "POST") {

         $username = $this->request->post('username');
         $email = $this->request->post('email');
         $password = $this->request->post('password');
         $displayName = $this->request->post('display_name');


         if (!$username || !$email || !$password || !$displayName) {
            $this->error = 'Veuillez renseigner tous les champs!';
         } else {
            $userModel = new ModelUser;
            $users = $userModel->findAll();

            //vérifier si usename ou emeil existe dans bd
            $user = \array_filter($users, fn ($user) => $user->getUsername() === $username || $user->getEmail() === $email);
            if (!empty($user)) {
               $this->error = 'utilisateur existe dejà!';
            } else {

               $modelUser = new ModelUser();
               $modelUser->setUserName($username);
               $modelUser->setEmail($email);
               $modelUser->setPassword($password);
               $modelUser->setDisplayName($displayName);
               $modelUser->register($modelUser);

               // connecter l'utilisateur uen foi enrgesté dans la bd
               $this->signIn();

               $this->redirect();
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
         $username = $this->request->post('username');
         $password = $this->request->post('password');

         if (!$username || !$password) {
            $this->error = 'Veuillez renseigner tous les champs!';
         } else {
            $user = $this->model->findOneUser($username);
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
      // $sessionId = $_COOKIE['session'] ?? '';
      $sessionId = $this->request->cookie('session');
      if ($sessionId) $this->model->logout($sessionId);

      $this->redirect([
         "type" => "user",
         "action" => "signin",
      ]);
   }
}
