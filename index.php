 <?php 

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_cud','root','admin@123');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);


$search = $_GET['search'] ?? '';
if ($search) {
   
  $Statement = $pdo ->prepare('SELECT * FROM products WHERE title LIKE :title ORDER BY create_date DESC');
    $Statement->bindValue(':title',"%$search%");
}else{

  $Statement = $pdo ->prepare('SELECT * FROM products ORDER BY create_date DESC');
}

$Statement ->execute();
$products = $Statement ->fetchAll(PDO :: FETCH_ASSOC);

  ?>


 <!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

     <style>
          body, html {
            height: 100%;
            margin: 0;
          }

          .bg {
            /* The image used */
            background-image: url("wellcome.jpg");

            /* Full height */
            height: 50%; 

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
          }
    </style>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
    <title>products_CRUD</title>
  </head>
  <body style="background-color: #CCCCFF;">
      <div class="bg"></div>
    <h1>Products CRUD</h1>

    <p>
      <a href="Create.php"  class="btn-success">create product</a>
    </p>
    <form>
      
    <div class="input-group mb-3">
  <input type="text" class="form-control" placeholder="Search for products" name="search">
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="submit">Search</button>
  </div>
</div>

    </form>
 

    <table class="w-100 table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">Title</th>
      <th scope="col">price</th>
      <th scope="col">Create_date</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($products as $i => $product): ?>
      <tr>
          <th scope="row"><?php echo $i +1 ?></th>
          <td>
            <img class="thumb-image" src="<?php echo $product['image'] ?>">
          </td>
          <td><?php echo $product['title'] ?></td>
          <td><?php echo $product['price'] ?></td>
          <td><?php echo $product['create_date'] ?></td>
          <td>
           <a href="update.php?id=<?php echo $product['id'] ?>"  class="btn btn-sm btn-outline-primary">Edit</a> 
           <form style ="display: inline-block" method="post" action="delet.php">
            <input type="hidden" name="id" value="<?php echo $product['id'] ?>"> 
              <button type="submit" class="btn btn-sm btn-outline-danger">Delet</button> 
           </form>

           
          </td>           
    </tr>
  <?php endforeach; ?>



  

  </tbody>
</table>
  
  </body>
</html>