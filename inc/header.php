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

</head>


<body>

<header>
    <nav class="navbar">
        <a href="index.php">
            <img class="logo" src="asset/img/logo1.png" alt="logo Nfactory Stats">
        </a>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="inscription.php">Inscription</a></li>
            <li><a href="connexion.php">Connexion</a></li>
        </ul>
    </nav>
</header>





