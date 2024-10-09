<html>
    <?php 
        require_once 'includes/head.php';        
        require_once './mesClasses/Cvisiteurs.php'; 
        
        session_start();
    ?>
<body>
        <?php
        $ovisiteur = unserialize($_SESSION['visiteur']);
        if($ovisiteur == NULL)
        {
            header('location:seConnecter.php');
        }
        $ovisiteurs = new Cvisiteurs();
        $ocollTrie = $ovisiteurs->getVisiteursTrie();
        
        // je mémorise le nombre total de visiteur pour utilisation ligne 79 et s
        $_SESSION['nbTotalVisiteur'] = count($ocollTrie);
        
         // Pour conservation de la valeur choisie après un postBack grâce aux variables de session
        if(isset($_POST['debutFin']) && isset($_POST['ville']) && isset($_POST['partieNom'])){
            $_SESSION['debutFin'] = $_POST['debutFin'];
            $_SESSION['ville'] = $_POST['ville'];
            $_SESSION['partieNom'] = $_POST['partieNom'];
        }
        
        $tabVilles = $ovisiteurs->getVilleVisiteur();
        //if(isset($_SESSION['ville'])){var_dump($_SESSION['ville']);}
        //var_dump($ocollTrie);
        //var_dump($tabVilles);
        ?>
        
    <div class="container">
       
        <header title="listevisiteur"></header>
        
        <?php require_once 'includes/navBar.php'; ?>
        
       <div title="filtrage">  
        <form class="" method="POST" action=""> <!-- quand rien alors action sur la même page -->
            <div class="row">
                <div class="col-lg-2">
                <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg></span>
                &nbsp; 
                <label class="form-label" for="ville">Choisir la localité :</label>
                &nbsp;
                </div>
                <div class="col-lg-5">
                <select name="ville">
                    <?php
                    // Conservation de la valeur choisie après un postBack grâce aux variables de session
                            echo "<option value='toutes'>Toutes villes</option>";
                            // isset obligatoire car au premier chargement le tableau associatif ($_SESSION['ville]) n'est pas défini
                            if(isset($_SESSION['ville']))
                            {
                                foreach ($tabVilles as $ville) {
                                    echo "<option value='".$ville;
                                    if($_SESSION['ville'] == trim($ville)){echo "' selected >";}else{echo "' >";}
                                    echo $ville." </option>";
                                }
                            }else{
                                foreach ($tabVilles as $ville) {
                                    echo "<option value='".$ville."' >".$ville."</option>";
                                }
                                
                            }
                            
                            
                    ?>

                </select>
                </div>
            </div>
            <br>
            <br>
            <br>
            <div class="row">
                <div class="col-lg-3">
                <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg></span>
                &nbsp;               
                <label class="col-form-label" for="partieNom"><span></span>Saisir tout ou partie du nom :</label>
                &nbsp;
                </div>
                <div class="col-lg-3">
                <!-- Conservation de la valeur choisie après un postBack grâce aux variables de session -->
                <input class="form-control" type="text" name="partieNom" value="<?=isset($_SESSION['partieNom'])?$_SESSION['partieNom']:''?>" required>
                </div>
                <div class="col-lg-3">
                    
                    <!-- Conservation de la valeur choisie après un postBack grâce aux variables de session -->
                        <?php if(isset($_SESSION['debutFin'])){
                        echo '<div class="radio">' ?>
                            <?php echo '<INPUT type= "radio" name="debutFin" value="debut"';
                            if($_SESSION['debutFin'] == 'debut'){echo ' checked required> Début &nbsp;';}else{echo'required> Début &nbsp;';}
                            echo '<INPUT type= "radio" name="debutFin" value="fin"';
                            if($_SESSION['debutFin'] == 'fin'){echo ' checked required> Fin &nbsp;';}else{echo'required> Fin &nbsp;';}
                            echo '<INPUT type= "radio" name="debutFin" value="nimporte"';
                            if($_SESSION['debutFin'] == 'nimporte'){echo ' checked required> Dans la chaine &nbsp';}else{echo'required> Dans la chaine &nbsp;';}
                        echo'</div>';

                        ?>
                        <?php }else{

                        echo '<div class="radio">
                            <INPUT type= "radio" name="debutFin" value="debut" checked required> Début &nbsp
                            <INPUT type= "radio" name="debutFin" value="fin" required> Fin &nbsp
                            <INPUT type= "radio" name="debutFin" value="nimporte" required> Dans La Chaine &nbsp
                            </div>';               
                        } 
                        ?>     
                </div>
                <div class="col-lg-2">
                     
                    <button type="submit" class="btnFiltrage">Filtrer</button>
                    
                </div>
            </div>           
         </form> 
      </div>  
        <?php
         
            if(isset($_POST['debutFin']) && isset($_POST['ville']) && isset($_POST['partieNom']))
            {
                
            
                $ovisiteurs = new Cvisiteurs();
                $tabVisiteurs = $ovisiteurs->getTabVisiteursParNomEtVille($_POST['debutFin'],$_POST['partieNom'], $_POST['ville']);
                $otrie = new Ctri();
                //$tabVisiteurs = $otrie->TriTableauObjetSurNom($tabVisiteurs);
                //var_dump($tabVisiteurs);
                
                if($tabVisiteurs != null)
                {
                    //dans le if car le tableau ne doit pas être nul pour le tri
                    $tabVisiteurs = $otrie->TriTableau($tabVisiteurs, 'nom');
                            /* remet l'en-tête du tableau comme au début si le nombre de visiteur est le nombre total
                            sinon l'en-tête précise que le tableau est filtré' avec le nombre de visiteur dans le titre*/
                            if(count($tabVisiteurs) == $_SESSION['nbTotalVisiteur']){
                              echo '<h1><p title="tabvisiteur">liste des visiteurs médicaux ('.count($tabVisiteurs).')</p></h1>';  
                            }
                            else{
                            echo '<h1><p title="tabvisiteur">liste des visiteurs médicaux filtrés par nom et par ville ('.count($tabVisiteurs).')</p></h1>';   }        
                            echo '<table class="table table-condensed">
                                    <thead title="entetetabvisiteur">
                                        <tr>
                                          <th>ID</th>
                                          <th>LOGIN</th>
                                          <th>NOM</th>
                                          <th>PRENOM</th>
                                          <th>VILLE</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                    $i = 0;
                    foreach ($tabVisiteurs as $ovisiteur)
                    {
        ?>
                            <tr class="<?=$i%2===0?'':'ligneTabVisitColor'?>">
                            <td><?=$ovisiteur->id?></td>
                            <td><?=$ovisiteur->login?></td>
                            <td><?=$ovisiteur->nom?></td>
                            <td><?=$ovisiteur->prenom?></td>
                            <td><?=$ovisiteur->ville?></td>
                            </tr>
        <?php                     
                            $i++;
                         
                    }


                        echo "</tbody>";
                    echo "</table>";
                }
                if($tabVisiteurs == null)
                {
                    $errorMsg = "Il n'y a pas de visiteur répondant aux critères.";
                    
                    if(isset($errorMsg))
                    {
                         echo "<br><br><div class='alert alert-danger'>".$errorMsg."</div>";
                        
                    }
                    
                }
            }
            
            else {
        

        echo '<h1><p title="tabvisiteur">liste des visiteurs médicaux ('.count($ocollTrie).')</p></h1>';;           
        echo '<table class="table table-condensed">
                <thead title="entetetabvisiteur">
                    <tr>
                      <th>ID</th>
                      <th>LOGIN</th>
                      <th>NOM</th>
                      <th>PRENOM</th>
                      <th>VILLE</th>
                    </tr>
                </thead>
                <tbody>';
                      
                          $i=0;
                           foreach ($ocollTrie as $ovisiteur)
                           {
                               if($i % 2 == 1)
                               {
        ?>        
                              <tr class="ligneTabVisitColor">
                                  <td><?php echo $ovisiteur->id ?></td>
                                  <td> <?php echo $ovisiteur->login ?></td>
                                  <td><?php echo $ovisiteur->nom ?></td>
                                  <td><?php echo $ovisiteur->prenom?></td>
                                  <td><?php echo $ovisiteur->ville?></td>
                              </tr>
        <?php
                               }
                               else{
        ?>
                              <tr>
                                  <td><?php echo $ovisiteur->id ?></td>
                                  <td> <?php echo $ovisiteur->login ?></td>
                                  <td><?php echo $ovisiteur->nom ?></td>
                                  <td><?php echo $ovisiteur->prenom?></td>
                                  <td><?php echo $ovisiteur->ville?></td>
                              </tr>
                              
        <?php
                           
                                }
                            $i++;
                          }
        ?>      

                  </tbody>
            </table>
        <?php
            }
        ?>
    </div>
</body>
</html>
