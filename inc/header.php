<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title><?php if (!empty($title)) {
            echo $title;
        } else {
            echo 'nom du site';
        } ?> </title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="asset/css/style.css">
    <link rel="stylesheet" href="asset/css/connexion.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

</head>


<body>
<header>
    <div id="hamburger">
        <div id="hamburger-content">
            <nav class="navbar">
                <a href="index.php">
                    <img class="logo" src="asset/img/logo1.png" alt="logo Nfactory Stats">
                </a>
                <ul>
                    <li><a class="btn-menu" href="index.php">Accueil</a></li>


                    <?php if (!is_logged()) { ?>
                        <li><a class="btn-menu" href="inscription.php">Inscription</a></li>
                        <li><a class="btn-menu" href="connexion.php">Connexion</a></li>

                    <?php } elseif ($_SESSION['email']['role'] == "admin") { ?>
                        <li><a class="btn-menu" href="back/index.php">Admin</a></li>
                        <li><a class="btn-menu" href="stats.php">Stats</a></li>
                        <li><a class="btn-menu" href="deconnexion.php">Deconnexion</a></li>

                    <?php } else { ?>
                        <li><a class="btn-menu" href="stats.php">Stats</a></li>
                        <li><a class="btn-menu" href="deconnexion.php">Deconnexion</a></li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
        <button id="hamburger-button">&#9776</button>
        <div id="hamburger-sidebar">
            <div id="hamburger-sidebar-header">
                <img class="logo-hamburger" src="asset/img/logo1.png" alt="logo Nfactory stats">
            </div>
            <div id="hamburger-sidebar-body"></div>
        </div>
        <div id="hamburger-overlay"></div>
    </div>
</header>













