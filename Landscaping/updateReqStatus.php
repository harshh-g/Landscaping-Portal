<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true ||$_SESSION["admin"]=='0')
    {
        header("location: adminLogin.php");
    }
    $ReqID = $ReqStatus="";
    $ReqID_err = $ReqStatus_err= "";
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $db= mysqli_connect("localhost","scot","tiger","Landscaping");
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
        $ReqID = $db->real_escape_string(trim($_POST['ReqID']));
        // $MDate=$db->real_escape_string(trim($_POST['MDate']));
        $ReqStatus=$db->real_escape_string(trim($_POST['ReqStatus']));
        

        if(empty($ReqID)){
            $ReqID_err = "Req ID cannot be empty.";
        }
        else{
            $query = "SELECT * FROM GCRequests WHERE ReqID ='$ReqID'";
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
        

        if(empty($ReqStatus)){
            $ReqStatus_err = "Status cannot be blank";
        }

        // If there were no errors, go ahead and insert into the database
        if(empty($ReqID_err) && empty($ReqStatus_err)){   
          
            
            $query= "UPDATE GCRequests SET ReqStatus='$ReqStatus' WHERE ReqID='$ReqID'";

            if ($result = mysqli_query($db,$query)){
                header("location: viewGCReq.php");   
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
            <h2 >CS355 Landscaping Service: GC Requests </h1>
        </div>
        <div class="subheading">
            <h3 >Welcome <?php echo $_SESSION["username"]; ?></h3>
            <h4> Fill the form below to update GrassCutting Request status:  </h4>
        </div>
        <form class="form-div" action="updateReqStatus.php" method="post">
            <div class="form-group">
            <label for="ReqID">ReqID: </label>
            <input type="text"  id="ReqID" name="ReqID"  placeholder="Enter Request ID" value='<?php echo $ReqID?>' required>
            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
            <?php if($ReqID_err)
                echo "<p class='error-message'>$ReqID_err</p>" 
            ?>
            </div>
            <div class="form-group">
            <label for="ReqStatus">Request Status: </label>
            <input type="text" id="ReqStatus" name="ReqStatus"placeholder="Enter Updated Status" value='<?php echo $ReqStatus?>' required>
            <?php if($ReqStatus_err)
                echo "<p class='error-message'>$ReqStatus_err</p>" 
            ?>
            </div>
            <button type="submit" class="form-buttons">Submit</button>
        </form> 
        
        <div class="buttons">
            <a href="./viewGCReq.php"><button>Go Back</button></a>
        </div>
    </body>
</html>