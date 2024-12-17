<?php
    $empID = $AreaCode = $ContactNo = "";
    $empID_err = $AreaCode_err = $ContactNo_err = "";
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $db= mysqli_connect("localhost","scot","tiger","Landscaping");
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
        $empID = $db->real_escape_string(trim($_POST['empID']));
        $AreaCode=$db->real_escape_string(trim($_POST['AreaCode']));
        $ContactNo=$db->real_escape_string(trim($_POST['ContactNo']));
        
        // Check if empID is empty
        if(empty($empID)){
            $empID_err = "Employee ID cannot be blank";
        }
        if(empty($AreaCode)){
            $AreaCode_err = "Area Code cannot be blank";
        }
        else{
            $query = "SELECT * FROM Areas WHERE AreaCode ='$AreaCode'";
            // echo $query;
            if ($result = mysqli_query($db,$query)) {
                $nr=mysqli_num_rows($result);
                if($nr==0){
                    $AreaCode_err="This Area Code is invalid.";
                } 
            }
            else{
                echo "Something Went Wrong!";
            }
        }
        if(strlen($ContactNo) !== 10 && (!is_numeric($ContactNo))){
            $ContactNo_err = "Contact Number is invalid.";
        }

        // If there were no errors, go ahead and insert into the database
        if(empty($empID_err) && empty($AreaCode_err) && empty($ContactNo_err)){  

            $query= "INSERT INTO GCRequests (AreaCode,ReqEmpID,ReqContact,ReqStatus) VALUES ('$AreaCode','$empID','$ContactNo','Submitted')";

            if ($result = mysqli_query($db,$query)){
                $id = mysqli_insert_id($db);
                $success= "Successfully Submitted your request. Your Request ID is : '$id'";
                echo '<script>alert("'.$success.'");</script>';
            }
            else{
                echo mysqli_error($db);
            }
        }
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
            <h2 >Landscaping Service : Grass Cutting Requests </h1>
        </div>
        <div class="subheading">
            <h4>Please fill in following form to submit grass cutting requests for any specific area.</h4>
        </div>
        <form class="form-div" action="GCReq.php" method="post">
            <div class="form-group">
            <label for="empID">Employee ID: </label>
            <input type="text"  id="empID" name="empID"  placeholder="Enter Employee ID" value='<?php echo $empID?>' required>
            <?php if($empID_err)
                echo "<p class='error-message'>$empID_err</p>" 
            ?>
            </div>
            <div class="form-group">
            <label for="AreaCode">Area Code: </label>
            <input type="text" id="AreaCode" name="AreaCode"placeholder="Area Code" value='<?php echo $AreaCode?>' required>
            <?php if($AreaCode_err)
                echo "<p class='error-message'>$AreaCode_err</p>" 
            ?>
            </div>
            <div class="form-group">
                <label for="ContactNo">Contact No: </label>
                <input type="text" id="ContactNo" name="ContactNo" placeholder="Enter Contact No." value='<?php echo $ContactNo?>' required>
                <?php if($ContactNo_err)
                    echo "<p class='error-message' >$ContactNo_err</p>" 
                ?>
            </div>
            <button type="submit" class="form-buttons">Submit</button>
           
        </form> 
        <div class="buttons">

            <a href="./index.php"><button> Go Back</button></a>
        </div>
        
    </body>
</html>