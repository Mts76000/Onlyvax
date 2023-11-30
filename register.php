<?php
session_start();
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/validation.php');



$errors = array();

$errors = array();

if(!empty($_POST['submitted'])) {
    // Faille XSS
    $nom = cleanXss('nom');
    $prenom = cleanXss('prenom');
    $mail = cleanXss('mail');
    $password = cleanXss('password');
    $password2 = cleanXss('password2');
    // Validations

    // validation Email
    $errors = validmail($errors,$mail,'mail');
    $errors = validText($errors,$nom,'nom',3,120,);
    $errors = validText($errors,$prenom,'prenom',3,120,);
    // unique email
    if(empty($errors['mail'])) {
        $sql = "SELECT id FROM users WHERE mail = :mail";
        $query = $pdo->prepare($sql);
        $query->bindValue('mail', $mail);
        $query->execute();
        $verifEmail = $query->fetch();
        if(!empty($verifEmail)) {
            $errors['mail'] = 'E-mail déjà pris';
        }
    }
    // Validation des deux passwords
    if(!empty($password) && !empty($password2)) {
        if($password != $password2) {
            $errors['password'] = 'Vos mots de passe sont différents.';
        } elseif(mb_strlen($password) < 6) {
            $errors['password'] = 'Votre mot de passe est trop court (6 caractères minimum)';
        }
    } else {
        $errors['password'] = 'Veuillez renseigner les mots de passe.';
    }
    // If no errors
    if(count($errors) == 0) {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = 'user';
        $token = generateRandomString(130);
        $sql = "INSERT INTO users (nom, prenom, mail, password, created_at, role, token)
                VALUES (:nom, :prenom , :mail, :pass, NOW(), '$role', '$token')";
        $query = $pdo->prepare($sql);
        $query->bindValue('nom', $nom, PDO::PARAM_STR);
        $query->bindValue('prenom', $prenom, PDO::PARAM_STR);
        $query->bindValue('mail',   $mail, PDO::PARAM_STR);
        $query->bindValue('pass',   $hashPassword, PDO::PARAM_STR);
        $query->execute();
        // redirection login.php
        header('Location: login.php');
    }
}

include('inc/header.php'); ?>



    <section id="incription" class="wave">
        <div class="wrap">
            <h2 class="title_page">S’INCRIRE</h2>
            <div class="intro_carnet">
                <div class="box_inscri">
                    <h2 class="title_inscription">Pensez à l’inscription</h2>
                    <p>Pensez à vous inscrire pour profiter pleinement de nos services. Avec un compte sécurisé, vous pouvez gérer facilement vos informations de vaccination, recevoir des rappels personnalisés et partager des données avec vos professionnels de la santé. Simplifiez votre suivi de vaccination dès maintenant !</p>
                </div>
                <div class="separator"></div>
                <div class="box_right">
                    <form action="" method="post" novalidate>
                        <div class="boxhaut">
                            <div class="box">
                                <label for="nom">Nom <focus>*</focus></label>
                                <input type="text" name="nom" id="nom" placeholder="nom" class="input_set" value="<?php getPostValue('nom'); ?>">
                                <span class="erreur"><?php viewError($errors, 'nom'); ?></span>
                            </div>
                            <div class="box">
                                <label for="prenom">Prenom <focus>*</focus></label>
                                <input type="text" name="prenom" id="prenom" placeholder="prenom" class="input_set" value="<?php getPostValue('prenom'); ?>">
                                <span class="erreur"><?php viewError($errors, 'prenom'); ?></span>
                            </div>
                        </div>
                        <div class="boxmilieu">
                            <div class="box">
                                <label for="mail">Email <focus>*</focus></label>
                                <input type="email" name="mail" id="mail" placeholder="email@gmail.com" class="input_set" value="<?php getPostValue('mail'); ?>">
                                <span class="erreur"><?php viewError($errors, 'mail'); ?></span>
                            </div>
                        </div>
                        <div class="boxbas">
                            <div class="box mdp_2">
                                <label for="password">Mot de passe <focus>*</focus></label>
                                <input type="password" name="password" id="password" placeholder="password" class="input_set" value="<?php getPostValue('password'); ?>">
                                <span class="erreur"><?php viewError($errors, 'password'); ?></span>
                            </div>
                            <div class="box">
                                <label for="password2">Confirmation mot de passe <focus>*</focus></label>
                                <input type="password" name="password2" id="password2" placeholder="password" class="input_set">
                                <span class="erreur"></span>
                            </div>
                        </div>
                            <div class="box_form2">
                                <input type="submit" name="submitted" value="S’Inscrire" class="submit_set">
                            </div>
                            <a href="login.php">J'ai deja un compte</a>
                    </form>
                </div>
            </div>
    </section>





<?php include('inc/footer.php');