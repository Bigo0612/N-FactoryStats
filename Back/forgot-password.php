<?php
session_start();
include ('../inc/function.php');
include ('../inc/pdo.php');
$title = 'Mot de pass oublié';
$errors = array();
$success = false;

if (!empty($_POST['submitted'])) {

    $email = clean($_POST['email']);

    $sql = "SELECT email, token FROM users where email = :email";
    $query = $pdo->prepare($sql);
    $query->bindValue(':email',$email,PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();

    if (!empty($user)) {
        $token = $user['token'];
        $email = urlencode($email);
        $html = '<a href="modif-mot-de-passe.php?token='.$token.'$email='.$email.'">Modifier votre mot de passe ici</a>';
        echo $html;

    } else {
        $errors['email'] = 'Veuillez renseigner un mot de passe';
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

  <title>Admin N'FactroryStats - mot de passe oublié</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">réinitialiser le mot de passe</div>
      <div class="card-body">
        <div class="text-center mb-4">
          <h4>Mot de passe oublié?</h4>
          <p>Entrez votre adresse e-mail et nous vous enverrons des instructions sur la façon de réinitialiser votre mot de passe.</p>
        </div>
        <form>
          <div class="form-group">
            <div class="form-label-group">
              <input type="email" id="inputEmail" class="form-control" placeholder="Entrer votre adresse email" required="required" autofocus="autofocus">
              <label for="inputEmail">Entrer votre adresse email</label>
            </div>
          </div>
          <a class="btn btn-primary btn-block" href="login.php">réinitialiser le mot de passe</a>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="register.php">Créer un compte</a>
          <a class="d-block small" href="login.php">Page de connexion</a>
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
