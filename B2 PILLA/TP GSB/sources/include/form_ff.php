<?php
    if(isset($_POST['btn-ff'])){
        if(!empty($_POST['ff-etape']) || !empty($_POST['ff-km']) || !empty($_POST['ff-hotel']) || !empty($_POST['ff-resto'])){
            $inputEtape = htmlspecialchars($_POST['ff-etape']);
            $inputKm = htmlspecialchars($_POST['ff-km']);
            $inputHotel = htmlspecialchars($_POST['ff-hotel']);
            $inputResto = htmlspecialchars($_POST['ff-resto']);

            // $oFichesFrais->AddLigneFraisForfait($inputLibFhf, $inputMntFhf);
            header('Location: saisirFicheFrais.php');
            exit();
        }
        else $errorMsg = "Veuillez saisir au moins un frais";
    }

    $oFraisForfaits = new C_FraisForfaits();
    $etape = $oFraisForfaits->GetFraisForfaitById('ETP');
    $km = $oFraisForfaits->GetFraisForfaitById('KM');
    $nuitee = $oFraisForfaits->GetFraisForfaitById('NUI');
    $repas = $oFraisForfaits->GetFraisForfaitById('REP');
?>

<div class="cnt box">
    <h2>Saisie des frais forfaitaires</h2>
    <form action="" method="POST">
        <div class="row">
            <label for="ff-etape"><?php echo $etape->Libelle(); ?></label>
            <input type="number" name="ff-etape" id="ff-etape" step="1">
            <input type="text" placeholder="<?php echo $etape->Montant(); ?>" readonly>
        </div>
        <div class="row">
            <label for="ff-km"><?php echo $km->Libelle(); ?></label>
            <input type="number" name="ff-km" id="ff-km" step="0.1">
            <input type="text" placeholder="<?php echo $km->Montant(); ?>" readonly>
        </div>
        <div class="row">
            <label for="ff-hotel"><?php echo $nuitee->Libelle(); ?></label>
            <input type="number" name="ff-hotel" id="ff-hotel" step="1">
            <input type="text" placeholder="<?php echo $nuitee->Montant(); ?>" readonly>
        </div>
        <div class="row">
            <label for="ff-resto"><?php echo $repas->Libelle(); ?></label>
            <input type="number" name="ff-resto" id="ff-resto" step="1">
            <input type="text" placeholder="<?php echo $repas->Montant(); ?>" readonly>
        </div>
        <input class="save" type="submit" name="btn-ff" value="Enregistrer">
    </form>
    <?php require_once "error-handling.php"; ?>
</div>