<?php
    session_start();
    $isAdmin='';
    if(isset($_SESSION['admin']) && $_SESSION['admin']=='1')
    {
       $isAdmin=true;
    }
    else
    {
        $isAdmin=false;
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
            <h2 >CS355 Landscaping Service: Gardening Requests </h1>
        </div>
        <div class="subheading">
            <h3 >Welcome! </h3>
            <h4> Current Requests are as follows: </h4>
        </div>

        <?php
            $db= mysqli_connect("localhost","scot","tiger","Landscaping");
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL Database: " . mysqli_connect_error();
            exit();
            }
            $query = "SELECT * FROM GCRequests";
            if ($result = mysqli_query($db,$query)) {
                if ($result->num_rows > 0) {
                    echo "<div class='form-div'>";
                    echo '<table border="1"><tr align="center"> <th align="center"> ReqID </th> <th align="center"> Area Code </th> <th align="center"> ReqEmpID </th> <th align="center"> ReqContact </th> <th align="center"> ReqStatus </th> </tr>';
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                      echo '<tr align="center"> <td align="center">'.$row["ReqID"].'</td> <td align="center">'.$row["AreaCode"].'</td> <td align="center">'.$row["ReqEmpID"].'</td> <td align="center">'.$row["ReqContact"].'</td> <td align="center">'.$row["ReqStatus"].'</td></tr>';
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
            <?php if($isAdmin)
            {
                echo '<a href="./updateReqStatus.php"><button>Update Req Status </button></a>';
            }
            ?>
            <a href="./viewAreas.php"><button > Area Division </button></a>
            <a href="./GCReq.php"><button>Submit New Req</button></a>
            <a href="./index.php"><button>Go Back</button></a>
        </div>
    </body>
</html>