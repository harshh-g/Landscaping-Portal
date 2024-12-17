<?php
    $GID = $passwd = $confPassword = "";
    $GID_err = $password_err = $confPassword_err = "";
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $db= mysqli_connect("localhost","scot","tiger","Landscaping");
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
        $GID = $db->real_escape_string(trim($_POST['GID']));
        $passwd=$db->real_escape_string(trim($_POST['password']));
        $confPassword=$db->real_escape_string(trim($_POST['confPassword']));
        
        
        // Check if username is empty
        if(empty($GID)){
            $GID_err = "Gardener ID cannot be blank";
        }
        else{
            $query = "SELECT passwd FROM Gardeners WHERE GID ='$GID'";
            // echo $query;
            if ($result = mysqli_query($db,$query)) {
                $nr=mysqli_num_rows($result);
                if($nr==0){
                    $GID_err="This gardener does not exist. Please contact adminisitration department.";
                }
                else{
                    $row=mysqli_fetch_array($result);
                    if($row['passwd']){
                        $GID_err="This user is already registered. Please go to Login Page.";
                    }
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
        if(empty($GID_err) && empty($password_err) && empty($confPassword_err)){   
            $hashed_password = password_hash($passwd, PASSWORD_DEFAULT);
            // echo $hashed_password."<br/>";
            $query= "UPDATE Gardeners SET passwd ='$hashed_password' WHERE GID='$GID'";

            if ($result = mysqli_query($db,$query)){
                echo "<script>alert('Sucessfully Registered. Please Login!'); window.location.href='./gardLogin.php';</script>";
                
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
            <h2 >CS355 Landscaping Service: Gardener Services </h1>
        </div>
        <div class="subheading">
            <h4>Please fill in following form to register your gardner account.</h4>
        </div>
        <form class="form-div" action="gardRegister.php" method="post">
            <div class="form-group">
            <label for="GID">Gardner ID: </label>
            <input type="text"  id="GID" name="GID"  placeholder="Enter Gardner ID" value='<?php echo $GID?>' required>
            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
            <?php if($GID_err)
                echo "<p class='error-message'>$GID_err</p>" 
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
            <a href="./gardener.php"><button> Go Back</button></a>
        </div>
        
    </body>
</html>