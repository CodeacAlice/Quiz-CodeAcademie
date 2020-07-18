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