<?php
    require 'database.php';

    $error = [];

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
        if($isUploadSuccess) 
        {
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO products (name,price,category,image,create_date) VALUES(?, ?, ?, ?, ?)");
            $statement->execute(array($name,$price,$category,$image,$date));
            $result = $statement->fetchAll();
            Database::disconnect();
            header("Location: table.php");
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
            <h1><strong>Ajouter un produit</strong></h1>
            <br>
            <form class="form" role="form" action="insert.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Nom:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="">
                </div>
                <div class="form-group">
                    <label for="price">Prix:</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="Prix" value="">
                </div>
                <div class="form-group">
                    <label for="category">Catégories:</label>
                    <select class="form-control" id="category" name="category">
                        <?php
                            $db = Database::connect();
                            foreach($db->query('SELECT * FROM product_categories') as $row)
                            {
                                echo '<option value="'. $row['id'] .'">' . $row['name'] . '</option>';
                            }
                            Database::disconnect();
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">Sélectionner une image:</label>
                    <input type="file" id="image" name="image">
                </div>
                <div class="form-group">
                    <label for="date">Date de depôt:</label>
                    <input type="date" id="date" name="date">
                </div>
                    <br>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Ajouter</button>
                    <a class="btn btn-primary" href="table.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>