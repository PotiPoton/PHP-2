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

    #region Getters Setters

    public function Id() { return $this->id; }
    public function Libelle() { return $this->libelle; }

    #endregion

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

    #region Getters Setters

    public function Id() { return $this->id; }
    public function Libelle() { return $this->libelle; }
    public function Montant() { return $this->montant; }

    #endregion

}

class C_FraisForfaits {
    protected $tabFraisForfaits;

    public function __construct(){

        try{
            $odao = new Cdao();
            $query = "SELECT * FROM fraisforfait;";
            $tempTabFraisForfaits = $odao->getTabDataFromSql($query);

            foreach ($tempTabFraisForfaits as $fraisforfait) {
                $this->tabFraisForfaits[] = new C_FraisForfait(
                    $fraisforfait['id'],
                    $fraisforfait['libelle'],
                    $fraisforfait['montant']
                );
            }
        }
        catch(Exception $e){
            echo "ERREUR : ".$e->getMessage();
        }
    }

    public function GetFraisForfaitById($sId){
        foreach ($this->tabFraisForfaits as $fraisforfait){
            if($fraisforfait->Id() == $sId) return $fraisforfait;
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

    #region Getters Setters

    public function IdVisiteur() { return $this->idVisiteur; }
    public function Mois() { return $this->mois; }
    public function NbJustificatifs() { return $this->nbJustificatifs; }
    public function MontantValide() { return $this->montantValide; }
    public function DateModif() { return $this->dateModif; }
    public function IdEtat() { return $this->idEtat; }

    #endregion

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
        catch(Exception $e){
            echo "ERREUR : ".$e->getMessage();
        }
    }

}

/*---------------------------------------------------------------------*/
#                                                                       #
#                        Lignes Frais Forfait                           #
#                                                                       #
/*---------------------------------------------------------------------*/

class C_LigneFraisForfait{
    protected $id;
    protected $idVisiteur;
    protected $mois;
    protected $idFraisForfait;
    protected $quantite;

    public function __construct($id, $idVisiteur, $mois, $idFraisForfait, $quantite){
        $this->id = $id;
        $this->idVisiteur = $idVisiteur;
        $this->mois = $mois;
        $this->idFraisForfait = $idFraisForfait;
        $this->quantite = $quantite; 
    }

    #region Getters Setters

    public function Id() { return $this->id; }
    public function IdVisiteur() { return $this->idVisiteur; }
    public function Mois() { return $this->mois; }
    public function IdFraisForfait() { return $this->idFraisForfait; }
    public function Quantite() { return $this->quantite; }

    #endregion

}

class C_LignesFraisForfait{
    protected $tabLignesFraisForfait;
    protected $visitor;

    public function __construct($sVisitor){

        $this->visitor = $sVisitor;
        try{
            $odao = new Cdao();
            $query = "SELECT * FROM lignefraisforfait;";
            $tempTabLignesFraisForfait = $odao->getTabDataFromSql($query);
    
            //TODO if (empty($tempTabLignesFraisForfait)) { $this->tabLignesFraisForfait[]; return; }

            $oFraisForfaits = new C_FraisForfaits();

            foreach ($tempTabLignesFraisForfait as $ligneFraisForfait) {
                $this->$tabLignesFraisForfait[] = new C_LigneFraisForfait(
                    $ligneFraisForfait['id'],
                    $this->visitor,
                    $ligneFraisForfait['mois'],
                    $oFraisForfaits->GetFraisForfaitById($ligneFraisForfait['idFraisForfait']),
                    $ligneFraisForfait['quantite']
                );
            }
        }
        catch(Exception $e){
            echo "ERREUR : ".$e->getMessage();
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

    #region Getters Setters

    public function Id() { return $this->id; }
    public function IdVisiteur() { return $this->idVisiteur; }
    public function Mois() { return $this->mois; }
    public function Libelle() { return $this->libelle; }
    public function Date() { return $this->date; }
    public function Montant() { return $this->montant; }

    #endregion
}

class C_LignesFraisHorsForfait{
    protected $tabLignesFraisHorsForfait;
    protected $visitor;

    public function __construct($sVisitor){

        $this->visitor = $sVisitor;
        try{
            $odao = new Cdao();
            $query = "SELECT * FROM lignefraishorsforfait WHERE idVisiteur='".$this->visitor->Id()."';";
            $tempTabLignesFraisHorsForfait = $odao->getTabDataFromSql($query);

            //TODO if (empty($tempTabLignesFraisHorsForfait)){ $this->tabLignesFraisHorsForfait[]; return; }

            $oEtats = new C_Etats();

            foreach ($tempTabLignesFraisHorsForfait as $ligneFraisHorsForfait) {
                $this->tabLignesFraisHorsForfait[] = new C_LigneFraisHorsForfait(
                    $ligneFraisHorsForfait['id'],
                    $this->visitor,
                    $ligneFraisHorsForfait['mois'],
                    $ligneFraisHorsForfait['libelle'],
                    $ligneFraisHorsForfait['date'],
                    $ligneFraisHorsForfait['montant']
                );
            }
            
        }
        catch(Exception $e){
            echo "ERREUR : ".$e->getMessage();
        }
    }

    #region Méthodes Publiques

    public function AddLigneFraisHorsForfait($sLibelle, $sMontant){
        try{
            $mois = date('m');
            $date = date('Y-m-d');
            $odao = new Cdao();

            $query = "INSERT INTO lignefraishorsforfait (`idVisiteur`, `mois`, `libelle`, `date`, `montant`) 
                VALUES ('".$this->visitor->Id()."', '$mois', '$sLibelle', '$date', $sMontant);";
            $odao->execute($query);

            $query = "SELECT MAX(id) FROM lignefraishorsforfait";
            $id = $odao->getTabDataFromSQL($query);
            $this->tabLignesFraisHorsForfait[] = new C_LigneFraisHorsForfait(
                $id[0], $this->visitor, $mois, $sLibelle, $date, $sMontant);
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
                    <td>".$ligneFraisHorsForfait->Libelle()."</td>
                    <td>".$ligneFraisHorsForfait->Date()."</td>
                    <td>".$ligneFraisHorsForfait->Montant()."</td>
                    <td>TODO: Add ACTION</td>
                </tr>";
            }
            return $rows;
        }
    }

    #endregion

}

/*$oFraisForfaits = new C_FraisForfaits();
$oFraisForfaits->GetFraisForfaitById('ETP');

$visitors=new C_visitors();
$visitor=$visitors->TabVisitors()[1];

$lignesfhf = new C_LignesFraisHorsForfait($visitor);
$lignesfhf->AddLigneFraisHorsForfait('test2', 12.84);*/

?>