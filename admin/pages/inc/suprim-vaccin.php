<?php
include('../../../inc/pdo.php');
// Vérifier si l'ID du vaccin est présent dans l'URL
if (isset($_GET['id'])) {
    // Récupérer et nettoyer l'ID du vaccin
    $id = htmlspecialchars($_GET['id']);

    // Préparer la requête de suppression
    $deleteSql = "DELETE FROM vaccin WHERE id = ?";
    $deleteQuery = $pdo->prepare($deleteSql);

    // Exécuter la requête de suppression avec l'ID du vaccin
    $deleteQuery->execute([$id]);

    // Rediriger vers la page principale après la suppression
    header('Location: ../vaccin.php');
    exit();
} else {
    // Si l'ID n'est pas présent dans l'URL, rediriger vers la page principale
    header('Location:../vaccin.php');
    exit();
}
?>

<!-- Le reste du contenu de la page supprimer-vaccin.php peut être ajouté selon vos besoins -->
