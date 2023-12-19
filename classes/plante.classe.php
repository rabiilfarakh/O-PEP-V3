<?php 
require_once "bdd.classes.php";
class plante{
    private $db;
    private $id;
    private $nom;
    private $img;
    private $description;
    private $prix;
    private $idC;

    public function  __construct(){}


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

    //ajouter plante
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
                echo "<script>window.location = 'admin.php';</script>";
                exit;
            } else {
                echo "<script>alert('Erreur lors de l'ajout de la plante')</script>";
            }
        } catch (PDOException $e) {
            echo "Erreur PDO: " . $e->getMessage()  ;
            return false;
        }
    }

    //supprimer plante
    public function supprimerPlante(plante $plant) {
        $id = $plant->getId();
        
        try {
            $this->db = new bdd();
            $pdo = $this->db->connect();

            $queryPlante = "DELETE FROM plantes WHERE idPlante = ?";
            $stmt = $pdo->prepare($queryPlante);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
               
            if ($stmt->execute()) {
                echo "<script>alert('Plante supprimée avec succès.')</script>";
                echo "<script>window.location = 'admin.php';</script>";
            } else {
                echo "<script>alert('Erreur lors de la suppression de la plante. Veuillez réessayer.')</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Erreur PDO: " . $e->getMessage() . "')</script>";
        }
    }



    
    public function getPlantes() {
        try {
            $this->db = new bdd();
            $req = "SELECT * FROM plantes";
            $res = $this->db->connect()->query($req);

            if ($res) {
                $plantesDB = $res->fetchAll(PDO::FETCH_ASSOC);
                $plantesT = array();

                foreach ($plantesDB as $plante) {
                    $planteObj = new plante();
                    $planteObj->setId($plante["idPlante"]);
                    $planteObj->setNom($plante["nomPlante"]);
                    $planteObj->setImg($plante["imagePlante"]);
                    $planteObj->setDescription($plante["descriptionPlante"]);
                    $planteObj->setPrix($plante["prix"]);
                    $planteObj->setIdC($plante["idCategorie"]);

                    $plantesT[] = $planteObj;
                }

                return $plantesT;
            }

            return null;
        } catch (PDOException $e) {
            echo "Erreur PDO: " . $e->getMessage();
            return null;
        }
    }



    public function getPlantesInCategories($id) {
        try {
            $this->db = new bdd();
            $req = "SELECT * FROM plantes WHERE idCategorie = ?";
            $stmt = $this->db->connect()->prepare($req);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
    
            $plantesDB = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $plantesT = array();
    
            foreach ($plantesDB as $plante) {
                $planteObj = new plante();
                $planteObj->setId($plante["idPlante"]);
                $planteObj->setNom($plante["nomPlante"]);
                $planteObj->setImg($plante["imagePlante"]);
                $planteObj->setDescription($plante["descriptionPlante"]);
                $planteObj->setPrix($plante["prix"]);
                $planteObj->setIdC($plante["idCategorie"]);
    
                $plantesT[] = $planteObj;
            }
    
            return $plantesT;
        } catch (PDOException $e) {
            echo "Erreur PDO: " . $e->getMessage();
            return null;
        }
    }

    

    public function searchPlantes($nomP) {
        try {
            $this->db = new bdd();
            $req = "SELECT * FROM plantes WHERE nomPlante LIKE :nomP";
            $stmt = $this->db->connect()->prepare($req);
            $stmt->bindValue(':nomP', '%' . $nomP . '%', PDO::PARAM_STR);
            $stmt->execute();
    
            $plantesDB = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $plantesT = array();
    
            foreach ($plantesDB as $planteData) {
                $planteObj = new plante();
                $planteObj->setId($planteData["idPlante"]);
                $planteObj->setNom($planteData["nomPlante"]);
                $planteObj->setImg($planteData["imagePlante"]);
                $planteObj->setDescription($planteData["descriptionPlante"]);
                $planteObj->setPrix($planteData["prix"]);
                $planteObj->setIdC($planteData["idCategorie"]);
    
                $plantesT[] = $planteObj;
            }
    
            return $plantesT;
        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
            return null;
        }
    }
    


}

?>