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
            <h2 >CS355 Landscaping Service :  Gardener Details </h1>
        </div>
        <div class="subheading">
            <h3 >Welcome <?php echo $_SESSION["GID"]; ?></h3>
            <h4> Your profile details are as follows: </h4>
        </div>
        <?php
            $db= mysqli_connect("localhost","scot","tiger","Landscaping");
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL Database: " . mysqli_connect_error();
            exit();
            }
            $GID= $_SESSION["GID"];
            $dayofweek = array("Sunday", "Monday", "Tuesday","Wednesday","Thursday","Friday","Saturday");
            $query = "SELECT * FROM Gardeners WHERE GID ='$GID'";
                // echo $query;
                if ($result = mysqli_query($db,$query)) {
                    $row = mysqli_fetch_array($result);
                        echo "<div class='form-div'>";
                        echo "<p class='pKey'>Gardener ID: </p>".$row['GID']."<br/>";
                        echo "<p class='pKey'>Name: </p>".$row['GardenerName']."<br/>";
                        echo "<p class='pKey'>DoE: </p>".$row['DoE']."<br/>";
                        echo "<p class='pKey'>Holiday: </p>".$dayofweek[$row['Holiday']]."<br/>";
                        echo "<p class='pKey'>Address: </p>".$row['Address']."<br/>";
                        echo "<p class='pKey'>Contact No.: </p>".$row['ContactNo']."<br/>";
                        echo "</div>";
                    
                }
                else{
                    echo "Failed to Fetch details!";
                }
        ?>
        <div class="buttons">
            <a href="./gardenerProfileUpdate.php"><button>Update Contact No</button></a>
            <a href="./viewAreas.php"><button > Area Division </button></a>
            <a href="./gardSchedule.php"><button>View Schedule</button></a>
            <a href="./viewGCReq.php"><button>View GrassCutting Req</button></a>
            <a href="./logout.php"><button>Log out</button></a>
        </div>
    </body>
</html>