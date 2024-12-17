<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true || $_SESSION["admin"]=='0')
    {
        header("location: adminLogin.php");
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
            <h2 >CS355 Landscaping Service: Admin Homepage </h1>
        </div>
        <div class="subheading">
            <h3 >Welcome <?php echo $_SESSION["username"]; ?></h3>
            <h4> Please click on following buttons to continue: </h4>
        </div>
        <div class="buttons">
            <a href="./makeAdmin.php"><button > Make an Admin </button></a>
            <a href="./viewAreas.php"><button > Area Division </button></a>
            <a href="./gardenerList.php"><button > Gardeners Details</button></a>
            <a href="./equipmentStock.php"><button > View/Update Equipment Stock</button></a>
            <a href="./attendance.php"><button > Attendance </button></a>
            <a href="./createSchedule.php"><button > Create/View Schedule </button></a>
            <a href="./viewGCReq.php"><button > View Grass Cutting Requests </button></a>
            <a href="./logout.php"><button>Log out</button></a>
        </div>
    </body>
</html>