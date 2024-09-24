<div class="cnt table">
    <h2>Récapitulatif des frais hors forfait</h2>
    <h4>Mois : <?php echo "insérer var" ?></h4>
    <?php

    $rows = $oLignesFraisHorsForfait->GetRowsLignesFraisHorsForfait();

    if (!strpos($rows, '<tr>')) $errorMsg = $rows;
    else {
        echo "
        <table>
            <thead>
                <th>Libellé</th>
                <th>Date</th>
                <th>Montant</th>
                <th>Action</th>
            </thead>
            <tbody>
                $rows
            </tbody>
        </table>";
    }
    require_once 'error-handling.php';
    ?>
</div>