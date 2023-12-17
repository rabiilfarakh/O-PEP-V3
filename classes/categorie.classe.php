<?php 

class categorie{
    private $id;
    private $nom;

    public function  __construct($id,$nom)
    {
        $this->id = $id;
        $this->nom = $nom;
    }

    //get
    public function getId(){
        return $this->id;
    }
    public function getNom(){
        return $this->nom;
    }

    //set
    public function setId($newId){
        $this->id = $newId;
    }
    public function setNom($newNom){
        $this->nom = $newNom;
    }

}

?>