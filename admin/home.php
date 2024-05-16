<?php 
   session_start();

   include("php/config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: index.php");
   }


   // Fetch products from the database
   $query = "SELECT * FROM products";
   $result = mysqli_query($con, $query);


   // Check if products were retrieved successfully
   if ($result) {
       $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
   } else {
       // Handle error if products retrieval fails
       echo "Error retrieving products from database";
       exit;
   }


   // Count the number of products
   $countQuery = "SELECT COUNT(*) AS total FROM products";
   $countResult = mysqli_query($con, $countQuery);
   $productCount = mysqli_fetch_assoc($countResult)['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Home</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">Product Store</a> </p>
        </div>

        <div class="right-links">
            <a href="home.php">Home</a>
            <?php 
            
            $id = $_SESSION['id'];
            $query = mysqli_query($con,"SELECT*FROM users WHERE Id=$id");

            while($result = mysqli_fetch_assoc($query)){
                $res_Uname = $result['Username'];
                $res_Email = $result['Email'];
                $res_Age = $result['Age'];
                $res_id = $result['Id'];
            }
            
            echo "<a href='editProfile.php?Id=$res_id'>Edit Profile</a>";
            ?>
            <a href="addproducts.php">Add Product</a>
            <a href="php/logout.php">Logout</a>

        </div>
    </div>
    <main>

       <div class="main-box top">
          <div class="top">
            <div class="box">
                <p>Hello <b><?php echo $res_Uname ?></b></p>
                <p>Welcome Back</p>
            </div>
            <div class="box">
                <p><b>Number of Products</b></p>
                <p align="center"><b><?php echo $productCount; ?></b></p>
            </div>
            
          </div>

          
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Product Name</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Type</th>
                <th scope="col">Photo</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['productName']; ?></td>
                    <td><?php echo $product['productDescription']; ?></td>
                    <td><?php echo $product['productPrice']; ?></td>
                    <td><?php echo $product['productType']; ?></td>
                    <td><img src="../uploads/<?php echo $product['productPhoto']; ?>" alt="<?php echo $product['productName']; ?>" style="max-width: 100px;"></td>
                    <td>
                        <a class="btn btn-success" href='editProduct.php?id=<?php echo $product['id']; ?>'>Edit</a>
                    </td>
                    <td><button type="button" class="btn btn-danger" onclick = deleteProduct() >Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
           
          
       </div>

    </main>


    <script>

        function deleteProduct(){
            window.location.href="delete.php?id='.$product['id']'";
        }

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>