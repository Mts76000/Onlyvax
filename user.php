<?php
session_start();
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/validation.php');

if (!isLogged()) {
    header('Location: login.php');
    exit(); // Ajout d'une sortie après la redirection
}

$errors = array();
$successMessage = '';
$mail = isset($_SESSION['user']['mail']) ? $_SESSION['user']['mail'] : '';


if (!empty($_POST['submitted'])) {
    // Faille XSS
    $newEmail = cleanXss('mail'); // Modification de 'mail' pour correspondre à votre champ email
    $oldPassword = cleanXss('old_password');
    $password = cleanXss('password');
    $password2 = cleanXss('password2');

    // Validation de l'ancien mot de passe
    $storedPassword = getUserPassword($_SESSION['user']['id']);
    if (!password_verify($oldPassword, $storedPassword)) {
        $errors['old_password'] = 'Ancien mot de passe incorrect.';
    }

    // Validation du nouvel email
    if (empty($newEmail) || !filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $errors['mail'] = 'Veuillez fournir une adresse e-mail valide.';
    }

    // Validation des deux passwords
    if (!empty($password) && !empty($password2)) {
        if ($password != $password2) {
            $errors['password'] = 'Vos mots de passe sont différents.';
        } elseif (mb_strlen($password) < 6) {
            $errors['password'] = 'Votre mot de passe est trop court <br> (6 caractères minimum)';
        }
    } else {
        $errors['password'] = 'Veuillez renseigner les mots de passe.';
    }

    if (empty($errors['mail'])) { // Correction du test d'erreur pour 'mail'
        // Mettez à jour l'e-mail
        if ($_SESSION['user']['mail'] !== $newEmail) {
            $sqlUpdateEmail = "UPDATE users SET mail = :mail WHERE id = :user_id";
            $queryUpdateEmail = $pdo->prepare($sqlUpdateEmail);
            $queryUpdateEmail->bindValue('mail', $newEmail, PDO::PARAM_STR);
            $queryUpdateEmail->bindValue('user_id', $_SESSION['user']['id'], PDO::PARAM_INT);
            $queryUpdateEmail->execute();

            header('Location: logout.php');
            exit();
        }
    }
    // Si aucune erreur
    if (count($errors) == 0) {



        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $sqlUpdatePassword = "UPDATE users SET password = :password  WHERE id = :user_id";
        $queryUpdatePassword = $pdo->prepare($sqlUpdatePassword);
        $queryUpdatePassword->bindValue('password', $hashPassword, PDO::PARAM_STR);
        $queryUpdatePassword->bindValue('user_id', $_SESSION['user']['id'], PDO::PARAM_INT);
        $queryUpdatePassword->execute();
        $successMessage = 'Mot de passe modifié avec succès!';
    }
}

include('inc/header.php');
?>

<section id="users" class="wave">
    <div class="wrap">
        <h2 class="title_page">Profil</h2>
        <div class="intro_carnet">
            <div class="box_left">
                <img src="asset/img/image_profil_user.png" alt="profil">
                <span>Bonjour <?php echo $_SESSION['user']['prenom']; ?>!</span>

                <span>Inscrit depuis le <?php

                                        $dateInscription = new DateTime($_SESSION['user']['created_at']);
                                        $dateFormatee = $dateInscription->format('d/m/Y');

                                        echo $dateFormatee;
                                        ?></span>
            </div>
            <div class="separator"></div>
            <div class="box_right">
                <form action="" method="post" novalidate>
                    <div class="edit_mail">
                        <span>Modifier l’E-mail </span>
                        <div class="box">
                            <label for="mail">Email *</label>
                            <input type="email" name="mail" id="mail" placeholder="Email" class="input_set" value="<?php echo $mail; ?>">

                            <span class="erreur"><?php viewError($errors, 'mail'); ?></span>
                        </div>
                    </div>

                    <div class="edit_password">
                        <div class="boxmilieu">
                            <span>Modifier le mot de passe </span>
                            <div class="box">
                                <label for="old_password">Ancien mot de passe <focus>*</focus></label>
                                <input type="password" name="old_password" id="old_password" placeholder="Ancien mot de passe" class="input_set">
                                <span class="erreur"><?php viewError($errors, 'old_password'); ?></span>
                            </div>
                        </div>
                        <div class="boxbas">
                            <div class="box3">
                                <label for="nom">Mot de passe <focus>*</focus></label>
                                <input type="password" name="password" id="password" placeholder="Password" class="input_set">
                                <span class="erreur"><?php viewError($errors, 'password'); ?></span>
                            </div>
                            <div class="box">
                                <label for="nom">Confirmer mot de passe <focus>*</focus></label>
                                <input type="password" name="password2" id="password2" placeholder="Password" class="input_set">
                                <span class="erreur"><?php viewError($errors, 'password2'); ?></span>
                            </div>
                        </div>
                        <div class="box_form2">
                            <input type="submit" name="submitted" value="Envoyer" class="submit_set">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><?php
            if (!empty($successMessage)) {
                echo ' <div class="success-message">';

                echo '<div class="success-box">';
                echo '<p>' . $successMessage . '</p>';
                echo '</div>';
                echo '</div>';
            }
            ?>

</section>




<?php include('inc/footer.php');
