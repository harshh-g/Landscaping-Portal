<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
    {
        header("location: adminLogin.php");
    }
    $EID = $MPlace=$MContact="";
    $EID_err = $MPlace_err =$MContact_err = "";
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $db= mysqli_connect("localhost","scot","tiger","Landscaping");
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
        $EID = $db->real_escape_string(trim($_POST['EID']));
        // $MDate=$db->real_escape_string(trim($_POST['MDate']));
        $MPlace=$db->real_escape_string(trim($_POST['MPlace']));
        $MContact=$db->real_escape_string(trim($_POST['MContact']));
        
        
        if(strlen($EID)!=5){
            $username_err = "Equipment ID needs to be 5 characters long";
        }
        else{
            $query = "SELECT * FROM Equipments WHERE EID ='$EID'";
            // echo $query;
            if ($result = mysqli_query($db,$query)) {
                $nr=mysqli_num_rows($result);
                if($nr==0){
                    $EID_err="This EID  does not  exist.";
                } 
            }
            else{
                echo "Something Went Wrong!";
            }
        }
        if(empty($MPlace)){
            $MPlace_err = "Maintenance Place cannot be blank";
        }
        if(strlen($MContact)!=10){
            $MContact_err = "Contact No. is invalid";
        }
       

        // If there were no errors, go ahead and insert into the database
        if(empty($EID_err) && empty($MPlace_err) && empty($MContact_err)){   
            
            $query= "INSERT INTO EqMaintenance(EID,MPlace,MContact,MDate,MStatus) VALUES ('$EID','$MPlace','$MContact',CURRENT_DATE,'Submitted')";

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
            <h4> Current Equipment Maintenace Log is as follows: </h4>
        </div>

        <?php
            $db= mysqli_connect("localhost","scot","tiger","Landscaping");
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL Database: " . mysqli_connect_error();
            exit();
            }
            $query = "SELECT * FROM EqMaintenance ";
            if ($result = mysqli_query($db,$query)) {
                if ($result->num_rows > 0) {
                    echo "<div class='form-div'>";
                    echo '<table border="1"><tr align="center"> <th align="center"> ReqID </th><th align="center"> EID </th> <th align="center"> MPlace </th> <th align="center"> MContact </th> <th align="center"> MDate</th><th align="center"> MStatus </th></tr>';
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                      echo '<tr align="center"><td align="center">'.$row["ReqID"].'</td> <td align="center">'.$row["EID"].'</td> <td align="center">'.$row["MPlace"].'</td> <td align="center">'.$row["MContact"].'</td> <td align="center">'.$row["MDate"].'</td> <td align="center">'.$row["MStatus"].'</td> </tr>';
                    }
                    echo "</table>";
                    echo "</div>";
                }
            }
            else
            {
                echo "Failed to Fetch details!";
            }          
        ?>


        <form class="form-div" action="equipMaintenance.php" method="post">
            <div class="form-group">
            <label for="EID">EID: </label>
            <input type="text"  id="EID" name="EID"  placeholder="Enter Equipment ID" value='<?php echo $EID?>' required>
            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
            <?php if($EID_err)
                echo "<p class='error-message'>$EID_err</p>" 
            ?>
            </div>
            <div class="form-group">
            <label for="MPlace">Maintainer Place: </label>
            <input type="text" id="MPlace" name="MPlace"placeholder="Enter M. Place" value='<?php echo $MPlace?>' required>
            <?php if($MPlace_err)
                echo "<p class='error-message'>$MPlace_err</p>" 
            ?>
            </div>
            <div class="form-group">
            <label for="MContact">Contact No: </label>
            <input type="text" class="form-control" id="MContact" name="MContact"  placeholder="Contact No." value="<?php echo $MContact; ?>" required>
            <?php if($MContact_err)
                echo "<p class='error-message'>$MContact_err</p>" 
            ?>
            </div>
            <!-- <div class="form-group">
                <label for="EquipmentName">Equipment Name: </label>
                <input type="text" id="EquipmentName" name="EquipmentName" placeholder="Enter Equipment Name" value='<?php echo $EquipmentName?>' required>
                <?php if($EquipmentName_err)
                    echo "<p class='error-message' >$EquipmentName_err</p>" 
                ?>
            </div> -->
            <button type="submit" class="form-buttons">Submit</button>
        </form> 
        
        <div class="buttons">
            <a href="./updateMStatus.php"><button>Update Maintenance Status</button></a>
            <a href="./adminWelcome.php"><button>Go Back</button></a>
        </div>
    </body>
</html>