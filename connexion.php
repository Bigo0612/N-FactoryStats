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

                //debug($session);
                header('Location: index.php');

            } else {
                $errors['email'] = 'email inconnu ou mot de passe oublié';
            }
        } else {
            $errors['email'] = 'email inconnu';
        }
    }
}


?>

    <h1>connexion</h1>

    <form action="connexion.php" method="post">

        <label for="email">email</label>
        <input type="text" name="email" id="email" value="<?php if(!empty($_POST['email']))
        { echo $_POST['email']; } ?>">
        <p class="error"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></p>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" value="">

        <input type="submit" name="submitted" value="connexion">
    </form>

    <a href="modif-mot-de-passe.php">Mot de passe oublié</a>
<?php include('inc/footer.php');