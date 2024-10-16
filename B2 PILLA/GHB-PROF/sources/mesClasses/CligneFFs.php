<?php   
class CligneFF
{
    public $idVisiteur;
    public $mois;
    public $oFraisForfait;
    public $quantite;
    
    public function __construct($sidVisiteur,$smois,$soFraisForfait,$squantite)
    {
        $this->idVisiteur = $sidVisiteur;
        $this->mois = $smois;
        $this->oFraisForfait = $soFraisForfait;
        $this->quantite = $squantite;
              
    }
}
class CligneFFs
{
    public $oCollLigneFraisForfait;
    
    public function __construct()
    {
        try
        {
            $odao = new Cdao();
            $query = 'SELECT * FROM lignefraisforfait';
            //$tabLigneFrais = $odao->getTabObjetFromSql($query, 'Cligneff');
            $tabLigneFrais = $odao->getTabDataFromSql($query);
            $this->oCollLigneFraisForfait = array();
            $ofraisForfaits = new CfraisForfaits();
            $ocollFFById = $ofraisForfaits->getCollFraisForfaitById();
                foreach($tabLigneFrais as $Lignefrais) //$oLignefrais est remplacé
                {
                    //$ofraisForfait = $ocollFFById[$oLignefrais->idFraisForfait];
                    $ofraisForfait = $ocollFFById[$Lignefrais['idFraisForfait']];
                    //$oLignefrais->idFraisForfait = $ofraisForfait;
                    $oLignefrais = new CligneFF($Lignefrais['idVisiteur'],$Lignefrais['mois'],$ofraisForfait,$Lignefrais['quantite']);
                    $this->oCollLigneFraisForfait[] = $oLignefrais;
                }
                unset($odao);
        }          
        catch (PDOException $e) 
        {
            $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
                         die($msg);
        }
    }
    
    public function verifExistLFFByIdVisiteurMois($sidVisiteur) //verifie l'existence des 4 lignes à 0
    {
        $mois = getAnneeMois();
        $lFFexist = false;
        foreach($this->oCollLigneFraisForfait as $oLigneFF)
        {
            if($oLigneFF->idVisiteur == $sidVisiteur && $oLigneFF->mois == $mois)
            {
                 $lFFexist = true; //Si une est rencontrée alors les autres le sont aussi donc break 
                 break;
            }
        }
        if(!$lFFexist)
        {
            $this->insertLigneFF();
        }
    }
    
    public function getLFFByIdVisiteurMois($sidVisiteur)
    {
        $ocollLFFbyIdVisiteurMois = array();
        $mois = getAnneeMois();
        foreach($this->oCollLigneFraisForfait as $oLigneFF)
        {
            if($oLigneFF->idVisiteur == $sidVisiteur && $oLigneFF->mois == $mois)
            {
                $ocollLFFbyIdVisiteurMois[] = $oLigneFF;
            }
        }
        
        return $ocollLFFbyIdVisiteurMois;
    }
    
    
    
    public function insertLigneFF() //insertion première fois => après par UpDate
    {
        $odao = new Cdao();
        $oVisiteur = unserialize($_SESSION['visiteur']);
        $query = "INSERT INTO lignefraisforfait values('" . $oVisiteur->id . "', '" . date('Ym') . "', 'ETP', '0')";
        $odao->insertion($query);
         $query = "INSERT INTO lignefraisforfait values('" . $oVisiteur->id . "', '" . date('Ym') . "', 'KM', '0')";
        $odao->insertion($query);
         $query = "INSERT INTO lignefraisforfait values('" . $oVisiteur->id . "', '" . date('Ym') . "', 'NUI', '0')";
        $odao->insertion($query);
         $query = "INSERT INTO lignefraisforfait values('" . $oVisiteur->id . "', '" . date('Ym') . "', 'REP', '0')";
        $odao->insertion($query);
        unset($odao);
    }
    
    public function updateLigneFF($squantite,$sidFF)
    {
        $odao = new Cdao();
        $oVisiteur = unserialize($_SESSION['visiteur']);
        $mois = getAnneeMois();
        
         $query = "update lignefraisforfait set quantite=".$squantite.
                            " where mois='".$mois."'"." and idVisiteur='".$oVisiteur->id."'"." and idFraisForfait='".$sidFF."'";
         $odao->update($query);
         unset($odao);
    }

    public function updateLignesFF($stab){
        $odao = new Cdao();
        $oVisiteur = unserialize($_SESSION['visiteur']);
        $mois = getAnneeMois();

        foreach ($stab as $id=>$montant){
            $query[] = "update lignefraisforfait set quantite=".$montant.
            " where mois='".$mois."'"." and idVisiteur='".$oVisiteur->id."'"." and idFraisForfait='".$id."'";
        }

        $odao->updateTransac($query);
        undset($odao);
    }
}
