
<?php
session_start();
include "bdd.classes.php";

class login extends bdd{
    private $email;
    private $pwd;

    public function __construct($email, $pwd) {
        $this->email = $email;
        $this->pwd = $pwd;
    }

    public function selectUser(){
        if(empty($this->email) || empty($this->pwd)){
            echo "Un champ est vide!";
        } else {
            $sql = "SELECT idUtl FROM utilisateurs WHERE emailUtl='$this->email' AND mdpUtl='$this->pwd'";
            $res = $this->connect()->query($sql);
            if($res){
                $row = $res->fetch(PDO::FETCH_ASSOC);
                $_SESSION['idUser'] = $row['idUtl'];
                header('location:./../pages/produits.php');
            } else {
                echo "email ou mdp incorrecte";
            }
        }
    }
}
?>
