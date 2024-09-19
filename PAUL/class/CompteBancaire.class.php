<?php

/*---------------------------------------------------------------------*/
#                                                                       #
#                           Compte Bancaire                             #
#                                                                       #
/*---------------------------------------------------------------------*/

class CompteBancaire{
    private $numero;
    private $solde;
    
    public function __construct(){
        $nmbArg = func_num_args();
        $argList = func_get_args();

        if ($nmbArg == 1) $this->Construct1($argList[0]); 
        else if ($nmbArg == 2) $this->Construct2($argList[0], $argList[1]); 
        else echo "ERREUR TROP/PAS ASSEZ D'ARGUMENTS";
    }
    protected function Construct1($numero){
        $this->numero = $numero;
    }
    protected function Construct2($numero, $solde){
        $this->numero = $numero;
        $this->solde = $solde;
    }

    public function Solde() { return $this->solde; }
    public function SetSolde($sSolde) { $this->solde = $sSolde; }

    public function AfficheSolde() { 
        $class = get_class($this);
        $sautLigne = ($class == 'CompteBancaire') ? "<br><br>" : "<br>";
        $return =  "Le solde du compte numéro $this->numero"; 
        $etatSolde = $this->GetSolde();

        if ($etatSolde != null) {
            $etatCompte = $this->GetEtatCompte();
            $solde = " est de $etatSolde.";
        }
        else {
            $etatCompte = '';
            $solde = " n'est pas initialisé";
        }
        
        return "$class <br> $return $solde $etatCompte $sautLigne";
    }
    private function GetSolde() { return (!isset($this->solde)) ? null : $this->solde; } 
    private function GetEtatCompte() { return ($this->solde >= 0) ? " Solde créditeur" : " Solde débiteur";}

    public function Debiter($sMontant) { $this->solde -= $sMontant; }
    public function Crediter($sMontant) { $this->solde += $sMontant; }
}

/*---------------------------------------------------------------------*/
#                                                                       #
#                            Livret Épargne                             #
#                                                                       #
/*---------------------------------------------------------------------*/

class LivretEpargne extends CompteBancaire{
    private $tauxInteret;
    private $apportMensuel;

    public function __construct($numero, $solde, $tauxInteret, $apportMensuel){
        parent::Construct2($numero, $solde);
        $this->tauxInteret = $tauxInteret;
        $this->apportMensuel = $apportMensuel;
    }

    public function AfficheSolde(){
        return parent::AfficheSolde()."Taux d'intéret : $this->tauxInteret %. Apport mensuel : $this->apportMensuel € / mois.<br>";
    }

    public function TableauEpargne($sNbAnnee){
        if ($sNbAnnee < 0) return "Le nombre d'année doit être supérieur à 0.";
        $tableStart = "
        <table>
            <thead>
                <th>Année</th>
                <th>Solde de départ</th>
                <th>Intérêt annuel</th>
                <th>Solde final</th>
            </thead>
            <tbody>
        ";
        $tr = $this->GetRowsTableauEpargne($sNbAnnee);
        $tableEnd = "
            </tbody>
        </table>
        ";

        return $tableStart.$tr.$tableEnd;
    }

    private function GetRowsTableauEpargne($sNbAnnee){
        $tr = "";
        for ($i = 1; $i < $sNbAnnee+1; $i++){
            $solde = $this->Solde();
            $interet = $this->CalculerInteretAnnuel();
            $soldeFinal = $solde + $interet + ($this->apportMensuel * 12);
            $this->SetSolde($soldeFinal);
            $tr .= "
            <tr>
                <td>Année $i</td>
                <td>$solde</td>
                <td>$interet</td>
                <td>$soldeFinal</td>
            </tr>
            ";
        }
        return $tr;
    }
    private function CalculerInteretAnnuel(){
        $interetAnnuel = 0;
        $tauxMensuel = ($this->tauxInteret / 12)/100;
        $solde = $this->Solde();
        for ($i = 1; $i < 13; $i++){
            $interetMensuel = $solde * $tauxMensuel;
            $interetAnnuel += $interetMensuel;
            $solde = $this->Solde() + ($i * 100);
            $solde += $interetMensuel;
        }
        return $interetAnnuel;
    }
} 


?>