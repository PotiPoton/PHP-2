<?php

require_once 'Cdao.php';
require_once 'DataBase.php';

/*---------------------------------------------------------------------*/
#                                                                       #
#                               Employee                                #
#                                                                       #
/*---------------------------------------------------------------------*/

#region Employee

abstract class C_Employee {
    protected $id;
    protected $nom;
    protected $prenom;
    protected $login;
    protected $hashMdp;
    protected $salt;
    protected $adresse;
    protected $cp;
    protected $ville;
    protected $dateEmbauche; 	

    public function __construct($id, $nom, $prenom, $login, $hashMdp, $salt, $adresse, $cp, $ville, $dateEmbauche){
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->login = $login;
        $this->salt = $this->AddSalt($salt, $id);
        $this->hashMdp = $this->AddHashPwd($hashMdp, $id);
        $this->adresse = $adresse;
        $this->cp = $cp;
        $this->ville = $ville;
        $this->dateEmbauche = $dateEmbauche;
    }

    //* Accesseurs
    public function Id() { return $this->id; }
    public function Nom() { return $this->nom; }
    public function Prenom() { return $this->prenom; }
    public function Login() { return $this->login; }
    public function HashMdp() { return $this->hashMdp; }
    public function Salt() { return $this->salt; }
    
    protected abstract function AddHashPwd($sHashPwd, $sId);
    
    protected abstract function AddSalt($sSalt, $sId);
}

#endregion

/*---------------------------------------------------------------------*/
#                                                                       #
#                               Visitor                                 #
#                                                                       #
/*---------------------------------------------------------------------*/

#region Visitor
class C_Visitor extends C_Employee{

    public function __construct($id, $nom, $prenom, $login, $hashMdp, $salt, $adresse, $cp, $ville, $dateEmbauche){
        parent::__construct($id, $nom, $prenom, $login, $hashMdp, $salt, $adresse, $cp, $ville, $dateEmbauche);
    }

    protected function AddHashPwd($sHashPwd, $sId){
        if(!empty($sHashPwd)) return $sHashPwd;
        
        $odao = new Cdao();
        $query = "SELECT mdp FROM visiteur WHERE id='$sId';";
        $user = $odao->getTabDataFromSql($query);

        $userPwd = $user[0]['mdp'].$this->salt;
        $hashPwd = hash('sha512', $userPwd);

        $query = "UPDATE visiteur SET hashMdp='$hashPwd' WHERE id='$sId';";
        $odao->execute($query);

        return $hashPwd;
    }

    protected function AddSalt($sSalt, $sId){
        if(!empty($sSalt)) return $sSalt;

        $charList = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $preSalt = '';
        for ($i = 0; $i < 20; $i++){
            $preSalt .= $charList[rand(0, strlen($charList) - 1)];
        }
        $salt = hash('sha256', $preSalt);

        $odao = new Cdao();
        $query = "UPDATE visiteur SET salt='$salt' WHERE id='$sId';";
        $odao->execute($query);

        return $salt; 
    }
}

class C_Visitors{
    private $tabVisitors;

    public function __construct(){
        
        $db = new DataBase('gsb');
        $this->tabVisitors = $db->GetObj('visitor');



        /*try{
            $odao = new Cdao();
            $query = "SELECT * FROM visiteur;";

            //*Récupération du tableau d'employés $tabVisitor par la méthode getTabDataFromSql() de la classe Cdao
            $tempTabVisitor = $odao->getTabDataFromSql($query);

            //*Instencie les éléments de la BDD bd_comparateur
            foreach($tempTabVisitor as $visitor){
                $this->tabVisitors[] = new C_Visitor(
                    $visitor['id'], 
                    $visitor['nom'], 
                    $visitor['prenom'],
                    $visitor['login'],
                    $visitor['hashMdp'],
                    $visitor['salt'],
                    $visitor['adresse'],
                    $visitor['cp'],
                    $visitor['ville'],
                    $visitor['dateEmbauche']);
            }
        }
        catch(PDOException $e){
            $msg = "ERREUR PDO dans ".$e->getFile()." Ligne ".$e->getLine()." : ".$e->getMessage();
            die($msg);
        }*/
        
    }

    #region Getter/Setter 

    public function TabVisitors() { return $this->tabVisitors; }

    #endregion

    #region Private Methodes

    private function GetSaltByLogin($sLogin){
        foreach($this->tabVisitors as $visitor){
            if($visitor->Login() == $sLogin) return $visitor->Salt();
        }
        return null;
    }

    #endregion

    #region Public Methodes

    public function GetVisitorById($sId){
        foreach ($this->tabVisitors as $visitor) {
            if($visitor->Id() == $sId) return $visitor;
        }
        return null;
    }

