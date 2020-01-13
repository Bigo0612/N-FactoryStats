<?php
include ('inc/function.php');
include ('inc/pdo.php');
$errors = array();
$success = false;
if (!empty($_POST['submit'])) {
    $nom             = clean($_POST['nom']);
    $prenom          = clean($_POST['prenom']);
    $email           = clean($_POST['email']);
    $message         = clean($_POST['message']);


    $errors = textValid($errors, $nom, 'nom',2, 140);
    $errors = textValid($errors, $prenom, 'prenom',2, 150);
    $errors = emailValid($errors, $email, 'email',5,255);
    $errors = textValid($errors, $message, 'message',10,2000);


    if (count($errors) == 0) {
        $success = true;
        $sql = "INSERT INTO contact VALUES(null ,:nom ,:prenom ,:email ,:message)";
        $query = $pdo->prepare($sql);
        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $query->bindValue(':email',$email, PDO::PARAM_STR);
        $query->bindValue(':message',$message, PDO::PARAM_STR);
        $query->execute();
    }
}
include('inc/header.php'); ?>

<div class="wrapper">

    <div class="flexslider">
        <div class=" wrap">
            <ul class="slides">
                <li>
                    <img src="asset/img/slide1.jpg" alt="image de stats 1"/>
                </li>
                <li>
                    <img src="asset/img/slide2.jpg" alt="image de stats 2"/>
                </li>
                <li>
                    <img src="asset/img/slide3.jpg" alt="image de stats 3"/>
                </li>
            </ul>
        </div>
    </div>

    <section id="quisommesnous">
        <div class=" wrap2">
            <h1>Qui somme nous ?</h1>
            <div class="text">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    Ad alias delectus dolor esse exercitationem fuga laboriosam laborum officiis quas quia,
                    ratione rem vel. A alias animi at autem corporis cum deserunt ducimus error eum ex excepturi expedita illo inventore iure laborum libero magni,
                    minus molestiae nam officiis possimus quaerat quidem quisquam reiciendis repellendus repudiandae,
                    sequi tempora temporibus, tenetur velit! Ipsam itaque iure nostrum nulla perspiciatis! Adipisci amet assumenda doloremque
                    eos in labore odit quae quas quasi sed! Ab aliquid expedita id itaque, laudantium provident? Alias consequatur
                    deserunt dolor excepturi hic illo ipsa modi qui totam. Minus molestiae quae repudiandae vero.</p>
            </div>
        </div>

    </section>

    <section id="contact">
        <div class="form">
            <div class="wrap3">
                <h2>Nous contacter</h2>
                <div class="ligne"></div>
                <h3>Envoyez votre message</h3>
            <?php if($success) {
                header('Location: success.php');
            } else { ?>
                <form action="" method="post">
                    <div id="titi" class="w50">
                        <label for="name">Votre Nom</label>
                        <input id="nom" type="text" name="nom" placeholder="Ex: Tarantino" value="<?php if (!empty($_POST['nom'])) {echo $_POST['nom'];} ?>">
                        <span class="error"><?php if(!empty($errors['nom'])) {echo $errors['nom']; }?></span>
                    </div>

                    <div id="tintin" class="w50">
                        <label for="name">Votre Prenom</label>
                        <input id="prenom" type="text" name="prenom" placeholder="Ex: Quentin" value="<?php if (!empty($_POST['prenom'])) {echo $_POST['prenom'];} ?>">
                        <span class="error"><?php if(!empty($errors['prenom'])) {echo $errors['prenom']; }?></span>
                    </div>

                    <div class="w50">
                        <label for="name">Votre Email</label>
                        <input id="email" type="email" name="email" placeholder="Ex: quentintarantino@gmail.com" value="<?php if (!empty($_POST['email'])) {echo $_POST['email'];} ?>">
                        <span class="error"><?php if(!empty($errors['email'])) {echo $errors['email']; }?></span>
                    </div>

                    <div class="w100">
                        <label for="name">Votre Message</label>
                        <textarea name="message" rows="8" cols="72" placeholder="Bonjour"><?php if (!empty($_POST['message'])) {echo $_POST['message'];} ?></textarea>
                        <span class="error"><?php if(!empty($errors['message'])) {echo $errors['message']; }?></span>
                    </div>

                    <input type="submit" name="submit" value="Envoyer">
                </form> <?php } ?>
            </div>
        </div>
        <div class="clear"></div>
    </section>

</div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script src="asset/flexslider/jquery.flexslider.js"></script>
    <script src="asset/js/main.js"></script>

<?php include('inc/footer.php');
