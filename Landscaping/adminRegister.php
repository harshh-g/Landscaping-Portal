<?php
    $username = $passwd = $confPassword = "";
    $username_err = $password_err = $confPassword_err = "";
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $db= mysqli_connect("localhost","scot","tiger","Landscaping");
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
        $username = $db->real_escape_string(trim($_POST['username']));
        $passwd=$db->real_escape_string(trim($_POST['password']));
        $confPassword=$db->real_escape_string(trim($_POST['confPassword']));
        
        
        // Check if username is empty
        if(empty($username)){
            $username_err = "username cannot be blank";
        }
        else{
            $query = "SELECT * FROM Admins WHERE username ='$username'";
            // echo $query;
            if ($result = mysqli_query($db,$query)) {
                $nr=mysqli_num_rows($result);
                if($nr!=0){
                    $username_err="This username already exist.";
                } 
            }
            else{
                echo "Something Went Wrong!";
            }
        }
        

        // Check for password
        
        if(empty($passwd)){
            $password_err = "Password cannot be blank";
        }
        else if(strlen($passwd) < 8){
            $password_err = "Password cannot be less than 8 characters";
        }

        // Check for confirm password field
        if($passwd!= $confPassword){
            $confPassword_err = "Passwords should match";
        }
        // If there were no errors, go ahead and insert into the database
        if(empty($username_err) && empty($password_err) && empty($confPassword_err)){   
            $hashed_password = password_hash($passwd, PASSWORD_DEFAULT);
            // echo $hashed_password."<br/>";
            $query= "INSERT INTO Admins(username,passwd) VALUES ('$username','$hashed_password')";

            if ($result = mysqli_query($db,$query)){
                echo "<script>alert('Sucessfully Registered. Please Login!'); window.location.href='./adminLogin.php';</script>";
                
            }
        }
        $_POST=array();
        $db->close();
    }
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CS355 Mini Project</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="header">
            <h2 >Landscaping Service : Administrative Services </h1>
        </div>
        <div class="subheading">
            <h4>Please fill in following form to register your Admin account.</h4>
        </div>
        <form class="form-div" action="adminRegister.php" method="post">
            <div class="form-group">
            <label for="username">Username: </label>
            <input type="text"  id="username" name="username"  placeholder="Enter username" value='<?php echo $username?>' required>
            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
            <?php if($username_err)
                echo "<p class='error-message'>$username_err</p>" 
            ?>
            </div>
            <div class="form-group">
            <label for="password">Password: </label>
            <input type="password" id="password" name="password"placeholder="Password" value='<?php echo $passwd?>' required>
            <?php if($password_err)
                echo "<p class='error-message'>$password_err</p>" 
            ?>
            </div>
            <div class="form-group">
                <label for="confPassword">Confirm Password: </label>
                <input type="password" id="confPassword" name="confPassword" placeholder="Re-enter Password" value='<?php echo $confPassword?>' required>
                <?php if($confPassword_err)
                    echo "<p class='error-message' >$confPassword_err</p>" 
                ?>
            </div>
            <button type="submit" class="form-buttons">Submit</button>
           
        </form> 
        <div class="buttons">
            <!-- <a href="./login.php"><button>Login Page</button></a> -->
            <a href="./admin.php"><button> Go Back</button></a>
        </div>
        
    </body>
</html>