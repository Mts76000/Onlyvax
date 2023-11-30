<?php
require('inc/pdo.php');

if (isset($_GET['id_vaccin'])) {
    $id = $_GET['id_vaccin'];
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
        try {
            $pdo->beginTransaction();
            $sql_delete_carnet_vaccin = "DELETE FROM carnet_vaccin WHERE id = :id";
            $query_delete_carnet_vaccin = $pdo->prepare($sql_delete_carnet_vaccin);
            $query_delete_carnet_vaccin->bindValue('id', $id, PDO::PARAM_INT);
            $query_delete_carnet_vaccin->execute();
            $pdo->commit();

            // Récupérer l'ID du carnet depuis l'URL
            $id_carnet = isset($_GET['id_carnet']) ? $_GET['id_carnet'] : '';

            // Redirection vers single.php avec l'ID du carnet
            header("Location: single.php?id=" . $id_carnet);
            exit;
        } catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        // Récupérer l'ID du carnet depuis l'URL
        $id_carnet = isset($_GET['id_carnet']) ? $_GET['id_carnet'] : '';

        echo '<script>
            var confirmation = window.confirm("Êtes-vous sûr de vouloir supprimer?");
            if (confirmation) {
                window.location.href = "suprim.php?id_vaccin=' . $id . '&id_carnet=' . $id_carnet . '&confirm=true";
            } else {
                window.location.href = "single.php?id=' . $id_carnet . '";
            }
        </script>';
    }
}
?>
