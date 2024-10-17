<?php
$errorMsg = NULL;
$successMsg = NULL;
if(isset($_SESSION['successMSG_FF']))
{
    $successMsg = $_SESSION['successMSG_FF'];
}
if (isset($_SESSION['errorMSG_FF'])){
  $errorMsg = $_SESSION['errorMSG_FF'];
}
$oLigneFFs = new CligneFFs; 
$oVisiteur = unserialize($_SESSION['visiteur']);
// Ne pas oublié include_once dans saisirFicheFrais pour CfraisForfaits.php
$ofraisForfaits = new CfraisForfaits(); // variable globale car utilisée dans le if et dans le html du formulaire
$ocollFraisForfait = $ofraisForfaits->getCollFraisForfait();
if(isset($_POST['btnFF']))
{
  try {
    foreach ($ocollFraisForfait as $ofraisForfait)
    {
        $montant = filter_input(INPUT_POST, $ofraisForfait->id, FILTER_SANITIZE_STRING) ;
        $check = VerificationFF($montant);
        $arrayMontant[$ofraisForfait->id] = $montant; 
    }
    $oLigneFFs->updateLignesFF($arrayMontant);

    $_SESSION['successMSG_FF'] = "Modification des quantités effectuée !";
    $_SESSION['errorMSG_FF'] = null;

  }catch (Exception $e) {
    $_SESSION['successMSG_FF'] = null;
    $_SESSION['errorMSG_FF'] = $e->getMessage;
  }
    


 
    
    header('location:saisirFicheFrais.php'); 
}
 else 
 {
     //Cela va créer les quatres lignes FF à 0
     $oLigneFFs->verifExistLFFByIdVisiteurMois($ovisiteur->id);
 }
 //Il faut réinstancier dans le cas ou les lignes viennet d'être créées
 $oLigneFFs = new CligneFFs;
 $ocollLigneFF = $oLigneFFs->getLFFByIdVisiteurMois($ovisiteur->id);
 $oFFs = new CfraisForfaits();
 $ocollFFById = $oFFs->getCollFraisForfaitById();
?>

<div class="container">
  <h3 class="frais"><p>Saisie des frais forfaitaires <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-currency-euro" viewBox="0 0 16 16">
  <path d="M4 9.42h1.063C5.4 12.323 7.317 14 10.34 14c.622 0 1.167-.068 1.659-.185v-1.3c-.484.119-1.045.17-1.659.17-2.1 0-3.455-1.198-3.775-3.264h4.017v-.928H6.497v-.936c0-.11 0-.219.008-.329h4.078v-.927H6.618c.388-1.898 1.719-2.985 3.723-2.985.614 0 1.175.05 1.659.177V2.194A6.617 6.617 0 0 0 10.341 2c-2.928 0-4.82 1.569-5.244 4.3H4v.928h1.01v1.265H4v.928z"/>
</svg></p></h3>
    <br>
  <form class="" action="<?=$formAction?>" method="POST">
    <div class="offset-md-1 mb-3 row">
      <label class="col-sm-2 col-form-label" for="etape">Forfait étape:</label>
      <div class="col-sm-7">
        <input type="number" step="1" min="0" class="form-control" id="etape" name="<?=$ocollLigneFF[0]->oFraisForfait->id?>" value="<?=$ocollLigneFF[0]->quantite?>">
      </div>
      <div class="col-sm-3"><?=$ocollFFById['ETP']->montant?></div>
    </div>
      
    <div class="offset-md-1 mb-3 row">
      <label class="col-sm-2 col-form-label" for="fraiskilometrique">Frais kilométrique:</label>
      <div class="col-sm-7">          
        <input type="number" step="1" min="0" class="form-control" id="fraiskilometrique" name="<?=$ocollFraisForfait[1]->id?>" value="<?=$ocollLigneFF[1]->quantite?>">
      </div>
      <div class="col-sm-3"><?=$ocollFFById['KM']->montant?></div>
    </div>
    <div class="offset-md-1 mb-3 row">
      <label class="col-sm-2 col-form-label" for="nuitee">Nuitée hôtel:</label>
      <div class="col-sm-7">          
        <input type="number" step="1" min="0" class="form-control" id="nuitee" name="<?=$ocollFraisForfait[2]->id?>" value="<?=$ocollLigneFF[2]->quantite?>">
      </div>
      <div class="col-sm-3"><?=$ocollFFById['NUI']->montant?></div>
    </div>
    <div class="offset-md-1 mb-3 row">
      <label class="col-sm-2 col-form-label" for="Repas">Repas restaurant:</label>
      <div class="col-sm-7">          
        <input type="number" step="1" min="0" class="form-control" id="nuitee" name="<?=$ocollFraisForfait[3]->id?>" value="<?=$ocollLigneFF[3]->quantite?>">
      </div>
      <div class="col-sm-3"><?=$ocollFFById['REP']->montant?></div>
    </div>
    <div class="offset-md-3 mb-12">            
        <button type="submit" name="btnFF" class="btn-lg">Enregistrer</button>
    </div>
  </form>
</div>



