<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true ||$_SESSION["admin"]=='0')
    {
        header("location: adminLogin.php");
    }
    $GID = '';
    $GID_err = "";
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $db= mysqli_connect("localhost","scot","tiger","Landscaping");
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
        $GID = $db->real_escape_string(trim($_POST['GID']));
        // Check if GID is empty
        if(empty($GID)){
            $GID_err = "Req ID cannot be empty.";
        }
        else{
            $query = "SELECT * FROM Gardeners WHERE GID ='$GID'";
            // echo $query;
            if ($result = mysqli_query($db,$query)) {
                $nr=mysqli_num_rows($result);
                if($nr==0){
                    $GID_err="This Gardener ID  does not  exist.";
                } 
            }
            else{
                echo "Something Went Wrong!";
            }
        }
        
        // If there were no errors, go ahead and insert into the database
        if(empty($GID_err)){   
            // echo $hashed_password."<br/>";
            
            $query= "INSERT INTO Attendance VALUES ('$GID',CURRENT_DATE)";

            if ($result = mysqli_query($db,$query)){
                echo "<script>alert('Sucessfully Marked!); window.location.href='./Attendance.php';</script>";  
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
            <h2 >CS355 Admin Service: Attendance </h1>
        </div>
        <div class="subheading">
            <h3 >Welcome <?php echo $_SESSION["username"]; ?></h3>
            <h4> Fill the form below to update Attendance:  </h4>
        </div>
        <form class="form-div" action="updateReqStatus.php" method="post">
            <div class="form-group">
                <label for="GID">GID: </label>
                <input type="text"  id="GID" name="GID"  placeholder="Enter Gardener ID" value='<?php echo $GID?>' required>
                <?php if($GID_err)
                    echo "<p class='error-message'>$GID_err</p>" 
                ?>
            </div>
            <button type="submit" class="form-buttons">Mark Attendance</button>
        </form> 
        
        <div class="buttons">
            <a href="./monthlyAttendance.php"><button>See Monthly Attendance</button></a>
            <a href="./adminWelcome.php"><button>Go Back</button></a>
        </div>
    </body>
</html>