<?php
session_start();
include('inc/function.php');
include('inc/pdo.php');
$title = 'Mot de pass oublié';
$errors = array();
$success = false;

if (!empty($_POST['submitted'])) {

    $email = clean($_POST['email']);

    $sql = "SELECT email, token FROM users where email = :email";
    $query = $pdo->prepare($sql);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();

    if (!empty($user)) {
        $token = $user['token'];
        $email = urlencode($email);
        $html = '<a href="modif-mot-de-passe.php?token=' . $token . '$email=' . $email . '">Modifier votre mot de passe ici</a>';
        echo $html;

    } else {
        $errors['email'] = 'Veuillez renseigner un mot de passe';
    }


}


include('inc/header.php'); ?>
    <div class="clear"></div>


    <form action="" method="post" class="formulaires">
        <label id="emmp" for="email">Email *</label>
        <input type="email" name="email" id="email" value="<?php if (!empty($_POST['email'])) {
            echo $_POST['email'];
        } ?>">
        <p class="error"><?php if (!empty($errors['email'])) {
                echo $errors['email'];
            } ?></p>

        <input id="submp" type="submit" name="submitted" value="Modifier votre mot de passe">
    </form>


<?php include('inc/footer.php');