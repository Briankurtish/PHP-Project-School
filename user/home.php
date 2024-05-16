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

   // Check if the 'cart' session variable exists, if not, initialize it as an empty array
   if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
    }

    // Check if a product is added to the cart
    if (isset($_POST['add_to_cart'])) {
        // Get the product ID
        $product_id = $_POST['product_id'];

        // Add the product to the cart
        if (!in_array($product_id, $_SESSION['cart'])) {
            $_SESSION['cart'][] = $product_id;
        }
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



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Function to filter products based on product type
        $("#productType").change(function() {
            filterProducts();
        });

        // Function to filter products based on search query
        $("#search").keyup(function() {
            filterProducts();
        });

        function filterProducts() {
            var selectedType = $("#productType").val().toLowerCase();
            var searchQuery = $("#search").val().toLowerCase();

            $(".card").each(function() {
                var productType = $(this).data("product-type").toLowerCase();
                var productName = $(this).find(".card-title").text().toLowerCase();

                var typeMatch = selectedType === "all" || productType === selectedType;
                var nameMatch = productName.includes(searchQuery);

                if (typeMatch && nameMatch) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    });
</script>

</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">Product Store</a> </p>
        </div>

        <div class="right-links">

            <?php 
            
            $id = $_SESSION['id'];
            $query = mysqli_query($con,"SELECT*FROM admin WHERE Id=$id");

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
          <div class="top">
            <div class="">
                <p><b>Filter: &nbsp; &nbsp; </b> <select id="productType" name="productType" required>
                    <option value="All">All</option>
                    <option value="Iphone">Iphone</option>
                    <option value="Samsung">Samsung</option>
                    <option value="MacBook">MacBook</option>
                    <option value="Ipad">Ipad</option>
                </select></p>
            </div>
            <div class="box">
                <p><b>Search</b> <input type="text" name="search" id="search" autocomplete="off" placeholder="Enter a product name"></p>
            </div>
            
          </div>

          
          <div class="products">
        <h2>Featured Products</h2>
        <!-- Display products here -->
        <div class="container">
            <div class="row">
            <?php 
            foreach($products as $product): ?>
                <div class="col-sm">
                <div class="card" id="display_card" style="width: 18rem; height: 600px; margin-bottom: 50px;" data-product-type="<?php echo $product['productType']; ?>">
                    <img src="../uploads/<?php echo $product['productPhoto']; ?>" alt="<?php echo $product['productName']; ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['productName']; ?></h5>
                        <p class="card-text"><?php echo $product['productDescription']; ?></p>
                        <p class="card-text"><?php echo "$" . $product['productPrice']; ?></p>
                        <p class="card-text"><?php echo $product['productType']; ?></p>
                        <!-- Add a form to submit product ID when "Add to cart" is clicked -->
                        <form method="post">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" name="add_to_cart" class="btn btn-primary">Add to cart</button>
                        </form>
                    </div>
                </div>
                </div>
        <?php endforeach;  ?>
            </div>
        </div>
    </div>
           
          
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

