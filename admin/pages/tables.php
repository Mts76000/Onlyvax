<?php
include('inc/nav.php');

$selectSql = "SELECT * FROM carnet ORDER BY created_at DESC;";
$selectQuery = $pdo->prepare($selectSql);
$selectQuery->execute();
$fiches = $selectQuery->fetchAll(PDO::FETCH_ASSOC);

$Sql = "SELECT * FROM users ORDER BY created_at DESC;";
$select = $pdo->prepare($Sql);
$select->execute();
$users = $select->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['changeRole'])) {
        $userId = $_POST['userId'];
        $currentRole = $_POST['currentRole'];


        $newRole = ($currentRole === 'admin') ? 'user' : 'admin';

        try {

            $updateSql = "UPDATE users SET role = :newRole WHERE id = :userId";
            $updateQuery = $pdo->prepare($updateSql);
            $updateQuery->bindParam(':newRole', $newRole, PDO::PARAM_STR);
            $updateQuery->bindParam(':userId', $userId, PDO::PARAM_INT);
            $updateQuery->execute();

            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit();
        } catch (PDOException $e) {

            echo "Erreur lors de la mise à jour du rôle : " . $e->getMessage();
            exit();
        }
    }
}
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Utilisateur</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nom/ Prénom</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Rôle</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Créé le</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Rôle</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <?php if (!empty($users)) { ?>
                                <?php foreach ($users as $user) { ?>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <div class="avatar avatar-sm me-3 border-radius-lg bg-dark">
                                                            <i class="material-icons opacity-10">person</i>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($user['prenom']); ?></h6>
                                                        <p class="text-xs text-secondary mb-0"><?php echo htmlspecialchars($user['nom']); ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($user['mail']); ?></span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <?php
                                                $role = htmlspecialchars($user['role']);
                                                $badgeColor = ($role === 'admin') ? 'bg-gradient-danger' : 'bg-gradient-success';
                                                ?>
                                                <span class="badge badge-sm <?php echo $badgeColor; ?>"><?php echo $role; ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($user['created_at']); ?></span>
                                            </td>
                                            <td class="align-middle text-center ">
                                                <form method="post" class="align-middle text-center ">
                                                    <input type="hidden" name="userId" value="<?= $user['id'] ?>">
                                                    <input type="hidden" name="currentRole" value="<?= $role ?>">
                                                    <button type="submit" class="btn btn-link text-secondary text-xs mt-3 change-role-btn" data-user-id="<?= $user['id'] ?>" data-current-role="<?= $role ?>">
                                                        Changer de rôle
                                                    </button>
                                                </form>
                                            </td>

                                            <td class="align-middle text-center">
                                                <a href="inc/suprim.php?id=<?= $user['id'] ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                                    supprimer
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php } ?>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const changeRoleButtons = document.querySelectorAll('.change-role-btn');

        changeRoleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = button.getAttribute('data-user-id');
                const currentRole = button.getAttribute('data-current-role');


                fetch(window.location.href, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `changeRole=true&userId=${userId}&currentRole=${currentRole}`,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {

                            const newRole = (currentRole === 'admin') ? 'user' : 'admin';
                            const badgeColor = (newRole === 'admin') ? 'bg-gradient-danger' : 'bg-gradient-success';

                            button.setAttribute('data-current-role', newRole);
                            button.parentElement.previousElementSibling.innerHTML = `<span class="badge badge-sm ${badgeColor}">${newRole}</span>`;
                        } else {
                            console.error('Échec du changement de rôle');
                        }
                    })
                    .catch(error => console.error('Erreur:', error));
            });
        });
    });
</script>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Carnet</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nom/ Prenom</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date de naissance</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Homme/ FEMME</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cree le</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <?php foreach ($fiches as $fiche) { ?>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <div class="avatar avatar-sm me-3 border-radius-lg bg-dark">
                                                        <i class="material-icons opacity-10">book</i>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($fiche['prenom']); ?></h6>
                                                    <p class="text-xs text-secondary mb-0"><?php echo htmlspecialchars($fiche['nom']); ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($fiche['date_de_nais']); ?></span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-success"><?php echo htmlspecialchars($fiche['status']); ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($fiche['sexe']); ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($fiche['created_at']); ?></span>
                                        </td>
                                        <td class="align-middle">
                                            <a href="delete.php?id_carnet=<?= $fiche['id'] ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                                supprimer
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            <?php } ?>
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