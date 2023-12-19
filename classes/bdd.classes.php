<!-- <?php
// class bdd {
//     private $host = "localhost";
//     private $user = "root";
//     private $pwd = "167200216";
//     private $dbName = "opep2";

//     protected function connect(){
//         $dns = 'mysql:host=' .$this->host. ';dbname=' .$this->dbName;
//         $pdo = new PDO($dns,$this->user,$this->pwd);
//         $pdo->setAttribute(PDO ::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//         return $pdo;
//     }
// }
?> -->
 <?php

require_once "db_config.php" ;

class bdd
{
    public function connect()
    {
        try{
            $conn = new PDO('mysql:host=' . host . ';dbname=' . dbName . ';user='. user . ';password=' . password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }catch(PDOException $e){
            echo "msgErreur:  " . $e->getMessage(); 
        }
    }   
}