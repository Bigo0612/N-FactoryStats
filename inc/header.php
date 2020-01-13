<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="asset/flexslider/flexslider.css" type="text/css">
    <link rel="stylesheet" href="asset/css/style.css">
    <title>N'FactoryStats</title>
</head>

<header>
    <div class="fixmenu">
        <div class="header-acceuil">
            <a id="logo" href="index.php"><img class="imglogo" src="asset/img/N'FactoryStats.png" alt="image de logo N\'FactoryStats"></a>
            <a href="#quisommesnous"><p>Qui sommes nous ?</p></a>
            <a href="#contact"><p>Contactez nous</p></a>
            <a onclick="document.getElementById('id02').style.display='block'" href="#"><p>Connexion</p></a>
            <a onclick="document.getElementById('id01').style.display='block'" href="#"><p>Inscription</p></a>
        </div>
    </div>
    <div class="clear"></div>
</header>

<div id="id01" class="modal">
    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">times;</span>
    <form class="modal-content" action="/action_page.php">
        <div class="container">
            <h1>Inscription</h1>
            <p>Veuillez remplir ce formulaire pour créer un compte.</p>
            <hr>
            <label for="email"><b>Email</b></label>
            <input class="inscritption" type="text" placeholder="Enter Email" name="email" required>

            <label for="psw"><b>Mot de passe</b></label>
            <input class="inscritption" type="password" placeholder="Entrer votre mot de pass" name="psw" required>

            <label for="psw-repeat"><b>Répéter le mot de passe</b></label>
            <input class="inscritption" type="password" placeholder="Répéter votre mot de passe" name="psw-repeat" required>

            <label>
                <input class="inscritption" type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Se souvenir de moi
            </label>

            <p>En créant un compte, vous acceptez nos <a href="#" style="color:dodgerblue">Conditions et confidentialité</a>.</p>

            <div class="clearfix">
                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                <button type="submit" class="signup">inscription</button>
            </div>
        </div>
    </form>
</div>



<div id="id02" class="modal2">
  <span onclick="document.getElementById('id02').style.display='none'"
        class="close2" title="Close Modal">&times;</span>


    <form class="modal-content2 animate" action="/action_page.php">
        <div class="imgcontainer2">
            <img src="img_avatar2.png" alt="Avatar" class="avatar">
        </div>

        <div class="container2">
            <label for="uname"><b>Nom d'utilisateur</b></label>
            <input type="text" placeholder="Entrer votre nom d'utilisateur" name="uname" required>

            <label for="psw"><b>Mot de pass</b></label>
            <input type="password" placeholder="Entrer votre mot de pass" name="psw" required>

            <button type="submit">S'identifier</button>
            <label>
                <input type="checkbox" checked="checked" name="remember"> Se souvenir de moi
            </label>
        </div>

        <div class="container2" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
            <span class="psw">Forgot <a href="#">password?</a></span>
        </div>
    </form>
</div>


