<?php
session_start();
require('../inc/pdo.php');
require('../inc/function.php');
$title = 'login';
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


?>

<!DOCTYPE html>
<html lang="fr">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin NFactoryStats - Connexion</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">S'identifier</div>
      <div class="card-body">
        <form>
          <div class="form-group">
            <div class="form-label-group">
              <input type="email" id="inputEmail" class="form-control" placeholder="Email" required="required" autofocus="autofocus">
              <label for="inputEmail">Email</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="inputPassword" class="form-control" placeholder="Mot de passe" required="required">
              <label for="inputPassword">Mot de passe</label>
            </div>
          </div>
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" value="Se souvenir de moi">
                Se souvenir de moi
              </label>
            </div>
          </div>
          <a class="btn btn-primary btn-block" href="index.php">S'identifier</a>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="register.php">Créer un compte</a>
          <a class="d-block small" href="forgot-password.php">Mot de passe oublié?</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
