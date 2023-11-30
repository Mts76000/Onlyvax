
<?php


$requestUri = $_SERVER['REQUEST_URI'];
$targetUrl = '/nfs%202023-2024/Projet%20Vaccin/inc/validation.php';

if ($requestUri === $targetUrl) {
    // Redirigez vers la page 404.php si l'URL correspond
    header('Location: ../404.php');

    exit;
}

function validText($err, $value, $keyErr, $min, $max)
{
if (!empty($value)) {
if (mb_strlen($value) < $min) {
$err[$keyErr] = 'Veuillez renseigner au moins ' . $min . ' caractères';
} elseif (mb_strlen($value) > $max) {
$err[$keyErr] = 'Veuillez renseigner pas plus de ' . $max . ' caractères';
}
} else {
$err[$keyErr] = 'Veuillez renseigner ce champ';
}
return $err;
}

function validNumber($err, $value, $keyErr)
{
    if (!empty($value)) {
        if (($value) < 0) {
            $err[$keyErr] = 'Veuillez renseigner un nombre positif ';
        } elseif (is_numeric($value) == false) {
            $err[$keyErr] = 'Veuillez renseigner un nombre entier ';
        }
    } else {
        $err[$keyErr] = 'Veuillez renseigner ce champ';
    }
    return $err;
}

function validmail($errors,$valeur,$key){
    if(!empty($valeur)) {
        if (!filter_var($valeur, FILTER_VALIDATE_EMAIL)) {
            $errors[$key] = 'Veuillez renseigner un email valide';
        }
    } else {
        $errors[$key] = 'Veuillez renseigner un email';
    }
    return $errors;
}