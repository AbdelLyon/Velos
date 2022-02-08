<?php

namespace Controllers;

use App\File;
use Models\Avis;
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

   public function indexApi(): void
   {
      $this->json($this->model->findAll());
   }



   public function showApi(): void
   {

      $id = $this->request->get('id');

      // if (!empty($_GET['id']) && ctype_digit($_GET['id'])) $id = $_GET['id'];
      if (!$id) $this->redirect();

      $velo = $this->model->findById($id);

      if (!$velo) $this->redirect();

      $this->json($this->model->findById($id));
   }


   /**
    * creer un vélo 
    * @return void
    */

   public function new(): void
   {

      $name = $this->request->post("name");
      $description = $this->request->post("description");
      $price = $this->request->post("price");
      $image = $this->request->file("image");

      if ($name && $description && $price && $image) {


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

         $newVelo = $this->model->insert([
            "name" => $velo->getName(),
            "description" => $velo->getDescription(),
            "image" => $velo->getImage(),
            "price" => $velo->getPrice(),
            'userid' => $velo->getAuthor()->getId()
         ]);

         $this->redirect([
            "action" => "show",
            "id" => $newVelo->getId(),
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
      $id = $this->request->get('id');

      if (!$id) $this->redirect();

      $velo = $this->model->findById($id);

      if (!$velo) $this->redirect();

      $author = $velo->getAuthor();

      $modelAvis = new Avis();
      $avis =  $modelAvis->findAllByVelo($velo);
      $pageTitle = $velo->getName();

      $this->render("velos/show", compact('pageTitle', 'velo', 'avis', 'author'));
   }

   /**
    * supprimer un velo par son ID et rediriger vers l'index des velos
    *@return void
    */

   public function delete(): void
   {
      $id = $this->request->post('id');

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
      // Valider le velo édité
      if ($_SERVER['REQUEST_METHOD'] === "POST") {

         $id = $this->request->post('id');
         $name = $this->request->post('name');
         $description = $this->request->post('description');
         $price = $this->request->post('price');
         $image = $this->request->file("image");

         if ($id && $name && $description && $price && $image) {

            $file = new File("image");
            $file->upload();

            if (!$file->isImage()) $this->redirect(["action" => "show", "id" => $id]);

            $velo = $this->model->findById($id);

            $velo->setName($name);
            $velo->setDescription($description);
            $velo->setPrice($price);
            $velo->setImage($file->getNameFile());

            $this->model->edit($velo);
         }

         $this->redirect([
            "action" => "show",
            "id" => $id
         ]);
      }

      // Récuperer le velo à éditer
      $id = $this->request->get('id');
      if ($id) {
         $velo = $this->model->findById($id);

         if (!$velo) $this->redirect();

         $pageTitle = "Modifier {$velo->getName()}";
         $this->render("velos/edit", compact('pageTitle', 'velo'));
      } else {
         $this->redirect(["info" => "noId"]);
      }
   }
}
