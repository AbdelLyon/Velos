<div class=" d-flex justify-content-around  shadow w-75 bg-white">
   <div class="d-flex justify-content-center w-50">
      <img height="300" src='assets/images/<?= $velo->getImage() ?>' />
   </div>
   <div class='ingredients w-50 my-4 px-4 d-flex flex-column'>
      <div class="flex-fill border-start ps-3">
         <h2 class='fw-bold fs-4 text-center '> <?= $velo->getName() ?> </h2>
         <h3 class='fw-bold fs-6 pt-2'> Déscription </h3>
         <p> <?= $velo->getDescription() ?> </p>
         <p> <?= $velo->getPrice() ?> € </p>

      </div>
      <div class="d-flex justify-content-end">
         <form method="POST" action="/?type=velo&action=delete">
            <button id="link-deleteCocktail" class="btn" name="id" value="<?= $velo->getId() ?>">
               <i class="far fa-minus-square text-danger fs-4"></i>
               <p class="link-deleteCocktail hidden">Suprimer</p>
            </button>
         </form>
         <a id="link-editeCocktail" class="btn" href="/?type=velo&action=edit&id=<?= $velo->getId() ?>">
            <i class="fas fa-pen-square text-success fs-4"></i>
            <p class="link-editeCocktail hidden">Modifier</p>
         </a>
      </div>
   </div>
</div>


<div class=" w-75 mt-5">
   <div class="d-flex justify-content-between">
      <h3 class="fw-bold fs-6 pb-2"><i class="fas fa-angle-right text-primary"></i> Ajouter un avis</h3>
   </div>

   <form id="form-create-message" method="post" action="/?type=avis&action=new">
      <div class=" form-floating mb-2">
         <input type="text" class="form-control" name="author">
         <label for="floatingTextarea2">Nom</label>
      </div>
      <div class="form-floating mb-2">
         <textarea type="text" class="form-control" name="content"></textarea>
         <label for="floatingTextarea2">Avis</label>
      </div>
      <div class="d-flex justify-content-end my-2">
         <button id="link-addComment" class="btn p-0" name="id" value="<?= $velo->getId() ?>"><i class="text-success fs-4 far fa-plus-square"></i>
            <p class="link-addComment hidden">Ajouter</p>
         </button>
      </div>
   </form>
</div>

<div class="accordion w-75">
   <h3 class='fw-bold fs-6 mb-4'><i class="fas fa-angle-right text-primary"></i> Avis</h3>
   <div class="accordion-item my-4 border-0">
      <h2 class="accordion-header">
         <button class="accordion-button bg-secondary text-white fw-bold collapsed title-comments-cocktail"><?= $velo->getName() ?></button>
      </h2>
      <?php if (!empty($avis)) : ?>
         <div class="accordion-collapse collapse show content-comments-cocktail bg-light">
            <div class="accordion-body ">
               <?php foreach ($avis as $avi) : ?>
                  <div class='list-comment'>
                     <div class='d-flex flex-column ms-2 w-100'>
                        <h5 class='fw-bold fs-6 mb-4'> <?= $avi->getAuthor() ?> </h5>
                        <p><?= $avi->getContent() ?></p>
                     </div>
                     <div class="d-flex justify-content-end">
                        <form method="POST" action="/?type=avis&action=delete">
                           <button id="link-deleteComment" class="btn" name="id" value="<?= $avi->getId() ?>">
                              <i class="far fa-minus-square text-danger fs-4"></i>
                           </button>
                        </form>
                        <a class="btn" href="/?type=avis&action=edit&avisId=<?= $avi->getId() ?>">
                           <i class="fas fa-pen-square text-success fs-4 mx-2"></i>
                        </a>
                     </div>
                  </div>
               <?php endforeach ?>
            </div>
         </div>
      <?php endif ?>
   </div>
</div>