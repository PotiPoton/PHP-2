<!DOCTYPE html>
<html lang="fr">
<?php
    require_once 'include/head.php';
    require_once 'class/Employee.php';
    require_once 'function/Functions.php';
    session_start();
?>

<body>

<?php

    $oVisitors = new C_Visitors();

//*Ici, trie sur tableau

    if(!isset($_SESSION['firstSort'])) $_SESSION['firstSort'] = '';
    if(!isset($_SESSION['ascDesc'])) $_SESSION['ascDesc'] = 'asc';

    $firstSort = $_SESSION['firstSort'];
    $ascDesc = $_SESSION['ascDesc'];

//*Appuie bouton
    if(isset($_POST['sortById'])){
        if($firstSort != 'id') {
            $firstSort = 'id';
            $ascDesc = 'asc';
        }
        else {
            $ascDesc = ($ascDesc == 'asc') ? 'desc' : 'asc';
        }
        $_SESSION['firstSort'] = $firstSort;
        $_SESSION['ascDesc'] = $ascDesc;
        $rows = $oVisitors->GetRowTabVisitor('id', $ascDesc);
    }
    else if(isset($_POST['sortByLogin'])){
        if($firstSort != 'login') {
            $firstSort = 'login';
            $ascDesc = 'asc';
        }
        else {
            $ascDesc = ($ascDesc == 'asc') ? 'desc' : 'asc';
        }
        $_SESSION['firstSort'] = $firstSort;
        $_SESSION['ascDesc'] = $ascDesc;
        $rows = $oVisitors->GetRowTabVisitor('login', $ascDesc);
    }
    else if(isset($_POST['sortByNom'])){
        if($firstSort != 'nom') {
            $firstSort = 'nom';
            $ascDesc = 'asc';
        }
        else {
            $ascDesc = ($ascDesc == 'asc') ? 'desc' : 'asc';
        }
        $_SESSION['firstSort'] = $firstSort;
        $_SESSION['ascDesc'] = $ascDesc;
        $rows = $oVisitors->GetRowTabVisitor('nom', $ascDesc);
    }
    else if(isset($_POST['sortByPrenom'])){
        if($firstSort != 'prenom') {
            $firstSort = 'prenom';
            $ascDesc = 'asc';
        }
        else {
            $ascDesc = ($ascDesc == 'asc') ? 'desc' : 'asc';
        }
        $_SESSION['firstSort'] = $firstSort;
        $_SESSION['ascDesc'] = $ascDesc;
        $rows = $oVisitors->GetRowTabVisitor('prenom', $ascDesc);
    }
    else {
        $rows = $oVisitors->GetRowTabVisitor();
    }

?>
    <h1>Tableau des visiteurs</h1>
    
    <table>
        <thead>
            <tr>
                <form action="" method="POST">
                    <th scope="col"><button type="submit" class="" name="sortById">ID</button></th>
                    <th scope="col"><button type="submit" class="" name="sortByLogin">LOGIN</button></th>
                    <th scope="col"><button type="submit" class="" name="sortByNom">NOM</button></th>
                    <th scope="col"><button type="submit" class="" name="sortByPrenom">PRENOM</button></th>
                </form>
            </tr>
        </thead>
        <tbody>
            <?php
            echo $rows
            ?>
        </tbody>
    </table>
</body>
</html>

