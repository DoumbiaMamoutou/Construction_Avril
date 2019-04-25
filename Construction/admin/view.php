<?php
	require 'database.php';

	if (!empty($_GET['id'])) {
        $id = checkInput($_GET['id']);
    }

    if (isset($_GET['id']) AND $_GET['id'] > 0) {
    	$data = Database::connect();
    	$getid = intval($_GET['id']);
    	$statement = $data->prepare("SELECT * FROM products WHERE id=?");
		$statement->execute(array($getid));
		$result = $statement->fetch();
		Database::disconnect();
	}


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
	<title>Profil</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="..css/style.css">
	</head>
<body>
	<div class="container-fluid">
		<br><br>
        <div class="card" style="max-width: 600px;">
          <img src="<?php echo '../sql/image/' . $result['image'] ?>" class="rounded-circle" alt="..." style="width: 30%;">
          <ul class="list-group list-group text-center">
            <li class="list-group-item"><label>Nom: <?php echo $result['name']; ?></label></li>
            <li class="list-group-item"><label>Prix: <?php echo $result['price']; ?></label></li>
            <li class="list-group-item"><label>Category: <?php echo $result['category']; ?></label></li>
            <li class="list-group-item"><label>Date: <?php echo $result['create_date']; ?></label></li>
          </ul>
        </div><br>
        <div class="form-actions">
            <a class="btn btn-primary" href="table.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
	   </div>
		</div>
	</div>
</body>
</html>
<?php ?>