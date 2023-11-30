<?php
session_start();
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/validation.php');

if (!empty($_GET['id_carnet']) && is_numeric($_GET['id_carnet'])) {
    $id_carnet = $_GET['id_carnet'];

    $sql = "SELECT id FROM carnet WHERE id = :id_carnet";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id_carnet', $id_carnet, PDO::PARAM_INT);
    $query->execute();
    $existingId = $query->fetch();

    if (empty($existingId)) {
        header('Location: 404.php');
    }

    $_SESSION['id_carnet'] = $id_carnet;
} else {
    header('Location: 404.php');
}

$carnetId = isset($_SESSION['id_carnet']) ? $_SESSION['id_carnet'] : 0;


$sql = "SELECT nom FROM vaccin";
$query = $pdo->prepare($sql);
$query->execute();
$vaccins = $query->fetchAll(PDO::FETCH_ASSOC);

if (empty($_SESSION['user']['nom']) || empty($_SESSION['user']['prenom']) || empty($_SESSION['user']['mail']) || empty($_SESSION['user']['id'])) {
    header('Location: login.php');
    exit();
}

$errors = array();
$nom = '';
$num_lot = '';
$date = '';

if (!empty($_POST['submitted'])) {
    $nom = cleanXss('nom');
    $num_lot = cleanXss('num_lot');
    $date = cleanXss('date');
    // $date_expiration = cleanXss('date_expiration');
    $rappel = (isset($_POST['checkbox']) && $_POST['checkbox'] == 'on') ? 'oui' : 'non';

    // Validation des champs
    if (empty($nom)) {
        $errors['nom'] = 'Veuillez sélectionner un vaccin.';
    }
    if (empty($num_lot)) {
        $errors['num_lot'] = 'Veuillez saisir un numéro de lot.';
    } elseif ($num_lot < 0) {
        $errors['num_lot'] = 'Le numéro de lot ne peut pas être négatif.';
    }
    if (empty($date)) {
        $errors['date'] = 'Veuillez saisir une date.';
    }



    if (count($errors) === 0) {

        $sql = "SELECT id FROM vaccin WHERE nom = :nom ";
        $query = $pdo->prepare($sql);
        $query->bindValue('nom', $nom, PDO::PARAM_STR);
        $query->execute();
        $id_vaccin_choose = $query->fetchColumn();

        $sql = "SELECT nb_utilisation FROM vaccin WHERE nom = :nom ";
        $query = $pdo->prepare($sql);
        $query->bindValue('nom', $nom, PDO::PARAM_STR);
        $query->execute();
        $nb_utilisation_vaccin = $query->fetchColumn();

        $nb_utilisation_vaccin = $nb_utilisation_vaccin + 1;
        debug($nb_utilisation_vaccin);

        $sql = "INSERT INTO carnet_vaccin (id_carnet, id_vaccin, vaccin_at, num_lot, rappel) VALUES (:id_carnet,:id_vaccin, :vaccin_at,:num_lot, :rappel)";
        $query = $pdo->prepare($sql);
        $query->bindValue(':id_carnet', $id_carnet, PDO::PARAM_INT);
        $query->bindValue(':id_vaccin', $id_vaccin_choose, PDO::PARAM_INT);
        $query->bindValue(':vaccin_at', $date, PDO::PARAM_STR);
        $query->bindValue(':num_lot', $num_lot, PDO::PARAM_STR);
        $query->bindValue(':rappel', $rappel, PDO::PARAM_STR);
        $query->execute();

        $sql = "UPDATE vaccin SET nb_utilisation = :nb_utilisation WHERE nom = :nom";
        $query = $pdo->prepare($sql);
        $query->bindValue('nb_utilisation', $nb_utilisation_vaccin, PDO::PARAM_INT);
        $query->bindValue('nom', $nom, PDO::PARAM_STR);
        $query->execute();

        header('Location: single.php?id=' . $id_carnet);
    }
}

include('inc/header.php');
?>

<section id="add_vaccin" class="wave">
    <div class="wrap">
        <h2 class="title_page">Ajouter un vaccin</h2>
        <div class="intro_carnet">
            <div class="box_left">
                <img src="asset/img/add_vaccin.png" alt="add vaccin">
            </div>
            <div class="separator"></div>
            <div class="box_right">
                <form action="" method="post" novalidate>
                    <div class="allboxform">
                        <div class="boxhaut">
                            <div class="box_form">
                                <label for="nom">Nom du vaccin *</label>
                                <input list="name" type="text" name="nom" id="nom" placeholder="Covid-19" autocomplete="off" class="input_set" value="<?= htmlspecialchars($nom); ?>">
                                <datalist id="name">
                                    <?php foreach ($vaccins as $vaccin) : ?>
                                        <option value="<?= htmlspecialchars($vaccin['nom']) ?>"></option>
                                    <?php endforeach; ?>
                                </datalist>
                                <span class="erreur"><?php viewError($errors, 'nom'); ?></span>
                            </div>
                            <div class="box_form">
                                <label for="date">Date *</label>
                                <input type="date" name="date" id="date" placeholder="14/12/2020" class="input_set" value="<?= htmlspecialchars($date); ?>">
                                <span class="erreur"><?php viewError($errors, 'date'); ?></span>
                            </div>


                        </div>
                        <div class="boxbas">
                            <div class="box_form">
                                <label for="num_lot">Numéro de lot *</label>
                                <input type="number" name="num_lot" id="num_lot" placeholder="1245666619" class="input_set" value="<?= htmlspecialchars($num_lot); ?>">
                                <span class="erreur"><?php viewError($errors, 'num_lot'); ?></span>
                            </div>
                            <!-- <div class="box_form">
                            <label for="date_expiration">Date d'expiration</label>
                            <input type="date" name="date_expiration" id="date_expiration" placeholder="14/12/2022" class="input_set">
                            <span class="erreur"></span>
                        </div> -->
                        </div>
                    </div>
                    <div class="checkbox">
                        <input type="checkbox" name="checkbox">
                        <p>Me prévenir quand la date d’expiration est proche</p>
                    </div>
                    <div class="box_form2">
                        <input type="submit" name="submitted" value="Ajouter" class="submit_set">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include('inc/footer.php'); ?>