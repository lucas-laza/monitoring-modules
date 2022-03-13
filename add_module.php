<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout de module</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="node_modules\bootstrap\dist\css\bootstrap.css">
</head>



<div class="top">
    
        <div><a href="./" class="link-primary"><< Accueil: monitoring</a></div>

        <!-- Une fois un module ajouté, ce texte s'affiche -->
        <?php if (isset($_GET["done"])){ if ($_GET["done"] == true){
            ?> <h2 style="color:var(--bs-success);">Votre module a bien été ajouté !</h2> <?php
        }} ?>
</div>

<!-- formulaire d'ajout d'un module -->
<form action="add_handler.php" method="POST" class="container">
    <h2>Formulaire d'ajout de module</h2>

    <div class="mb-3">
        <label for="nom" minlength="3" class="form-label">*Nom du module</label>
        <input type="text" name="nom" id="nom" required class="form-control">
    </div class="mb-3">

    <div class="mb-3">
        <label for="periode" class="form-label">*Période de prise de mesure en secondes</label>
        <input type="num" name="periode" id="periode" required class="form-control">
    </div class="mb-3">

    <div class="mb-3">
        <label for="nbSerie" class="form-label">Numéro de série</label>
        <input type="text" name="nbSerie" id="nbSerie" class="form-control">
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">*Description</label>
        <textarea name="description" id="description" cols="40" rows="4" required minlength="3" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label for="unite" class="form-label">*Unite de mesure</label>
        <input type="text" name="unite" id="unite" required class="form-control">
    </div>


    <div class="form-text">*champs obligatoires</div>


    <div class="d-grid gap-2 col-6 mx-auto my-5"><input type="submit" value="Ajouter" class="btn btn-primary"></div>

</form>

<script src="node_modules\bootstrap\dist\js\bootstrap.min.js"></script>