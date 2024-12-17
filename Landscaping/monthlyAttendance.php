<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true || $_SESSION["admin"]=='0')
    {
        header("location: adminLogin.php");
    }
    $SYear_err="";
    $SYear="";
    $SMonth="";
    $SMonth_err="";
    if(isset($_GET['SYear']))
    {   
        $SYear =$_GET['SYear'];
        $SMonth=$_GET['SMonth'];
        if($SMonth<=0||$SMonth>12)
        {
            $SMonth_err="Invalid Month.";
        }
        if($SYear<2000)
        {
            $SYear_err="Invalid Year.";
        }
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
            <h2 >CS355 Landscaping Service: Monthly Attendance </h1>
        </div>
        <div class="subheading">
            <h3 >Welcome! </h3>
            <h4> Monthly Attendance of all Gardeners: </h4>
        </div>
        <form class="form-div" action="monthlyAttendance.php" method="get">
        <div class="form-group">
          <label for="SYear">Year: </label>
          <input type="number" class="form-control" id="SYear" name="SYear"  placeholder="Enter Year(YYYY)" value='<?php echo $SYear?>' required>
          <?php if($SYear_err)
                echo "<p class='error-message'>$SYear_err</p>" ;
          ?>
          <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
        </div>
        <div class="form-group">
          <label for="SMonth">Month: </label>
          <input type="SMonth" class="form-control" id="SMonth" name="SMonth"placeholder="Enter Month (MM)" value='<?php echo $SMonth?>' required>
          <?php if($SMonth_err)
                echo "<p class='error-message'>$SMonth_err</p>" ;
          ?>
        </div>
       
        <button type="submit" class="form-buttons">Fetch Details</button>
    </form> 
        <?php
            if(isset($_GET['SYear']))
            {   
               
                if(!empty($SYear)&&!empty($SMonth)&&empty($SYear_err)&&empty($SMonth_err))
                {
                    $db= mysqli_connect("localhost","scot","tiger","Landscaping");
                    if (mysqli_connect_errno()) {
                        echo "Failed to connect to MySQL Database: " . mysqli_connect_error();
                    exit();
                    }
                    $query = "SELECT GID,COUNT(At_Date) AS Num_of_Days FROM Attendance WHERE MONTH(At_Date)='$SMonth' AND YEAR(At_Date)='$SYear' GROUP BY GID";
                    if ($result = mysqli_query($db,$query)) {
                        if ($result->num_rows > 0) {
                            echo "<div class='form-div'>";
                            echo '<table border="1"><tr align="center"> <th align="center"> GID </th> <th align="center"> Number of Days </th></tr>';
                            while($row = $result->fetch_assoc()) {
                            echo '<tr align="center"> <td align="center">'.$row["GID"].'</td> <td align="center">'.$row["Num_of_Days"].'</td></tr>';
                            }
                            echo "</table>";
                            echo "</div>";
                        }
                        else
                        {
                            echo "No Data Found.";
                        }
                    }
                    else
                    {
                        echo "Failed to Fetch details!";
                    }         
                }
            }
             
        ?>
        <div class="buttons">
            <a href="./attendance.php"><button>Go Back</button></a>
        </div>
    </body>
</html>