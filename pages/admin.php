<?php
require_once "./../classes/plante.classe.php" ;
require_once "./../classes/categorie.classe.php" ;
require_once "traitement.php";

$objetPlante = new plante();
$objetCategorie = new categorie(); 

// Ajout de Plante
if (isset($_POST['submitPlante'])) {

    $objetPlante->setNom($_POST['nomPlante']);
    $objetPlante->setImg($_POST['descriptionPlante']);
    $objetPlante->setDescription($_POST['imagePlante']);
    $objetPlante->setPrix($_POST['prix']);
    $objetPlante->setIdC($_POST['idCategorie']);

    $objetPlante->ajouterPlante($objetPlante);   
}

// Ajout de catégorie
if (isset($_POST['submitCategorie'])) {
    
    $objetCategorie->setNom($_POST['nomCategorie']);

    $objetCategorie->ajouterCategorie($objetCategorie);   
}


// Suppression de plante
if (isset($_POST['submitSuppressionPlante'])) {
    $objetPlante->setId($_POST['idPlanteSuppression']);
    $objetPlante->supprimerPlante($objetPlante);

}


// Modification de catégorie
if (isset($_POST['submitModificationCategorie'])) {

    $objetCategorie->setId($_POST['idCategorieModification']);
    $objetCategorie->setNom($_POST['nouveauNomCategorie']);

    $objetCategorie->modifierCategorie($objetCategorie); 
}



//Ajouter theme

if (isset($_POST['submitTheme'])) {
    $nomTheme = $_POST['nomTheme'];
    $descriptionTheme = $_POST['descriptionTheme'];
    $imageTheme = $_POST['imageTheme'];

    if (is_array($_POST['tags'])) {
        $tags = implode(',', $_POST['tags']);
    } else {
        $tags = $_POST['tags'];
    }

    $insertThemeQuery = "INSERT INTO themes (nomTh, descriptionTh, imageTh) VALUES ('$nomTheme', '$descriptionTheme', '$imageTheme')";
    $result = $conn->query($insertThemeQuery);

    $idTheme = $conn->insert_id;
    $tagsArray = explode(',', $tags);
    foreach ($tagsArray as $tag) {
        $tag = trim($tag);
        $insertTagQuery = "INSERT INTO tags (nomTag) VALUES ('$tag')";
        $conn->query($insertTagQuery);
        $idTag = $conn->insert_id;
        $insertLinkQuery = "INSERT INTO tags_theme (idTh, idTag) VALUES ('$idTheme', '$idTag')";
        $result2 = $conn->query($insertLinkQuery);
    }

    if ($result2 && $result) {
        echo "<script>alert('Le thème a été ajouté avec succès.')</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'admin.php'; }, 1000);</script>";
    } else {
        echo "<script>alert('Erreur lors de l'ajout du thème : " . $conn->error . "')</script>";
    }
}



//suprimer theme
if (isset($_POST['submitSuppressiontheme'])) {
    $idTheme = $_POST['idthemeSuppression'];

$deleteTagsThemeQuery = "DELETE FROM tags_theme WHERE idTh = '$idTheme'";
$conn->query($deleteTagsThemeQuery);

$deleteThemeQuery = "DELETE FROM themes WHERE idTh = '$idTheme'";
$result = $conn->query($deleteThemeQuery);

if ($result != false) {
    
    echo "<script>alert('Le thème a été supprimé avec succès.')</script>";
    echo "<script>setTimeout(function(){ window.location.href = 'admin.php'; }, 1000);</script>";
    
} else {
    echo "<script>alert('Erreur lors de la suppression du thème. Veuillez réessayer.')</script>";
}
}



// supprimer Article
if (isset($_POST['submitSuppressionArticle'])) {

     $idArticle = $_POST['idArticleSuppression'];


    $deleteCommentsQuery = "DELETE FROM commentaire WHERE idAr = '$idArticle'";
    $resultComments = $conn->query($deleteCommentsQuery);

    $deleteArticleQuery = "DELETE FROM articles WHERE idAr = '$idArticle'";
    $result = $conn->query($deleteArticleQuery);

    if ($result) {
        echo "<script>alert('L'article a été supprimé avec succès.')</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'admin.php'; }, 1000);</script>";
    } else {
        echo "<script>alert('Erreur lors de la suppression de l'article : " . $conn->error . "')</script>";
    }
}



