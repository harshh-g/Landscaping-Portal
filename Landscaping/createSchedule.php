<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true || $_SESSION["admin"]=='0')
    {
        header("location: adminLogin.php");
    }
    $WDay='';
    $WDay_err='';
    $AreaCode='';
    $AreaCode_err=""; 
    $GID="";
    $GID_err="";
    if(isset($_GET['WDay']))
    {
        $WDay=$_GET['WDay'];
    }   
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $db= mysqli_connect("localhost","scot","tiger","Landscaping");
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
        $GID = $db->real_escape_string(trim($_POST['GID']));
        $AreaCode=$db->real_escape_string(trim($_POST['AreaCode']));
        $WDay=$db->real_escape_string(trim($_POST['WDay']));
        $d=$WDay-1;
        
        
        if(empty($GID)){
            $GID_err = "Gardener ID cannot be blank";
        }
        else{
            $query = "SELECT * FROM Gardeners WHERE GID ='$GID'";
            // echo $query;
            if ($result = mysqli_query($db,$query)) {
                $nr=mysqli_num_rows($result);
                if($nr==0){
                    $GID_err="This gardener does not exist. Please contact adminisitration department.";
                }
            }
            else{
                echo "Something Went Wrong!";
            }
        }
        
        if(empty($WDay)){
            $WDay_err = "Weekday cannot be blank";
        }
        else {

            $query = "SELECT * FROM DutyAssignment WHERE GID ='$GID' AND Wday='$d'";
            // echo $query;
            if ($result = mysqli_query($db,$query)) {
                $nr=mysqli_num_rows($result);
                if($nr>0){
                    $WDay_err="Entered Gardener is already busy on this day";
                }
            }
            else{
                echo "Something Went Wrong!";
            }
        }

        // Check for confirm password field
        if(empty($AreaCode)){
            $AreaCode_err = "AreaCodecannot be blank";
        }
        else {

            $query = "SELECT * FROM Areas WHERE AreaCode ='$AreaCode'";
            // echo $query;
            if ($result = mysqli_query($db,$query)) {
                $nr=mysqli_num_rows($result);
                if($nr==0){
                    $AreaCode_err="Any such area doesnot exist.";
                }
            }
            else{
                echo "Something Went Wrong!";
            }
        }
        // If there were no errors, go ahead and insert into the database
        if(empty($GID_err) && empty($WDay_err) && empty($AreaCode_err)){   
            $query= "INSERT INTO DutyAssignment VALUEs ('$GID','$AreaCode','$d')";

            if ($result = mysqli_query($db,$query)){
                echo "<script>alert('Sucessfully Assigned'); window.location.href='./createSchedule.php';</script>";
                
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
        <title>CS355 Mini Project </title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="header">
            <h2 >CS355 Landscaping Service: Assign Duty</h1>
        </div>
        <div class="subheading">
            <h3 >Welcome! </h3>
            <h4> Fill the following form to assign Duty to a Gardener </h4>
        </div>
        <form class="form-div" action="createSchedule.php" method="get">
        <div class="form-group">
          <label for="WDay">Day: </label>
          <input type="number" class="form-control" id="WDay" name="WDay"  placeholder="Enter Day(1-7)" value='<?php echo $WDay?>' required>
          <?php if($WDay_err)
                echo "<p class='error-message'>$WDay_err</p>" ;
          ?>
        </div>
        <button type="submit" class="form-buttons">Fetch Suggestions</button>
    </form> 
    <?php
            if(isset($_GET['WDay']))
            {   
               $WDay=$_GET['WDay'];
                if(!empty($WDay)&&empty($Wday_err))
                {
                    $db= mysqli_connect("localhost","scot","tiger","Landscaping");
                    if (mysqli_connect_errno()) {
                        echo "Failed to connect to MySQL Database: " . mysqli_connect_error();
                    exit();
                    }
                    $d=$WDay-1;
                    $query = "SELECT GID FROM Gardeners WHERE Holiday!='$WDay'AND GID NOT IN (SELECT GID FROM DutyAssignment WHERE Wday='$d') LIMIT 5";
                    if ($result = mysqli_query($db,$query)) {
                        if ($result->num_rows > 0) {
                            echo "<div class='form-div'>";
                            echo '<table border="1"><tr align="center"> <th align="center"> Suggested GIDs </th></tr>';
                            while($row = $result->fetch_assoc()) {
                            echo '<tr align="center"> <td align="center">'.$row["GID"].'</td></tr>';
                            }
                            echo "</table>";
                            echo "</div>";
                        }
                        else
                        {
                            echo "<div class='form-div'>";
                            echo "<p>No one is Available on this Day.<p>";
                            echo "</div>";
                        }
                    }
                    else
                    {
                        echo "Failed to Fetch details!";
                    }         
                }
            }
             
        ?>

    <form class="form-div" action="createSchedule.php" method="post">
        <div class="form-group">
          <label for="WDay">Day: </label>
          <input type="number" class="form-control" id="WDay" name="WDay"  placeholder="Enter Day(1-7)" value='<?php echo $WDay?>' required>
          <?php if($WDay_err)
                echo "<p class='error-message'>$WDay_err</p>" ;
          ?>
          <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
        </div>
        <div class="form-group">
          <label for="AreaCode">Area Code: </label>
          <input type="AreaCode" class="form-control" id="AreaCode" name="AreaCode"placeholder="Enter Area Code" value='<?php echo $AreaCode?>' required>
          <?php if($AreaCode_err)
                echo "<p class='error-message'>$AreaCode_err</p>" ;
          ?>
        </div>
        <div class="form-group">
          <label for="GID">Gardener: </label>
          <input type="GID" class="form-control" id="GID" name="GID"placeholder="Enter Gardener ID" value='<?php echo $GID?>' required>
          <?php if($GID_err)
                echo "<p class='error-message'>$GID_err</p>" ;
          ?>
        </div>
       
        <button type="submit" class="form-buttons">Assign Duty</button>
    </form> 
      
        <div class="buttons">
        <a href="./viewSchedule.php"><button>View Current Schedule</button></a>
            <a href="./adminWelcome.php"><button>Go Back</button></a>
        </div>
    </body>
</html>