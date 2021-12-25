<?php
session_start();

require "connection.php";
require "function.php";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $tel = $_POST['tel'];
    $petname = $_POST['petname'];
    $type = $_POST['type'];
    $species = $_POST['species'];
    $weight = $_POST['weight'];
    $color = $_POST['color'];

    $query = "SELECT customerusername FROM customer WHERE customerusername = '$username'";
    $result = mysqli_query($connect, $query);
    if (mysqli_num_rows($result) == 0) {
        $passwordenc = md5($password);
        $query2 = "INSERT INTO customer (customerusername, customerpassword, customerfirstname, customerlastname, tel, petname, pettype, species, weight, color, room)
                                    VALUES ('$username', '$passwordenc', '$firstname', '$lastname', '$tel', '$petname', '$type', '$species', '$weight', '$color', 0)";
        echo $query2;
        if (mysqli_query($connect, $query2)) {
            header("location: mainpage.php");
            exit;
        } else {
            die("Error with the query");
        }
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
        <div class="register-box">
            <h1 Align=center>Registration</h1>
            <br>
            <?php
            if (isset($_SESSION['errorprompt'])) {
                ShowError();
            }
            ?>
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-6">
                        <h5>Username</h5>
                        <div class="textbox">
                            <input type="text" name="username" required>
                        </div>
                        <h5>ชื่อ</h5>
                        <div class="textbox">
                            <input type="text" name="firstname" required>
                        </div>
                        <h5>เบอร์โทรศัพท์</h5>
                        <div class="textbox">
                            <input type="text" name="tel" required>
                        </div>
                        <h5>ชนิด</h5>
                        <div class="textbox">
                            <input type="text" name="type" required>
                        </div>
                        <h5>น้ำหนัก(kg)</h5>
                        <div class="textbox">
                            <input type="text" name="weight" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h5>Password</h5>
                        <div class="textbox">
                            <input type="password" name="password" required>
                        </div>
                        <h5>นามสกุล</h5>
                        <div class="textbox">
                            <input type="text" name="lastname" required>
                        </div>
                        <h5>ชื่อสัตว์เลี้ยง</h5>
                        <div class="textbox">
                            <input type="text" name="petname" required>
                        </div>
                        <h5>สายพันธุ์</h5>
                        <div class="textbox">
                            <input type="text" name="species" required>
                        </div>
                        <h5>สี</h5>
                        <div class="textbox">
                            <input type="text" name="color" required>
                        </div>
                        <br>
                        <input class="btn-registerpage" type="button" name="back" value="Back" onclick="location.href='mainpage.php'">&nbsp;&nbsp;&nbsp;&nbsp;
                        <input class="btn-registerpage" type="submit" name="register" value="Register">
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