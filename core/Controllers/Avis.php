<?php

namespace Controllers;

use Models\Avis as ModelAvis;
use Models\Velo;

class Avis extends AbstractController
{
   protected object $model;
   protected string $modelName = ModelAvis::class;

   /**
    * creer un avisaire 
    * @return void
    */

   public function new()
   {
      $avisId = null;
      $author = null;
      $content = null;

      if ((!empty($_POST['id']) && ctype_digit($_POST['id'])))  $avisId = $_POST['id'];
      if (!empty($_POST['author'])) $author = htmlspecialchars($_POST['author']);
      if (!empty($_POST['content'])) $content = htmlspecialchars($_POST['content']);

      if (!$avisId  || !$author || !$content) $this->redirect([
         "action" => "show",
         "id" => $avisId
      ]);

      // on vérifie si le cocktail existe bien avant de le aviser
      $modelVelo = new Velo();

      $velos = $modelVelo->findById($avisId);
      if (!$velos) $this->redirect(["id" => "noId"]);

      // on vérifie si le cocktail existe bien avant de le aviser
      $avis = new ModelAvis();
      $avis->setAuthor($author);
      $avis->setContent($content);
      $avis->setVeloId($velos->getId());

      $avis->insert([
         "author" => $avis->getAuthor($author),
         "content" => $avis->getContent($content),
         "velo_id" => $avis->getVeloId($velos->getId())
      ]);

      $this->redirect([
         "action" => "show",
         "id" => $avis->getVeloId()
      ]);
   }

   /**
    * suprimer un avisaire 
    * @return void
    */

   public function delete()
   {
      $id = null;
      if (!empty($_POST['id']) && ctype_digit($_POST['id']))  $id = $_POST['id'];
      if (!$id) die("Erreur ID");

      //verifier que le avisaire existe
      $avis = $this->model->findById($id);
      if (!$avis) $this->redirect(["info" => "noId"]);
      $this->model->remove($id);

      $this->redirect([
         "action" => "show",
         "id" => $avis->getVeloId()
      ]);
   }



   /**
    * editer un velo 
    * @return void
    */

   public function edit(): void
   {
      $avisId = null;
      $veloId = null;
      $author = null;
      $content = null;

      // Valider le velo édité
      if ($_SERVER['REQUEST_METHOD'] === "POST") {
         if ((!empty($_POST['id']) && ctype_digit($_POST['id'])))  $avisId = $_POST['id'];
         if ((!empty($_POST['velo_id']) && ctype_digit($_POST['velo_id'])))  $veloId = $_POST['velo_id'];
         if (!empty($_POST['author'])) $author = htmlspecialchars($_POST['author']);
         if (!empty($_POST['content'])) $content = htmlspecialchars($_POST['content']);

         if ($author && $content && $avisId) {

            // on vérifie si le cocktail existe bien avant de l'editer
            $avis = new ModelAvis();
            $avis->setAuthor($author);
            $avis->setContent($content);
            $avis->setVeloId($veloId);

            $this->model->edit($avisId, $avis);
         }

         $this->redirect([
            "action" => "show",
            "id" => $avis->getVeloId()
         ]);
      }

      // Récuperer le velo à éditer
      if (!empty($_GET['avisId']) && ctype_digit($_GET['avisId'])) {
         $id = $_GET['avisId'];
         $avis = $this->model->findById($id);

         if (!$avis) $this->redirect();
         $pageTitle = "Modifier {$avis->getAuthor()}";

         $this->render("avis/edit", compact('pageTitle', 'avis'));
      } else {
         $this->redirect(["info" => "noId"]);
      }
   }
}