?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../style/styleAdmin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <title>OPEP</title>
    <style>
        .btnTags{
      border-radius: 7px;
      height: 40px;
      width: auto;
      margin-top: 20px;
      background-color: #132a137e;
      color: white;
    }
    .tags{
        margin: 0 0 15px 0;
    }
    #affichageChamp{
      
        padding: 20px 0;
    }
    </style>
</head>
<body class="body">
    <section class="header">
        <h1><span style="color: #567255;">O</span>P<span style="color: #567255;">E</span>P</h1>
    </section>
    <section class="main">
        <div class="sidebar">
            <ul class="sidebar--items">
                <li>
                    <a href="#"  onclick="afficherFormulaireAjoutCategorie()">
                        <div class="sidebar--item">Ajouter Catégorie</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="sidebar--item" onclick="afficherFormulaireModificationCategorie()">Modifier Catégorie</div>
                    </a>
                </li>
                <li>
                    <a href="#" onclick="afficherFormulaireAjoutPlante()">
                        <div class="sidebar--item">Ajouter Plante</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="sidebar--item" onclick="afficherFormulaireSuppressionPlante()">Supprimer Plante</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="sidebar--item" onclick="afficherFormulaireAjoutTheme()">Ajouter Theme</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="sidebar--item" onclick="supprimerFormulaireTheme()">Supprimer Theme</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="sidebar--item" onclick="afficherFormulaireSuppressionArticle()">Supprimer Article</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="sidebar--item" onclick="afficherFormulaireModificationTheme()">Modifier Theme</div>
                    </a>
                </li>
            </ul>
            <!-- <ul class="sidebar--bottom--items">
                <li>
                    <a href="connection.php">
                        <span class="icon"><i class="ri-logout-box-r-line"></i></span>
                        <div class="sidebar--item">Logout</div>
                    </a>
                </li>
            </ul> -->
        </div>
        <div class="main--container">
            <div class="form-container" id="formContainer">
                <!-- Ici, le formulaire apparaîtra après le clic sur "Ajouter Plante" -->
            </div>
        </div>
    </section>

    <!-- ... Votre code JavaScript existant ... -->

<script>
    // ----------------------------------------------FormulaireAjoutPlante------------------------------------
    function afficherFormulaireAjoutPlante() {
        var formContainer = document.getElementById("formContainer");
        formContainer.innerHTML = `
            <div class="close-button" onclick="fermerFormulaireAjoutPlante()">X</div>
            <h2>Ajouter Plante</h2>
            <form method="POST"  >

                <label for="idCategorie">Catégorie :</label>
                <select id="idCategorie" name="idCategorie" required>
                    <?php
                    // Récupérer les catégories depuis la base de données
                    $categoriesQuery = $conn->query("SELECT * FROM categories");

                    while ($categorie = $categoriesQuery->fetch_assoc()) {
                        echo "<option value='{$categorie['idCategorie']}'>{$categorie['nomCategorie']}</option>";
                    }
                    ?>
                </select><br>
                <label for="nomPlante">Nom de la Plante:</label>
                <input type="text" id="nomPlante" name="nomPlante" required><br>
                <label for="imagePlante">Image de la Plante (URL):</label>
                <input type="file" id="imagePlante" name="imagePlante" required><br>

                <label for="descriptionPlante">Description:</label>
                <textarea id="descriptionPlante" name="descriptionPlante" required></textarea><br>

                <label for="stockPlante">Stock:</label>
                <input type="number" id="stockPlante" name="stockPlante" required><br>

                <label for="prixFr">Prix (en DH):</label>
                <input type="number" id="prixFr" name="prix" required><br>

                <!-- ... Ajoutez d'autres champs si nécessaire ... -->

                <button type="submit" name="submitPlante">Ajouter</button>
            </form>
        `;
    }

  // ----------------------------------------------FormulaireAjoutCategorie------------------------------------
    function afficherFormulaireAjoutCategorie() {
        var formContainer = document.getElementById("formContainer");
        formContainer.innerHTML = `
            <div class="close-button" onclick="fermerFormulaireAjoutCategorie()">X</div>
            <h2>Ajouter Catégorie</h2>
            <form method="POST">
                <label for="nomCategorie">Nom de la Catégorie:</label>
                <input type="text" id="nomCategorie" name="nomCategorie" required><br>
                <button type="submit" name="submitCategorie">Ajouter</button>
            </form>
        `;
    }

