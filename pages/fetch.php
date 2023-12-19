<?php

require_once "./../classes/getPlantes.classe.php" ;

$objetPlante = new plantes(); 

$idC = $_POST['id'];
$plantes = $objetPlante->getPlantesInCategories($idC);

    $counter = 0;
    $out='';
    foreach($plantes as $plante){
        if ($counter % 3 == 0) {
            echo '<div class="row">';
        }
        echo '<div class="col-md-4 mb-4">';
        echo '<div class="card">';
        echo '<div class="d-flex justify-content-center">';
        echo '<img " src="./../plantes/' . $plante->getImg() . '" class="card-img-top card-img-custom" alt="' . $plante->getNom() . '">';
        echo '</div>';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $plante->getNom() . '</h5>';
        echo '<hr>';
        echo '<div class="text-left">';
        echo '<p class="card-text mb-2"><strong>Description:</strong> <span style="color:black;">' . $plante->getDescription() . '</span></p>';
        echo '<p class="card-text mb-2"><strong>Price:</strong> <span style="color:black;">' . $plante->getPrix() . 'DH </span></p>';
        echo '<p class="card-text mb-2"><strong>Stock:</strong> <span style="color:black;">Ilimité</span></p>';
        echo '</div>';
        echo '<div class="d-flex justify-content-center">';
        //---------------------------------- form-btn--------------------------------------
        echo '<form method="POST" >';
        echo '<button class="btn btn-success panier-btn mt-2" name="addToCart" value="' . $plante->getId() . '">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z"/>
        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
        </svg>
            Ajouter
        </button>';
        echo '</form>';
        //fin
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
                    
        if ($counter % 3 == 2) {
            echo '</div>';
        }   
                    
        $counter++;
    }
    if ($counter % 3 != 0) {
        echo '</div>';
    }                   
    echo $out;

?>