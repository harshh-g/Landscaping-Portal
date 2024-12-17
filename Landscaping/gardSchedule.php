<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
    {
        header("location: gardLogin.php");
    }
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> CS355 Mini Project </title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="header">
            <h2 >CS355 Landscaping Service: Gardeners </h1>
        </div>
        <div class="subheading">
            <h3 >Welcome <?php echo $_SESSION["GID"]; ?></h3>
            <h4> Your Schedule is as follows: </h4>
        </div>
        <?php
            $db= mysqli_connect("localhost","scot","tiger","Landscaping");
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL Database: " . mysqli_connect_error();
            exit();
            }
            $GID= $_SESSION["GID"];
            $dayofweek = array("Sunday", "Monday", "Tuesday","Wednesday","Thursday","Friday","Saturday");
            $query = "SELECT Wday, AreaName FROM DutyAssignment JOIN Areas ON DutyAssignment.AreaCode=Areas.AreaCode WHERE GID ='$GID'";
            if ($result = mysqli_query($db,$query)) {
                if ($result->num_rows > 0) {
                    echo "<div class='form-div'>";
                    echo '<table border="1"><tr align="center"><th align="center" >Day</th><th align="center">Area</th></tr>';
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                      echo '<tr align="center" ><td align="center">'.$dayofweek[$row["Wday"]].'</td><td align="center">'.$row["AreaName"].'</td></tr>';
                    }
                    echo "</table>";
                    echo "</div>";
                }
                else
                {
                    echo "No Records!";
                }
            }
            else{
                echo "Failed to Fetch!";
            }
        ?>
        <div class="buttons">
            <a href="./gardProfile.php"><button>Go Back</button></a>
        </div>
    </body>
</html>