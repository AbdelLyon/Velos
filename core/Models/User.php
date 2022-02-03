<?php

namespace Models;

use Models\AbstractModel;

class User extends AbstractModel
{
   protected string $table = "users";

   private $id;
   private $username;
   private $password;
   private $email;
   private $displayName;

   private \PDOStatement $statementCreateUser;
   // private \PDOStatement $statementGetOneUser;
   // private \PDOStatement $statementUpdateUser;
   // private \PDOStatement $statementGetAllUser;
   private \PDOStatement $statementSession;
   private \PDOStatement $deleteStatementSession;
   private \PDOStatement $GetStatementSession;

   function __construct()
   {
      parent::__construct();

      $this->statementCreateUser = $this->pdo->prepare("INSERT INTO $this->table VALUES (DEFAULT, :username, :email, :password, :display_name)");
      $this->statementUpdateUser = $this->pdo->prepare("UPDATE $this->table SET username=:username, email=:email, password=:password WHERE id=:id");
      $this->statementGetOneUser = $this->pdo->prepare("SELECT * FROM $this->table WHERE username=:username");
      $this->statementSession = $this->pdo->prepare("INSERT INTO session VALUES (:id,:userid)");
      $this->deleteStatementSession = $this->pdo->prepare("DELETE FROM session WHERE id=:id");
      $this->GetStatementSession = $this->pdo->prepare("SELECT * FROM session JOIN $this->table  on users.id=session.userid WHERE session.id=:id");
   }

   public function getId()
   {
      return $this->id;
   }

   public function getUsername()
   {
      return $this->username;
   }

   public function setUsername($username): void
   {
      $this->username = $username;
   }

   public function getPassword()
   {
      return $this->password;
   }

   public function setPassword($password): void
   {
      $this->password = password_hash($password, PASSWORD_DEFAULT);
   }

   public function getEmail()
   {
      return $this->email;
   }

   public function setEmail($email): void
   {
      $this->email = $email;
   }

   public function getDisplayName()
   {
      return $this->displayName;
   }

   public function setDisplayName($displayName): void
   {
      $this->displayName = $displayName;
   }

   /**
    * creer un utilisateur
    * @param User $user
    * @return User|bool 
    */

   public function register(User $user): User | bool
   {
      $this->statementCreateUser->execute([
         ':username' => $user->getUsername(),
         ':email' => $user->getEmail(),
         ':password' => $user->getPassword(),
         ':display_name' => $user->getDisplayName()
      ]);

      return $this->findById($this->pdo->lastInsertId());
   }


   /**
    * creer un utilisateur
    * @param string $username
    * @return User|bool 
    */

   public function fetchOneUser(string $username): User | bool
   {
      $this->statementGetOneUser->execute([":username" => $username]);
      $this->statementGetOneUser->setFetchMode(\PDO::FETCH_CLASS, get_class($this));
      return $this->statementGetOneUser->fetch();
   }


   // public function update(array $user): void
   // {
   //    $this->statementUpdateUser->bindValue(':username', $user['username']);
   //    $this->statementUpdateUser->bindValue(':email', $user['email']);
   //    $this->statementUpdateUser->bindValue(':password', $user['password']);
   //    $this->statementUpdateUser->bindValue(':display_name', $user['display_name']);
   //    $this->statementUpdateUser->bindValue(':id', $user['id']);
   //    $this->statementUpdateUser->execute();
   // }

   public function login(string $userId): void
   {
      $sessionId = bin2hex(random_bytes(32));
      $this->statementSession->execute([
         ':id' => $sessionId,
         ':userid' => $userId
      ]);
      $signature = hash_hmac('sha256', $sessionId, 'majax');
      setcookie('session', $sessionId, time() + 60 * 60 * 24 * 14, '/', '', false, true);
      setcookie('signature', $signature, time() + 60 * 60 * 24 * 14, '/', '', false, true);
   }



   function isLoggedIn(): bool | object
   {
      $sessionId = $_COOKIE['session'] ?? '';
      $signature = $_COOKIE['signature'] ?? '';
      if ($sessionId && $signature) {
         $hash = hash_hmac('sha256', $sessionId, 'majax');
         if (hash_equals($hash, $signature)) {
            $this->GetStatementSession->execute([':id' => $sessionId]);
            $user =  $this->GetStatementSession->fetch();
         }
      }
      return $user ?? false;
   }

   public function logout(string $sessionId): void
   {
      $this->deleteStatementSession->execute([':id' => $sessionId]);
      setcookie('session', "", time() - 1, '/');
      setcookie('signature', "", time() - 1, '/');
   }
}
