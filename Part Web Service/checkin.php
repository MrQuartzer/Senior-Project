<?php
session_start();

require "connection.php";

date_default_timezone_set("Asia/Bangkok");

$username = "";
$firstname = "";
$lastname = "";
$petname = "";
$pettype = "";
$species = "";
$weight = "";
$color = "";
$id = "";

if (isset($_POST['checkin'])) {
    $user = $_POST['user'];
    $id = $_POST['id'];
    $pet = $_POST['petname'];
    $pettype = $_POST['type'];
    $species = $_POST['species'];
    $weight = $_POST['weight'];
    $color = $_POST['color'];
    $owner = $_POST['owner'];
    $room = $_POST['room'];
    $room = intval($room);
    $time = time();
    $date = date("d-m-Y H:i:s",$time);
    $now = "$date";

        $query = "INSERT INTO service (petname, pettype, species, weight, color, owner, room, checkin, checkout, user, customerID)
                                    VALUES ('$pet', '$pettype', '$species', '$weight', '$color', '$owner', '$room', '$now', '-', '$user', '$id')";
        echo ($query);
        if (mysqli_query($connect, $query)) {
            $query = "SELECT * FROM customer WHERE customerID LIKE '$id' ";
            $result = mysqli_query($connect, $query);
            if (mysqli_num_rows($result)) {
                $query = "UPDATE customer SET room = '$room' WHERE customerID = '$id'";
                if (mysqli_query($connect, $query)) {
                    header("location: mainpage.php");
                    exit;
                } else {
                    die("Error with the query");
                }
            } else {
                die("Error with the query");
            }
        } else {
            die("Error with the query");
        }

}

if (isset($_POST['search'])) {
    $username = $_POST['username'];
    $query = "SELECT * FROM customer WHERE customerusername LIKE '%$username%' ORDER BY MIN(customerID) DESC LIMIT 1";
    $result = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row["customerID"];
        $username = $row["customerusername"];
        $firstname = $row["customerfirstname"];
        $lastname = $row["customerlastname"];
        $petname = $row["petname"];
        $fullname = $firstname . " " . $lastname;
        $pettype = $row["pettype"];
        $species = $row["species"];
        $weight = $row["weight"];
        $color = $row["color"];
        $room = $row["room"];
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
            <h1>Check In</h1>
            <form action="" method="post">
                <div class="row">
                    <form action="" method="get" id="form" enctype="multipart/form-data">
                        <div class="col-sm-4" Align=right>
                            <br>
                            <h4>Username</h4>
                        </div>
                        <div class="col-sm-8" Align=left>
                            <div class="textbox">
                                <input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>" required>
                                <input class="btn-profile" type="submit" name="search" value="Search">
                            </div>
                        </div>
                    </form>
                </div>
            </form>
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-6" Align=left>
                        <h5>ชื่อสัตว์เลี้ยง</h5>
                        <div class="textbox-checkin">
                            <input type="text" name="petname" value="<?php echo $petname; ?>" required>
                        </div>
                        <h5>สายพันธุ์</h5>
                        <div class="textbox-checkin">
                            <input type="text" name="species" value="<?php echo $species; ?>" required>
                        </div>
                        <h5>สี</h5>
                        <div class="textbox-checkin">
                            <input type="text" name="color" value="<?php echo $color; ?>" required>
                        </div>
                    </div>
                    <div class="col-sm-5" Align=left>
                        <h5>ชนิด</h5>
                        <div class="textbox-checkin">
                            <input type="text" name="type" value="<?php echo $pettype; ?>" required>
                        </div>
                        <h5>น้ำหนัก(kg)</h5>
                        <div class="textbox-checkin">
                            <input type="text" name="weight" value="<?php echo $weight; ?>" required>
                        </div>
                        <h5>ห้อง</h5>
                        <SELECT name="room" class="choice-checkin">
                            <OPTION SELECTED disabled>----------ห้อง----------
                                <?php
                                $query = "SELECT * FROM room";
                                $result = mysqli_query($connect, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $roomno = $row["roomno"];
                                ?>
                            <OPTION VALUE=<?php echo $roomno; ?>><?php echo $roomno; ?>
                            <?php
                                }
                            ?>

                        </SELECT>
                    </div>
                    <input type="hidden" name="owner" value="<?php echo $fullname; ?>">
                    <input type="hidden" name="user" value="<?php echo $username; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="col-sm-8" Align=right>
                        <input class="btn-30per" type="submit" name="checkin" value="Check In">
                    </div>
                    <div class="col-sm-3" Align=left>
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