<?php
session_start();
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/validation.php');



$idUtilisateur = $_SESSION['user']['id'];

if (empty($_SESSION['user']['nom']) || empty($_SESSION['user']['prenom']) || empty($_SESSION['user']['mail']) || empty($_SESSION['user']['id'])) {
    header('Location: login.php');
}

$errors = array();

if (!empty($_POST['submitted'])) {

    $prenom = cleanXss('prenom');
    $nom = cleanXss('nom');
    $sexe = cleanXss('sexe');
    $date_de_nais = cleanXss('date_de_nais');

    $errors = validText($errors,$nom,'nom',3,120,);
    $errors = validText($errors,$prenom,'prenom',3,120,);

    if (empty($date_de_nais)) {
        $errors['date_de_nais'] = 'Veuillez renseigner la date de naissance.';
    }


    if (count($errors) === 0) {
        $sql = "INSERT INTO carnet (nom, prenom, date_de_nais, sexe, etat_vaccin, created_at, id_user)
                VALUES (:nom, :prenom, :date_de_nais, :sexe, 'non_vaccin', NOW(), :id_user)";
        $query = $pdo->prepare($sql);
        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $query->bindValue(':date_de_nais', $date_de_nais, PDO::PARAM_STR);
        $query->bindValue(':sexe', $sexe, PDO::PARAM_STR);
        $query->bindValue(':id_user', $idUtilisateur, PDO::PARAM_INT);

        if ($query->execute()) {
            // Redirigez l'utilisateur vers une page de confirmation ou une autre page
            header('Location: listing.php');
        } else {
            // Gérez l'erreur d'insertion dans la base de données
            $errors['database'] = 'Une erreur est survenue lors de l\'ajout du carnet.';
        }
    }
}

include('inc/header.php');
?>


    <section id="add_carnet" class="wave">
        <div class="wrap">
            <h2 class="title_page">Ajouter un carnet</h2>
            <div class="intro_carnet">
                <div class="box_left">
                    <img src="asset/img/carnet.png" alt="carnet">
                </div>
                <div class="separator"></div>
                <div class="box_right">
                    <form action="" method="post" novalidate>
                        <div class="allboxform" >
                            <div class="boxhaut">
                                <div class="box_form">
                                    <label for="prenom">Prenom <focus>*</focus></label>
                                    <input type="text" name="prenom" id="prenom" placeholder="prenom" class="input_set" value="<?php getPostValue('prenom'); ?>">
                                    <span class="erreur"><?php viewError($errors, 'prenom'); ?></span>
                                </div>
                                <div class="box_form">
                                    <label for="sexe">Sexe  <focus>*</focus></label>
                                    <select name="sexe" class="input_set">
                                        <option value="homme">Homme</option>
                                        <option value="femme">Femme </option>
                                    </select>
                                    <span class="erreur"></span>
                                </div>

                            </div>
                            <div class="boxbas">
                                <div class="box_form">
                                    <label for="nom">Nom <focus>*</focus></label>
                                    <input type="text" name="nom" id="nom" placeholder="nom" class="input_set" value="<?php getPostValue('nom'); ?>">
                                    <span class="erreur" ><?php viewError($errors, 'nom'); ?></span>
                                </div>
                                <div class="box_form">
                                    <label for="date_de_nais">Date de naissance <focus>*</focus></label>
                                    <input type="date" name="date_de_nais" id="date_de_nais"  class="input_set" value="<?php echo (isset($_POST['date_de_nais']) ? htmlspecialchars($_POST['date_de_nais']) : ''); ?>">
                                    <span class="erreur"><?php viewError($errors, 'date_de_nais'); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="box_form2">
                            <input type="submit" name="submitted" value="Ajouter" class="submit_set">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>





<?php include('inc/footer.php');