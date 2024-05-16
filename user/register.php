<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">

        <?php 
            include("php/config.php");
            if(isset($_POST['submit'])) {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                // verify the unique email

                $verify_query = mysqli_query($con, "SELECT Email FROM users where Email='$email'");

                if(mysqli_num_rows($verify_query) != 0){
                    echo "<div class='message'>
                            <p>This email is already taken, Try another one please!</p>
                        </div> <br>";
                    
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                }
                else{
                    mysqli_query($con, "INSERT into admin(Username, Email, Password) Values('$username', '$email', '$password')") or die("Error Occurred");

                    echo "<div class='message'>
                            <p>Registration Successful!</p>
                        </div> <br>";
                    
                    echo "<a href='index.php'><button class='btn'>Login Now</button>";
                }
            } else {
        ?>

        <header>Sign Up</header>
        <form action="" method="post">
            <div class="field input">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </div>

            <div class="field input">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" autocomplete="off" required>
            </div>

            <div class="field input">
                <label for="password">Password</label> 
                <input type="password" name="password" id="password" autocomplete="off" required>
            </div>

            <div class="field">
                <input type="submit" class="btn" name="submit" value="Register" required>
            </div>

            <div class="links">
                Already have an account? <a href="index.php">Login</a>
            </div>
        </form>
        </div>
        <?php } ?>
    </div>
</body>
</html>