// ----------------------------------------------FormulaireSupprimerPlante------------------------------------
    function afficherFormulaireSuppressionPlante() {
    var formContainer = document.getElementById("formContainer");
    formContainer.innerHTML = `
        <div class="close-button" onclick="fermerFormulaireSuppressionPlante()">X</div>
        <h2>Supprimer Plante</h2>
        <form method="POST">
            <label for="idPlanteSuppression">Sélectionnez la plante à supprimer :</label>
            <select id="idPlanteSuppression" name="idPlanteSuppression" class="form-control" required>
                <?php

                $plantesQuery = $conn->query("SELECT * FROM plantes");

                while ($plante = $plantesQuery->fetch_assoc()) {
                    echo "<option value='{$plante['idPlante']}'>{$plante['nomPlante']}</option>";
                }
                ?>
            </select><br>
            <button id="bttn" type="submit" name="submitSuppressionPlante">Supprimer</button>
        </form>
    `;
}
// ----------------------------------------------FormulaireModiferCategorie------------------------------------
function afficherFormulaireModificationCategorie() {
    var formContainer = document.getElementById("formContainer");
    formContainer.innerHTML = `
        <div class="close-button" onclick="fermerFormulaireModificationCategorie()">X</div>
        <h2>Modifier Catégorie</h2>
        <form method="POST">
            <label for="idCategorieModification">Sélectionnez la catégorie à modifier :</label>
            <select id="idCategorieModification" name="idCategorieModification" class="form-control" required>
                <?php
                // Récupérer les catégories depuis la base de données
                $categoriesQuery = $conn->query("SELECT * FROM categories");

                while ($categorie = $categoriesQuery->fetch_assoc()) {
                    echo "<option value='{$categorie['idCategorie']}'>{$categorie['nomCategorie']}</option>";
                }
                ?>
            </select><br>
            <label for="nouveauNomCategorie">Nouveau nom de la catégorie :</label>
            <input type="text" id="nouveauNomCategorie" name="nouveauNomCategorie" class="form-control" required><br>
            <button type="submit" name="submitModificationCategorie">Modifier</button>
        </form>
    `;
}
// ----------------------------------------------FormulaireSupprimerArticle------------------------------------
function afficherFormulaireSuppressionArticle() {
    var formContainer = document.getElementById("formContainer");
    formContainer.innerHTML = `
        <div class="close-button" onclick="fermerFormulaireSuppressionArticle()">X</div>
        <h2>Supprimer Article</h2>
        <form method="POST">
            <label for="idArticleSuppression">Sélectionnez la article à supprimer :</label>
            <select id="idArticleSuppression" name="idArticleSuppression" class="form-control" required>
                <?php

                $articlesQuery = $conn->query("SELECT * FROM articles");

                while ($article = $articlesQuery->fetch_assoc()) {
                    echo "<option value='{$article['idAr']}'>{$article['nomAr']}</option>";
                }
                ?>
            </select><br>
            <button id="bttn" type="submit" name="submitSuppressionArticle">Supprimer</button>
        </form>
    `;
}

