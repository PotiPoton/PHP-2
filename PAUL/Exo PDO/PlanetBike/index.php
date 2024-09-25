<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

    function BDD(){
        try{
            //*Connexion
            $bdd=new PDO('mysql:host=172.29.1.70;dbname=planetbike','root','');
            return $bdd;
        }
        catch(Exception $e){
            echo 'Connexion impossible : '.$e->getMessage();
        }
    }
    

    //*Preparation
    $query='SELECT * FROM produit';
    $req=$bdd->prepare($query);
    //*Execution
    $req->execute();

    $Produits=$req->fetchAll(PDO::FETCH_OBJ);

    foreach($Produits as $produit){
        echo '<li>'.$produit->DesiProd.' pour '.$produit->PrixProd.' euros</li>';
    }

    ?>
</body>
</html>