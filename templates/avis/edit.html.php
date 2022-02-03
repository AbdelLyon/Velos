<form class="w-50" method="post" action="/?type=avis&action=edit">
   <div class=" form-floating mb-2">
      <input type="text" class="form-control" name="author" value="<?= $avis->getAuthor() ?>">
      <label for="floatingTextarea2">Nom</label>
   </div>
   <div class="form-floating mb-2">
      <input type="text" class="form-control" name="content" value="<?= $avis->getContent() ?>">
      <label for="floatingTextarea2">Avis</label>
   </div>
   <input type="hidden" class="form-control" name="velo_id" value="<?= $avis->getVeloId() ?>">
   <div class="d-flex justify-content-end align-items-center">
      <button class="btn p-0" name="id" value="<?= $avis->getId() ?>"><i class="text-success fs-5 far fa-plus-square"></i></button>
   </div>
</form>