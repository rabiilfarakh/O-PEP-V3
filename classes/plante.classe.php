<?php 
class plante{
    private $id;
    private $nom;
    private $img;
    private $description;
    private $stock;
    private $prix;
    private $idC;

    public function  __construct($id,$nom,$img,$description,$stock,$prix,$idC)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->img = $img;
        $this->description = $description;
        $this->stock = $stock;
        $this->prix = $prix;
        $this->idC = $idC;
    } 

    //get
    public function getId(){
        return $this->id;
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
    public function setId($newId){
        $this->id = $newId;
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