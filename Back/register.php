<?php
session_start();
require('../inc/pdo.php');
require('../inc/function.php');
$title = 'register';
$errors = array();
$success = false;


if(!empty($_POST['submitted'])) {



    $email = trim(strip_tags($_POST['email']));
    $password1 = trim(strip_tags($_POST['password1']));
    $password2 = trim(strip_tags($_POST['password2']));
    $cgu       = trim(strip_tags($_POST['cgu']));


    if(filter_var($email,FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'Veuillez renseigner un email valide';
    }else{

        $sql = "SELECT id FROM users WHERE email = :mail LIMIT 1";
        $query = $pdo->prepare($sql);
        $query->bindValue(':mail' ,$email,PDO::PARAM_STR);
        $query->execute();
        $verifemail = $query->fetch();
        if(!empty($verifemail)) {
            $errors['pseudo'] = 'cet email existe déjà!';
        }
    }

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

        $hashpassword = password_hash($password1,PASSWORD_BCRYPT);
        $token = generateRandomString(120);

        $sql = "INSERT INTO users VALUES (null,:email,:password,:token,'abonne',NOW())";
        $query = $pdo->prepare($sql);
        $query->bindValue(':email' , $email, PDO::PARAM_STR);
        $query->bindValue(':password' , $hashpassword, PDO::PARAM_STR);
        $query->bindValue(':token' , $token, PDO::PARAM_STR);
        $query->execute();
        $success = true;

        header('location: login.php');
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

  <title>Admin NFactoryStats - Inscription</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Créer un compte</div>
      <div class="card-body">
        <form>

          <div class="form-group">
            <div class="form-label-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>">
                <p class="error"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></p>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <div class="form-label-group">
                    <label for="password1">Mot de passe</label>
                    <input type="password" name="password1" id="password1" value="">
                    <p class="error"><?php if(!empty($errors['password'])) { echo $errors['password']; } ?></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-label-group">
                    <label for="password2">Confirmer le mot de passe</label>
                    <input type="password" name="password2" id="password2" value="">
                    <p class="error"><?php if(!empty($errors['password2'])) { echo $errors['password2']; } ?></p>
                </div>
              </div>
            </div>
          </div>
          <a class="btn btn-primary btn-block" href="login.php">S'inscrire</a>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="login.php">Page de connexion</a>
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
