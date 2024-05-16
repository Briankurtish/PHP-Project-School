<?php 
   session_start();

   include("php/config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: index.php");
   }

   // Check if the user is logged in
    if(!isset($_SESSION['username'])) {
        // Redirect to login page
        header("Location: index.php");
        exit; // Terminate script execution after redirection
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Add Products</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">Product Store</a> </p>
        </div>

        <div class="right-links">
            <a href="home.php">Home</a>
            <a href="#">Add Product</a>
            <a href="php/logout.php"> <button class="btn">Log Out</button> </a>
        </div>
    </div>
    <div class="container">
        <div class="box form-box">
            <?php 
               if(isset($_POST['submit'])){
                $productName = $_POST['productName'];
                $productDescription = $_POST['productDescription'];
                $productPrice = $_POST['productPrice'];
                $productType = $_POST['productType'];
                $image_name = $_FILES['productPhoto']['name'];
                $temp_name = $_FILES['productPhoto']['tmp_name'];
                $folder = '../uploads/'.$image_name;
                move_uploaded_file($temp_name, $folder);


            
               
                $query = "INSERT INTO products (productName, productDescription, productPrice, productType, productPhoto) VALUES ('$productName', '$productDescription', '$productPrice', '$productType', '$image_name')";
                mysqli_query($con, $query);

                if($query){
                    echo "<div class='message'>
                    <p>Product Added Successfully!</p>
                </div> <br>";
                echo "<a href='home.php'><button class='btn'>Go Home</button>";
                }
               }else{

                $id = $_SESSION['id'];
                $query = mysqli_query($con,"SELECT*FROM users WHERE Id=$id ");

                while($result = mysqli_fetch_assoc($query)){
                    $res_Uname = $result['Username'];
                    $res_Email = $result['Email'];
                    $res_Age = $result['Age'];
                }

            ?>
            <header>Add Product</header>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="field input">
                <label for="productName">Product Name</label>
                <input type="text" name="productName" id="productName" required>
            </div>

            <div class="field input">
                <label for="email">Description</label>
                <input type="text" name="productDescription" id="productDescription" autocomplete="off" required>
            </div>

            <div class="field input">
                <label for="age">Price</label>
                <input type="number" name="productPrice" id="productPrice" autocomplete="off" required>
            </div>

            <div class="field input">
                <label for="productType">Type:</label>
                <select id="productType" name="productType" required>
                    <option value="Iphone">Iphone</option>
                    <option value="Samsung">Samsung</option>
                    <option value="MacBook">MacBook</option>
                    <option value="Ipad">Ipad</option>
                    <!-- Add more options as needed -->
                </select>
            </div>

            <div class="field input">
                <label for="productPhoto">Photos:</label>
                <input type="file" id="productPhoto" name="productPhoto" accept="image/*" multiple>
            </div>

            <div class="field">
                <input type="submit" class="btn" name="submit" value="Add Product" required>
            </div>

            
        </form>
        </div>
        <?php } ?>
      </div>
</body>
</html>