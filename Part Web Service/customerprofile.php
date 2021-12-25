<?php
session_start();

require "connection.php";

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
        <div class="profile-box">
            <h1>Customer Profile</h1>
            <form action="" method="post">
                <div class="row">
                    <form action="" method="get" id="form" enctype="multipart/form-data">
                        <div class="col-sm-4">
                            <br>
                            <h4 Align=right>Username</h4>
                        </div>
                        <div class="col-sm-8" Align=left>
                            <div class="textbox">
                                <input type="text" name="username" placeholder="Username" required>&nbsp;&nbsp;&nbsp;&nbsp;
                                <input class="btn-profile" type="submit" name="search" value="Search">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="details-box" Align=left style="font-size:1vw">
                    <?php
                    if (isset($_POST['search'])) {
                        $username = $_POST['username'];
                        $query = "SELECT * FROM customer WHERE customerusername LIKE '%$username%' ORDER BY MIN(customerID) DESC LIMIT 1";
                        $result = mysqli_query($connect, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row["customerID"];
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
                            echo "ชื่อ-นามสกุล : $firstname $lastname";
                            echo "<br/>";
                            echo "เบอร์โทรศัพท์ : $tel";
                            echo "<br/>";
                            echo "ชื่อสัตว์เลี้ยง : $petname";
                            echo "<br/>";
                            echo "ชนิด : $pettype";
                            echo "<br/>";
                            echo "สายพันธุ์ : $species";
                            echo "<br/>";
                            echo "น้ำหนัก : $weight";
                            echo "<br/>";
                            echo "สี : $color";
                            echo "<br/>";
                            echo "ห้อง : $room";
                        }
                    }
                    ?>
                </div>
                <div class="row">
                    <div class="col-sm-12" Align=right>
                        <input class="btn-25per" type="button" name="back" value="Back" onclick="location.href='mainpage.php'">
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