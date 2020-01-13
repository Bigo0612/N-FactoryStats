<?php
include ('inc/function.php');
include ('inc/pdo.php');
$errors = array();
$success = false;
if (!empty($_POST['submit'])) {
    $email           = clean($_POST['email']);
    $password        = clean($_POST['password']));
    $password2       = clean($_POST['password2']));


    $errors = emailValid($errors, $email, 'email',5,255);
    $error['password']  = $formVerif->errorText($password, 'Mot de passe', 5, 255);
    $error['password2'] = $formVerif->errorRepeat($password, $password2, 'Les mots de passe ne correspondent pas.');


    if (count($errors) == 0) {
        $success = true;
        $sql = "INSERT INTO contact VALUES(null ,:email ,:password ,:password2)";
        $query = $pdo->prepare($sql);
        $query->bindValue(':email',$email, PDO::PARAM_STR);
        $query->bindValue(':password', $password, PDO::PARAM_STR);
        $query->bindValue(':password2', $password2, PDO::PARAM_STR);
        $query->execute();
    }
}
include('inc/header.php'); ?>

<div class="wrapper">

    <div class="flexslider">
        <div class=" wrap">
            <ul class="slides">
                <li>
                    <img src="asset/img/slide1.png" alt="image de stats 1"/>
                </li>
                <li>
                    <img src="asset/img/slide2.png" alt="image de stats 2"/>
                </li>
                <li>
                    <img src="asset/img/slide3.png" alt="image de stats 3"/>
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
</div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script src="asset/flexslider/jquery.flexslider.js"></script>
    <script src="asset/js/main.js"></script>

<?php include('inc/footer.php');
