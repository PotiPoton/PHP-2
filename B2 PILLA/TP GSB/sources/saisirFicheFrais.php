<!DOCTYPE html>
<html lang="en">
<?php
    //error_reporting(0);
    require_once 'include/head.php';
    require_once 'class/Employee.php';
    require_once 'class/FicheFrais.php';
    require_once 'function/Functions.php';
    session_start();
    $oVisitor = $_SESSION['visitor'];
    CheckIfLogged($oVisitor);

    $oLignesFraisHorsForfait = new C_LignesFraisHorsForfait();
    

    /*$oFichesFrais = new C_FichesFrais();
    $oFichesFrais->CheckFicheFrais($oVisitors->id);
    if(isset($_GET['idLFHF']) || isset($_POST['btnFHF'])) $_SESSION['successMsg_FF'] = null;*/
?>
<body>
    <?php require_once 'include/navbar.php'; ?>
    <div class="cnt content">
    <?php require_once 'include/form_fhf.php'; ?>
    <?php require_once 'include/show_fhf.php';?>
    </div>
    
    
    
        <?
            /*
            require_once 'include/form_ff.php';
            require 'include/error-handling.php';
            
            
            require 'include/error-handling.php';*/
        ?>
    </div>
</body>
</html>