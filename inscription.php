<?php
session_start();
require('inc/pdo.php');
require('inc/function.php');
$title = 'inscription';
$errors = array();
$success = false;

// traiement de formulaire
if(!empty($_POST['submitted'])) {
    //die('ok');

    // Faille XSS
    $email = trim(strip_tags($_POST['email']));
    $password1 = trim(strip_tags($_POST['password1']));
    $password2 = trim(strip_tags($_POST['password2']));


/////////////////////////////////
// Validation
///////////////////////////////


    // email
    if(filter_var($email,FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'Veuillez renseigner un email valide';
    }else{
        //no error
        $sql = "SELECT id FROM users WHERE email = :mail LIMIT 1";
        $query = $pdo->prepare($sql);
        $query->bindValue(':mail' ,$email,PDO::PARAM_STR);
        $query->execute();
        $verifemail = $query->fetch();
        if(!empty($verifemail)) {
            $errors['pseudo'] = 'cet email existe déjà!';
        }
    }
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
        // password hash
        $hashpassword = password_hash($password1,PASSWORD_BCRYPT);
        $token = generateRandomString(120);
        // insert
        $sql = "INSERT INTO users VALUES (null,:email,:password,:token,NOW())";
        $query = $pdo->prepare($sql);
        $query->bindValue(':email' , $email, PDO::PARAM_STR);
        $query->bindValue(':password' , $hashpassword, PDO::PARAM_STR);
        $query->bindValue(':token' , $token, PDO::PARAM_STR);
        $query->execute();
        $success = true;
        // redirection vers la connection
        header('location: connexion.php');
    }
}
//debug($_POST);
//debug($errors);

?>

    <h1>Inscription</h1>

    <form action="inscription.php" method="post" autocomplete="off">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>">
        <p class="error"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></p>

        <label for="password1">Mot de passe</label>
        <input type="password" name="password1" id="password1" value="">
        <p class="error"><?php if(!empty($errors['password'])) { echo $errors['password']; } ?></p>

        <label for="password2">confirmer mot de passe</label>
        <input type="password" name="password2" id="password2" value="">

        <input type="submit" name="submitted" value="Inscrivez vous">
    </form>



<?php include('inc/footer.php');