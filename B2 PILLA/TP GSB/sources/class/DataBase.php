<?php

class DataBase{
    
    protected $db;

    public function __construct($dbname, $host='localhost', $usr='root', $pwd=''){
        try{
            $this->db = new PDO("mysql:host=$host;dbname=$dbname","$usr","$pwd");
        }
        catch(Exception $e){
            echo 'Connexion impossible : '.$e->getMessage();
            $this->db = null;
        }
    }
    
    public function GetObj($table, $param=null){
        //*Préparation
        $sth = $this->db->prepare("SELECT :param FROM :table");
        //*Paramètres
        $sth->bindParam(':table', $table);
        if(empty($param)) $sth->bindParam(':param', '*');
        else $sth->bindParam(':param', $param);
        //*Execution
        $sth->execute();
        //*Retourner l'objet
        return $sth->fetchAll(PDO::FETCH_OBJ);
    }
}

$db = new DataBase('gsb');

?>