<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true ||$_SESSION["admin"]=='0')
    {
        header("location: adminLogin.php");
    }
    $username = '';
    $username_err = "";
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $db= mysqli_connect("localhost","scot","tiger","Landscaping");
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
        $username = $db->real_escape_string(trim($_POST['username']));
        // $MDate=$db->real_escape_string(trim($_POST['MDate']));
        // $ReqStatus=$db->real_escape_string(trim($_POST['ReqStatus']));
        
        // Check if username is empty
        if(empty($username)){
            $username_err = "username cannot be empty.";
        }
        else{
            $query = "SELECT * FROM Admins WHERE username ='$username'";
            // echo $query;
            if ($result = mysqli_query($db,$query)) {
                $nr=mysqli_num_rows($result);
                if($nr==0){
                    $usernameID_err="This Username does not  exist.";
                } 
            }
            else{
                echo "Something Went Wrong!";
            }
        }
        
        // If there were no errors, go ahead and insert into the database
        if(empty($username_err)){   
            // echo $hashed_password."<br/>";
            
            $query= "UPDATE Admins SET isAdmin='1' WHERE username='$username'";

            if ($result = mysqli_query($db,$query)){
                echo "<script>alert('Success!); window.location.href='./adminWelcome.php';</script>";  
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
            <h2 >CS355 Landscaping Services: Admin </h1>
        </div>
        <div class="subheading">
            <h3 >Welcome <?php echo $_SESSION["username"]; ?></h3>
            <h4> Fill the form below to make a user Admin:  </h4>
        </div>
        <form class="form-div" action="makeAdmin.php" method="post">
            <div class="form-group">
                <label for="username">Username: </label>
                <input type="text"  id="username" name="username"  placeholder="Enter Username" value='<?php echo $username?>' required>
                <?php if($username_err)
                    echo "<p class='error-message'>$username_err</p>" 
                ?>
            </div>
            <button type="submit" class="form-buttons">Make Admin</button>
        </form> 
        
        <div class="buttons">
            <a href="./adminWelcome.php"><button>Go Back</button></a>
        </div>
    </body>
</html>