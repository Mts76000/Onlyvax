<?php
require('../../../inc/pdo.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
        try {
            $pdo->beginTransaction();

            // Supprimer les enregistrements liés dans la table carnet_vaccin
            $sql_delete_carnet_vaccin = "DELETE FROM carnet_vaccin WHERE id_carnet IN (SELECT id FROM carnet WHERE id_user = :id)";
            $query_delete_carnet_vaccin = $pdo->prepare($sql_delete_carnet_vaccin);
            $query_delete_carnet_vaccin->bindValue('id', $id, PDO::PARAM_INT);
            $query_delete_carnet_vaccin->execute();

            // Supprimer les enregistrements liés dans la table carnet
            $sql_delete_carnet = "DELETE FROM carnet WHERE id_user = :id";
            $query_delete_carnet = $pdo->prepare($sql_delete_carnet);
            $query_delete_carnet->bindValue('id', $id, PDO::PARAM_INT);
            $query_delete_carnet->execute();

            // Supprimer l'enregistrement principal dans la table users
            $sql_delete_user = "DELETE FROM users WHERE id = :id";
            $query_delete_user = $pdo->prepare($sql_delete_user);
            $query_delete_user->bindValue('id', $id, PDO::PARAM_INT);
            $query_delete_user->execute();

            // Valider la transaction
            $pdo->commit();

            header("Location: ../tables.php");
            exit;
        } catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        // Suppression non confirmée, afficher la boîte de dialogue côté client
        echo '<script>
            var confirmation = window.confirm("Êtes-vous sûr de vouloir supprimer?");
            if (confirmation) {
                window.location.href = "suprim.php?id='. $id .'&confirm=true";
            } else {
                window.location.href = "../tables.php";
            }
        </script>';
        // Ne pas exécuter le reste du code PHP ici
        exit;
    }
} else {
    echo "ID manquant.";
}
?>
