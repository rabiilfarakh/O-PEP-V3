
<?php
require_once "categorie.classe.php";
require_once "bdd.classes.php";
class categories{
    private $db;
    
    public function getCategories(){
        $this->db = new bdd();
        $req = "SELECT * FROM categories";
        $res = $this->db->connect()->query($req);
        if($res){
            $categoriesDB = $res->fetchAll(PDO::FETCH_ASSOC);
            $categoriesT = array();
            foreach($categoriesDB as $categorie){
                $categoriesT[] = new categorie($categorie["idCategorie"],$categorie["nomCategorie"]);
            }
            return $categoriesT;
        }
        return null;
    }   

    
    
}
?>
    