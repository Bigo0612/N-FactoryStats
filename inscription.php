<?php
session_start();
require('inc/pdo.php');
require('inc/function.php');
$title = 'inscription';
$errors = array();
$success = false;


if(!empty($_POST['submitted'])) {



    $email = trim(strip_tags($_POST['email']));
    $password1 = trim(strip_tags($_POST['password1']));
    $password2 = trim(strip_tags($_POST['password2']));
    $cgu       = trim(strip_tags($_POST['cgu']));


    if(filter_var($email,FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'Veuillez renseigner un email valide';
    }else{

        $sql = "SELECT id FROM users WHERE email = :mail LIMIT 1";
        $query = $pdo->prepare($sql);
        $query->bindValue(':mail' ,$email,PDO::PARAM_STR);
        $query->execute();
        $verifemail = $query->fetch();
        if(!empty($verifemail)) {
            $errors['pseudo'] = 'cet email existe déjà!';
        }
    }

    if(!empty($password1)) {
        if($password1 != $password2) {
            $errors['password'] = 'Les deux mot de passe doivent être identique';
        } elseif(mb_strlen($password1) <= 5) {
            $errors['password'] = 'Min 6 caractères';
        }
    }else{
        $errors['password'] = 'Veuillez renseigner un mot de passe';
    }
    //debug ($_POST);
    //die();
    if(!empty($_POST['cgu']) && $_POST['cgu']) {

    } else {
        $errors['cgu'] = 'Veuillez accepter les Conditions générales d’utilisation.';
    }






    if(count($errors) == 0) {

        $hashpassword = password_hash($password1,PASSWORD_BCRYPT);
        $token = generateRandomString(120);

        $sql = "INSERT INTO users VALUES (null,:email,:password,:token,'abonne',NOW())";
        $query = $pdo->prepare($sql);
        $query->bindValue(':email' , $email, PDO::PARAM_STR);
        $query->bindValue(':password' , $hashpassword, PDO::PARAM_STR);
        $query->bindValue(':token' , $token, PDO::PARAM_STR);
        $query->execute();
        $success = true;

        header('location: connexion.php');
    }
}

include('inc/header.php');
?>

    <div class="clear"></div>

    <h1 class="h1form">Inscription</h1>

    <form action="inscription.php" method="post" autocomplete="off" class="formulaires">

        <div class="formdiv">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>">
        <p class="error"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></p>
        </div>
        <div class="formdiv">
        <label for="password1">Mot de passe</label>
        <input type="password" name="password1" id="password1" value="">
        <p class="error"><?php if(!empty($errors['password'])) { echo $errors['password']; } ?></p>
        </div>
        <div class="formdiv">
        <label for="password2">Confirmer le mot de passe</label>
        <input type="password" name="password2" id="password2" value="">
        </div>
        <div class="formdiv">
            <a href="cgu.php"><label for="cgu">Conditions générales d’utilisation</label></a>
        <input type="checkbox" name="cgu" id="cgu" value="yes">
        <p class="error"><?php if(!empty($errors['cgu'])) { echo $errors['cgu']; } ?></p>
        </div>
        <div class="formdiv">
        <input type="submit" name="submitted" value="Inscrivez vous">
        </div>
    </form>

<div class="clear"></div>



<?php include('inc/footer.php');