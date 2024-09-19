<?php

class Cdao{ //*classe outil

    function filtrerChainePourBD($str) {
        if ( ! get_magic_quotes_gpc() ) { 
            /*
            *si la directive de configuration magic_quotes_gpc est activée dans php.ini,
            *toute chaîne reçue par get, post ou cookie est déjà échappée 
            *par conséquent, il ne faut pas échapper la chaîne une seconde fois */                              
            $str = mysql_real_escape_string($str);
        }
        return $str;
    }

    //*mettre le DSN en paramètre formel
    private function getObjetPDO() {

        $strConnection = 'mysql:host=localhost;dbname=gsb'; //* DSN
        $arrExtraParam= array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"); //* demande format utf-8
        //$pdo = new PDO($strConnection, 'remote_user', '3d7giXhAeOVZa8bL', $arrExtraParam); //* Instancie la connexion si base distante remote_user remotepass
        $opdo = new PDO($strConnection, 'root', '', $arrExtraParam);
        $opdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //* Demande la gestion d'exception car par défaut PDO ne la propose pas

        return $opdo;
    }

    public function getTabDataFromSql($squery) {
       $opdo = $this->getObjetPDO();

       //$query = 'SELECT id,login,mdp,nom,prenom from visiteur';
       $sth = $opdo->prepare($squery);
       $sth->execute();

       $result = $sth->fetchAll(); //* fetchall met toutes les données dans un tableau de tableau associatif (type dictionnaire)
       //unset($lepdo);
       return $result; //* $result est un tableau de tableaux associatifs

    }

    public function getTabObjetFromSql($_query, $_type){
        $lepdo = $this->getObjetPDO();

        $sth = $lepdo->prepare($_query);
        $sth->execute();

        $result = $sth->fetchAll(PDO::FETCH_CLASS, $_type);
        unset($lepdo);
        return $result;
    }

    //* fera une mise à jour dans la base en fonction de la requete recue en parametre
    public function execute($_query) {
        $lepdo = $this->getObjetPDO();

        $sth = $lepdo->prepare($_query);
        $sth->execute();
        unset($lepdo);            
    }
    

}