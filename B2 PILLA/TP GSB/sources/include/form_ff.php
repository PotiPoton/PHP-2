<?php
    if(isset($_POST['btn-ff'])){
        if(!empty($_POST['ff-etape']) || !empty($_POST['ff-km']) || !empty($_POST['ff-hotel']) || !empty($_POST['ff-resto'])){
            $inputEtape = htmlspecialchars($_POST['ff-etape']);
            $inputKm = htmlspecialchars($_POST['ff-km']);
            $inputHotel = htmlspecialchars($_POST['ff-hotel']);
            $inputResto = htmlspecialchars($_POST['ff-resto']);

            echo "CACAPROUT";
            // $oFichesFrais->AddLigneFraisForfait($inputLibFhf, $inputMntFhf);
        }
        else $errorMsg = "Veuillez saisir au moins un frais";
    }
?>

<div class="cnt box">
    <h2>Saisie des frais forfaitaires</h2>
    <form action="" method="POST">
        <div class="row">
            <label for="ff-etape">Forfait étape</label>
            <input type="number" name="ff-etape" id="ff-etape" step="1">
            <input type="text" placeholder="Ajouter Fonction php" readonly>
        </div>
        <div class="row">
            <label for="ff-km">Frais Kilométrique</label>
            <input type="number" name="ff-km" id="ff-km" step="0.1">
            <input type="text" placeholder="Ajouter Fonction php" readonly>
        </div>
        <div class="row">
            <label for="ff-hotel">Nuitée hotel</label>
            <input type="number" name="ff-hotel" id="ff-hotel" step="1">
            <input type="text" placeholder="Ajouter Fonction php" readonly>
        </div>
        <div class="row">
            <label for="ff-resto">Repas restaurant</label>
            <input type="number" name="ff-resto" id="ff-resto" step="1">
            <input type="text" placeholder="Ajouter Fonction php" readonly>
        </div>
        <input class="save" type="submit" name="btn-ff" value="Enregistrer">
    </form>
    <?php require_once "error-handling.php"; ?>
</div>