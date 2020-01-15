<?php
require('inc/pdo.php');
require('inc/function.php');
$title = 'modifier votre mot de passe';
$errors  = array();
$success = true;

if(!empty($_GET['token'] && (!empty($_GET))['email'])) {
    $email = trim(strip_tags($_GET['email']));
    $token = trim(strip_tags($_GET['token']));
    $email = urldecode($email);
    $sql   = "SELECT email, token FROM users WHERE email = :email AND token =:token";
    $query = $pdo->prepare($sql);
    $query->bindValue(':email',$email,PDO::PARAM_STR);
    $query->bindValue(':token',$token,PDO::PARAM_STR);
    $query->execute();
    $user  = $query->fetch();
    if(!empty($user)) {
        // gestion du formulaire ici dans cette condition +++
        if(!empty($_POST['submitted'])){
            $password1 = trim(strip_tags($_POST['password1']));
            $password2 = trim(strip_tags($_POST['password2']));

            // password
            if(!empty($password1)) {
                if($password1 != $password2) {
                    $errors['password'] = 'Les deux mot de passe doivent être identique';
                } elseif(mb_strlen($password1) <= 5) {
                    $errors['password'] = 'Min 6 caractères';
                }
            }else{
                $errors['password'] = 'Veuillez renseigner un mot de passe';
            }

            if(count($errors) == 0) {
                // UPDATE
                $hashpassword = password_hash($password1,PASSWORD_BCRYPT);
                $token = generateRandomString(120);
                $sql = "UPDATE users SET password = :password, token = WHERE email = :email";
                $query = $pdo->prepare($sql);
                $query->bindValue(':email' , $email, PDO::PARAM_STR);
                $query->bindValue(':password' , $hashpassword, PDO::PARAM_STR);
                $query->bindValue(':token' , $token, PDO::PARAM_STR);
                $query->execute();
                // redirection vers le connexion.php
                header('location: connexion.php');
            }
        }

    } else {
        //die('404');
    }
} else {
    //die('404');
}


?>

    <h1>Modifier votre mot de passe</h1>

    <form action="" method="post">
        <label for="password1">Nouveau mot de passe</label>
        <input type="password" name="password" id="password" value="<?php if(!empty($_POST['password']))
        { echo $_POST['password']; } ?>">
        <p class="error"><?php if(!empty($errors['password'])) { echo $errors['password']; } ?></p>

        <label for="password2">Confirmer le mot de passe</label>
        <input type="password" name="password" id="password" value="<?php if(!empty($_POST['password']))
        { echo $_POST['password']; } ?>">
        <p class="error"><?php if(!empty($errors['password'])) { echo $errors['password']; } ?></p>

        <input type="submit" name="submitted" value="modifier votre mot de passe">

    </form>

<?php include('inc/footer.php');