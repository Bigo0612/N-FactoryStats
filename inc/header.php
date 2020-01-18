<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <title><?php if (!empty($title)) {
            echo $title;
        } else {
            echo 'nom du site';
        } ?> </title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="asset/css/style.css">
    <link rel="stylesheet" href="asset/css/connexion.css">

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
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="stats1.php">stats1</a></li>
                    <li><a href="back/index.php">Admin</a></li>

                    <?php if (!is_logged()) { ?>
                        <li><a href="inscription.php">Inscription</a></li>
                        <li><a href="connexion.php">Connexion</a></li>

                    <?php } elseif ($_SESSION['email']['role'] == "admin") { ?>
                        <li><a href="back/index.php">Admin</a></li>

                    <?php } else { ?>
                        <li><a href="deconnexion.php">Deconnexion</a></li>
                        <li><?php echo $_SESSION['email']['email']; ?></li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
        <button id="hamburger-button">&#9776</button>
        <div id="hamburger-sidebar">
            <div id="hamburger-sidebar-header"></div>
            <div id="hamburger-sidebar-body"></div>
        </div>
        <div id="hamburger-overlay"></div>
    </div>
</header>













