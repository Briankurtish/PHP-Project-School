<?php 
    session_start();

    include("php/config.php");
    if(!isset($_SESSION['valid'])){
        header("Location: index.php");
    }

    // Fetch products from the database
    $query = "SELECT * FROM products";
    $result = mysqli_query($con, $query);

    // Check if the 'cart' session variable exists, if not, initialize it as an empty array
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
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
            <?php 
                $id = $_SESSION['id'];
                $query = mysqli_query($con,"SELECT * FROM admin WHERE Id=$id");

                while($result = mysqli_fetch_assoc($query)){
                    $res_Uname = $result['Username'];
                    $res_Email = $result['Email'];
                    $res_id = $result['Id'];
                }
            
                echo "<a href='editProfile.php?Id=$res_id'>Edit Profile</a>";
            ?>
            <a href="viewCart.php">View cart</a>
            <a href="php/logout.php">Logout</a>
        </div>
    </div>

    <main>
        <div class="main-box top">
            <div class="bottom">
                <div class="box">
                    <h2><b>Cart Items</b></h2>
                </div>

                <div class="card w-100">
                <?php 
                    if (!empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $productId) {
                            // Retrieve product details by product ID
                            $query = "SELECT * FROM products WHERE id = $productId";
                            $result = mysqli_query($con, $query);
                            $product = mysqli_fetch_assoc($result);

                            // Display product details
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . $product['productName'] .'</h5>';
                            echo '<p class="card-text">' . $product['productDescription'] . '</p>';
                            echo '<a href="#" class="btn btn-primary">' . "$" . $product['productPrice'] .'</a>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="alert alert-warning" role="alert">Your cart is empty.</div>';
                    }
                ?>
                </div>
                                    
            </div>
            
            
            
        </div>
    </main>

    <script>
        function deleteProduct() {
            window.location.href="delete.php?id='.$product['id']'";
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
