<?php
    session_start();
    $isAdmin='';
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true || $_SESSION["admin"]=='0')
    {
       $isAdmin=false;
    }
    else
    {
        $isAdmin=true;
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
            <h2 >CS355 Landscaping Service: View Duty Assignments </h1>
        </div>
        <div class="subheading">
            <h3 >Welcome! </h3>
            <h4> Current Schedule  is as follows: </h4>
        </div>

        <?php
            $db= mysqli_connect("localhost","scot","tiger","Landscaping");
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL Database: " . mysqli_connect_error();
            exit();
            }
            $query = "SELECT * FROM DutyAssignment";
            $dayofweek = array("Sunday", "Monday", "Tuesday","Wednesday","Thursday","Friday","Saturday");
            if ($result = mysqli_query($db,$query)) {
                if ($result->num_rows > 0) {
                    echo "<div class='form-div'>";
                    echo '<table border="1"><tr align="center"> <th align="center"> WeekDay </th> <th align="center"> Area Code </th> <th align="center"> GID </th></tr>';
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                      echo '<tr align="center"> <td align="center">'.$dayofweek[$row["Wday"]].'</td> <td align="center">'.$row["AreaCode"].'</td> <td align="center">'.$row["GID"].'</td></tr>';
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
        <div class="buttons">
            <a href="./adminWelcome.php"><button>Go Back</button></a>
        </div>
    </body>
</html>