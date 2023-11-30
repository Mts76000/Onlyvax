<?php
session_start();
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/validation.php');


include('inc/header.php'); ?>

<section id="connexion" class="wave">
    <div class="wrap">
        <div class="box_left">
            <img src="asset/img/image_404.png" alt="404">
        </div>
        <div class="seperator"></div>
        <div class="box_right">
            <h1>Erreur 404</h1>
            <p>La page que vous cherchez n'existe pas.</p>
            <a class="forget_mdp" href="index.php">Retourner à l'accueil</a>
            
        </div>
    </div>
</section>





<?php include('inc/footer.php');
