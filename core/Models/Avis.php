<?php

namespace Models;

use JsonSerializable;

class Avis extends AbstractModel implements JsonSerializable
{
   protected string $table = "avis";
   private int $id;
   private string $author;
   private string $content;
   private int $velo_id;

   public function getId(): ?int
   {
      return $this->id;
   }

   public function getAuthor(): ?string
   {
      return $this->author;
   }

   public function setAuthor(string $author): void
   {
      $this->author = $author;
   }

   public function getContent(): ?string
   {
      return $this->content;
   }

   public function setContent(string $content): void
   {
      $this->content = $content;
   }

   public function getVeloId(): ?int
   {
      return $this->velo_id;
   }

   public function setVeloId(int $veloId): void
   {
      $this->velo_id = $veloId;
   }

   /**
    * trouve tous les commentaires associés à un cocktail
    * @param object
    * @return array|bool 
    */

   public function findAllByVelo(Velo $velo): array | bool
   {
      $requete = $this->pdo->prepare("SELECT * FROM $this->table WHERE velo_id = :velo_id");
      $requete->execute(["velo_id" => $velo->getId()]);
      return $requete->fetchAll(\PDO::FETCH_CLASS, get_class($this));
   }

   /**
    * edite un velo dans la base de données
    * @param integer $Id
    * @param object $avis
    * @return void
    */

   public function edit(Avis $avis): void
   {
      $statementEdit = $this->pdo->prepare("UPDATE $this->table SET author = :author, content = :content WHERE id = :id");
      $statementEdit->execute([
         'author' => $avis->getAuthor(),
         'content' => $avis->getContent(),
         "id" => $avis->getId()
      ]);
   }


   public function jsonSerialize(): mixed
   {
      return [
         "id" => $this->getId(),
         "content" => $this->getContent(),
         "author" => $this->getAuthor(),

      ];
   }
}
