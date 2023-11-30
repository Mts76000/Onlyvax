<?php


$requestUri = $_SERVER['REQUEST_URI'];
$targetUrl = '/nfs%202023-2024/Projet%20Vaccin/inc/fonction.php';

if ($requestUri === $targetUrl) {
    // Redirigez vers la page 404.php si l'URL correspond
    header('Location: ../404.php');

    exit;
}

function debug($tableau)
{
    echo '<pre style="height:200px;overflow-y: scroll;font-size: .5rem;padding: .6rem;font-family: Consolas, Monospace; background-color: #000;color:#fff;">';
    print_r($tableau);
    echo '</pre>';
}

function getPostValue($key)
{
    if (!empty($_POST[$key])) {
        echo $_POST[$key];
    }
}

function viewError($err, $key)
{
    if (!empty($err[$key])) {
        echo $err[$key];
    }
}

function cleanXss($key)
{
    return trim(strip_tags($_POST[$key]));
}



function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function isLogged()
{
    if(!empty($_SESSION['user']['id'])) {
        if(!empty($_SESSION['user']['nom'])) {
            if(!empty($_SESSION['user']['prenom'])) {
                if(!empty($_SESSION['user']['mail'])) {
                    if(!empty($_SESSION['user']['ip'])) {
                        if($_SESSION['user']['ip'] == $_SERVER['REMOTE_ADDR']) {
                            return true;
                        }
                    }
                }

            }
        }
    }
    return false;
}

function isAdmin() {
    if(isLogged()) {
        if($_SESSION['user']['role'] == 'admin') {
            return true;
        }
    }
    return false;
}

function getUserPassword($userId)
{
    global $pdo; // Assurez-vous que $pdo est déclaré et initialisé dans votre script.

    $sql = "SELECT password FROM users WHERE id = :user_id";
    $query = $pdo->prepare($sql);
    $query->bindValue('user_id', $userId, PDO::PARAM_INT);
    $query->execute();

    // Récupérez le mot de passe depuis la base de données
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // Retournez le mot de passe
    return ($result) ? $result['password'] : null;
}


