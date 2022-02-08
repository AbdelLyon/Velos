<?php

namespace Models;

use App\Request;
use Models\AbstractModel;

class User extends AbstractModel
{
   protected string $table = "users";

   private $id;
   private $username;
   private $password;
   private $email;
   private $display_name;

   private \PDOStatement $statementCreateUser;
   // private \PDOStatement $statementUpdateUser;
   private \PDOStatement $statementGetOneUser;
   private \PDOStatement $statementSession;
   private \PDOStatement $GetStatementSession;
   private \PDOStatement $deleteStatementSession;

   function __construct()
   {
      parent::__construct();

      $this->statementCreateUser = $this->pdo->prepare("INSERT INTO $this->table VALUES (DEFAULT, :username, :email, :password, :display_name)");
      // $this->statementUpdateUser = $this->pdo->prepare("UPDATE $this->table SET username=:username, email=:email, password=:password WHERE id=:id");
      $this->statementGetOneUser = $this->pdo->prepare("SELECT * FROM $this->table WHERE username=:username");
      $this->statementSession = $this->pdo->prepare("INSERT INTO session VALUES (:id,:userid)");
      $this->GetStatementSession = $this->pdo->prepare("SELECT * FROM session JOIN $this->table  on users.id=session.userid WHERE session.id=:id");
      $this->deleteStatementSession = $this->pdo->prepare("DELETE FROM session WHERE id=:id");
   }

   public function getId(): ?int
   {
      return $this->id;
   }

   public function getUsername(): ?string
   {
      return $this->username;
   }

   public function setUsername(string $username): void
   {
      $this->username = $username;
   }

   public function getPassword(): ?string
   {
      return $this->password;
   }

   public function setPassword(string $password): void
   {
      $this->password = password_hash($password, PASSWORD_DEFAULT);
   }

   public function getEmail(): ?string
   {
      return $this->email;
   }

   public function setEmail(string $email): void
   {
      $this->email = $email;
   }

   public function getDisplayName(): ?string
   {
      return $this->display_name;
   }

   public function setDisplayName(string $display_name): void
   {
      $this->display_name = $display_name;
   }

   /**
    * creer un utilisateur
    * @param User $user
    * @return User|bool 
    */

   public function register(User $user): void
   {

      $this->statementCreateUser->execute([
         ':username' => $user->getUsername(),
         ':email' => $user->getEmail(),
         ':password' => $user->getPassword(),
         ':display_name' => $user->getDisplayName()
      ]);
   }

   /**
    * creer un utilisateur
    * @param string $username
    * @return User|bool 
    */

   public function findOneUser(string $username): User | bool
   {
      $this->statementGetOneUser->execute([":username" => $username]);
      $this->statementGetOneUser->setFetchMode(\PDO::FETCH_CLASS, get_class($this));
      return $this->statementGetOneUser->fetch();
   }

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
      return;
   }



   static function findCurrentUser(): bool | User
   {

      $request = new Request();

      $sessionId = $_COOKIE['session'] ?? '';
      $signature = $_COOKIE['signature'] ?? '';

      $sessionId = $request->cookie('session');
      $signature = $request->cookie('signature');
      if ($sessionId && $signature) {
         $hash = hash_hmac('sha256', $sessionId, 'majax');
         if (hash_equals($hash, $signature)) {
            $user = new User;
            $user->GetStatementSession->execute([':id' => $sessionId]);
            $user->GetStatementSession->setFetchMode(\PDO::FETCH_CLASS, get_class($user));
            $user =  $user->GetStatementSession->fetch();
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
