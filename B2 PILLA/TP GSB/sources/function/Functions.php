<?php
    function SetAllMessageToNull(){
        $errorMsg = null; 
        $successMsg = null; 
        $disconnectedMsg = null;
    }

    function CheckIfLogged($visitor){
        if(empty($visitor)) header("Location: connect.php");
    }

    function Disconnect(){
        $_SESSION['visitor'] = null;
        SetAllMessageToNull();
        $disconnectedMsg = "Vous avez bien été deconnecté(e) !";
        header("Location: connect.php");
    }
?>