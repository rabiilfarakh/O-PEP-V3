<?php
require_once "bdd.classes.php";
require_once "plante.classe.php";
require_once "panier.classe.php";

class panierM{
    private $db;

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

    public function getPanier(){
        // session_start();
        $idUtl = isset($_SESSION['idUtl']) ? $_SESSION['idUtl'] : null;
    
        if ($idUtl) {
            try {
                $this->db = new bdd();
                $pdo = $this->db->connect();
    
                $req = "SELECT * FROM plantes pl
                        JOIN panier pa ON pa.idPlante = pl.idPlante
                        WHERE pa.idUtl = :idUtl";
    
                $stmt = $pdo->prepare($req);
                $stmt->bindParam(':idUtl', $idUtl, PDO::PARAM_INT);
                $stmt->execute();
    
                $panierDB = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $panierT = array();
    
                foreach ($panierDB as $panier) {
                    $panierT[] = new panier(
                        $panier["idPlante"],
                        $panier["nomPlante"],
                        $panier["imagePlante"],
                        $panier["descriptionPlante"],
                        $panier["stock"],
                        $panier["prix"],
                        $panier["idCategorie"],
                        $panier["idPanier"],
                        $panier["idUtl"]
                    );
                }
                return $panierT;
            } catch (PDOException $e) {
                echo "<script>alert('Erreur PDO: " . $e->getMessage() . "')</script>";
            }
        } else {
            echo "<script>alert('ID utilisateur non trouvé dans la session')</script>";
        }
        return null;
    }
    

    public function supprimerPanier($idPanier) {

        try {
            $this->db = new bdd();
            $pdo = $this->db->connect();
    
            $stmt = $pdo->prepare("DELETE FROM panier WHERE idPanier = :idPanier");
            $stmt->bindParam(':idPanier', $idPanier, PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                echo "<script>alert('produit supprimé du panier')</script>";
                echo "<script>window.location = 'panier.php';</script>";
            } else {
                echo "<script>alert('erreur')</script>";
                echo "<script>window.location = 'panier.php';</script>";
            }
        } catch (PDOException $e) {

            echo "<script>alert('Erreur PDO: " . $e->getMessage() . "')</script>";
            echo "<script>window.location = 'produits.php';</script>";
        }
    }

    public function prixTotal() {
        $idUtl = isset($_SESSION['idUtl']) ? $_SESSION['idUtl'] : null;
    
        if ($idUtl) {
            try {
                $this->db = new bdd();
                $pdo = $this->db->connect();
    
                $stmt = $pdo->prepare("SELECT SUM(prix) AS totalPrix FROM plantes JOIN panier ON plantes.idPlante = panier.idPlante WHERE panier.idUtl = ?");
                $stmt->bindParam(1, $idUtl, PDO::PARAM_INT);
    
                if (!$stmt->execute()) {
                    echo "<script>alert('Erreur d'exécution de la requête')</script>";
                } else {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
                    if ($result) {
                        $totalPrix = $result['totalPrix'];
                        return $totalPrix;
                    } else {
                        echo "<script>alert('Aucun produit dans le panier')</script>";
                    }
                }
            } catch (PDOException $e) {
                echo "<script>alert('Erreur PDO: " . $e->getMessage() . "')</script>";
            }
        } else {
            echo "<script>alert('ID utilisateur non trouvé dans la session')</script>";
        }
    
        return null;
    }

    public function count(){
        $idUtl = isset($_SESSION['idUtl']) ? $_SESSION['idUtl'] : null;
    
        if ($idUtl) {
            try {
                $this->db = new bdd();
                $pdo = $this->db->connect();
    
                $stmt = $pdo->prepare("SELECT COUNT(idPanier) AS COUNT_P FROM panier WHERE idUtl = ?");
                $stmt->bindParam(1, $idUtl, PDO::PARAM_INT);
    
                if (!$stmt->execute()) {
                    echo "<script>alert('Erreur d'exécution de la requête')</script>";
                } else {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
                    if ($result) {
                        $count = $result['COUNT_P'];
                        return $count;
                    } else {
                        echo "<script>alert('Aucun produit dans le panier')</script>";
                    }
                }
            } catch (PDOException $e) {
                echo "<script>alert('Erreur PDO: " . $e->getMessage() . "')</script>";
            }
        } else {
            echo "<script>alert('ID utilisateur non trouvé dans la session')</script>";
        }
    
        return null;
    }
    
    public function commander(){
        $idUtl = isset($_SESSION['idUtl']) ? $_SESSION['idUtl'] : null;
        
        if ($idUtl) {
            $this->db = new bdd();
            $pdo = $this->db->connect();

            $reqCommandes = "INSERT INTO commandes (idUtl) VALUES (?)";
            $stmtCommandes = $pdo->prepare($reqCommandes);
            $stmtCommandes->bindParam(1, $idUtl, PDO::PARAM_INT);
    
            if ($stmtCommandes->execute()) {

                $lastInsertedId = $pdo->lastInsertId();
    
                $reqDetailsCommande = "INSERT INTO details_commande (idCommande, idPlante, quantite) 
                                      SELECT ?, idPlante, quantite FROM panier WHERE idUtl = ?";
                $stmtDetailsCommande = $pdo->prepare($reqDetailsCommande);
                $stmtDetailsCommande->bindParam(1, $lastInsertedId, PDO::PARAM_INT);
                $stmtDetailsCommande->bindParam(2, $idUtl, PDO::PARAM_INT);
                $stmtDetailsCommande->execute();
    
                $reqSuppressionPanier = "DELETE FROM panier WHERE idUtl = ?";
                $stmtSuppressionPanier = $pdo->prepare($reqSuppressionPanier);
                $stmtSuppressionPanier->bindParam(1, $idUtl, PDO::PARAM_INT);
                $stmtSuppressionPanier->execute();
    
                echo "<script>alert('Commande validée avec succès')</script>";
                header("Location: panier.php");
                exit();
            } else {
                echo "<script>alert('Erreur lors de la validation de la commande')</script>";
            }
        } else {
            echo "<script>alert('ID utilisateur non trouvé dans la session')</script>";
        }
    }
    

    
}