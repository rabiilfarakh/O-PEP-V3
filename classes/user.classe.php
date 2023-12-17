
<?php
include "classes/bdd.classes.php";

class user{
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $pwd;

    public function __construct($id,$nom, $prenom, $email, $pwd) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->pwd = $pwd;
    }

        //get
        // public function getId(){
        //     return $this->id;
        // }
        public function getNom(){
            return $this->nom;
        }
        public function getPrenom(){
            return $this->prenom;
        }
        public function getEmail(){
            return $this->email;
        }
        public function getPwd(){
            return $this->pwd;
        }

        //set
        // public function setId($newId){
        //     return $this->$newId;
        // }
        public function setNom($newNom){
            return $this->$newNom;
        }
        public function setPrenom($newPrenom){
            return $this->$newPrenom;
        }
        public function setEmail($newEmail){
            return $this->$newEmail;
        }
        public function setPwd($newPwd){
            return $this->$newPwd;
        }
    
    }

?>
