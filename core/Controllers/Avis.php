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
      $avisId = $this->request->post('id');
      $author = $this->request->post('author');
      $content = $this->request->post('content');

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

      $newAvis = $avis->insert([
         "author" => $avis->getAuthor($author),
         "content" => $avis->getContent($content),
         "velo_id" => $avis->getVeloId($velos->getId())
      ]);

      $this->redirect([
         "action" => "show",
         "id" => $newAvis->getVeloId()
      ]);
   }

   /**
    * suprimer un avisaire 
    * @return void
    */

   public function delete()
   {
      $id = $this->request->post('id');
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

      $avisId = $this->request->post('id');
      $veloId = $this->request->post('velo_id');
      $author = $this->request->post('author');
      $content = $this->request->post('content');

      // Valider le velo édité
      if ($_SERVER['REQUEST_METHOD'] === "POST") {

         if ($avisId && $veloId && $author && $content) {

            // on vérifie si le cocktail existe bien avant de l'editer
            $avis = $this->model->findById($avisId);

            $avis->setAuthor($author);
            $avis->setContent($content);
            $avis->setVeloId($veloId);

            $this->model->edit($avis);
         }

         $this->redirect([
            "action" => "show",
            "id" => $avis->getVeloId()
         ]);
      }

      // Récuperer le velo à éditer
      $id = $this->request->get('avisId');
      if (!$id) {
         $avis = $this->model->findById($id);

         if (!$avis) $this->redirect();
         $pageTitle = "Modifier {$avis->getAuthor()}";

         $this->render("avis/edit", compact('pageTitle', 'avis'));
      } else {
         $this->redirect(["info" => "noId"]);
      }
   }
}
