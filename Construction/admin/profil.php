<?php
	require 'database.php';

	session_start();

	if (!empty($_GET['id'])) {
        $id = checkInput($_GET['id']);
    }

 	if(isset($_SESSION) && !empty($_SESSION)){
 		$data = Database::connect();
    	$getid = intval($_GET['id']);
    	$statement = $data->prepare("SELECT * FROM customers WHERE id=?");
		$statement->execute(array($getid));
		$query = $statement->fetch();
		Database::disconnect();
 	}
 	else
 	{
 		 header("Location: index.html");
 	}

	

 //    if (isset($_GET['id']) AND $_GET['id'] > 0) {
    	
	// }

	function checkInput($data){
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>
<!DOCTYPE html>
<html>
	<head>
	<title>Construction</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="..css/style.css">
	</head>
	<style>
		label
		{
			text-transform: uppercase;
			font-weight: bold;
			float: left;
			color: purple;
			text-shadow: 1px 1px #333;
		}
		label:hover
		{
			color: gray;
		}
		#deconnexion
	    {
	       margin-bottom: 50px;
	       float: right;
	    }
	</style>
<body>
	<div class="container">
		<a href="deconnexion.php" id="deconnexion" class="btn btn-danger"><span>Déconnexion</span></a>
		<br><br>
        <div class="card" style="width: 600px;">
          <img src="<?php echo '../images/' . $query['image'] ?>" class="rounded-circle" alt="..." style="width: 30%;">
          <ul class="list-group list-group text-center">
            <li class="list-group-item"><label>Nom: <?php echo $query['nom']; ?></label></li>
            <li class="list-group-item"><label>Prénom: <?php echo $query['lname']; ?></label></li>
            <li class="list-group-item"><label>Email: <?php echo $query['email']; ?></label></li>
            <li class="list-group-item"><label>Commune: <?php echo $query['commune']; ?></label></li>
            <li class="list-group-item"><label>Mot de passe: <?php echo $query['Pass']; ?></label></li>
            <li class="list-group-item"><label>Date: <?php echo $query['join_date']; ?></label></li>
          </ul>
        </div><br>
        <div class="form-actions">
            <a class="btn btn-primary" href="dashbord.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
	   </div>
		</div>
	</div>
</body>
</html>
<?php ?>