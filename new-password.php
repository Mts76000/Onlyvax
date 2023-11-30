<?php
session_start();
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/validation.php');

$errors = array();
$token = '';

if (!empty($_GET['token']) && is_string($_GET['token'])) {
    $token = $_GET['token'];
} else {
    header('Location: 403.php');

}

if (!empty($_POST['submitted'])) {
    // Faille XSS
    $password = cleanXss('password');
    $password2 = cleanXss('password2');

    // Validation des deux passwords
    if (!empty($password) && !empty($password2)) {
        if ($password != $password2) {
            $errors['password'] = 'Vos mots de passe sont différents.';
        } elseif (mb_strlen($password) < 6) {
            $errors['password'] = 'Votre mot de passe est trop court (6 caractères minimum)';
        }
    } else {
        $errors['password'] = 'Veuillez renseigner les mots de passe.';
    }

    // Si aucune erreur
    if (count($errors) == 0) {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $newToken = generateRandomString(130);

        $sql = "UPDATE users SET password = :password, token = :newToken WHERE token = :oldToken";
        $query = $pdo->prepare($sql);
        $query->bindValue('password', $hashPassword, PDO::PARAM_STR);
        $query->bindValue('newToken', $newToken, PDO::PARAM_STR);
        $query->bindValue('oldToken', $token, PDO::PARAM_STR);
        $query->execute();
        header('Location: login.php');
    }
}


include('inc/header.php');
?>

<section id="new_password" class="wave">
    <div class="wrap">
        <h2 class="title_page">Changer le mot de passe</h2>
        <div class="intro_carnet">
            <div class="box_left">
                <img src="asset/img/image_principale_new-password.png" alt="edit vaccin">
            </div>
            <div class="separator"></div>
            <div class="box_right">

                <form action="" method="post" novalidate>
                    <div class="boxhaut">
                        <div class="box">
                        <label for="password">Mot de passe <focus>*</focus></label>
                        <input type="password" name="password" id="password" placeholder="Password" class="input_set">
                        <span class="erreur"><?php viewError($errors, 'password'); ?></span>
                        </div>
                        <div class="box">
                        <label for="password2">Confirmation <focus>*</focus></label>
                        <input type="password" name="password2" id="password2" placeholder="Password" class="input_set">
                        <span class="erreur"><?php viewError($errors, 'password2'); ?></span>
                        </div>
                    </div>
                    <div class="box_form2">
                        <input type="submit" name="submitted" value="CHANGER LE MOT DE PASSE" class="submit_set">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>




<?php include('inc/footer.php'); ?>

