<div class="w-100 d-flex flex-column align-items-center">
   <h3 class='fw-bold fs-6 mb-4 w-50'><i class="fas fa-angle-right text-primary"></i> Se connecter</h3>
   <form class="w-50" method="POST">
      <div class="form-group mb-2">
         <label class="form-label">Utilisateur</label>
         <input type="text" class="form-control" name="username">
      </div>
      <div class="form-group mb-2">
         <label class="form-label">Mot de passe</label>
         <input type="password" class="form-control" name="password">
      </div>
      <div class="d-flex justify-content-end align-items-center">
         <button class="btn p-0 "><i class="text-success fs-5 far fa-plus-square"></i></button>
      </div>
      <?php if ($error) : ?>
         <p class="alert alert-danger"> <?= $error ?></p>
      <?php endif ?>
   </form>
</div>