<header>
    <div style="width:100%;">
        <img id="logo_codeac" src="<?= $path ?>/assets/images/Logo-code-academie.jpg" alt="Logo de la Code Académie">
        <img id="logo_face" src="<?= $path ?>/assets/images/RENNES_PNG.png" alt="Logo de FACE Rennes">
    </div>
    <?php if ($_SESSION) { ?>
    <div>
        <?php include($path."/assets/images/accountbutton.svg"); ?>
    </div>
    <?php } ?>
</header>