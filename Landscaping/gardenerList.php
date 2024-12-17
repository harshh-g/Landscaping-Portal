<?php
    session_start();
    $isAdmin='';
    if(!isset($_SESSION['admin']))
    {
       header("adminLogin.php");
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
            <h2 >CS355 Landscaping Service: Gardener List </h1>
        </div>
        <div class="subheading">
            <h3 >Welcome! </h3>
            <h4> List of Currently employed Gardeners is as follows: </h4>
        </div>

        <?php
            $db= mysqli_connect("localhost","scot","tiger","Landscaping");
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL Database: " . mysqli_connect_error();
            exit();
            }
            $query = "SELECT * FROM Gardeners";
            $dayofweek = array("Sunday", "Monday", "Tuesday","Wednesday","Thursday","Friday","Saturday");
            if ($result = mysqli_query($db,$query)) {
                if ($result->num_rows > 0) {
                    echo "<div class='form-div'>";
                    echo '<table border="1"><tr align="center"> <th align="center"> GID </th> <th align="center"> GardenerName</th> <th align="center"> ContactNo</th><th align="center"> Address </th><th align="center"> DoE </th><th align="center"> Holiday </th></tr>';
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                      echo '<tr align="center"> <th align="center"> '.$row["GID"].'</th> <th align="center"> '.$row["GardenerName"].'</th> <th align="center"> '.$row["ContactNo"].'</th><th align="center"> '.$row["Address"].'</th><th align="center">'.$row["DoE"].'</th><th align="center">'.$dayofweek[$row["Holiday"]].' </th></tr>';
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
          
            <a href="./insertGardener.php"><button>Insert New Gardener </button></a>
            <a href="./adminWelcome.php"><button>Go Back </button></a>
        </div>
    </body>
</html>