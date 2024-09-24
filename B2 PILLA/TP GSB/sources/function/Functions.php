<?php

    $monthFr = array(
        "January" => "Janvier",
        "February" => "Février",
        "March" => "Mars",
        "April" => "Avril",
        "May" => "Mai",
        "June" => "Juin",
        "July" => "Juillet",
        "August" => "Août",
        "September" => "Septembre",
        "October" => "Octobre",
        "November" => "Novembre",
        "December" => "Décembre"
    );

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