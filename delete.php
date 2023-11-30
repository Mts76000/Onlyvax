<?php
session_start();
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/validation.php');

if (!empty($_GET['id_carnet']) && is_numeric($_GET['id_carnet'])) {
    $id = $_GET['id_carnet'];

    $sql = "UPDATE carnet SET status = 1 WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $existingId = $query->fetch();
    header('Location: listing.php');
} else {
    header('Location: 404.php');
}
