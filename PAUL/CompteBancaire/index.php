<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>
<body>
    <?php 
    require_once 'class/CompteBancaire.class.php';

    $compte1 = new CompteBancaire(514);
    echo $compte1->AfficheSolde();
    $compte1->Debiter(800);
    echo $compte1->AfficheSolde();

    $compte2 = new CompteBancaire(515, -1500);
    echo $compte2->AfficheSolde();
    $compte2->Crediter(1800);
    echo $compte2->AfficheSolde();

    $livret = new LivretEpargne(516, 2000, 12, 100);
    echo $livret->AfficheSolde();
    echo $livret->TableauEpargne(5);
    ?>
</body>
</html>