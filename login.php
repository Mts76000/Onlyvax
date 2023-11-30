<?php
session_start();
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/validation.php');


$mail='';


$errors = array();
if (!empty($_POST['submitted'])) {
    // Faille XSS
    $mail = cleanXss('mail');
    $password = cleanXss('password');
    // Validation
    $sql = "SELECT * FROM users
            WHERE mail = :mail";
    $query = $pdo->prepare($sql);
    $query->bindValue('mail', $mail, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();
    if (!empty($user)) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = array(
                'id'     => $user['id'],
                'nom' => $user['nom'],
                'prenom' => $user['prenom'],
                'mail'  => $user['mail'],
                'role'   => $user['role'],
                'created_at'   => $user['created_at'],
                'ip'     => $_SERVER['REMOTE_ADDR'],

            );
            header('Location: index.php');
        } else {
            $errors['login'] = 'Errors credentials';
        }
    } else {
        $errors['login'] = 'Errors credentials';
    }
}

include('inc/header.php'); ?>

<section id="connexion" class="wave">
    <div class="wrap">
        <h2 class="title_page">SE CONNECTER</h2>
        <div class="intro_carnet">
        <div class="box_left">
            <img src="asset/img/connexion.png" alt="connexion">
        </div>
            <div class="separator"></div>
        <div class="box_right">
            <form action="" method="post" novalidate>
                <div class="boxhaut">
                    <div class="box">
                <label for="mail">Email <focus>*</focus></label>
                <input type="email" name="mail" id="mail" placeholder="email" class="input_set" value="<?= htmlspecialchars($mail); ?>">
                <span class="erreur"><?php viewError($errors, 'login'); ?></span>
                    </div>
                    <div class="box">
                <label for="password">Mot de passe <focus>*</focus></label>
                <input type="password" name="password" id="password" placeholder="Mot de passe" class="input_set>
                    <span class=" erreur"></span>
                    </div>
            </div>
                <div class="box_form2">
                <input type="submit" name="submitted" value="Connexion" class="submit_set">
                </div>
            <a  class="forget_mdp" href="forget-password.php">Mot de passe oublié</a>
            </form>
        </div>
    </div>
</section>





<?php include('inc/footer.php');
