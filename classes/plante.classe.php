<?php 
require_once "bdd.classes.php";
class plante{
    private $db;

    private $id;
    private $nom;
    private $img;
    private $description;
    private $stock;
    private $prix;
    private $idC;

    // public function  __construct($id,$nom,$img,$description,$prix,$idC)
    // {
    //     $this->id = $id;
    //     $this->nom = $nom;
    //     $this->img = $img;
    //     $this->description = $description;
    //     $this->prix = $prix;
    //     $this->idC = $idC;
    // } 

    public function  __construct()
    {
    
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


    public function ajouterPlante(plante $plant) {
        
        $nom = $plant->getNom();
        $img = $plant->getImg();
        $description = $plant->getDescription();
        $prix = $plant->getPrix();
        $idC = $plant->getIdC();

        try {
            $this->db = new bdd();
            $pdo = $this->db->connect();

            $req = "INSERT INTO plantes (nomPlante, imagePlante, descriptionPlante, prix, idCategorie) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($req);
            
            $stmt->bindParam(1, $nom, PDO::PARAM_STR);
            $stmt->bindParam(2, $img, PDO::PARAM_STR);
            $stmt->bindParam(3, $description, PDO::PARAM_STR);
            $stmt->bindParam(4, $prix, PDO::PARAM_INT);
            $stmt->bindParam(5, $idC, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                echo "<script>alert('Plante ajoutée avec succès')</script>";
            } else {
                echo "<script>alert('Erreur lors de l'ajout de la plante')</script>";
            }
        } catch (PDOException $e) {
            echo "Erreur PDO: " . $e->getMessage()  ;
            return false;
        }
    }
}

?>