// ----------------------------------------------FormulaireModiferTheme------------------------------------
function afficherFormulaireModificationTheme() {
        var formContainer = document.getElementById("formContainer");
        formContainer.innerHTML = `
            <div class="close-button" onclick="fermerFormulaireModificationTheme()">X</div>
            <h2>Modifier Theme</h2>
            <form method="POST" onsubmit="submitModificationTheme()">
                <label for="idThemeModification">Sélectionnez le Theme à modifier :</label>
                <select id="champSelectionne" name="idThemeModification" class="form-control" required onchange="afficherChampSelectionne(this)">
                <option Selected>Select ...</option>
                    <?php
                    // Récupérer les catégories depuis la base de données
                    $ThemesQuery = $conn->query("SELECT * FROM themes");
                          
                    while ($Theme = $ThemesQuery->fetch_assoc()) {
                        echo "<option class='option' value='{$Theme['idTh']}'>{$Theme['nomTh']}</option>";
                    }
                    ?>
                </select><br>
              
                <label for="nouveauNomTheme">Nouveau nom de Theme :</label>
                <input type="text" id="nouveauNomTheme" name="nouveauNomTheme" class="form-control" required><br>
                <label for="nouveauDescriptionTheme">Nouveau Description de Theme :</label>
                <input type="text" id="nouveauDescriptionTheme" name="nouveauDescriptionTheme" class="form-control" required><br>
                <label for="nouveauImageTheme">Nouveau Image de Theme :</label>
                <input type="text" id="nouveauImageTheme" name="nouveauImageTheme" class="form-control" required><br>
                <h3 class="tags">Tags</h3>
                <div id="affichageChamp"></div>
                <button type="submit" name="submitModificationTheme" class="btnTags" >Modifier</button>
            </form>
        `;
    }





    // ----------------------------------------------FormulaireAjoutTheme------------------------------------
    function afficherFormulaireAjoutTheme() {
    var formContainer = document.getElementById("formContainer");
    formContainer.innerHTML = `
        <div class="close-button" onclick="fermerFormulaireAjoutTheme()">X</div>
        <h2>Ajouter Theme</h2>
        <form method="POST" onsubmit="ajouterTheme(); return false;">
            <label for="nomTheme">Nom de Theme:</label>
            <input type="text" id="nomTheme" name="nomTheme"><br>
            <label for="descriptionTheme">Description de Theme:</label>
            <input type="text" id="DescriptionTheme" name="descriptionTheme"><br>
            <label for="imageTheme">Image de Theme:</label>
            <input type="file" id="imageTheme" name="imageTheme"><br>
            <label for="tags">Tags (séparés par des virgules):</label>
            <input type="text" id="tags" name="tags"><br>
            <button type="submit" name="submitTheme">Ajouter</button>
        </form>
    `;
}

// ----------------------------------------------FormulaireSupprimerTheme------------------------------------

function supprimerFormulaireTheme(){
    var formContainer = document.getElementById("formContainer");
    formContainer.innerHTML = `
    <div class="close-button" onclick="fermerFormulaireSupprimerFormulaireTheme()">X</div>
        <h2>Supprimer Theme</h2>
        <form method="POST">
            <label for="idthemeSuppression">Sélectionnez leTheme à supprimer :</label>
            <select id="idthemeSuppression" name="idthemeSuppression" class="form-control" required>
                <?php

                $themesQuery = $conn->query("SELECT * FROM themes");

                while ($theme = $themesQuery->fetch_assoc()) {
                    echo "<option value='{$theme['idTh']}'>{$theme['nomTh']}</option>";
                }
                ?>
            </select><br>
            <button id="bttn" type="submit" name="submitSuppressiontheme">Supprimer</button>
        </form>
        `;
}
//****************************************************************************************************************** */

function fermerFormulaireModificationCategorie() {
    var formContainer = document.getElementById("formContainer");
    formContainer.innerHTML = "";
}


function fermerFormulaireSuppressionPlante() {
    var formContainer = document.getElementById("formContainer");
    formContainer.innerHTML = "";
}


function fermerFormulaireAjoutPlante() {
    var formContainer = document.getElementById("formContainer");
    formContainer.innerHTML = ""; 
}


function fermerFormulaireAjoutCategorie() {
    var formContainer = document.getElementById("formContainer");
    formContainer.innerHTML = ""; 
}

function fermerFormulaireSupprimerFormulaireTheme() {
    var formContainer = document.getElementById("formContainer");
    formContainer.innerHTML = ""; 
}

function fermerFormulaireModificationTheme() {
        var formContainer = document.getElementById("formContainer");
        formContainer.innerHTML = "";
    }


    var input =document.querySelectorAll('#champSelectionne');
    input.forEach(btn=>{
        btn.addEventListener("click",function(){
            let x=this.value;
            console.log(x);
        })
    })


    function afficherChampSelectionne(selectElement) {
    const selectedValue = selectElement.value;
    console.log("Selected Value:", selectedValue);


    var xhr = new XMLHttpRequest(); 
   //modifier 
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.querySelector('#affichageChamp').innerHTML = this.responseText;
        }
    };
    xhr.open("GET", "validertags.php?tag="+selectedValue, true);
        xhr.send();
}

</script>

<!-- ... Votre code JavaScript existant ... -->

</body>

</html>
