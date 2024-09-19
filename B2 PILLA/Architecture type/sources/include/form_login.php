<?php
    session_start();
    require_once './class/Employee.php';
    require_once './function/Functions.php';

    $oVisitors = new C_Visitors();
    $oAccountants = new C_Accountants();

    if(isset($_POST["connect"])){

        if(!empty($_POST["inputLogin"]) && !empty($_POST["inputPwd"])){
            $inputLogin = htmlspecialchars($_POST["inputLogin"]);
            $inputPwd = htmlspecialchars($_POST["inputPwd"]);

            $logged = $oAccountants->CheckLoginInfo($inputLogin, $inputPwd);
            if (gettype($logged) === 'object') $successMsg = "Identifiants correctes, mais Comptable";
            else if ($logged === 'pwd') $errorMsg = "Mot de passe incorrect COMPTABLE";
            else {
                $logged = $oVisitors->CheckLoginInfo($inputLogin, $inputPwd);
                if (gettype($logged) === 'object'){
                    SetAllMessageToNull(); 
                    $_SESSION['visitor'] = $logged; 
                    header('Location: home.php');
                    exit;
                }
                else if ($logged == 'pwd') $errorMsg = "Mot de passe incorrect";
                else if ($logged == 'lgn') $errorMsg = "Login incorrect";  
            }
        }
        else $errorMsg = "Il manque au moins une information";
    }

    require_once 'error-handling.php'; 

?>
<div class="cnt center">
    <div class="cnt form small nomgn">
        <h2>Connexion</h2>
        <form action="" method="POST">
            <input type="text" name="inputLogin" placeholder="Login">
            <input type="password" name="inputPwd" placeholder="Mot de Passe">
            <input type="submit" name="connect" value="Se connecter">
        </form>
    </div>

</div>