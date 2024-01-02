<?php
require_once "model/LivreManager.class.php";

class LivreController{
  
    private $livreManager;
    public function __construct(){

        $this->livreManager = new LivreManager;
        $this->livreManager->chargementLivres();
    }

    function afficherLivres(){
        $livres = $this->livreManager->getLivres();
        require "view/livres.view.php";
    }

    public function afficherLivre($id){
          $livre = $this->livreManager->getLivreById($id);
          require "view/afficherLivre.view.php";
    }
    
    public function ajoutLivre(){
        require "view/ajoutLivre.view.php";
    }

    public function ajoutLivreValidation(){
        $file = $_FILES['image'];
        $repertoire = "public/images/";
        $nomImage = $this->imageAjout($file, $repertoire);
        $this->livreManager->ajoutLivreBd($_POST['titre'], $_POST['nbPages'] ?? null, $nomImage);
        header('Location: '. URL . "livres"); 
    }

    public function suppressionLivre($id){
        $nomImage = $this->livreManager->getLivreById($id)->getImage();
        unlink("public/images/". $nomImage);
        $this->livreManager->suppressionLivreBd($id);
        header('Location: '. URL . "livres"); 
    }

    public function modificationLivre($id){
        $livre=$this->livreManager->getLivreById($id); 
        require "view/modifierLivre.view.php";
    }

    public function modificationLivreValidation(){
        $imageActuelle = $this->livreManager->getLivreById($_POST['identification'])->getImage();
        $file=$_FILES['image'];

        if($file['size']>0){
            unlink("public/images/". $imageActuelle);
            $repertoire = "public/images/";
            $nomImageToAdd = $this->imageAjout($file, $repertoire);
        }else
        $nomImageToAdd=$imageActuelle;
        $this->livreManager->modificationLivreBd($_POST['identification'],$_POST['titre'],$_POST['nbPages'],$imageActuelle);
        header('Location: '. URL . "livres");
    }
    private function imageAjout($file, $dir){
        if(!isset($file['name'])||empty($file['name']))
        throw new Exception ("vous devez indiquer une image");

        if(!file_exists($dir)) mkdir($dir, 0777);

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $random = rand(0,9999);
        $target_file = $dir.$random."_".$file['name'];

        if(!getimagesize($file["tmp_name"]))
         throw new Exception("le fichier n'est pas une image");
        if($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" )
        throw new Exception("l'extension du fichier n'est pas reconnu");
        if(file_exists($target_file))
        throw new Exception("le fichier existe deja");
        if($file['size']>5000)
        throw new Exception("le fichier est trop gros");
        if(!move_uploaded_file($file['tmp_name'], $target_file))
        throw new Exception("l'image n'a pas ete ajouter");
          else    return($random."_".$file['name']);
    }
}
