<?php
require('inc/pdo.php');
require('inc/validation.php');
require('inc/fonction.php');

require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$success = false;
$errors = [];

if (!empty($_POST['submitted'])) {
    // Faille XSS
    $mail = cleanxss('mail');
    $errors = validmail($errors, $mail, 'mail');

    $sql = "SELECT mail FROM users";
    $query = $pdo->prepare($sql);
    $query->execute();
    $dbmail = $query->fetchAll();


    if (count($errors) == 0) {
        $success = true;

        $sql = "SELECT token FROM users
        WHERE mail = :mail";
        $query = $pdo->prepare($sql);
        $query->bindValue('mail', $mail, PDO::PARAM_STR);
        $query->execute();
        $token = $query->fetchColumn();


        $sendmail = new PHPMailer(true);

        try {
            // Paramètres du serveur SMTP
            $sendmail->isSMTP();
            $sendmail->Host = 'smtp.hostinger.com';
            $sendmail->SMTPAuth = true;
            $sendmail->Username = '...';
            $sendmail->Password = '...';
            $sendmail->SMTPSecure = 'ssl';
            $sendmail->Port = 465; 

            // Destinataire et contenu
            $sendmail->setFrom('contact@portfoliobileldounar.online');
            $sendmail->addAddress($mail);
            $sendmail->isHTML(true);
            $sendmail->Subject = 'Recuperation de Mot de Passe - ONLYVAX';
            $sendmail->Body = "<div color: #452A79;> <h1> Cher(e) utilisateur, </h1> <br>
            Nous avons bien reçu votre demande de réinitialisation de mot de passe. <br> Pour procéder, veuillez cliquer sur le lien ci-dessous : 
            http://localhost/php/Projet-Vaccin/new-password.php?token={$token} <br>
            Si vous n\'avez pas demandé cette réinitialisation ou si vous rencontrez des problèmes, veuillez nous contacter immédiatement à support@onlyvax.com. <br>
            <span style='font-weight: bold;'> Cordialement, <br>
            Service de support technique </span> </div>";

            $sendmail->AltBody = 'Contenu de l\'email en texte brut';


            // Envoyer l'email
            $sendmail->send();
            echo 'L\'email a été envoyé avec succès.';
        } catch (Exception $e) {
            echo "Erreur lors de l'envoi de l'email : {$sendmail->ErrorInfo}";
        }
    }
}






include('inc/header.php');
?>

<section id="forgot_password" class="wave">
    <div class="wrap">
        <h2 class="title_page"> MOT DE PASSE OUBLIE</h2>
        <div class="intro_carnet">
            <div class="box_left">
                <img src="asset/img/image_forgot_password.png" alt="image_password">
            </div>
            <div class="separator"></div>
            <div class="box_right">
                <form action="" method="POST">
                    <label for="mail">Email <focus>*</focus></label>
                    <input type="text" name="mail">
                    <span class="errors"></span>
                    <div class="box_form2">
                        <input type="submit" name="submitted" value="ENVOYER">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
include('inc/footer.php')
?>