<!DOCTYPE html>
<html lang="en">
<?php
    require_once 'include/head.php';
    require_once 'class/Employee.php';
    require_once 'function/Functions.php';
    session_start();
    $oVisitor = $_SESSION['visitor'];
    CheckIfLogged($oVisitor);
    
?>
<body>
    <?php 
    require_once 'include/navbar.php'; 
    ?>
    
</body>
</html>