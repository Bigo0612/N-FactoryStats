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
    <nav class="navbar">
        <a href="index.php">
            <img class="logo" src="asset/img/logo1.png" alt="logo Nfactory Stats">
        </a>
        <ul>
            <li><a href="index.php">Accueil</a></li>

            <?php if(!is_logged()) { ?>
            <li><a href="inscription.php">Inscription</a></li>
            <li><a href="connexion.php">Connexion</a></li>

            <?php } else { ?>
                <li><a href="deconnexion.php">Deconnexion</a></li>
                <li><?php echo $_SESSION['email']['email']; ?></li>
                <?php if($_SESSION['email']['role'] == "admin") { ?>
                    <li><a href="back/index.php">Admin</a></li>
                <?php } ?>
            <?php } ?>
        </ul>
    </nav>
</header>












