<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Vujahday+Script&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="assets/js/index.js" defer></script>
  <title><?= $pageTitle ?></title>
</head>

<body>
  <div class="app d-flex flex-column bg-light ">
    <header>
      <nav class="navbar navbar-expand-sm navbar-primary bg-white shadow px-5 d-flex">
        <a class="flex-fill navbar-brand" href="/"><i class="fas fa-biking"></i></a>
        <ul class="navbar-nav me-auto mb-2">
          <?php if (!Models\User::findCurrentUser()) : ?>
            <a id="link-register" class="nav-link me-5" href="/?type=user&action=signup"><i class="fas fa-user-plus fs-6"></i>
              <p class="link-register hidden">Inscription</p>
            </a>
            <a id="link-addCocktail" class="nav-link me-5" href="/?type=user&action=signin"><i class="fas fa-sign-in-alt fs-6"></i>
              <p class="link-addCocktail hidden">Connexion</p>
            </a>
          <?php else : ?>
            <a id="link-register" class="nav-link me-5" href="/?type=user&action=signout"><i class="fas fa-sign-out-alt fs-6"></i>
              <p class="link-register hidden">Déconnexion</p>
            </a>
            <a id="link-addCocktail" class="nav-link" href="/?type=velo&action=new"><i class="far fa-plus-square fs-6"></i>
              <p class="link-addCocktail hidden">Ajouter vélo</p>
            </a>
          <?php endif ?>
        </ul>
      </nav>
    </header>
    <main class="flex-fill my-5">
      <div class="page-content">
        <?= $pageContent ?>
      </div>
    </main>
    <footer class="py-4">
      <h3 class="text-center text-white">Footer</h3>
    </footer>
  </div>
</body>

</html>