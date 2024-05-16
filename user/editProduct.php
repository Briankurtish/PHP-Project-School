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

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch product details from the database
    $query = "SELECT * FROM products WHERE id=$id";
    $result = mysqli_query($con, $query);
    
    if(mysqli_num_rows($result) == 1) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "Product not found";
        exit;
    }
} else {
    echo "Invalid product ID";
    exit;
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Edit Product</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php"> Logo</a></p>
        </div>

        <div class="right-links">
            <a href="#">Edit Product</a>
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
                    $productPhoto = $_POST['productPhoto'];
                
                    // Update product details in the database
                    $query = "UPDATE products SET productName='$productName', productDescription='$productDescription', productPrice='$productPrice', productType='$productType', productPhoto='$productPhoto' WHERE id=$id";
                    $result = mysqli_query($con, $query);
                
                    if($result){
                        echo "<div class='message'>
                            <p>Product Updated Successfully!</p>
                        </div> <br>";
                        echo "<a href='home.php'><button class='btn'>Go Home</button>";
                    } else {
                        echo "Error updating product: " . mysqli_error($con);
                    }
                }
            ?>

            <header>Edit Product</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="productName">Product Name</label>
                    <input type="text" name="productName" id="productName" value="<?php echo $product['productName']; ?>" required>
                </div>

                <div class="field input">
                    <label for="productDescription">Description</label>
                    <input type="text" name="productDescription" id="productDescription" value="<?php echo $product['productDescription']; ?>" required>
                </div>

                <div class="field input">
                    <label for="productPrice">Price</label>
                    <input type="number" name="productPrice" id="productPrice" value="<?php echo $product['productPrice']; ?>" required>
                </div>

                <div class="field input">
                    <label for="productType">Type:</label>
                    <select id="productType" name="productType" required>
                        <option value="Meals" <?php if($product['productType'] == 'Meals') echo 'selected'; ?>>Meals</option>
                        <option value="Drinks" <?php if($product['productType'] == 'Drinks') echo 'selected'; ?>>Drinks</option>
                        <option value="Starters" <?php if($product['productType'] == 'Starters') echo 'selected'; ?>>Starters</option>
                        <option value="Desserts" <?php if($product['productType'] == 'Desserts') echo 'selected'; ?>>Desserts</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>

                <div class="field input">
                    <label for="productPhoto">Photos:</label>
                    <input type="file" id="productPhoto" name="productPhoto" accept="image/*" value="<?php echo $product['productPhoto']; ?>" multiple>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Update Product">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
