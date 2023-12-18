
<?php
require_once "plante.classe.php";
require_once "bdd.classes.php";
class plantes{
    private $db;

    public function getPlantes(){

        $this->db = new bdd();
        $req = "SELECT * FROM plantes";
        $res = $this->db->connect()->query($req);
        if($res){
            $plantesDB = $res->fetchAll(PDO::FETCH_ASSOC);
            $plantesT = array();
            foreach($plantesDB as $plante){
                $plantesT[] = new plante($plante["idPlante"],$plante["nomPlante"],$plante["imagePlante"],$plante["descriptionPlante"],$plante["stock"],$plante["prix"],$plante["idCategorie"]);
            }
            return $plantesT;
        }
        return null;
    }
    
    public function getPlantesInCategories($id){

        $this->db = new bdd();
        $req = "SELECT * FROM plantes 
        WHERE idCategorie = $id ";
        $res = $this->db->connect()->query($req);
        if($res){
            $plantesDB = $res->fetchAll(PDO::FETCH_ASSOC);
            $plantesT = array();
            foreach($plantesDB as $plante){
                $plantesT[] = new plante($plante["idPlante"],$plante["nomPlante"],$plante["imagePlante"],$plante["descriptionPlante"],$plante["stock"],$plante["prix"],$plante["idCategorie"]);
            }
            return $plantesT;
        }
        return null;
    }

    public function searchPlantes($nomP){

        $this->db = new bdd();
        $req = "SELECT * FROM plantes 
        WHERE nomPlante LIKE '%$nomP%' ";
        $res = $this->db->connect()->query($req);
        if($res){
            $plantesDB = $res->fetchAll(PDO::FETCH_ASSOC);
            $plantesT = array();
            foreach($plantesDB as $plante){
                $plantesT[] = new plante($plante["idPlante"],$plante["nomPlante"],$plante["imagePlante"],$plante["descriptionPlante"],$plante["stock"],$plante["prix"],$plante["idCategorie"]);
                
            }
            return $plantesT;
        }
        return null;
    }

    public function ajouterPlantes_panier($idP){
        // session_start();
        $idUtl = isset($_SESSION['idUtl']) ? $_SESSION['idUtl'] : null;
        
        if ($idUtl) {
            $this->db = new bdd();
            $pdo = $this->db->connect();
            $req = "INSERT INTO panier (idUtl, idPlante) VALUES (?, ?)";
            $stmt = $pdo->prepare($req);
            $stmt->bindParam(1, $idUtl);
            $stmt->bindParam(2, $idP);
    
            if ($stmt->execute()) {
                echo "<script>alert('produit ajouté au panier')</script>";
                echo "<script>window.location = 'produits.php';</script>";
                exit();
            } else {
                echo "<script>alert('erreur d\'ajout')</script>";
            }
        } else {
            echo "ID utilisateur non trouvé dans la session";
        }
    }
    

    
}
?>