<?php
//This script will handle login
    session_start();

// check if the user is already logged in
    if(isset($_SESSION['GID']))
    {
        header("location: gardProfile.php");
        exit;
    }
    $db= mysqli_connect("localhost","scot","tiger","Landscaping");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    $GID = $passwd = "";
    $err = "";

// if request method is post
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $GID = $db->real_escape_string(trim($_POST['GID']));
        $passwd=$db->real_escape_string(trim($_POST['password']));
        if(empty($GID)|| empty($passwd))
        {
            $err = "Please enter username + password";
        }
        if(empty($err))
        {
            $query="SELECT passwd FROM Gardeners WHERE GID='$GID'";
            if ($result = mysqli_query($db,$query)) {
                $nr=mysqli_num_rows($result);
                
                if($nr==0)
                {
                    $err="This Gardener does not exist.Please enter correct Gardener ID.";
                }
                
                else
                {
                    $row=mysqli_fetch_array($result);
                    if($row['passwd']=="")
                    {
                        $err="This account is not yet registered.";
                    }
                    else
                    {
                        $hashed_password= $row['passwd'];
                        if(password_verify($passwd, $hashed_password))
                        {
                            // this means the password is corrct. Allow user to login
                            session_start();
                            $_SESSION["GID"] = $GID;
                            $_SESSION["loggedin"] = true;

                            //Redirect user to welcome page
                            echo "Login Successfull!";
                            header("location: gardProfile.php");
                            
                        }
                        else
                        {
                            $err="Incorrect credentials given.";
                        }

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
        <h2 >CS355 Landscaping Service: Gardeners</h1>
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
    <form class="form-div" action="gardLogin.php" method="post">
        <div class="form-group">
          <label for="GID">Gardener ID: </label>
          <input type="text" class="form-control" id="GID" name="GID"  placeholder="Enter Gard. ID" value='<?php echo $GID?>' required>
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