<?php 
ob_start(); 
?>

<form method="POST" action="<?= URL?>livres/mv" enctype= "multipart/form-data">

    <div class="form-group">
        <label for="titre">Titre: </label>
        <input type="text" class="form-control" id="titre" name="titre" value="<?= $livre->getTitre()?>">
    </div>

    <div class="form-group">
        <label for="nbpages">Nombre de pages: </label>
        <input type="number" class="form-control" id="nbpages" name="nbPages" value="<?= $livre->getNbPages()?>" >
    </div>
    <h3>Image: </h3>
    <img src="<?= URL?>public/images/<?= $livre->getImage()?> " alt="image du livre">
    <div class="form-group">
        <label for="image">Changer L'image: </label>
        <input type="file" class="form-control" id="image" name="image" >
    </div>
    <input type="hidden" name="identification" value="<?= $livre->getId()?>">
        <button type="submit" class="btn btn-primary">valider</button>

</form>

<?php
$content = ob_get_clean();
$titre = "Modification du livre " .$livre->getId();
require "template.php";
?>