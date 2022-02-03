<?php

namespace App;

class File
{
   private array $fileData;
   private string $tempNameFile;
   private string $newNameFile;
   private string $target;
   private string $mimeType;
   private  $formatsAcceptes = ['image/jpg', 'image/jpeg', 'image/png'];

   public function __construct(string $index)
   {
      $this->fileData = $_FILES[$index];
      $this->mimeType = $this->fileData['type'];
      $this->tempNameFile = $this->fileData['tmp_name'];
      $this->newNameFile = uniqid() . "." . pathinfo($this->fileData['name'], PATHINFO_EXTENSION);
      $this->target = dirname(__DIR__) . "/../assets/images/" . $this->newNameFile;
   }

   public function getNameFile(): string
   {
      return $this->newNameFile;
   }

   public function upload(): void
   {
      move_uploaded_file($this->tempNameFile, $this->target);
   }

   public function isImage(): bool
   {
      return \in_array($this->mimeType, $this->formatsAcceptes);
   }
}
