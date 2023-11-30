<?php
session_start();
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/validation.php');


if (!isLogged()) {
    // header('Location: login.php');
    echo '<script>alert("Veuillez vous connecter afin d\'acceder à vos carnets");
    window.location.href="login.php";</script>';
}
$id_session = $_SESSION['user']['id'];


$selectSql = "SELECT id_user FROM carnet WHERE :id_session";
$selectQuery = $pdo->prepare($selectSql);
$selectQuery->bindValue('id_session', $id_session, PDO::PARAM_INT);
$selectQuery->execute();
$idUsers = $selectQuery->fetch(PDO::FETCH_ASSOC);


$selectSql = "SELECT id, prenom, date_de_nais  
FROM carnet 
WHERE id_user = :id_user AND status = 0
ORDER BY created_at DESC
;
";
$selectQuery = $pdo->prepare($selectSql);
$selectQuery->bindValue(':id_user', $id_session, PDO::PARAM_INT);
$selectQuery->execute();
$fiches = $selectQuery->fetchAll(PDO::FETCH_ASSOC);



include('inc/header.php');
?>

<section id="listing" class="wave">
    <div class="wrap">
        <h2 class="title_page">CARNET DE VACCINATION</h2>
        <div class="intro_listing">
            <div class="box_left">
                <img src="asset/img/image_carnet1.png" alt="ImageListing">
            </div>
            <div class="separator"></div>
            <div class="box_right">
                <a href="add-carnet.php" class="a_add"><i class="fa-solid fa-plus" style="color: white;"></i> Créer un nouveau carnet</a>
                <p>ICI, CONSULTER VOS CARNETS DE VACCINATION</p>
            </div>
        </div>

    </div>
</section>
<?php if (!empty($fiches)) { ?>
    <?php foreach ($fiches as $fiche) { ?>
        <section id="liste_carnet">
            <div class="wrap">
                <div class="container_carnet" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom">
                    <a class="carnet" href="single.php?id=<?php echo $fiche['id']; ?>">
                        <img src="asset/img/user_fiche.png" alt="">
                        <div class="fichedetail">
                            <p> <?php echo htmlspecialchars($fiche['prenom']); ?></p>
                            <p> <?php echo htmlspecialchars($fiche['date_de_nais']); ?></p>
                        </div>
                    </a>
                    <div class="suprRappel">
                        <a href="rappels.php?id=<?php echo $fiche['id']; ?>"><img src="asset/img/rappel.png" alt=""> Mes rappels</a>
                        <a href="delete.php?id_carnet=<?= $fiche['id'] ?>"><img src="asset/img/poubelle.png" alt="">Supprimer</a>
                    </div>
                </div>
            </div>
        </section>

    <?php }
} else { ?>
    <!-- PARTIE SANS VACCIN -->
    <section id="no_vax">
        <div class="no_vax_submitted wrap">
            <p>AUCUN CARNET ENREGISTRÉE. AJOUTEZ VOS CARNETS POUR FAIRE LE SUIVI DE VOTRE ÉTAT VACCINAL.</p>
        </div>
    </section>
<?php } ?>



<?php
include('inc/footer.php');
