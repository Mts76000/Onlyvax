<?php

$requestUri = $_SERVER['REQUEST_URI'];
$targetUrl = '/nfs%202023-2024/Projet%20Vaccin/inc/footer.php';

if ($requestUri === $targetUrl) {
    // Redirigez vers la page 404.php si l'URL correspond
    header('Location: ../404.php');

    exit;
}

?>
<div class="imgfooter"></div>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script>
    AOS.init();
</script>

<footer>
    <div class="footerAll wrap2">
        <div class="contact">
            <h2>ONLYVAX</h2>
            <nav>
                <ul>
                    <li><a href="contact.php">CONTACTEZ-NOUS</a></li>
                </ul>
            </nav>
        </div>
        <div class="nav">
            <nav>
                <ul>
                    <li>
                        <a href="register.php" id="inscription-link">S'INSCRIRE</a>
                    </li>

                    <li>
                        <a href="login.php" id="connexion-link">CONNEXION</a>
                    </li>

                    <li><a href="mention-legal.php">MENTIONS LÉGALES</a></li>
                </ul>
            </nav>
        </div>
        <div class="reseau">
            <nav>
                <ul>
                    <li><a href="#"><i class="fa-brands fa-facebook" style="color: #ffffff;"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-twitter" style="color: #ffffff;"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-instagram" style="color: #ffffff;"></i></a></li>
                </ul>
            </nav>
        </div>
    </div>
</footer>

<!-- Script JavaScript pour afficher la popup -->
<script>
    document.getElementById('inscription-link').addEventListener('click', function(event) {
        // Vérifier si l'utilisateur est connecté (pour des raisons de sécurité)
        <?php if (isLogged()) : ?>
            alert("Vous êtes déjà connecté !");
            event.preventDefault(); // Empêche le lien de rediriger
        <?php endif; ?>
    });
</script>

<script>
    document.getElementById('connexion-link').addEventListener('click', function(event) {
        // Vérifier si l'utilisateur est connecté (pour des raisons de sécurité)
        <?php if (isLogged()) : ?>
            alert("Vous êtes déjà connecté !");
            event.preventDefault(); // Empêche le lien de rediriger
        <?php endif; ?>
    });
</script>