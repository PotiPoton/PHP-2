<?php

// la classe est abstraite. Cela empêche l'instanciation qui est inutile pour ce genre de classe parent
abstract class Cemploye{
    
    public $id;
    public $login;
    public $mdp;
    public $nom;
    public $prenom;
    public $connecte;
    public $ville;
    
    function __construct($sid,$slogin,$smdp,$snom,$sprenom,$sville){
        $this->id = $sid;
        $this->login = $slogin;
        $this->mdp = $smdp;
        $this->nom = $snom;
        $this->prenom = $sprenom;
        $this->ville = $sville;
        $this->connecte = false;   // le visiteur est par défaut non connecté*/
        
    }
}

