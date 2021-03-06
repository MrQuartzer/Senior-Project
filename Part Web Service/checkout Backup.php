<?php
session_start();

require "connection.php";

date_default_timezone_set("Asia/Bangkok");

$customerid = "";
$id = "";
$room = "";

if (isset($_POST['checkout'])) {
    $customerid = $_POST['customerid'];
    $id = $_POST['id'];
    $room = $_POST['room'];
    $date = new DateTime();
    $time = $date->format('Y-m-d H:i:s');
    $now = "$time";

    $query = "UPDATE service,customer,room SET service.checkout = '$now', customer.room = '0', customer.customertoken = '-', room.token = '-' FROM service,customer,room WHERE service.serviceID LIKE '$id' AND customer.customerID = '$customerid' AND room.room = '$room' ";
    echo $query;
    if ($result = mysqli_query($connect, $query)) {
        $query = "UPDATE customer SET customer.room = 0, customer.customertoken = '-' WHERE customer.customerID = '$customerid'";
        echo $query;
        if ($result = mysqli_query($connect, $query)) {
            header("location: mainpage.php");
            exit;
        } else {
            die("Error with the query");
        }
    } else {
        die("Error with the query");
    }
}



?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Care Business</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="d-flex justify-content-center">
        <div class="checkincheckout-box">
            <h1>Check Out</h1>
            <br>
            <form action="" method="post">
                <div class="row">
                    <form action="" method="get" id="form" enctype="multipart/form-data">
                        <div class="col-sm-4">
                            <br>
                            <h4>Username</h4>
                        </div>
                        <div class="col-sm-8" Align=left>
                            <div class="textbox">
                                <input type="text" name="username" placeholder="Username" required>
                                <input class="btn-profile" type="submit" name="search" value="Search">
                            </div>
                        </div>
                    </form>
                </div>
            </form>
            <form action="" method="post">
                <div class="details-checkout" Align=left style="font-size:1vw">
                    <?php
                    if (isset($_POST['search'])) {
                        $username = $_POST['username'];
                        $query = "SELECT * FROM customer WHERE customerusername LIKE '%$username%' ";
                        $result = mysqli_query($connect, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $customerid = $row["customerID"];
                            $username = $row["customerusername"];
                            $firstname = $row["customerfirstname"];
                            $lastname = $row["customerlastname"];
                            $tel = $row["tel"];
                            $petname = $row["petname"];
                            $pettype = $row["pettype"];
                            $species = $row["species"];
                            $weight = $row["weight"];
                            $color = $row["color"];
                            $room = $row["room"];

                            echo "Customer ID : $id";
                            echo "<br/>";
                            echo "Username : $username";
                            echo "<br/>";
                            echo "????????????-????????????????????? : $firstname $lastname";
                            echo "<br/>";
                            echo "??????????????????????????????????????? : $tel";
                            echo "<br/>";
                            echo "????????????????????????????????????????????? : $petname";
                            echo "<br/>";
                            echo "???????????? : $pettype";
                            echo "<br/>";
                            echo "??????????????????????????? : $species";
                            echo "<br/>";
                            echo "????????????????????? : $weight";
                            echo "<br/>";
                            echo "?????? : $color";
                            echo "<br/>";
                            echo "???????????? : $room";
                            $query = "SELECT * FROM service WHERE user LIKE '%$username%' ORDER BY serviceID DESC LIMIT 1";
                            $result = mysqli_query($connect, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $id = $row["serviceID"];
                            }
                        }
                    }
                    ?>
                    <input type="hidden" name="customerid" value="<?php echo $customerid; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="room" value="<?php echo $room; ?>">
                </div>
                <div class="row">
                    <div class="col-sm-9" Align=right>
                        <input class="btn-30per" type="submit" name="checkout" value="Check out">
                    </div>
                    <div class="col-sm-3">
                        <input class="btn" type="button" name="back" value="Back" onclick="location.href='mainpage.php'">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<?php
mysqli_close($connect);
?>