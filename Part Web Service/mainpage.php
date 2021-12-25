<?php
    session_start();

    require "connection.php";
    if(isset($_SESSION['username'], $_SESSION['password'])) {
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
        <div class="main-box">
            <h1>Pet Care Business</h1>
            <br>
            <div class="row">
                <div class="col-sm-6">
                    <a href="registration.php">
                        <button class="btn-mainpage">ลงทะเบียนลูกค้า</button>
                    </a>
                    <br>
                    <a href="customerprofile.php">
                        <button class="btn-mainpage">ข้อมูลลูกค้า</button>
                    </a>
                    <br>
                    <a href="checkin.php">
                        <button class="btn-mainpage">เช็คอิน</button>
                    </a>
                    <br>
                    <a href="history.php">
                        <button class="btn-mainpage">ประวัติการใช้บริการ</button>
                    </a>
                </div>
                <div class="col-sm-6">
                    <a href="editprofile.php">
                        <button class="btn-mainpage">แก้ไขข้อมูล</button>
                    </a>
                    <br>
                    <a href="camera.php">
                        <button class="btn-mainpage">ดูกล้อง</button>
                    </a>
                    <br>
                    <a href="checkout.php">
                        <button class="btn-mainpage">เช็คเอาท์</button>
                    </a>
                    <br>
                    <a href="logout.php">
                        <button class="btn-mainpage">Log out</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
    } else {
        header("location: index.php");
        exit;
    }
    mysqli_close($connect);
?>