<?php

namespace Models;

class Velo extends AbstractModel implements \JsonSerializable
{
   protected string $table = "velos";
   private int $id;
   private string $name;
   private string $description;
   private string $image;
   private int $price;
   private int $userid;

   public function getId(): ?int
   {
      return $this->id;
   }

   public function getName(): ?string
   {
      return $this->name;
   }

   public function setName(string $name): void
   {
      $this->name = $name;
   }

   public function getDescription(): ?string
   {
      return $this->description;
   }

   public function setDescription(string $description): void
   {
      $this->description = $description;
   }

   public function getImage(): ?string
   {
      return $this->image;
   }

   public function setImage(string $image): void
   {
      $this->image = $image;
   }

   public function getPrice(): ?int
   {
      return $this->price;
   }

   public function setPrice(string $price): void
   {
      $this->price = $price;
   }

   public function getAuthor(): ?User
   {
      $modelUser = new User;
      return $modelUser->findById($this->userid);
   }

   public function setAuthor(int $userid): void
   {
      $this->userid = $userid;
   }

   /**
    * edite un velo dans la base de données
    * @param integer $Id
    * @param object $velo
    * @return void
    */

   public function edit(Velo $velo): void
   {
      $statementEdit = $this->pdo->prepare("UPDATE $this->table SET name = :name, image = :image, description = :description, price = :price WHERE id = :id");
      $statementEdit->execute([
         "id" => $velo->id,
         'name' => $velo->name,
         'description' => $velo->description,
         'image' => $velo->image,
         "price" => $velo->price
      ]);
   }

   public function jsonSerialize(): mixed
   {
      $model = new Avis();
      $author = $model->findAllByVelo($this);
      return [
         "id" => $this->id,
         "name" => $this->name,
         "description" => $this->description,
         "image" => $this->image,
         "author" => $author
      ];
   }
}
