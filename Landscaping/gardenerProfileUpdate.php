<?php
    $success=false;
    session_start();
    $GID=$_SESSION["GID"];
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
    {
        header("location: gardLogin.php");
    }
    $db= mysqli_connect("localhost","scot","tiger","Landscaping");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
    $query = "SELECT * FROM Gardeners WHERE GID ='$GID'";
    if ($result = mysqli_query($db,$query)) {
        $row = mysqli_fetch_array($result);
    }
    else{
        echo "Failed to Fetch details!";
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        
        $mobileNo = $db->real_escape_string(trim($_POST['ContactNo']));
     

        $query = "UPDATE Gardeners SET ContactNo = '$mobileNo' WHERE GID = '$GID'";
        if($result=mysqli_query($db,$query)){   
            echo "<script>alert('Sucessfully Updated.'); window.location.href='./gardProfile.php';</script>";
        }
        else{
            echo "Some error occured while update.";
        }
    }
    $db->close();
?>

<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CS355 Mini Project</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="header">
            <h2 >CS355 Landscaping Services : Gardeners </h1>
        </div>
        <div class="subheading">
            <h3 >Welcome <?php echo $_SESSION["GID"];?></h3>
            <h4>Please fill out all fields with updated information.</h4>
        </div>
        
        <form class="form-div" method="post" action="#" >
            <div class="form-group">
            <label for="ContactNo">Mobile No: </label>
            <input type="text" class="form-control" id="ContactNo" name="ContactNo"  placeholder="Contact No." value="<?php echo $row['ContactNo']; ?>" required>
            </div>
           
            <div class="buttons">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
    
        </form>
            <div class="buttons">
            <a href="./logout.php"><button>Log out</button></a> 
            <a href="./gardProfile.php"><button>Cancel</button></a> 
            </div>
            
         
         
    </body>
</html>