<?php 

require_once 'Cdao.php';
require_once 'Employee.php';

/*---------------------------------------------------------------------*/
#                                                                       #
#                               ETAT                                    #
#                                                                       #
/*---------------------------------------------------------------------*/

class C_Etat{
    protected $id;
    protected $libelle;

    public function __construct($id, $libelle){
        $this->id = $id;
        $this->libelle = $libelle;
    }

    public function Id() { return $this->id; }
    public function Libelle() { return $this->libelle; }
}

class C_Etats {
    protected $tabEtats;

    public function __construct(){
        
        try{
            $odao = new Cdao();
            $query = "SELECT * FROM etat;";
            $tempTabEtat = $odao->getTabDataFromSql($query);

            //TODO if (empty($tempTabEtat)) { $this->tabEtats[]; return; }

            foreach ($tempTabEtat as $etat) {
                $this->tabEtats[] = new C_Etat(
                    $etat['id'],
                    $etat['libelle']
                );
            }
        }
        catch(PDOException $e){
            $msg = "ERREUR PDO dans ".$e->getFile()." Ligne ".$e->getLine()." : ".$e->getMessage();
            die($msg);
        }
    }

    public function GetEtatById($sId){
        foreach ($this->tabEtats as $etat) {
            if($etat->Id() == $sId) return $etat;
        }
        return null;
    }
}

/*---------------------------------------------------------------------*/
#                                                                       #
#                          Frais Forfait                                #
#                                                                       #
/*---------------------------------------------------------------------*/

class C_FraisForfait{
    protected $id;
    protected $libelle;
    protected $montant;

    public function __construct($id, $libelle, $montant){
        $this->id = $id;
        $this->libelle = $libelle;
        $this->montant = $montant;
    }

    public function Id() { return $this->id; }
    public function Libelle() { return $this->libelle; }
    public function Montant() { return $this->montant; }
}

class C_FraisForfaits {
    protected $tabFraisForfaits;

    public function __construct(){

        try{
            $odao = new Cdao();
            $query = "SELECT * FROM fraisforfait;";
            $tempTabFraisForfaits = $odao->getTabDataFromSql($query);

            //TODO if (empty($tempTabFraisForfaits)) $this->tabFraisForfaits[]; return;

            foreach ($tempTabFraisForfaits as $fraisforfait) {
                $this->tabFraisForfaits[] = new C_Etat(
                    $fraisforfait['id'],
                    $fraisforfait['libelle'],
                    $fraisforfait['montant']
                );
            }
        }
        catch(PDOException $e){
            $msg = "ERREUR PDO dans ".$e->getFile()." Ligne ".$e->getLine()." : ".$e->getMessage();
            die($msg);
        }
    }

    public function GetFraisForfaitById($sId){
        foreach ($this->$tabFraisForfaits as $fraisForfait){
            if($fraisforfait->Id() == $sId) return $fraisForfait;
        }
        return null;
    }
}

/*---------------------------------------------------------------------*/
#                                                                       #
#                          Fiche Frais                                  #
#                                                                       #
/*---------------------------------------------------------------------*/

class C_FicheFrais{
    protected $idVisiteur;
    protected $mois;
    protected $nbJustificatifs;
    protected $montantValide;
    protected $dateModif;
    protected $idEtat;

    public function __construct($idVisiteur, $mois, $nbJustificatifs, $montantValide, $dateModif, $idEtat){
        $this->idVisiteur = $idVisiteur;
        $this->mois = $mois;
        $this->nbJustificatifs = $nbJustificatifs;
        $this->montantValide = $montantValide;
        $this->dateModif = $dateModif;
        $this->idEtat = $idEtat;
    }

    public function IdVisiteur() { return $this->idVisiteur; }
    public function Mois() { return $this->mois; }
    public function NbJustificatifs() { return $this->nbJustificatifs; }
    public function MontantValide() { return $this->montantValide; }
    public function DateModif() { return $this->dateModif; }
    public function IdEtat() { return $this->idEtat; }
}

class C_FichesFrais{
    protected $tabFichesFrais;

    public function __construct(){

        try{
            $odao = new Cdao();
            $query = "SELECT * FROM fichefrais;";
            $tempTabFichesFrais = $odao->getTabDataFromSql($query);

            //TODO if (empty($tempTabFichesFrais)) $this->tabFichesFrais[]; return;

            $oVisitors = new C_Visitors();
            $oEtats = new C_Etats();

            foreach ($tempTabFichesFrais as $ficheFrais) {
                $this->tabFichesFrais[] = new C_FicheFrais(
                    $oVisitors->GetVisitorById($ficheFrais['idVisiteur']),
                    $ficheFrais['mois'],
                    $ficheFrais['nbJustificatifs'],
                    $ficheFrais['montantValide'],
                    $ficheFrais['dateModif'],
                    $oEtats->GetEtatById($ficheFrais['idEtat'])
                );
            }
        }
        catch(PDOException $e){
            $msg = "ERREUR PDO dans ".$e->getFile()." Ligne ".$e->getLine()." : ".$e->getMessage();
            die($msg);
        }
    }
}

