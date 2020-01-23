<?php
session_start();
require('../inc/pdo.php');
require('../inc/function.php');

$errors = array();
$success = false;

$sql = "SELECT * from users WHERE 1";
$query = $pdo->prepare($sql);
$query->execute();
$users = $query->fetchALL();

$sql = "SELECT * FROM users";
$query = $pdo->prepare($sql);
$query->execute();
$user = $query->fetchAll();


if(!empty($_POST['submitted'])) {

    $email = trim(strip_tags($_POST['email']));
    $password1 = trim(strip_tags($_POST['password1']));
    $password2 = trim(strip_tags($_POST['password2']));


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

        header('location: tables.php');
    }
}

if (!empty($_POST['desactive'])) {
    $i= 0;
    $id = $user[$i]['id'];
    $sql = "DELETE FROM users WHERE  id = $id";
    $query = $pdo->prepare($sql);
    $query->execute();
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

  <title>Admin NFactoryShool - Tables</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="index.php">NFactoryStats</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Rechercher..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw"></i>
          <span class="badge badge-danger"></span>
        </a>

      </li>
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-envelope fa-fw"></i>
          <span class="badge badge-danger"></span>
        </a>

      </li>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Se déconnecter</a>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Tableau de bord</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pages</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Écrans de connexion:</h6>
          <a class="dropdown-item" href="login.php">S'identifier</a>
          <a class="dropdown-item" href="register.php">S'inscrire</a>
          <a class="dropdown-item" href="forgot-password.php">Mot de passe oublié</a>
      </li>

      <li class="nav-item active">
        <a class="nav-link" href="tables.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li>
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Tableau de bord</a>
          </li>
          <li class="breadcrumb-item active">Tables</li>
        </ol>

        <!-- DataTables Example -->

              <h2>désactiver un utilisateur:</h2>

              <div class="card mb-4">
                  <div class="card-header">
                      <i class="fas fa-table"></i>

                      Tableau de données</div>
                  <div class="card-body">
                      <div class="table-responsive">
                          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                              <thead>
                              <tr>
                                  <th>Id</th>
                                  <th>Email</th>
                                  <th>role</th>
                                  <th>Date</th>
                              </tr>
                              </thead>
                              <tfoot>
                              <tr>
                                  <th>Id</th>
                                  <th>Email</th>
                                  <th>role</th>
                                  <th>Date</th>
                              </tr>
                              </tfoot>
                              <tbody>
                              <?php
                              echo '<tr>'; ?>
                              <form action="tables.php" name="desactive" method="post"> <?php
                                  for ($i = 0; $i < count($user); $i++) {
                                  echo '<td>' . $user[$i]['id'] . '</td>';
                                  echo '<td>' . $user[$i]['email'] . '</td>';
                                  echo '<td>' . $user[$i]['role'] . '</td>';
                                  echo '<td>' . $user[$i]['created_at'] . '</td>';
                                  echo '<td>' . '<input type="submit" name="desactive" id="' . $user[$i]['id'] . '" value="desactiver ' . $user[$i]['id'] . '">'.'</td>';
                                  ?>
                              </form> <?php
                              echo '</tr>';} ?>
                              </tbody>
                          </table>
                      </div>
                  </div>

                  <h2>Edition d'un utilisateur:</h2>

                  <div class="card mb-5">
                      <div class="card-header">
                          <i class="fas fa-table"></i>

                          Tableau de données</div>
                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                  <thead>
                                  <tr>
                                      <th>Email</th>
                                      <th>Role</th>
                                      <th>Edition</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <?php foreach ($users as $key => $user): ?>
                                      <tr>
                                          <td><?php echo $user['email']; ?></td>
                                          <td><?php echo $user['role'] ?></td>
                                          <td><a class="btn btn-success"href="edit_user.php?id=<?php echo $user['id'] ?>">EDITION</a></td>
                                      </tr>
                                  <?php endforeach; ?>
                                  </tbody>
                              </table>
                          </div>
                      </div>

        <div class="card-footer small text-muted">Mis à jour hier à 23h59</div>
                  </div>

              </div>
          <!-- /.container-fluid -->

          <!-- Sticky Footer -->
          <footer class="sticky-footer">
              <div class="container my-auto">
                  <div class="copyright text-center my-auto">
                      <span>&copy; 2020 - NFactoryStats &reg;</span>
                  </div>
              </div>
          </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Prêt à partir?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Sélectionnez "Déconnexion" ci-dessous si vous êtes prêt à terminer votre session en cours.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
          <a class="btn btn-primary" href="login.php">Se déconnecter</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
