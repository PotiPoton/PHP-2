<?php
    if(isset($_POST['btn-fhf'])){
        if(!empty($_POST['lib-fhf']) && !empty($_POST['mnt-fhf'])){
            $inputLibFhf = htmlspecialchars($_POST['lib-fhf']);
            $inputMntFhf = htmlspecialchars($_POST['mnt-fhf']);
            
            $oLignesFraisHorsForfait->AddLigneFraisHorsForfait($inputLibFhf, $inputMntFhf);
            // header('Refresh');
        }
        else $errorMsg = "Il manque au moins une information";
    }
?>

<div class="cnt box">
    <h2>Saisie des frais hors forfait</h2>
    <form action="" method="POST">
        <input type="text" name="lib-fhf" placeholder="Entrer le libellé des frais">
        <input type="number" name="mnt-fhf" placeholder="Entrer le montant des frais" step="0.01">
        <input class="save" type="submit" name="btn-fhf" value="Enregistrer">
    </form>
    <?php require_once "error-handling.php"; ?>
</div>