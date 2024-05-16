<?php
    $dbhost  = 'localhost';
    $dbuser = 'root';
    $dbname = 'productmgmtdb';
    $dbpass = '';

    if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
        die("Failed Connection");
    }

    $query = "SELECT * FROM products";
    $result = mysqli_query($con, $query);

    $row = mysqli_fetch_assoc($result);

    $id = $row["id"];

    $sql = "DELETE FROM products where id = $id";

    if(mysqli_query($con, $sql)){
        header("Location: home.php");
        exit;
    }
    else{
        echo "An Error Occurred while deleting";
    }
?>