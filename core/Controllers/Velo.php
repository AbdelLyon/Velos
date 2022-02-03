<?php

namespace Controllers;

use App\File;
use Models\Avis;
use Models\User;
use Models\Velo as ModelVelo;

class Velo extends AbstractController
{
   protected string $modelName = ModelVelo::class;

   /**
    * affiche l'accueil 
    *@return void
    */

   public function index(): void
   {
      $velos = $this->model->findAll();
      $pageTitle = "Accueil";
      $this->render("velos/index", compact('pageTitle', 'velos'));
   }

   /**
    * creer un vélo 
    * @return void
    */

   public function new(): void
   {

      $name = null;
      $description = null;
      $price = null;

      if (!empty($_POST['name'])) $name = htmlspecialchars($_POST['name']);
      if (!empty($_POST['description'])) $description = htmlspecialchars($_POST['description']);
      if (!empty($_POST['price']) && ctype_digit($_POST['price']))  $price = $_POST['price'];

      if ($name && $description && $price && !empty($_FILES['image'])) {

         $file = new File("image");
         $file->upload();

         if (!$file->isImage()) $this->redirect(["action" => "new"]);

         $author = $this->getUser();

         $velo = new ModelVelo();

         $velo->setName($name);
         $velo->setDescription($description);
         $velo->setImage($file->getNameFile());
         $velo->setPrice($price);
         $velo->setAuthor($author->getId());



         $id = $this->model->insert([
            "name" => $velo->getName(),
            "description" => $velo->getDescription(),
            "image" => $velo->getImage(),
            "price" => $velo->getPrice(),
            'userid' => $velo->getAuthor()
         ]);

         $this->redirect([
            "action" => "show",
            "id" => $id,
         ]);
      };

      $pageTitle = "Nouveau velo";
      $this->render("velos/create", compact('pageTitle'));
   }

   /**
    * afficher un velo et ses commentaires
    * @return void
    */

   public function show(): void
   {
      $id = null;

      if (!empty($_GET['id']) && ctype_digit($_GET['id'])) $id = $_GET['id'];
      if (!$id) $this->redirect();

      $velo = $this->model->findById($id);

      if (!$velo) $this->redirect();

      $modelUser = new User;

      $author = $modelUser->findById($velo->getAuthor());


      $modelAvis = new Avis();
      $avis =  $modelAvis->findAllByVelo($id);
      $pageTitle = $velo->getName();

      $this->render("velos/show", compact('pageTitle', 'velo', 'avis', 'author'));
   }


   /**
    * supprimer un velo par son ID et rediriger vers l'index des velos
    *@return void
    */

   public function delete(): void
   {
      $id = null;
      if (!empty($_POST['id']) && ctype_digit($_POST['id'])) $id = $_POST['id'];

      if (!$id) $this->redirect(["info" => "noId"]);
      $velo = $this->model->findById($id);

      if (!$velo) $this->redirect();

      $this->model->remove($id);
      $this->redirect(["info" => "deleted"]);
   }


   /**
    * editer un velo 
    * @return void
    */

   public function edit(): void
   {
      $id = null;
      $name = null;
      $description = null;
      $price = null;

      // Valider le velo édité
      if ($_SERVER['REQUEST_METHOD'] === "POST") {
         if (!empty($_POST['id']) && ctype_digit($_POST['id'])) $id = $_POST['id'];
         if (!empty($_POST['name'])) $name = htmlspecialchars($_POST['name']);
         if (!empty($_POST['description'])) $description = htmlspecialchars($_POST['description']);
         if (!empty($_POST['price']) && ctype_digit($_POST['price'])) $price = $_POST['price'];


         if ($id && $name && $description && $price && !empty($_FILES['image'])) {

            $file = new File("image");
            $file->upload();

            if (!$file->isImage()) $this->redirect(["action" => "show", "id" => $id]);

            $velo = new ModelVelo();

            $velo->setName($name);
            $velo->setDescription($description);
            $velo->setPrice($price);
            $velo->setImage($file->getNameFile());


            $this->model->edit($id, $velo);
         }

         $this->redirect([
            "action" => "show",
            "id" => $id
         ]);
      }

      // Récuperer le velo à éditer
      if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {

         $id = $_GET['id'];
         $velo = $this->model->findById($id);

         if (!$velo) $this->redirect();

         $pageTitle = "Modifier {$velo->getName()}";
         $this->render("velos/edit", compact('pageTitle', 'velo'));
      } else {
         $this->redirect(["info" => "noId"]);
      }
   }
}
