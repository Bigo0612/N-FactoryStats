<?php
session_start();
require('inc/pdo.php');
require('inc/function.php');
$title = 'Home page';


include('inc/header.php'); ?>
    <div class="bg-img"></div>
    <section class="graph-texte">
        <div class="exterieur">
            <div class="text-left">
                <h2><span class="span-color">NFactory Stats</span></h2>
                <p>Réseau, fichier Json, chiffres, pourcentages… <br>
                    Tant de mots connotés d'ombres, et pourtant…<br>
                    Il suffit juste d'un bon site!<br>
                    Alors, ne dites plus non aux statistiques, dites oui à <span class="span-color">NFactory Stats !<span></span></p>
            </div>
            <img src="asset/img/graph.png">
        </div>

    </section>
    <div class="clear"></div>

    <section id="fonctionnement">
        <div class="wrap2">
            <div class="ex simple">
                <h3>Simple</h3>
                <img src="asset/img/pouce.png" alt="logo simplicité">
                <p>Simple d'utilisation</p>
            </div>

            <div class="ex util">
                <h3>Utile</h3>
                <img src="asset/img/utiles.png" alt="logo utilité">
                <p>Utile pour analyser votre reseau</p>
            </div>

            <div class="ex pedagogique">
                <h3>Pédagogique</h3>
                <img src="asset/img/owl.png" alt="logo sécurité">
                <p>Simple à comprendre</p>
            </div>
        </div>
    </section>

    <section id="tronbinoscope">
        <div class="ava avajan">
            <h4>Janssen</h4>
            <img src="asset/img/avatarjanssen.png" alt="avatar Janssen">
            <p>Chef de projet</p>
        </div>

        <div class="ava avamel">
            <h4>Mélanie</h4>
            <img src="asset/img/avatarmelanie.png" alt="avatar Mélanie">
            <p>Développeur</p>
        </div>

        <div class="ava avasof">
            <h4>Sofien</h4>
            <img src="asset/img/avatarsofien.png" alt="avatar Sofien">
            <p>Développeur</p>
        </div>

        <div class="ava avaste">
            <h4>Steve</h4>
            <img src="asset/img/avatarsteve.png" alt="avatar Steve">
            <p>Développeur</p>
        </div>
    </section>


<?php include('inc/footer.php');