<?php 
	// require 'database.php';
	// session_start();
 // 	if(isset($_SESSION) && !empty($_SESSION)){
 //     header("Location: ../index.html");
	// }
?>
<!DOCTYPE html>
<html>
<head>
	<title>CONSTRUCTION</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<script type="text/javascript" src="js/bootstrap.js"></script>
</head>
<body>
	<div class="container">
		<?php

			require 'database.php';

			echo '<ul class="nav nav-pills">';

			$db = Database::connect();
            $statement = $db->query('SELECT * FROM product_categories');
            $categories = $statement->fetchAll();
            foreach ($categories as $category) 
            {
            	if($category['id'] == '1')
            		echo '<li class="nav-item"><a class="nav-link active" href="#'. $category['id'] . '">' . $category['name'] .'</a></li>';
            	else
            		echo '<li class="nav-item"><a class="nav-link" href="#'. $category['id'] . '">' . $category['name'] .'</a></li>';
            }
            echo '<li class="nav-item"><a class="nav-link" href="profil.php?id=' .$category['id'].'">PROFIL</a></li>';
            echo '</ul>';

            echo '<div class="row">';
            foreach ($categories as $category) 
            {
            	echo '<section id="' . $category['id'] .'">';

            	echo '<div class="row">';
            	$statement = $db->prepare('SELECT * FROM products WHERE products.category = ?');
                $statement->execute(array($category['id']));
                while ($item = $statement->fetch()) 
                {
                	echo '<div class="col-md-4">
					<!-- Card Narrower -->
					<div class="card card-cascade narrower">

					  <!-- Card image -->
					  	<div class="view view-cascade overlay">
					    <img  class="card-img-top" src="../sql/image/' . $item['image'] . '" alt="Card image cap">
					    <a>
					    <div class="mask rgba-white-slight"></div>
					    </a>
					  	</div>

					  <!-- Card content -->
					  <div class="card-body card-body-cascade">

					    <!-- Title -->
					    <h4 class="font-weight-bold card-title">' . $item['name'] . '</h4>
					    <!-- Text -->
					    <div class="price text-center">' . $item['price']  . 'F</div>
					    <!-- Button -->
					    <a class="btn btn-primary">COMMANDER</a>

					  </div>

					</div>
					<!-- Card Narrower -->
				</div>';
                }
                echo    '</section>
                        </div>';
            }
             Database::disconnect();
                echo  '</div>';
		?>
		</div>
	</body>
</html>