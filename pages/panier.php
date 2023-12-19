<?php
session_start();
require_once "./../classes/methodesPanier.php" ;
require_once "./../classes/plante.classe.php" ;

$objetPanier = new panierM();
$objetPlantes = new plante(); 

if(isset($_POST['supprimerPanier'])){
    $idPanier = $_POST['idpanier'];
    $objetPanier->supprimerPanier($idPanier);
}
if(isset($_POST['commander'])){
  $objetPanier->commander();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="stylePanier.css">
    <title>Document</title>
</head>
<body style="background-color: #132A13;">
<section class="h-100" >
  <div class="container py-5">
    <div class="row d-flex justify-content-center my-4">
      <div class="col-md-8">
        <div class="card mb-4">
          <div class="card-header py-3">
            <h5 class="mb-0">Cart - Item </h5>
 
          </div>
          <div class="card-body">
            <?php
            $panier = $objetPanier->getPanier();
            foreach($panier as $pan){
                ?>
                <!-- Single item -->
                <div class="row">
                    <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                        <!-- Image -->
                        <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                            <img src="./../plantes/<?php echo $pan->getImg() ?>"
                                class="w-100" alt="<?php echo $pan->getNom(); ?>" />
                            <a href="#!">
                                <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                            </a>
                        </div>
                        <!-- Image -->
                    </div>

                    <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                        <!-- Data -->
                        <p><strong><?php echo $pan->getNom(); ?></strong></p>
                        <p><span style="color: green"> Description:<?php $pan->getIdUtl();?></span> <?php echo $pan->getDescription(); ?></p>
                        <p><span style="color: green">Stock: <span style="color: black;">Ilimité</span></p>

                        <!-- Data -->
                    </div>
                    

                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                        <!-- Quantity -->

                            <div class="form-outline">
                                <input id="form1" min="0" name="quantity" value="1" type="number" class="form-control" />
                                <label class="form-label" for="form1">Quantity</label>
                            </div>

                        <!-- Quantity -->

                        <!-- Price -->
                        <p class="text-start text-md-center">
                            <strong><?php echo $pan->getPrix(); ?>DH</strong>
                        </p>
                        
                        <!-- Price -->
                        <div class="d-flex" style="gap:10px">
                        <form method="POST">
                          <input type="hidden" name="idpanier" value="<?php echo $pan->getIdPanier(); ?>">
                          
                          <button type="submit" name="supprimerPanier" class="btn" style="color:white; background-color: red; width:100px; height:40px">Supprimer</button>
                        </form> 
                        
                        </div>
                    </div>
                    
                </div>
                <!-- Single item -->
                
                <p>----------------------------------------------------------------------------------------------------------</p>
            <?php } ?> 
            <hr class="my-4" />  
            <!-- ... (Le reste de votre contenu) ... -->
          </div>
       
        </div>
      </div>
      <div class="col-md-4">
      <?php

      // Calcul du prix total des produits dans le panier
      $prixT = $objetPanier->prixTotal();
      // Calcul de la TVA 
      $tva = $prixT * 0.2;
      // Calcul du prix total avec TVA
      $prixTotalAvecTVA = $prixT + $tva;
      ?>


      <div class="card mb-4">
          <div class="card-header py-3">
              <h5 class="mb-0">Récapitulatif de la commande</h5>
          </div>
          <div class="card-body">
              <p><strong> Prix total des produits:</strong> <?php echo $prixT; ?> DH</p>
              <p><strong> TVA (20%):</strong> <?php echo $tva; ?> DH</p>
              <p><strong>Prix total avec TVA:</strong> <?php echo $prixTotalAvecTVA; ?> DH</p>
              <form method="POST" class="d-flex justify-content-center">
            <input type="hidden" name="idPanier" value="<?php echo $idPanier; ?>">
            <button type="submit" name="commander" class="btn" style="color:white; background-color: green; width:150px; height:40px; margin-top:10px">Commander</button>
          </form>
          </div>

      </div>
      </div>
    </div>
  </div>
</section>

</body>
</html>