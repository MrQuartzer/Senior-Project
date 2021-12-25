<?php
session_start();

require "connection.php";

$username = "";
$password = "";
$firstname = "";
$lastname = "";
$tel = "";
$id = "";

if (isset($_POST['edit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $tel = $_POST['tel'];
    $id = $_POST['id'];

    $passwordenc = md5($password);

    $query = "UPDATE customer SET customerpassword = '$passwordenc', customerfirstname = '$firstname', customerlastname = '$lastname', tel = '$tel'
                            WHERE customerID = '$id' ";
    echo $query;
    if ($result = mysqli_query($connect, $query)) {
        header("location: editprofile.php");
        exit;
    } else {
        die("Error with the query");
    }
}

if (isset($_POST['search'])) {
    $username = $_POST['username'];
    $query = "SELECT * FROM customer WHERE customerusername LIKE '%$username%' ORDER BY customerID DESC";
    $result = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row["customerID"];
        $username = $row["customerusername"];
        $firstname = $row["customerfirstname"];
        $lastname = $row["customerlastname"];
        $tel = $row["tel"];
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
        <div class="edit-box">
            <h1 Align=center>Edit Profile</h1>
            <br>
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-auto">
                        <form action="" method="get" id="form" enctype="multipart/form-data">
                            <h5>Username</h5>
                            <div class="editbox">
                                <input type="text" name="username" value="<?php echo $username; ?>" required>
                            </div>
                        </form>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <h5>Password</h5>
                        <div class="editbox">
                            <input type="password" name="password">
                        </div>
                        <h5>ชื่อ</h5>
                        <div class="editbox">
                            <input type="text" name="firstname" value="<?php echo $firstname; ?>">
                        </div>
                        <h5>นามสกุล</h5>
                        <div class="editbox">
                            <input type="text" name="lastname" value="<?php echo $lastname; ?>">
                        </div>
                        <h5>เบอร์โทรศัพท์</h5>
                        <div class="editbox">
                            <input type="text" name="tel" value="<?php echo $tel; ?>">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <br>
                        <input class="btn" type="submit" name="search" value="Search">
                    </div>
                    <div Align=center>
                        <input class="btn-editpage30" type="button" name="back" value="Back" onclick="location.href='mainpage.php'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input class="btn-editpage30" type="submit" name="edit" value="Edit">
                    </div>
                </div>
        </div>
        </form>
    </div>
</body>

</html>

<?php
mysqli_close($connect);
?>