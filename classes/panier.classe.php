<?php 
class panier{
    private $idPlante;
    private $nom;
    private $img;
    private $description;
    private $stock;
    private $prix;
    private $idC;
    private $idPanier;
    private $idUtl;

    public function  __construct($idPlante,$nom,$img,$description,$stock,$prix,$idC,$idPanier,$idUtl)
    {
        $this->idPlante = $idPlante;
        $this->nom = $nom;
        $this->idPanier = $idPanier;
        $this->idUtl = $idUtl;
        $this->img = $img;
        $this->description = $description;
        $this->stock = $stock;
        $this->prix = $prix;
        $this->idC = $idC;
    } 

    //get
    public function getIdPlante(){
        return $this->idPlante;
    }
    public function getIdPanier(){
        return $this->idPanier;
    }
    public function getIdUtl(){
        return $this->idUtl;
    }
    public function getNom(){
        return $this->nom;
    }
    public function getImg(){
        return $this->img;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getStock(){
        return $this->stock;
    }
    public function getPrix(){
        return $this->prix;
    }
    public function getIdC(){
        return $this->idC;
    }

    //set
    public function setIdPlante($newIdPlante){
        $this->idPlante = $newIdPlante;
    }
    public function setIdPanier($newIdPanier){
        $this->idPanier = $newIdPanier;
    }
    public function setIdUtl($newIdUtl){
        $this->idUtl = $newIdUtl;
    }
    public function setNom($newNom){
        $this->nom = $newNom;
    }
    public function setImg($newImg){
        $this->img = $newImg;
    }
    public function setDescription($newDescription){
        $this->description = $newDescription;
    }
    public function setPrix($newPrix){
        $this->prix = $newPrix;
    }
    public function setIdC($newIdC){
        $this->idC = $newIdC;
    }

}

?>