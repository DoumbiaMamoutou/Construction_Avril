<?php
	require 'database.php';


	if (!empty($_GET['id'])) {
        $id = checkInput($_GET['id']);
    }

    if(!empty($_POST))
    {
        $name = checkInput($_POST['name']);
        $price = checkInput($_POST['price']);
        $category = checkInput($_POST['category']);
        $date = checkInput($_POST['date']);
        $image = checkInput($_FILES['image']['name']);
        $imagePath  = '../sql/image/' . basename($image);
        $imageExtension  = pathinfo($imagePath, PATHINFO_EXTENSION);
        $isUploadSuccess = false;
        
        if (empty($name) && empty($price) && empty($category) && empty($date) && empty($image)) {
            $error[] = "Erreur !";
        }

        else
        {
            $isUploadSuccess = true;
            if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" ) 
            {
                $imageError = "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
                $isUploadSuccess = false;
            }
            if(file_exists($imagePath)) 
            {
                $imageError = "Le fichier existe deja";
                $isUploadSuccess = false;
            }
            if($_FILES["image"]["size"] > 500000) 
            {
                $imageError = "Le fichier ne doit pas depasser les 500KB";
                $isUploadSuccess = false;
            }
            if($isUploadSuccess) 
            { if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) 
                {
                    $imageError = "Il y a eu une erreur lors de l'upload";
                    $isUploadSuccess = false;
                } 
            } 
            
        }
        if (($isImageUpdated && $isUploadSuccess) || (!$isImageUpdated))
        {
        	$db = Database::connect();
            if($isImageUpdated)
            {
            	$statement = $db->prepare("UPDATE products  set name = ?, price = ?, category = ?, image = ?, create_date=? WHERE id = ?");
                $statement->execute(array($name,$price,$category,$image,$date,$id));
            }
            else
            {
            	$statement = $db->prepare("UPDATE products  set name = ?, price = ?, category = ?, image = ?, create_date=? WHERE id = ?");
                $statement->execute(array($name,$price,$category,$image,$date,$id));
            }
            Database::disconnect();
            header("Location: table.php");
        }
        else if($isImageUpdated && !$isUploadSuccess)
        {
        	$db = Database::connect();
            $statement = $db->prepare("SELECT * FROM products where id = ?");
            $statement->execute(array($id));
            $item = $statement->fetch();
            $image          = $item['image'];
            Database::disconnect();
        }
    }
    else
    {
    	$db = Database::connect();
        $statement = $db->prepare("SELECT * FROM products where id = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $name           = $item['name'];
        $price          = $item['price'];
        $category       = $item['category'];
        $image          = $item['image'];
        $date           = $item['create_date'];
        Database::disconnect();
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
	<title>Construction</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
</head>
<body>
	<div class="container">
        <div class="row">
            <h1><strong>Modifier un produit</strong></h1>
            <br>
            <form class="form" role="form" action="<?php echo 'update.php?id='.$id;?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Nom:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name;?>">
                </div>
                <div class="form-group">
                    <label for="price">Prix:</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price;?>">
                </div>
                <div class="form-group">
                    <label for="category">Catégories:</label>
                    <select class="form-control" id="category" name="category">
                        <?php
                            $db = Database::connect();
                            foreach($db->query('SELECT * FROM product_categories') as $row)
                            {
                                if($row['id'] == $category)
                                    echo '<option selected="selected" value="'. $row['id'] .'">'. $row['name'] . '</option>';
                                else
                                    echo '<option value="'. $row['id'] .'">'. $row['name'] . '</option>';
                            }
                            Database::disconnect();
                        ?>
                    </select>
                </div>
                <div class="form-group">
                	<label for="image">Image:</label>
                    <p><?php echo $image;?></p>
                    <label for="image">Sélectionner une nouvelle image:</label>
                    <input type="file" id="image" name="image">
                </div>
                <div class="form-group">
                    <label for="date">Date de depôt:</label>
                    <input type="date" id="date" name="date" value="<?php echo $date;?>">
                </div>
                    <br>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
                    <a class="btn btn-primary" href="table.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>