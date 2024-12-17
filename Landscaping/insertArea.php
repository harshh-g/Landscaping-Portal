<?php
    
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true ||$_SESSION["admin"]=='0')
    {
        header("location: adminLogin.php");
    }
    $AreaCode = $AreaName=$AreaLocation="";
    $AreaCode_err = $AreaName_err = $AreaLocation_err = "";
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $db= mysqli_connect("localhost","scot","tiger","Landscaping");
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
        $AreaCode = $db->real_escape_string(trim($_POST['AreaCode']));
        // $MDate=$db->real_escape_string(trim($_POST['MDate']));
        $AreaName=$db->real_escape_string(trim($_POST['AreaName']));
        $AreaLocation=$db->real_escape_string(trim($_POST['AreaLocation']));
        
        
        if(empty($AreaCode)){
            $AreaCode_err = "AreaCode cannot be empty.";
        }
        else{
            $query = "SELECT * FROM Areas WHERE AreaCode ='$AreaCode'";
            // echo $query;
            if ($result = mysqli_query($db,$query)) {
                $nr=mysqli_num_rows($result);
                if($nr>0){
                    $AreaCode_err="This AreaCode  already  exist.";
                } 
            }
            else{
                echo "Something Went Wrong!";
            }
        }
        

        if(empty($AreaName)){
            $AreaName_err = "AreaName cannot be blank";
        }
        if(empty($AreaLocation)){
            $AreaLocation_err = "AreaLocation cannot be blank";
        }

        // If there were no errors, go ahead and insert into the database
        if(empty($AreaCode_err) && empty($AreaName_err) && empty($AreaLocation_err)){   
          
            
            $query= "INSERT INTO Areas VALUES ('$AreaCode','$AreaName','$AreaLocation')";

            if ($result = mysqli_query($db,$query)){
                header("location: viewAreas.php");   
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
            <h2 >CS355 Landscaping Service: View Areas </h1>
        </div>
        <div class="subheading">
            <h3 >Welcome <?php echo $_SESSION["username"]; ?></h3>
            <h4> Fill the form below to insert New Area:  </h4>
        </div>
        <form class="form-div" action="insertArea.php" method="post">
            <div class="form-group">
            <label for="AreaCode">AreaCode: </label>
            <input type="number"  id="AreaCode" name="AreaCode"  placeholder="Enter AreaCode" value='<?php echo $AreaCode?>' required>
            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
            <?php if($AreaCode_err)
                echo "<p class='error-message'>$AreaCode_err</p>" ;
            ?>
            </div>
            <div class="form-group">
            <label for="AreaName">Area Name: </label>
            <input type="text" id="AreaName" name="AreaName"placeholder="Enter Area Name" value='<?php echo $AreaName?>' required>
            <?php if($AreaName_err)
                echo "<p class='error-message'>$AreaName_err</p>" ;
            ?>
            </div>
            <div class="form-group">
            <label for="AreaLocation">Area Location: </label>
            <input type="text" id="AreaLocation" name="AreaLocation"placeholder="Enter Area Location" value='<?php echo $AreaLocation?>' required>
            <?php if($AreaLocation_err)
                echo "<p class='error-message'>$AreaLocation_err</p>" ;
            ?>
            </div>
            <button type="submit" class="form-buttons">Submit</button>
        </form> 
        
        <div class="buttons">
            <a href="./viewAreas.php"><button>Go Back</button></a>
        </div>
    </body>
</html>