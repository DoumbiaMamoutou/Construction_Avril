<?php
    session_start();
  
    //header("Location: connexion.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>CONSTRUCTION</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    
    <body>
        <div class="container-fluid">
            <div class="row">
                <h1><strong>Listes des produits  </strong><a href="insert.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus">Ajouter</span></a></h1>
                
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prix</th>
                            <th>Categorie</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                           require 'database.php';
                            $db = Database::connect();
                            $statement = $db->query('SELECT u.id, u.name, u.price, c.name AS category FROM products AS u left JOIN product_categories AS c ON u.category = c.id ORDER BY u.id ASC');
                            while($item = $statement->fetch())
                            {
                               echo '<tr>';
                                echo '<td>'.$item['name'] . '</td>';
                                echo '<td>' . $item['price'] . '</td>';
                                echo '<td>' . $item['category'] . '</td>';
                                echo '<td width=300>';
                                echo'<a class="btn btn-default" href="view.php?id=' .$item['id'].'"><span class="glyphiconglyphicon-eye-open"></span> Voir</a>';
                                echo '<a class="btn btn-primary" href="update.php?id='.$item['id'].'"><span class="glyphiconglyphicon-pencil"></span> Modifier</a>';
                                echo '<a class="btn btn-danger" href="delete.php?id='.$item['id']. '"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
                                echo "</td>";
                                echo "</tr>";
                                
                            }
                            Database::disconnect();
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>