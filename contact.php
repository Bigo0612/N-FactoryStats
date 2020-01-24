<?php

session_start();

require('inc/pdo.php');
require('inc/function.php');
$title = 'Contact';

$errors = array();
$success = false;

if (!empty($_POST['submitted'])) {
    //debug($_POST);

    $email = clean($_POST['email']);
    $message = clean($_POST['message']);

    $errors = emailValid($errors, $email, 'email');
    $errors = textValid($errors, $message, 'message', 5, 2000);

    if (empty($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'Veuillez renseigner un email valide';
    }

    if (empty($message)) {
        $errors['message'] = 'Veuillez renseigner ce champ';
    } elseif (mb_strlen($message) < 5) {
        $errors['message'] = 'Min 5 caractères';
    } elseif (mb_strlen($message) > 2000) {
        $errors['message'] = 'Max 2000 caractères';
    }


    if (count($errors) == 0) {
        $sql = "INSERT INTO contact VALUES (null,:email,:message,NOW())";
        $query = $pdo->prepare($sql);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':message', $message, PDO::PARAM_STR);
        $query->execute();
        $success = true;
    }
}


include('inc/header.php');
?>

    <div class="clear"></div>


    <form action="" method="post" class="formulaires">

        <div class="formdiv">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php if (!empty($_POST['email'])) {
                echo $_POST['email'];
            } ?>">
            <p class="error"><?php if (!empty($errors['email'])) {
                    echo $errors['email'];
                } ?></p>
        </div>
        <div class="formdiv">
            <textarea placeholder="Votre message" name="message" rows="8"
                      cols="53"><?php if (!empty($_POST['message'])) {
                    echo $_POST['message'];
                } ?></textarea>
            <p class="error"><?php if (!empty($errors['message'])) {
                    echo $errors['message'];
                } ?></p>
        </div>
        <div class="formdiv">
            <input type="submit" name="submitted" value="Envoyer">
        </div>
    </form>

<?php
include('inc/footer.php');