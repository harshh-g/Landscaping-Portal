<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
    {
        header("location: adminLogin.php");
    }
    $EID = $AreaCode = $EquipmentName = "";
    $EID_err = $AreaCode_err = $EquipmentName_err = "";
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $db= mysqli_connect("localhost","scot","tiger","Landscaping");
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
        $EID = $db->real_escape_string(trim($_POST['EID']));
        $AreaCode=$db->real_escape_string(trim($_POST['AreaCode']));
        $EquipmentName=$db->real_escape_string(trim($_POST['EquipmentName']));
        
        
     
        if(strlen($EID)!=5){
            $username_err = "Equipment ID nneds to be 5 characters long";
        }
        else{
            $query = "SELECT * FROM Equipments WHERE EID ='$EID'";
            // echo $query;
            if ($result = mysqli_query($db,$query)) {
                $nr=mysqli_num_rows($result);
                if($nr!=0){
                    $EID_err="This EID already exist.";
                } 
            }
            else{
                echo "Something Went Wrong!";
            }
        }
        
  
        if(empty($AreaCode)){
            $AreaCode_err = "Password cannot be blank";
        }
        else {
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

      
        if(empty($EquipmentName)){
            $EquipmentName_err = "Equipment name cannot be blank";
        }
        // If there were no errors, go ahead and insert into the database
        if(empty($EID_err) && empty($AreaCode_err) && empty($EquipmentName_err)){   
           
            $query= "INSERT INTO Equipments VALUES ('$EID','$AreaCode','$EquipmentName')";

            if ($result = mysqli_query($db,$query)){
                header("location: equipmentStock.php");
                
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
            <h4> Current Equipment Stock is as follows: </h4>
        </div>

        <?php
            $db= mysqli_connect("localhost","scot","tiger","Landscaping");
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL Database: " . mysqli_connect_error();
            exit();
            }
            $query = "SELECT * FROM Equipments ";
            if ($result = mysqli_query($db,$query)) {
                if ($result->num_rows > 0) {
                    echo "<div class='form-div'>";
                    echo '<table border="1"><tr align="center"> <th align="center"> EID </th> <th align="center"> Equipment Name </th> <th align="center"> Area Code </th> </tr>';
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                      echo '<tr align="center"> <td align="center">'.$row["EID"].'</td> <td align="center">'.$row["EquipmentName"].'</td> <td align="center">'.$row["Area"].'</td> </tr>';
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


        <form class="form-div" action="equipmentStock.php" method="post">
            <div class="form-group">
            <label for="EID">EID: </label>
            <input type="text"  id="EID" name="EID"  placeholder="Enter Equipment ID" value='<?php echo $EID?>' required>
            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
            <?php if($EID_err)
                echo "<p class='error-message'>$EID_err</p>" 
            ?>
            </div>
            <div class="form-group">
            <label for="AreaCode">Area Code: </label>
            <input type="text" id="AreaCode" name="AreaCode"placeholder="Enter AreaCode" value='<?php echo $AreaCode?>' required>
            <?php if($AreaCode_err)
                echo "<p class='error-message'>$AreaCode_err</p>" 
            ?>
            </div>
            <div class="form-group">
                <label for="EquipmentName">Equipment Name: </label>
                <input type="text" id="EquipmentName" name="EquipmentName" placeholder="Enter Equipment Name" value='<?php echo $EquipmentName?>' required>
                <?php if($EquipmentName_err)
                    echo "<p class='error-message' >$EquipmentName_err</p>" 
                ?>
            </div>
            <button type="submit" class="form-buttons">Insert</button>
        </form> 
        <div class="buttons">
            <a href="./equipMaintenance.php"><button>View Maintainance Status</button></a>
            <a href="./adminWelcome.php"><button>Go Back</button></a>
        </div>
    </body>
</html>