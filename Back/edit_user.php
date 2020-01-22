<?php
session_start();
require('../inc/pdo.php');
require('../inc/function.php');

$title = 'Edit user';
$errors = array();


if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $user = $query->fetch();
    if(!empty($user)) {

        if(!empty($_POST['submitted'])){



                $email1 = clean($_POST['email1']);

                if (!empty($email1)) {
                    if (!filter_var($email1, FILTER_VALIDATE_EMAIL)) {
                        $errors['email'] = 'email invalide';
                    }
                } else {
                    $errors['email'] = 'Entrez un email!';
                }

                    if (count($errors) == 0) {

                        $sql = " UPDATE users SET email = :email, created_at = NOW() WHERE id = :id";
                        $query = $pdo->prepare($sql);
                        $query->bindValue(':email', $email1, PDO::PARAM_STR);
                        $query->bindValue(':id', $id, PDO::PARAM_INT);
                        $query->execute();
                        header('Location: tables.php');
                    }
            }
        } else {
        die('404');
    }

} else {
    die('404');
}

 ?>

<h1>Editer un utilisateur</h1>

<?php
if (!empty($id)) {
    if (!empty($_GET['id'])) { ?>
        <form action="" method="post">
            <label for="email1"> Entrer un nouvel email: </label>
            <input type="text" name="email1" id="email1" value="<?php echo $user['email'] ?>">
            <p class="error"><?php if (!empty($errors['email'])) {
                    echo $errors['email'];
                } ?></p>

            <input type="submit" name="submitted" value="Editer">
        </form>
    <?php } else {
        echo 'Error 404';
    }
}
