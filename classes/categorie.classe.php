<?php 
require_once "bdd.classes.php";
class categorie{
    private $db;
    private $id;
    private $nom;

    public function  __construct(){}


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



        //ajouter categorie
        public function ajouterCategorie(categorie $catg) {
            $nom = $catg->getNom();
    
            try {
                $this->db = new bdd();
                $pdo = $this->db->connect();
    
                $req = "INSERT INTO categories (nomCategorie) VALUES ( ?)";
                $stmt = $pdo->prepare($req);
                $stmt->bindParam(1, $nom, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    echo "<script>alert('categorie ajoutée avec succès')</script>";
                    echo "<script>window.location = 'admin.php';</script>";
                    exit;
                } else {
                    echo "<script>alert('Erreur lors de l'ajout de la categorie')</script>";
                }
            } catch (PDOException $e) {
                echo "Erreur PDO: " . $e->getMessage()  ;
                return false;
            }
        }
    
        //supprimer categorie
        public function supprimerCategorie(categorie $catg) {
            $nom = $catg->getNom();
            
            try {
                $this->db = new bdd();
                $pdo = $this->db->connect();
    
                $queryC = "DELETE FROM categories WHERE nomCategorie = ?";
                $stmt = $pdo->prepare($queryC);
                $stmt->bindParam(1, $nom, PDO::PARAM_STR);
                   
                if ($stmt->execute()) {
                    echo "<script>alert('categorie supprimée avec succès.')</script>";
                    echo "<script>window.location = 'admin.php';</script>";
                } else {
                    echo "<script>alert('Erreur lors de la suppression de la categorie. Veuillez réessayer.')</script>";
                }
            } catch (PDOException $e) {
                echo "<script>alert('Erreur PDO: " . $e->getMessage() . "')</script>";
            }
        }

//modifier categorie
public function modifierCategorie(categorie $catg) {
    $nom = $catg->getNom();
    $id = $catg->getId();
    try {
        $this->db = new bdd();
        $pdo = $this->db->connect();

        $query = "UPDATE categories SET nomCategorie = ? WHERE idCategorie = ?";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(1, $nom, PDO::PARAM_STR);
        $stmt->bindParam(2, $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>alert('categorie modifié avec succès.')</script>";
            echo "<script>window.location = 'admin.php';</script>";
        } else {
            echo "<script>alert('Erreur lors de la modification de la categorie. Veuillez réessayer.')</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Erreur PDO: " . $e->getMessage() . "')</script>";
    }
}



public function getCategories() {
    try {
        $this->db = new bdd();
        $req = "SELECT * FROM categories";
        $res = $this->db->connect()->query($req);

        if ($res) {
            $categoriesDB = $res->fetchAll(PDO::FETCH_ASSOC);
            $categoriesT = array();

            foreach ($categoriesDB as $categorie) {
                $categorieObj = new categorie();
                $categorieObj->setId($categorie["idCategorie"]);
                $categorieObj->setNom($categorie["nomCategorie"]);

                $categoriesT[] = $categorieObj;
            }

            return $categoriesT;
        }

        return null;
    } catch (PDOException $e) {
        echo "Erreur PDO: " . $e->getMessage();
        return null;
    }
}


}

?>