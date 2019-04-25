<?php

  session_start();
  require 'admin/database.php';

  $database = Database::connect();

  $commune = $database->prepare("SELECT * FROM customer_addresses");
  $commune->execute(array());
  $liste_commune = $commune->fetchAll();

  $error = [];


  if (!empty ($_POST)) {
    $nom = checkInput($_POST['nom']);
    $lname = checkInput($_POST['lname']);
    $email = checkInput($_POST['email']);
    $join_date = checkInput($_POST['join_date']);
    $pass = checkInput($_POST['pass']);
    $commune = checkInput($_POST['commune']);
    $image = checkInput($_FILES['image']['name']);
    $imagePath  = 'images/' . basename($image);
    $imageExtension  = pathinfo($imagePath, PATHINFO_EXTENSION);
    $isUploadSuccess = false;

    if (empty($nom) && empty($lname) && empty($email) && empty($pass) && empty($join_date) && empty($commune) && empty($image)) {
      $error[] = "Erreur Oup !";
    }
    else {
      $isUploadSuccess = true;
      if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" ) {
          $imageError = "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
          $isUploadSuccess = false;
        }
        if(file_exists($imagePath)) {
          $imageError = "Le fichier existe deja";
          $isUploadSuccess = false;
        }
        if($_FILES["image"]["size"] > 500000) {
          $imageError = "Le fichier ne doit pas depasser les 500KB";
          $isUploadSuccess = false;
        }
        if($isUploadSuccess) { 
          if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
            $imageError = "Il y a eu une erreur lors de l'upload";
            $isUploadSuccess = false;
          } 
        }       
      }
    if (count($error) == 0) {
      $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

       $query = $database->prepare("INSERT INTO customers (nom, lname, email, commune, Pass, image, join_date) VALUES(?, ?, ?, ?, ?, ?, ?)");
       $result = $query->execute(array($nom,$lname,$email,$commune,$pass,$image,$join_date));

       if ($result) {
          $_SESSION['success'] = true;
        }else{
          $_SESSION['error'] = true;
        }
        Database::disconnect();
      header("Location: admin/connexion.php");
    }

   }

   function checkInput($data)
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

?>
<!DOCTYPE html>
<html>
<head>
  <title>INSCRIPTION</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <style>
    .login-form{
      width: 300px;
      margin: 0 auto;
      font-family: Tahoma, Geneva, sans-serif;
    }
    .login-form h1{
      text-align: center;
      color: #4d4d4d;
      font-size: 24px;
      padding: 20px 0 20px 0;
    }
    .login-form input[type="password"],
    .login-form input[type="text"],
    .login-form input[type="email"],
    .login-form input[type="number"],
    .login-form input[type="date"],
    .login-form input[type="file"],
    .login-form select{
      width: 100%;
      padding: 15px;
      border: 1px solid #ddd;
      margin-bottom: 15px;
      box-sizing: border-box;
    }
    .login-form input[type="submit"]{
      width: 100%;
      padding: 15px;
      background-color: #535b63;
      border: 0;
      box-sizing: border-box;
      cursor: pointer;
      font-weight: bold;
      color: #fff;
    }
  </style>
</head>
<body>
  <div class="login-form">
    <h1>INSCRIPTION</h1>
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success" role="alert">
        Félicitation!
      </div>
    <?php unset($_SESSION['success']); ?>
    <?php endif ?>
      
    <?php if (isset($_SESSION['error'])): ?>  
      <div class="alert alert-danger" role="alert">
        Oup!
      </div>
      <?php unset($_SESSION['error']); ?>
      <?php endif ?>

      <?php if ($error): ?>
        <?php foreach ($error as $value): ?>
          <div class="alert alert-danger" role="alert">
            <?= $value ?>
          </div>
      <?php endforeach ?>
      <?php endif ?>
    <form role="form" method="POST" enctype="multipart/form-data">
      <input type="text" name="nom" id="nom" placeholder="Votre nom">
      <input type="text" name="lname" id="lname" placeholder="Votre prénom">
      <input type="email" name="email" id="email" placeholder="Votre email">
      <input type="password" name="pass" id="pass" placeholder="Password">
      <input type="file" name="image" id="image">
      <input type="date" name="join_date" placeholder="Date de votre commande">
      <select name="commune" class="form-control">
        <?php 
          foreach ($liste_commune as $commune):
            $commune_address = $commune['address'];
            $commune_id = $commune['id'];
         ?>
        <option value="<?=  $commune_address;?>"><?=  $commune_address;?></option>
        <?php endforeach; ?>
      </select>
      <input type="submit"> 
    </div>
    </form>
    
  </div>
</body>
</html>