
<?php
require_once "bdd.classes.php";
    class signup extends bdd {

        public function singnupM($nom, $prenom, $email, $pwd) {
            $pdo = $this->connect();
    
            $sql = "INSERT INTO utilisateurs (nomUtl, prenomUtl, emailUtl, mdpUtl) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $nom);
            $stmt->bindParam(2, $prenom);
            $stmt->bindParam(3, $email);
            $stmt->bindParam(4, $pwd);
    
            if($stmt->execute()) {
                $idUtl = $pdo->lastInsertId();
                session_start();
                $_SESSION['idUtl'] = $idUtl;
                header('location:./../pages/role.php');
                exit();
            } else {
                echo "Erreur d'insertion";
            }
        }
    
        public function loginM($email, $pwd) {
            $sql = "SELECT r.nomRole, r.idUtl FROM roles r
                    JOIN utilisateurs u ON r.idUtl = u.idUtl
                    WHERE u.emailUtl = ? AND u.mdpUtl = ?";
        
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $email);
            $stmt->bindParam(2, $pwd);
        
            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if ($result) {
                    $role = $result['nomRole'];
                    session_start();
                    $_SESSION['idUtl'] = $result['idUtl'];
                    $id = $_SESSION['idUtl'];
                    header('location:pages/' . ($role == 'client' ? 'produits.php' : 'admin.php') . '?role=' . $role.$id);
                    exit();
                } else {
                    echo "email ou mdp incorrect";
                }
            } else {
                echo "Erreur lors de l'exécution de la requête";
            }
        }
        
    
        public function roleM($role) {
            session_start();
            $idUtl = isset($_SESSION['idUtl']) ? $_SESSION['idUtl'] : null;
    
            if ($idUtl) {
                $pdo = $this->connect();
    
                $sql = "INSERT INTO roles (nomRole, idUtl) VALUES (?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(1, $role);
                $stmt->bindParam(2, $idUtl);
    
                if($stmt->execute()) {
                    header('location:./../index.php');
                } else {
                    echo "Erreur lors de l'ajout du rôle";
                }
            } else {
                echo "ID utilisateur non trouvé dans la session";
            }
        }
    }
    
?>
