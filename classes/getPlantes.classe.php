
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
        $this->db = new bdd();
        $req = "SELECT * FROM plantes 
        WHERE idPlante = $idP ";
        $res = $this->db->connect()->query($req);
        if($res){
            echo "sucee";
        }
    }
}
?>