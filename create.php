 <?php 

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_cud','root','admin@123');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);

	$errors=[];

	$title ='';
	$price ='';
	$description='';



	if($_SERVER['REQUEST_METHOD']==='POST'){
	$title = $_POST['title'];
	$description = $_POST['description'];
	$price = $_POST['price'];
	$date =date('Y-m-d H:i:s');

	

	if(empty($title)){
		$errors[] = 'product title is required';
	} 
	if (empty($price)) {
		$errors[] = 'product price is required';
	}
	if (!is_dir('images')) {
		mkdir('images');
	}
	if (empty($errors)) {
	 $image = $_FILES['image'] ?? null;
	 $imagePath ='';
	  if ($image) {

	  	$imagePath ='images/'.randomString(8).'/'.$image['name']; 
	  	mkdir(dirname($imagePath));
	  	move_uploaded_file($image['tmp_name'],$imagePath);
	  }
	$statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
		VALUES(:title,:image,:description, :price,:date)");
	$statement->bindValue(':title',$title);
	$statement->bindValue(':image',$imagePath);
	$statement->bindValue(':description',$description);
	$statement->bindValue(':price',$price);
	$statement->bindValue(':date',$date);
	$statement->execute();
	header('Location:index.php');
	}
 }

 function randomString($n){
 	return time();
 }
  ?>


 <!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
    <title>products_CRUD</title>
  </head>

  <body>
  	 <p>
  		<a href="index.php" class="btn btn-secondary">Go Back to Products</a>
  	</p>
  	
    <h1>Create New Product</h1>

    <?php if (!empty($errors)): ?>
    
	    <div class="alert" class="alert-danger">
	    	  	<?php foreach ($errors as $error) :  ?>
	    	  		<div> <?php echo $error ?>  </div>
	    	  	<?php endforeach; ?>
	    </div>
	<?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label>Product Image</label>
    <br>
    <input type="file" name="image">
  </div>
   <div class="form-group">
    <label>Product Title</label>
    <input type="text" name ="title" class="form-control" value="<?php echo $title ?>">
  </div>
    <div class="form-group">
    <label>Product Description</label>
    <textarea class="form-control" name="description"> <?php echo $description ?> </textarea>
  </div>
    <div class="form-group">
    <label>Product price</label>
    <input type="number" step=".01" name="price" value="<?php echo $price ?>" class="form-control" > 
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
  </body>
</html>

 




















