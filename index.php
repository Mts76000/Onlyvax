<?php
session_start();
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/validation.php');
include('inc/header.php');

?>

<section id="accueil" class="wave">
    <div class="wrap2">
        <div class="accueil">
            <h2 class="title_page">ACCUEIL</h2>
        </div>
        <div class="img_accueil">
            <img src="asset/img/image_accueil_1.png" alt="">
        </div>
    </div>
</section>

<section id="nosService" class="wrap">
    <div class="index_title">
        <h2>Nos Services ?</h2>
        <div class="surligne"></div>
    </div>
    <div class="ns_pres">
        <div class="pres1" data-aos="fade-right" data-aos-anchor-placement="top-center">
            <img src="asset/img/image_server.png" alt="">
            <h2>Stockage en ligne, sécurité des données de vaccination</h2>
            <p>Les utilisateurs peuvent créer un compte personnel et consulter leurs suivis de vaccination, notamment les dates, les types de vaccins reçus et les rappels. Ces données sont stockées de manière sécurisée, permettant un accès facile et la sauvegarde d'informations de santé importantes.</p>
        </div>
        <div class="pres1" data-aos="fade-up" data-aos-anchor-placement="top-center">
            <img src="asset/img/image_oreille.png" alt="">
            <h2>Rappels et notifications personnalisés</h2>
            <p>Le site peut envoyer des rappels et des notifications aux utilisateurs pour les informer des prochaines vaccinations, en fonction de leur historique de vaccination. Cela garantit que les individus restent à jour avec leurs vaccins et ne manquent pas les dates importantes.</p>
        </div>
        <div class="pres1" data-aos="fade-left" data-aos-anchor-placement="top-center">
            <img src="asset/img/image_partage.png" alt="">
            <h2>Créez et consuler des carnets pour tout vos proches</h2>
            <p>Les utilisateurs ont la possibilité de créer une multitude de carnets dédiés à eux-mêmes, à leurs enfants et à leur famille, permettant ainsi d'assurer un suivi vaccinal complet, le tout regroupé au même endroit.</p>
        </div>
    </div>
</section>

<section id="start">
    <a href="listing.php">COMMENCER?</a>
</section>

<section id="quiSommeNous" class="wrap">
    <div class="index_title">
        <h2>Qui Sommes-Nous</h2>
        <div class="surligne2"></div>
    </div>
    <div class="qsm_pres" data-aos="fade-left" data-aos-anchor-placement="top-center">
        <p data-aos="fade-right" data-aos-anchor-placement="top-center">Nous sommes ONLYVAX, une équipe passionnée de professionnels de la santé et de technologie. Notre objectif est de simplifier la gestion des carnets de vaccination pour vous et vos proches.
            Grâce à notre plateforme en ligne, vous pouvez stocker en toute sécurité vos informations de vaccination, recevoir des rappels personnalisés pour rester à jour et partager vos données avec les professionnels de la santé.
            Nous croyons en la prévention et en la protection de la santé. Rejoignez-nous dans notre mission de rendre la vaccination plus accessible et plus efficace pour tous. Votre santé est notre priorité.</p>
        <img src="asset/img/QSM_image.png" alt="">
    </div>
</section>

<section id="questionFrequente" class="wrap">
    <div class="index_title">
        <h2>Questions Fréquentes</h2>
        <div class="surligne3"></div>
    </div>
    <div class="qcm_pres">
        <img src="asset/img/qcm_image.png" alt="" data-aos="fade-right" data-aos-anchor-placement="top-center">
        <p data-aos="fade-right" data-aos-anchor-placement="top-center">Chez ONLYVAX, nous comprenons que vous pourriez avoir des questions sur la gestion de vos carnets de vaccination et l'utilisation de notre plateforme. Nous avons rassemblé ici quelques-unes des questions les plus courantes pour vous fournir des réponses rapides et utiles. Si vous ne trouvez pas la réponse à votre question, n'hésitez pas à nous contacter, notre équipe est là pour vous aider.</p>
    </div>
</section>
<?php
include('inc/footer.php');
