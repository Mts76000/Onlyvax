<?php
include('inc/nav.php');

$formSubmitted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $rappel_vaccin = htmlspecialchars($_POST['rappel_vaccin']);
    $description = htmlspecialchars($_POST['description']);

    $created_at = date('Y-m-d H:i:s');

    $insertSql = "INSERT INTO vaccin (nom, created_at, rappel_vaccin, description) VALUES (?, ?, ?, ?)";
    $insertQuery = $pdo->prepare($insertSql);

    $insertQuery->execute([$nom, $created_at, $rappel_vaccin, $description]);

    $formSubmitted = true;
}
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Ajouter un vaccin</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <?php
                    if ($formSubmitted) {
                        echo '<div id="success-message" class="alert alert-success mt-3 text-center success-box">Vaccin ajouté !</div>';
                        echo '<script>
                                setTimeout(function() {
                                    var successMessage = document.getElementById("success-message");
                                    if (successMessage) {
                                        successMessage.style.display = "none";
                                    }
                                }, 5000);
                              </script>';
                    }
                    ?>

                    <form method="post" action="add-vaccin-admin.php" class="p-4">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom du vaccin</label>
                            <input type="text" class="form-control bg-light p-lg-2" id="nom" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="rappel_vaccin" class="form-label">Rappel (jour)</label>
                            <input type="number" class="form-control bg-light p-lg-2" id="rappel_vaccin" name="rappel_vaccin" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control bg-light p-lg-2" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter le vaccin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .success-box {
        max-width:  400px; /* Ajustez la largeur comme vous le souhaitez */
        margin-left: auto;
        margin-right: auto;
    }
</style>

<?php
include('inc/reglage.php');
?>
</body>
</html>
