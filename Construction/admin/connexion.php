<?php

  session_start();

  require 'database.php';
  $database = Database::connect();

  if (!empty($_POST)){
    $email = checkInput($_POST['email']);
    $pass = checkInput($_POST['pass']);

    if (!isEmail($email)) {
      $emailError = "ceci n'est pas un email";
      $isSuccess = false;
    }
    if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.\W).{4,}$#', $pass)) {
      //echo "mot de conforme";
    }
    else
    {
      //echo "mot de passe non conforme";
    }
    if (count($_POST) > 0) {
      $statement = $database->prepare("SELECT * FROM customers WHERE email=? AND Pass=?");
      $statement->execute(array($email,$pass));
      $connect = $statement->rowCount();
      if ($connect == 1) {
        $result = $statement->fetch();
        $_SESSION['id'] = $result['id'];
        $_SESSION['email'] = $result['email'];
        $_SESSION['pass'] = $result['pass'];        
      }
      else
      {
        die('mot de passe incorrect');
      }
      
    }
    Database::disconnect();
    header("Location: dashbord.php");
  }

  function isEmail($var){
    return filter_var($var, FILTER_VALIDATE_EMAIL);
  }


  
//   if(isset($_POST) && isset($_POST['email']) && isset($_POST['pass'])){
//   $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
 
//   $query = $database->prepare("SELECT * FROM customers WHERE email=? and pass=? ");
//   $query->execute(array($email,$pass));

//   if($connect=$query->fetchAll()){
//     header("Location: dashbord.php");
//   }else{
//     die('mot de passe incorrect');
//   }
//   Database::disconnect();
//   }
// }

  function checkInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>CONNEXION</title>
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
    .login-form input[type="email"]{
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
    <h1>Connexion</h1>
    <form action="" method="POST">
      <input type="email" name="email" placeholder="Votre email">
      <input type="password" name="pass" placeholder="Mot de passe">
      <input type="submit">
    </form>
  </div>
</body>
</html>