<div class="w-100 d-flex flex-column align-items-center">
   <h3 class='fw-bold fs-6 mb-4 w-50'><i class="fas fa-angle-right text-primary"></i> Modifier</h3>
   <form class="w-50" method="post" action="/?=type=velo&action=edit" enctype="multipart/form-data">
      <div class=" form-group mb-2">
         <label class="form-label">Nom</label>
         <input type="text" class="form-control" name="name" value="<?= $velo->getName() ?>">
      </div>
      <div class="form-group mb-2">
         <label class="form-label">Déscription</label>
         <input type="text" class="form-control" name="description" value="<?= $velo->getDescription() ?>">
      </div>
      <div class="form-group mb-2">
         <label class="form-label">Prix</label>
         <input type="text" class="form-control" name="price" value="<?= $velo->getPrice() ?>">
      </div>
      <div class="form-group mb-2">
         <label class="form-label">Image</label>
         <input type="file" class="form-control form-control-md" name="image" value="<?= "assets/images/" . $velo->getImage() ?>">
      </div>
      <div class="d-flex justify-content-end align-items-center">
         <button class="btn p-0" name="id" value="<?= $velo->getId() ?>"><i class="text-success fs-5 far fa-plus-square"></i></button>
      </div>
   </form>
</div>