    <?php
    session_start();
    require('inc/pdo.php');
    require('inc/fonction.php');
    require('inc/validation.php');

    require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'vendor/phpmailer/phpmailer/src/SMTP.php';
    require 'vendor/phpmailer/phpmailer/src/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $success = false;
    $errors = [];

    if (!empty($_POST['submitted'])) {
        // Faille XSS
        $nom = cleanxss('nom');
        $mail = cleanxss('mail');
        $message = cleanxss('message');



        $errors = validText($errors, $nom, 'nom', 3, 30);
        $errors = validmail($errors, $mail, 'mail');
        $errors = validText($errors, $message, 'message', 5, 200);


        if (count($errors) == 0) {
            $success = true;


            $sendmail = new PHPMailer(true);
            try {
                // Paramètres du serveur SMTP
                $sendmail->isSMTP();
                $sendmail->Host = 'smtp.hostinger.com';
                $sendmail->SMTPAuth = true;
                $sendmail->Username = '...';
                $sendmail->Password = '...';
                $sendmail->SMTPSecure = 'ssl';
                $sendmail->Port = 465; // ou 465


                // Destinataire et contenu
                $sendmail->setFrom('...');
                $sendmail->AddAddress('bileldounar@gmail.com');
                $sendmail->isHTML(true);
                $sendmail->Subject = 'Formulaire de Contact';
                $sendmail->Body = "<div color: #452A79;> <h1> Formulaire de Contact </h1> <br>
                Nom : " . $nom . "<br> Mail :" . $mail . "<br><br>
                Message : <p> " . $message . " </p> </div>";

                // Envoyer l'email
                $sendmail->send();
                echo '<div class="success-message">L\'email a été envoyé avec succès.</div> ';
            } catch (Exception $e) {
                echo "Erreur lors de l'envoi de l'email : {$sendmail->ErrorInfo}";
            }
        }
    }





    include('inc/header.php'); ?>

    <section id="contact" class="wave">
        <div class="wrap">
            <h2 class="title_page">Contact</h2>
            <div class="intro_carnet">
                <div class="box_left">
                    <img src="asset/img/contact.png" alt="edit vaccin">

                </div>
                <div class="separator"></div>
                <div class="box_right">
                    <form action="" method="POST">
                        <div class="boxhaut">
                            <div class="box">
                                <label for="nom">Nom <focus>*</focus></label>
                                <input type="text" name="nom" id="nom" placeholder="Nom" class="input_set" value="<?php getPostValue('nom'); ?>">
                                <span class="erreur"><?php viewError($errors, 'nom'); ?></span>
                            </div>
                            <div class="box">
                                <label for="mail">Email <focus>*</focus></label>
                                <input type="mail" name="mail" id="mail" placeholder="exemple@mail.com" class="input_set" value="<?php getPostValue('mail'); ?>">
                                <span class="erreur"><?php viewError($errors, 'mail'); ?></span>
                            </div>
                        </div>
                        <div class="boxbas">
                            <div class="box">
                                <label for="num_lot">Message <focus>*</focus></label>
                                <textarea name="message" id="message" placeholder="Message"><?php getPostValue('message'); ?></textarea>
                                <span class="erreur"><?php viewError($errors, 'message'); ?></span>
                            </div>
                        </div>
                        <div class="box_form2">
                            <input type="submit" name="submitted" value="Envoyer" class="submit_set">
                        </div>
                    </form>
                </div>
            </div>
    </section>





    <?php include('inc/footer.php');
