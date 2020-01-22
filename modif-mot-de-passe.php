<?php
session_start();
require('inc/pdo.php');
require('inc/function.php');
$title = 'modifier votre mot de passe';
$errors = array();
$success = false;

if(!empty($_GET['token']) && !empty($_GET['email'])) {
    $token = trim(strip_tags($_GET['token']));
    $email = trim(strip_tags($_GET['email']));
    $email = urldecode($email);
    $sql = "SELECT * FROM users WHERE email = :email AND token = :token";
    $query = $pdo->prepare($sql);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->bindValue(':token', $token, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();
    if(!empty($user)) {

        if(!empty($_POST['submitted'])) {
            $password1 = trim(strip_tags($_POST['password1']));
            $password2 = trim(strip_tags($_POST['password2']));

            if(!empty($password1)) {
                if($password1 != $password2) {
                    $errors['password'] = 'Les deux mots de passe doivent être identiques';
                } elseif(mb_strlen($password1) <= 5) {
                    $errors['password'] = 'Min 6 caractères';
                }
            } else {
                $errors['password'] = 'Veuillez renseigner un mot de passe';
            }
            if(count($errors) == 0) {

                $hashPassword = password_hash($password1,PASSWORD_BCRYPT);
                $token = generateRandomString(120);
                $sql = "UPDATE users SET password = :password, token = :token WHERE email = :email";
                $query = $pdo->prepare($sql);
                $query->bindValue(':email',   $email,PDO::PARAM_STR);
                $query->bindValue(':password',$hashPassword,PDO::PARAM_STR);
                $query->bindValue(':token',   $token,PDO::PARAM_STR);
                $query->execute();

                header('Location: connexion.php');
            }
        }
    }
}
include('inc/header.php'); ?>

    <h2 id="modmp">Modifier votre mot de passe</h2>

    <form action="" method="post" class="formulaires">
        <div class="formdiv">
        <label for="password1">Mot de passe 1</label>
        <input type="password" name="password1" value="">
        <p class="error"><?php if(!empty($errors['password'])) { echo $errors['password']; } ?></p>
        </div>
        <div class="formdiv">
        <label for="password2">Mot de passe 2</label>
        <input type="password" name="password2" value="">
        </div>
        <div class="formdiv">
        <input type="submit" name="submitted" value="Envoyer">
        </div>
    </form>

<?php include('inc/footer.php');