<?php 
ob_start(); 
?>

Bienvenu!

<?php
$content = ob_get_clean();
$titre = "Bibliothèque MGA";
require "template.php";
?>