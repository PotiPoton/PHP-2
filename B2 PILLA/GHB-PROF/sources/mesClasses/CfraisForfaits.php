<?php
require_once 'Cdao.php';

class CfraisForfait
{
    public $id; // Exemple : ETP
    public $libelle; // ex : Frais Etape
    public $montant; // ex : 110 pour 110 euros prix forfaitaire d'une étape pour un visiteur médical
}

class CfraisForfaits
{
    private $ocollFraisForfait;
    private $ocollFFById;
    
    public function __construct() 
    {
        $odao = new Cdao();
        
        $query = 'SELECT * FROM fraisforfait';
        
        $tabObjetFraisForfait = $odao->getTabObjetFromSql($query, 'CfraisForfait');
        
        
        foreach($tabObjetFraisForfait as $ofraisForfait)
        {
            $this->ocollFFById[$ofraisForfait->id] = $ofraisForfait;
            $this->ocollFraisForfait[] = $ofraisForfait;
        }
        unset($odao);
    }
    
    public function getCollFraisForfait()
    {
        return $this->ocollFraisForfait;
        
    }
    
    public function getCollFraisForfaitById()
    {
        return $this->ocollFFById;
        
    }
}