    public function CheckLoginInfo($sLogin, $sPwd){
        $salt = $this->GetSaltByLogin($sLogin);
        if(empty($salt)) return 'lgn'; //login faux

        $hashPwd = hash('sha512', $sPwd.$salt);
        foreach($this->tabVisitors as $visitor){
            $isTrue = ($visitor->Login() == $sLogin && $visitor->HashMdp() == $hashPwd);
            if ($isTrue) return $visitor; //OK
        }
        return 'pwd';//Mot de passe faux
    }
            
    public function GetRowTabVisitor($sSortType = null, $sAscDesc = 'asc'){
        if ($sSortType != null) {
            usort($this->tabVisitors, function($a, $b) use ($sSortType, $sAscDesc){
                $direction = ($sAscDesc == 'desc') ? -1 : 1;
                switch ($sSortType){
                    case 'login':
                        return $direction * strcmp($a->Login(), $b->Login());
                    case 'nom':
                        return $direction * strcmp($a->Nom(), $b->Nom());
                    case 'prenom':
                        return $direction * strcmp($a->Prenom(), $b->Prenom());
                    case 'id':
                        return $direction * strcmp($a->Id(), $b->Id());
                    default:
                        return 0;
                }
            });
        }

        $rows = "";
        foreach($this->tabVisitors as $visitor){
            $rows .= "
            <tr>
                <th scope='row'>".$visitor->Id()."</th>
                <td>".$visitor->Login()."</td>
                <td>".$visitor->Nom()."</td>
                <td>".$visitor->Prenom()."</td>
            </tr>";
        }
        return $rows;
    }
    
    public function RebootHashPwd(){
        $odao = new Cdao();
        foreach ($this->tabVisitors as $visitor){
            $query = "UPDATE visiteur SET hashMdp='' WHERE id='".$visitor->Id()."'";
            $odao->execute($query);
        }
    }

    #endregion
}

#endregion

/*---------------------------------------------------------------------*/
#                                                                       #
#                             Accountant                                #
#                                                                       #
/*---------------------------------------------------------------------*/

#region Accountant

class C_Accountant extends C_Employee{

    public function __construct($id, $nom, $prenom, $login, $hashMdp, $salt, $adresse, $cp, $ville, $dateEmbauche){
        parent::__construct($id, $nom, $prenom, $login, $hashMdp, $salt, $adresse, $cp, $ville, $dateEmbauche);
    }

    protected function AddHashPwd($sHashPwd, $sId){
        if(!empty($sHashPwd)) return $sHashPwd;
        
        $odao = new Cdao();
        $query = "SELECT mdp FROM comptable WHERE id='$sId';";
        $user = $odao->getTabDataFromSql($query);

        $userPwd = $user[0]['mdp'].$this->salt;
        $hashPwd = hash('sha512', $userPwd);

        $query = "UPDATE comptable SET hashMdp='$hashPwd' WHERE id='$sId';";
        $odao->execute($query);

        return $hashPwd;
    }

    protected function AddSalt($sSalt, $sId){
        if(!empty($sSalt)) return $sSalt;

        $charList = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $preSalt = '';
        for ($i = 0; $i < 20; $i++){
            $preSalt .= $charList[rand(0, strlen($charList) - 1)];
        }
        $salt = hash('sha256', $preSalt);

        $odao = new Cdao();
        $query = "UPDATE comptable SET salt='$salt' WHERE id='$sId';";
        $odao->execute($query);
        
        return $salt;
    }
}

class C_Accountants{
    protected $tabAccountants;

    public function __construct(){
        
        try{
            $odao = new Cdao();
            $query = "SELECT * FROM comptable;";
            $tempTabAccountants = $odao->getTabDataFromSql($query);

            if (empty($tempTabAccountants)) return null;

            foreach ($tempTabAccountants as $accountant) {
                $this->tabAccountants[] = new C_Accountant(
                    $accountant['id'],
                    $accountant['nom'],
                    $accountant['prenom'],
                    $accountant['login'],
                    $accountant['hashMdp'],
                    $accountant['salt'],
                    $accountant['adresse'],
                    $accountant['cp'],
                    $accountant['ville'],
                    $accountant['dateEmbauche']
                );
            }
        }
        catch(PDOException $e){
            $msg = "ERREUR PDO dans ".$e->getFile()." Ligne ".$e->getLine()." : ".$e->getMessage();
            die($msg);
        }
    }

    #region Private Methodes

    private function GetSaltByLogin($sLogin){
        foreach($this->tabAccountants as $accountant){
            if($accountant->Login() == $sLogin) return $accountant->Salt();
        }
        return null;
    }

    #endregion

    #region Public Methodes

    public function CheckLoginInfo($sLogin, $sPwd){
        $salt = $this->GetSaltByLogin($sLogin);
        if(empty($salt)) return 'lgn'; //login faux

        $hashPwd = hash('sha512', $sPwd.$salt);
        foreach($this->tabAccountants as $accountant){
            $isTrue = ($accountant->Login() == $sLogin && $accountant->HashMdp() == $hashPwd);
            if ($isTrue) return $accountant; //OK
        }
        return 'pwd';//Mot de passe faux
    }

    #endregion

}

#endregion
?>