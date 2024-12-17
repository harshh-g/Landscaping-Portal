<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
    {
        header("location: adminLogin.php");
    }
    $ReqID = $MStatus="";
    $ReqID_err = $MStatus_err= "";
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $db= mysqli_connect("localhost","scot","tiger","Landscaping");
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
        $ReqID = $db->real_escape_string(trim($_POST['ReqID']));
        // $MDate=$db->real_escape_string(trim($_POST['MDate']));
        $MStatus=$db->real_escape_string(trim($_POST['MStatus']));
        
        if(empty($ReqID)){
            $ReqID_err = "Req ID cannot be empty.";
        }
        else{
            $query = "SELECT * FROM EqMaintenance WHERE ReqID ='$ReqID'";
            // echo $query;
            if ($result = mysqli_query($db,$query)) {
                $nr=mysqli_num_rows($result);
                if($nr==0){
                    $ReqID_err="This ReqID  does not  exist.";
                } 
            }
            else{
                echo "Something Went Wrong!";
            }
        }
        

      
        if(empty($MStatus)){
            $MStatus_err = "Status cannot be blank";
        }

        // If there were no errors, go ahead and insert into the database
        if(empty($ReqID_err) && empty($MStatus_err)){   
          
            
            $query= "UPDATE EqMaintenance SET MStatus='$MStatus' WHERE ReqID='$ReqID'";

            if ($result = mysqli_query($db,$query)){
                header("location: equipMaintenance.php");   
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
            <h2 >CS355 Landscaping Service: Equipments and Tools </h1>
        </div>
        <div class="subheading">
            <h3 >Welcome <?php echo $_SESSION["username"]; ?></h3>
            <h4> Fill the form below to update maintenance status:  </h4>
        </div>
        <form class="form-div" action="updateMStatus.php" method="post">
            <div class="form-group">
            <label for="ReqID">ReqID: </label>
            <input type="text"  id="ReqID" name="ReqID"  placeholder="Enter Request ID" value='<?php echo $ReqID?>' required>
            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
            <?php if($ReqID_err)
                echo "<p class='error-message'>$ReqID_err</p>" 
            ?>
            </div>
            <div class="form-group">
            <label for="MStatus">Maintenance Status: </label>
            <input type="text" id="MStatus" name="MStatus"placeholder="Enter Updated Status" value='<?php echo $MStatus?>' required>
            <?php if($MStatus_err)
                echo "<p class='error-message'>$MStatus_err</p>" 
            ?>
            </div>
            <button type="submit" class="form-buttons">Submit</button>
        </form> 
        
        <div class="buttons">
            <a href="./equipMaintenance.php"><button>Go Back</button></a>
        </div>
    </body>
</html>