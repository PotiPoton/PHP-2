<?php
    require_once './function/Functions.php';

    if(isset($_POST['disconnect'])) Disconnect();
?>

<nav id="navbar">
    <h1>TP PHP GSB</h1>
    <h3>Bienvenue <?php echo $oVisitor->Prenom(); ?></h3>
    <a href="./home.php" <?php if (basename($_SERVER['PHP_SELF']) == 'home.php') echo "id='active'"; ?> >Accueil</a>
    <a href="./saisirFicheFrais.php" <?php if(basename($_SERVER['PHP_SELF']) == 'saisirFicheFrais.php') echo "id='active'"; ?> >Fiche de Frais</a>
    <div class="cnt bottom">
        <form action="" method="POST">
            <input type="submit" name="disconnect" value="Se déconnecter">
        </form>
    </div>

</nav>