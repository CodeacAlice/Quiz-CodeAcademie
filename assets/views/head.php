<!doctype html>
<html lang="fr">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?= $path ?>/assets/css/bootstrap.min.css">

  <!-- jQuery -->
  <script src="<?= $path ?>/assets/js/jquery.js"></script>

  <title><?= $titlepage ?> - [Code Academie] Promo #3 - Quiz</title>

  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="<?= $path ?>/assets/css/stylesheet.css">
  <link rel="stylesheet" type="text/css" href="<?= $path ?>/assets/css/homepage.css">

</head>
<body>

<header>
    <div style="width:100%;">
        <img id="logo_codeac" src="<?= $path ?>/assets/img/Logo-code-academie.jpg" alt="Logo de la Code Académie">
        <img id="logo_face" src="<?= $path ?>/assets/img/Logo-face-rennes.png" alt="Logo de FACE Rennes">
    </div>

    <?php if ($_SESSION) { 
        if (isset($_SESSION['Admin'])) {$name = $_SESSION['Admin'];}
        else {$name = $_SESSION['Loger'];}
    ?>
    <div>
        <?php include($path."/assets/img/accountbutton.svg"); ?>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <h6 class="dropdown-header"><?= $name ?></h6>
            <a class="dropdown-item" href="homepage.php">Accueil</a>
            <a class="dropdown-item" href="moncompte.php">Mon compte</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="../deconnexion.php">Déconnexion</a>
        </div>
    </div>
    <?php } ?>
</header>
