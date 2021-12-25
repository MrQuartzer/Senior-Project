<?php
require "connection.php";

$cam = "";

if (isset($_POST['search'])) {
    $room = $_POST["room"];
    $query = "SELECT * FROM room WHERE roomno LIKE '%$room%' ORDER BY MIN(roomno) DESC LIMIT 1";
    $result = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $cam = $row["camera"];
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
        <div class="camera-box">
            <form action="" method="post">
                <h1>Camera</h1>
                <div class="row">
                    <div class="col-sm-3">
                        <br>
                        <h4 Align=right>กล้อง</h4>
                    </div>
                    <form action="" method="get" id="form" enctype="multipart/form-data">
                        <div class="col-sm-8" Align=left>
                            <div>
                                <SELECT name="room" class="choice-camera">
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
                                <input class="btn-profile" type="submit" name="search" value="Search">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="cameraviewbox">
                    <iframe src="http://<?php echo ''.$cam.'';?>" style="width: 780px; height: 460px;"></iframe>
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