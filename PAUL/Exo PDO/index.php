<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Liste des sociétés</h1>
    <?php 
    
    //*Base de donnée
    $bdd=new PDO('mysql:host=localhost;dbname=comptoir','root','');
    //*Requete à passer
    $query='SELECT * FROM clients LIMIT 20';
    
    //*
    $getted=$bdd->prepare($query);
    $getted->execute();

    $tabobj[]=$getted->fetchAll(PDO::FETCH_OBJ);


    
    //*Affichage
    while($resultat=$getted->fetch(PDO::FETCH_OBJ)){
        echo '<li>'.$resultat->Societe.'</li>';
    }

    ?>
</body>
</html>