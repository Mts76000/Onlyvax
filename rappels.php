<?php
session_start();
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/validation.php');


// Vérification de l'existence et de la validité de l'ID
if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT id FROM carnet WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $existingId = $query->fetch();


    if (empty($existingId)) {
        header('Location: 404.php');
    }

    $_SESSION['id_carnet'] = $id;
} else {
    header('Location: 404.php');
}

// Récupération des données de la table "carnet_vaccin"

$sql = "SELECT 
            v.nom AS nom, 
            cv.vaccin_at AS vaccin_at, 
            cv.num_lot AS num_lot, 
            v.rappel_vaccin AS rappel_vaccin,
            DATE_ADD(cv.vaccin_at, INTERVAL v.rappel_vaccin DAY) AS date_rappel_calculée
        FROM vaccin AS v 
        INNER JOIN carnet_vaccin AS cv ON v.id = cv.id_vaccin 
        WHERE cv.id_carnet = :id";

$selectQuery = $pdo->prepare($sql);
$selectQuery->bindValue('id', $id, PDO::PARAM_INT);
$selectQuery->execute();

$nomVaccins = $selectQuery->fetchAll(PDO::FETCH_ASSOC);



include('inc/header.php');
?>
<section id="rappels" class="wave">
    <div class="wrap">
        <h2 class="title_page">MES RAPPELS</h2>
        <div class="intro_rappels">
            <div class="box_left">
                <img src="asset/img/image_principale_rappels.png" alt="horloge">
            </div>
            <div class="separator"></div>
            <div class="box_right">
                <a href="add-vaccin.php?id_carnet=<?php echo $id; ?>" class="a_add"><i class="fa-solid fa-plus" style="color: white;"></i> Ajouter un vaccin</a>
                <p class="info">ICI CONSULTEZ VOS RAPPELS DE VACCINATION</p>
            </div>
        </div>
    </div>
</section>



<?php if (!empty($nomVaccins)) { ?>
    <?php foreach ($nomVaccins as $nomVaccin) { ?>
        <section id="rappel" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom">
            <div class="wrap">
                <div class="vaccin_container">
                    <div class="vaccin_container_logo">
                        <img src="asset/img/image_rappels.png" alt="horloge">
                    </div>
                    <div class="vaccin_container_text">
                        <span><?php echo htmlspecialchars($nomVaccin['nom']); ?></span><br>
                        <span>Administer le <?php echo htmlspecialchars((new DateTime($nomVaccin['vaccin_at']))->format('d M Y')); ?></span><br>
                        <span>Il vous reste <?php echo htmlspecialchars((new DateTime($nomVaccin['date_rappel_calculée']))->diff(new DateTime())->days) ?> jours avant la prochaine dose</span>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>

<?php } else { ?>

    <section id="no_vax">
        <div class="no_vax_submitted wrap">
            <p>Aucun rappel enregistré Ajoutez a vos vaccinations un rappel pour avoir accés au suivi</p>
        </div>
    </section>
<?php } ?>

<?php include('inc/footer.php');
