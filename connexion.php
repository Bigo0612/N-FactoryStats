<?php
session_start();
require('inc/pdo.php');
require('inc/function.php');
$title = 'connexion';
$errors = array();
$success = false;

if(!empty($_POST['submitted'])) {

    $email    = trim(strip_tags($_POST['email']));
    $password = trim(strip_tags($_POST['password']));

    if(empty($email) || empty($password)) {
        $errors['email'] = 'Veuillez renseigner ces champs';
    } else {
        $sql = "SELECT * FROM users WHERE email=:email";
        $query = $pdo->prepare($sql);
        $query -> bindValue(':email',$email,PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch();
        if(!empty($user)) {

            if(password_verify($password,$user['password'])) {

                $_SESSION['email'] = array(
                    'id'    => $user['id'],
                    'email'=> $user['email'],
                    'role'  => $user['role'],
                    'ip'    => $_SERVER['REMOTE_ADDR']
                );

                header('Location: index.php');

            } else {
                $errors['email'] = 'email inconnu ou mot de passe oublié';
            }
        } else {
            $errors['email'] = 'email inconnu';
        }
    }
}

include('inc/header.php');
?>

<div class="clear"></div>

    <h1 class="h1form">connexion</h1>

    <form action="connexion.php" method="post" class="formulaires">

        <div class="formdiv">
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="<?php if(!empty($_POST['email']))
        { echo $_POST['email']; } ?>">
        <p class="error"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></p>
        </div>
        <div class="formdiv">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" value="">
        </div>
        <div class="formdiv">
        <input type="submit" name="submitted" value="Connexion">
        </div>
    </form>

    <a id="mpoublie" href="mot-de-passe-oublie.php">Mot de passe oublié</a>

<div class="clear"</div>
<?php include('inc/footer.php');