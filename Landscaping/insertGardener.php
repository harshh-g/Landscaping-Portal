<?php
    
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true ||$_SESSION["admin"]=='0')
    {
        header("location: adminLogin.php");
    }
    $GID = $GardenerName=$Address=$DoE=$Holiday=$ContactNo="";
    $GID_err = $GardenerName_err=$Address_err=$DoE_err=$Holiday_err=$ContactNo_err="";
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $db= mysqli_connect("localhost","scot","tiger","Landscaping");
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
        $GID = $db->real_escape_string(trim($_POST['GID']));
        // $MDate=$db->real_escape_string(trim($_POST['MDate']));
        $GardenerName=$db->real_escape_string(trim($_POST['GardenerName']));
        $Holiday=$db->real_escape_string(trim($_POST['Holiday']));
        $DoE=$db->real_escape_string(trim($_POST['DoE']));
        $Address=$db->real_escape_string(trim($_POST['Address']));
        $ContactNo=$db->real_escape_string(trim($_POST['ContactNo']));
        
        
        if(empty($GID)){
            $GID_err = "GID cannot be empty.";
        }
        else{
            $query = "SELECT * FROM Gardeners WHERE GID ='$GID'";
            // echo $query;
            if ($result = mysqli_query($db,$query)) {
                $nr=mysqli_num_rows($result);
                if($nr>0){
                    $GID_err="This GID  already  exist.";
                } 
            }
            else{
                echo "Something Went Wrong!";
            }
        }
        

        if(empty($GardenerName)){
            $GardenerName_err = "GardenerName cannot be blank";
        }

        if($Holiday>7&&$Holiday<1){
            $Holiday_err=" Holiday invalid";
        }
        if(empty($Address)){
            $Address_err = "Address cannot be blank";
        }
        if(empty($DoE)){
            $DoE_err = "Date of Employement cannot be blank";
        }
        if(!is_numeric($ContactNo)){
            $ContactNo_err = "COntactNo is invalid";
        }
        


        // If there were no errors, go ahead and insert into the database
        if(empty($GID_err) && empty($GardenerName_err) && empty($Holiday_err)&& empty($Address_err)&& empty($DoE_err)&& empty($ContactNo_err)){   
          
            $h=$Holiday-1;
            $query= "INSERT INTO Gardeners (GID,GardenerName,ContactNo,Address,DoE,Holiday) VALUES ('$GID','$GardenerName','$ContactNo','$Address','$DoE','$h');";

            if ($result = mysqli_query($db,$query)){
                header("location: gardenerList.php");   
            }
            else
            {
                echo mysqli_error($db);
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
            <h2 >CS355 Landscaping Service: Gardeners </h2>
        </div>
        <div class="subheading">
            <h3 >Welcome <?php echo $_SESSION["username"]; ?></h3>
            <h4> Fill the form below to insert New Gardener:  </h4>
        </div>
        <form class="form-div" action="insertGardener.php" method="post">
            <div class="form-group">
            <label for="GID">GID: </label>
            <input type="text"  id="GID" name="GID"  placeholder="Enter GID CHAR(5)" value='<?php echo $GID?>' required>
            <?php if($GID_err)
                echo "<p class='error-message'>$GID_err</p>" ;
            ?>
            </div>
            <div class="form-group">
            <label for="GardenerName">Gardener Name: </label>
            <input type="text" id="GardenerName" name="GardenerName"placeholder="Enter Gardener Name" value='<?php echo $GardenerName?>' required>
            <?php if($GardenerName_err)
                echo "<p class='error-message'>$GardenerName_err</p>" ;
            ?>
            </div>
            <div class="form-group">
            <label for="Address">Address: </label>
            <input type="text" id="Address" name="Address"placeholder="Enter Address" value='<?php echo $Address?>' required>
            <?php if($Address_err)
                echo "<p class='error-message'>$Address_err</p>" ;
            ?>
            </div>
            <div class="form-group">
            <label for="Holiday">Holiday: </label>
            <input type="number" id="Holiday" name="Holiday"placeholder="Enter Holiday" value='<?php echo $Holiday?>' required>
            <?php if($Holiday_err)
                echo "<p class='error-message'>$Holiday_err</p>" ;
            ?>
            </div>
            <div class="form-group">
            <label for="ContactNo">ContactNo: </label>
            <input type="text" id="ContactNo" name="ContactNo"placeholder="Enter ContactNo" value='<?php echo $ContactNo?>' required>
            <?php if($ContactNo_err)
                echo "<p class='error-message'>$ContactNo_err</p>" ;
            ?>
            </div>
            <div class="form-group">
            <label for="DoE">DoE: </label>
            <input type="text" id="DoE" name="DoE"placeholder="Enter DoE (YYYY-MM-DD)" value='<?php echo $DoE?>' required>
            <?php if($DoE_err)
                echo "<p class='error-message'>$DoE_err</p>" ;
            ?>
            </div>
            <button type="submit" class="form-buttons">Submit</button>
        </form> 
        
        <div class="buttons">
            <a href="./gardenerList.php"><button>Go Back</button></a>
        </div>
    </body>
</html>