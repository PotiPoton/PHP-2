<div class="cnt box">
    <h2>Saisie des frais forfaitaires</h2>
    <form action="" method="POST">
        <div class="row">
            <label for="ff-etape">Forfait étape</label>
            <input type="number" name="ff-etape" id="ff-etape" step="1">
            <input type="text" placeholder="Ajouter Fonction php" readonly>
        </div>
        <div class="row">
            <label for="ff-km">Frais Kilométrique</label>
            <input type="number" name="ff-etape" id="ff-km" step="0.1">
            <input type="text" placeholder="Ajouter Fonction php" readonly>
        </div>
        <div class="row">
            <label for="ff-hotel">Nuitée hotel</label>
            <input type="number" name="ff-etape" id="ff-hotel" step="1">
            <input type="text" placeholder="Ajouter Fonction php" readonly>
        </div>
        <div class="row">
            <label for="ff-resto">Repas restaurant</label>
            <input type="number" name="ff-etape" id="ff-resto" step="1">
            <input type="text" placeholder="Ajouter Fonction php" readonly>
        </div>
        <input class="save" type="submit" name="btn-ff" value="Enregistrer">
    </form>
</div>