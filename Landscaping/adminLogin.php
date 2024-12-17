<?php
//This script will handle login
    session_start();

// check if the user is already logged in
    if(isset($_SESSION['username']))
    {
        header("location: adminWelcome.php");
        exit;
    }
    $db= mysqli_connect("localhost","scot","tiger","Landscaping");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    $username = $passwd = "";
    $err = "";

// if request method is post
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $username = $db->real_escape_string(trim($_POST['username']));
        $passwd=$db->real_escape_string(trim($_POST['password']));
        if(empty($username)|| empty($passwd))
        {
            $err = "Please enter username + password";
        }
        if(empty($err))
        {
            $query="SELECT * FROM Admins WHERE username='$username'";
            if ($result = mysqli_query($db,$query)) {
                $nr=mysqli_num_rows($result);
                
                if($nr==0)
                {
                    $err="This User does not exist.Please enter correct Username.";
                }
                
                else
                {
                    $row=mysqli_fetch_array($result);
                        $hashed_password= $row['passwd'];
                        if(password_verify($passwd, $hashed_password))
                        {
                            // this means the password is corrct. Allow user to login
                            session_start();
                            
                            $_SESSION["username"] = $username;
                            $_SESSION["loggedin"] = true;
                            $_SESSION["admin"]=$row['isAdmin'];
                            //Redirect user to welcome page
                            echo "Login Successfull!";
                            header("location: adminWelcome.php");
                            
                        }
                        else
                        {
                            $err="Incorrect credentials given.";
                        }
                }
                
            }
            else
            {
                echo "Something Went Wrong!";
            }
        
        }    
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
        <h2 >CS355 Landscaping Service: Admin Section </h1>
    </div>
    <div class="subheading">
        <h4>Please provide correct credentials to login. </h4>
        <?php
        if($err)
        {
            echo "<p class='error-message'>$err</p>";
        }
        ?>
    </div>
    <form class="form-div" action="adminLogin.php" method="post">
        <div class="form-group">
          <label for="username">Username: </label>
          <input type="text" class="form-control" id="username" name="username"  placeholder="Enter Username" value='<?php echo $username?>' required>
          <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
        </div>
        <div class="form-group">
          <label for="password">Password: </label>
          <input type="password" class="form-control" id="password" name="password"placeholder="Password" value='<?php echo $passwd?>' required>
        </div>
       
        <button type="submit" class="form-buttons">Login</button>
    </form> 
    
    <div class="buttons">
        <a href="./index.php"><button>Go Back</button></a>
    </div>
</body>
</html>