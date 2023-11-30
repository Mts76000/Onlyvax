<?php
session_start();
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/validation.php');
include('inc/header.php');



// Vérification de l'existence et de la validité de l'ID
if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT id FROM carnet WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $existingId = $query->fetch();


    $selectSql = "SELECT * FROM carnet ORDER BY created_at DESC;";
    $selectQuery = $pdo->prepare($selectSql);
    $selectQuery->execute();
    $fiches = $selectQuery->fetchAll(PDO::FETCH_ASSOC);


    if (empty($existingId)) {
        header('Location: 404.php');
    }

    $_SESSION['id_carnet'] = $id;
} else {
    header('Location: 404.php');
}

// Récupération des données de la table "carnet_vaccin"
// Récupération des données de la table "carnet_vaccin"
$sql = "SELECT cv.id AS id_vaccin, v.nom AS nom, cv.vaccin_at AS vaccin_at, cv.num_lot AS num_lot 
        FROM vaccin AS v 
        INNER JOIN carnet_vaccin AS cv ON v.id = cv.id_vaccin 
        WHERE cv.id_carnet = :id";
$selectQuery = $pdo->prepare($sql);
$selectQuery->bindValue('id', $id, PDO::PARAM_INT);
$selectQuery->execute();
$vaccins = $selectQuery->fetchAll();



?>



<!-- PARTIE AVEC VACCIN -->
<section id="single_vax" class="wave">
    <div class="wrap">
        <h2 class="title_page"> MES VACCINATION</h2>
        <div class="boxVax">
            <div class="box_left">
                <img src="asset/img/image_single_no_vac.png" alt="image_single">
            </div>
            <div class="separator"></div>
            <div class="box_right">
                <a href="add-vaccin.php?id_carnet=<?php echo $id; ?>" class="a_add"><i class="fa-solid fa-plus" style="color: white;"></i> Ajouter un vaccin</a>
                <p>ICI, CONSULTER VOS VACCINATION</p>
            </div>
        </div>
    </div>
    </div>
</section>
    <section id="vax">
    <?php if (!empty($vaccins)) { ?>
    <?php foreach ($vaccins as $vaccin) { ?>
        <div class="wrap" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom">
            <div class="container_carnet">
                <div class="carnet">
                    <img src="asset/img/user_fiche.png" alt="">
                    <div class="fichedetail">
                        <p> <?php echo htmlspecialchars($vaccin['nom']); ?></p>
                        <p><?php echo htmlspecialchars((new DateTime($vaccin['vaccin_at']))->format('d/m/Y')); ?></p>

                        <p> <?php echo htmlspecialchars($vaccin['num_lot']); ?></p>
                    </div>
                </div>
            </div>

            <div class="suprRappel">
                <a href="rappels.php?id=<?= $id ?>" class="a_add">
                    <i class="fa-solid fa-bell" style="color: white;"></i> Mes rappels
                </a>
                <a href="suprim.php?id_carnet=<?= $id ?>&id_vaccin=<?= $vaccin['id_vaccin'] ?>" class="a_add">
                    <i class="fa-solid fa-ellipsis" style="color: white;"></i> Supprimer
                </a>
            </div>
        </div>
    <?php } ?>

    </section>


<?php } else { ?>
    <!-- PARTIE SANS VACCIN -->
    <section id="no_vax">
        <div class="no_vax_submitted wrap">
            <p>AUCUNE VACCINATION ENREGISTRÉE. AJOUTEZ VOS VACCINATIONS POUR FAIRE LE SUIVI DE VOTRE ÉTAT VACCINAL.</p>
        </div>
    </section>
<?php } ?>



<?php include('inc/footer.php');
