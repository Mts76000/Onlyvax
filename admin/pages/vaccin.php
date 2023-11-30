<?php
include('inc/nav.php');

$selectSql = "SELECT * 
FROM vaccin ORDER BY created_at DESC;";
$selectQuery = $pdo->prepare($selectSql);
$selectQuery->execute();
$vaccins = $selectQuery->fetchAll(PDO::FETCH_ASSOC);
?>


<style>
    .description-cell {
        max-width: 300px; /* Ajustez la largeur comme vous le souhaitez */
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        word-wrap: break-word;
    }
</style>


<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Vaccins</h6>
                        <a href="add-vaccin-admin.php" class="btn btn-dark btn-sm float-end mt-5">Ajouter un vaccin</a>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nom</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">RAppel(jour)</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Description</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($vaccins as $vaccin) { ?>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <div class="avatar avatar-sm me-3 border-radius-lg bg-dark">
                                                    <i class="material-icons opacity-10">person</i>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-xs text-secondary mb-0"><?php echo htmlspecialchars($vaccin['nom']); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($vaccin['rappel_vaccin']); ?></span>
                                    </td>
                                    <td class="align-middle text-center description-cell">
                                        <span class="text-secondary text-xs  font-weight-bold"><?php echo htmlspecialchars($vaccin['description']); ?></span>
                                    </td>
                                    <td class="text-center">
                                        <a href="inc/suprim-vaccin.php?id=<?php echo $vaccin['id']; ?>" class="btn btn-danger btn-sm">Supprimer</a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('inc/reglage.php');
?>
</body>
</html>