/*---------------------------------------------------------------------*/
#                                                                       #
#                        Lignes Frais Forfait                           #
#                                                                       #
/*---------------------------------------------------------------------*/

class C_LigneFraisForfait{
    protected $idVisiteur;
    protected $mois;
    protected $idFraisForfait;
    protected $quantite;

    public function __construct($idVisiteur, $mois, $idFraisForfait, $quantite){
        $this->idVisiteur = $idVisiteur;
        $this->mois = $mois;
        $this->idFraisForfait = $idFraisForfait;
        $this->quantite = $quantite; 
    }

    public function IdVisiteur() { return $this->idVisiteur; }
    public function Mois() { return $this->mois; }
    public function IdFraisForfait() { return $this->idFraisForfait; }
    public function Quantite() { return $this->quantite; }
}

class C_LignesFraisForfait{
    protected $tabLignesFraisForfait;

    public function __construct(){

        try{
            $odao = new Cdao();
            $query = "SELECT * FROM lignefraisforfait;";
            $tempTabLignesFraisForfait = $odao->getTabDataFromSql($query);
    
            //TODO if (empty($tempTabLignesFraisForfait)) { $this->tabLignesFraisForfait[]; return; }

            $oVisitors = new C_Visitors();
            $oFraisForfaits = new C_FraisForfaits();

            foreach ($tempTabLignesFraisForfait as $ligneFraisForfait) {
                $this->$tabLignesFraisForfait[] = new C_LigneFraisForfait(
                    $oVisitors->GetVisitorById($ligneFraisForfait['idVisiteur']),
                    $ligneFraisForfait['mois'],
                    $oFraisForfaits->GetFraisForfaitById($ligneFraisForfait['idFraisForfait']),
                    $ligneFraisForfait['quantite']
                );
            }
        }
        catch(PDOException $e){
            $msg = "ERREUR PDO dans ".$e->getFile()." Ligne ".$e->getLine()." : ".$e->getMessage();
            die($msg);
        }
    }
}

/*---------------------------------------------------------------------*/
#                                                                       #
#                     Lignes Frais hors Forfait                         #
#                                                                       #
/*---------------------------------------------------------------------*/

class C_LigneFraisHorsForfait{
    protected $id;
    protected $idVisiteur;
    protected $mois;
    protected $libelle;
    protected $date;
    protected $montant;

    public function __construct($id, $idVisiteur, $mois, $libelle, $date, $montant){
        $this->id = $id;
        $this->idVisiteur = $idVisiteur;
        $this->mois = $mois;
        $this->libelle = $libelle;
        $this->date = $date;
        $this->montant = $montant;
    }

    public function Id() { return $this->id; }
    public function IdVisiteur() { return $this->idVisiteur; }
    public function Mois() { return $this->mois; }
    public function Libelle() { return $this->libelle; }
    public function Date() { return $this->date; }
    public function Montant() { return $this->montant; }
}

class C_LignesFraisHorsForfait{
    protected $tabLignesFraisHorsForfait;

    public function __construct(){

        try{
            $odao = new Cdao();
            $query = "SELECT * FROM lignefraishorsforfait;";
            $tempTabLignesFraisHorsForfait = $odao->getTabDataFromSql($query);

            //TODO if (empty($tempTabLignesFraisHorsForfait)){ $this->tabLignesFraisHorsForfait[]; return; }

            $oVisitors = new C_Visitors();
            $oEtats = new C_Etats();

            foreach ($tempTabLignesFraisHorsForfait as $ligneFraisHorsForfait) {
                $this->tabLignesFraisHorsForfait[] = new C_FicheFrais(
                    $ligneFraisHorsForfait['id'],
                    $oVisitors->GetVisitorById($ligneFraisHorsForfait['idVisiteur']),
                    $ligneFraisHorsForfait['mois'],
                    $ligneFraisHorsForfait['libelle'],
                    $ligneFraisHorsForfait['date'],
                    $ligneFraisHorsForfait['montant']
                );
            }
        }
        catch(PDOException $e){
            $msg = "ERREUR PDO dans ".$e->getFile()." Ligne ".$e->getLine()." : ".$e->getMessage();
            die($msg);
        }
    }

    public function GetRowsLignesFraisHorsForfait(){
        //TODO ici faire une vérifiation sur le mois en plus
        if(empty($this->tabLignesFraisHorsForfait)){ 
            return "Pas de frais hors forfait enregistrés";
        }
        else {
            $rows = "";
            foreach ($this->tabLignesFraisHorsForfait as $ligneFraisHorsForfait){
                $rows .= "
                <tr>
                    <td>$ligneFraisHorsForfait->Libelle()</td>
                    <td>$ligneFraisHorsForfait->Date()</td>
                    <td>$ligneFraisHorsForfait->Montant()</td>
                    <td>TODO: Add ACTION</td>
                </tr>";
            }
            return $rows;
        }
    }
}

?>