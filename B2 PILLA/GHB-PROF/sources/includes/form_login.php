    <?php        
        require_once './mesClasses/Cvisiteurs.php';   
        
        $_SESSION['visiteur'] = null;
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING) ;
        $mdp = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_STRING) ;
        if(!empty($username) && !empty($mdp))
        {
            $lesVisiteurs = new Cvisiteurs();
            
            // Filtrage des tags HTML éventuels dans une chaine
            
            //var_dump($mdp);
            $ovisiteur = $lesVisiteurs->verifierInfosConnexion($username,$mdp,);
            
            //$ovisiteur = $lesVisiteurs->verifierInfosConnexion($_POST['username'], $_POST['pwd']);
            //var_dump($_POST['pwd']);

            if($ovisiteur)
            {
                $_SESSION['visiteur'] = serialize($ovisiteur);
                header('Location: saisirFicheFrais.php');
            }
            else
            {
               $errorMsg = "Login/Mot de passe incorrect";
            }            
        }
        
    ?>  
    





<header title="formlogin">
    <h2 title="cnx">Connexion lab GSB</h2>
    <!--<img class=img-responsive src="../img/med1.jpg">-->
</header>

<?php
            require_once 'navBar.php';
?>



<form action="" method="POST">
  <div class="col-lg-4 offset-md-4 mb-3 mt-3">
    <label for="username" class="form-label">Login:</label>
    <input type="text" class="form-control" id="username" placeholder="Saisir votre login" name="username" required="required">
  </div>
  <div class=" col-lg-4 offset-md-4 mb-3">
    <label for="pwd" class="form-label">Mot de passe:</label>
    <input type="password" class="form-control" id="pwd" placeholder="Saisir votre mot de passe" name="pwd" required="required">
  </div>
  <div class="col-lg-8 offset-md-4 form-check mb-3">
    <label class="form-check-label">
      <input class="form-check-input" type="checkbox" name="remember"> Se souvenir de moi
    </label>
  </div>
  <button type="submit" class="offset-md-4 btn-lg">Se connecter</button>
</form>