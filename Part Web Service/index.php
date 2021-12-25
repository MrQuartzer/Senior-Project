<?php
    session_start();

    require "connection.php";
    require "function.php";

    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password = md5($password);
        $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password' ";
        $result = mysqli_query($connect, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['adminID'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['password'] = $row['password'];
            header("Location: mainpage.php");
            exit;
        } else {
            $_SESSION['errorprompt'] = "invalid username or password.";
        }
    }
    if (!isset($_SESSION['username'], $_SESSION['password'])) {
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
        <div class="login-box">
            <h3>Pet Care Business</h3>
            <br>
            <?php
                    if (isset($_SESSION['errorprompt'])) {
                    ShowError();
                }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <h4>Username</h4>
                <div class="textbox">
                    <input type="text" name="username" placeholder="Username" required>
                    <br>
                </div>
                <h4>Password</h4>
                <div class="textbox">
                    <input type="password" name="password" placeholder="Password" required>
                    <br>
                </div>

                <input class="btn" type="submit" name="login" value="Login">
            </form>
        </div>
        
    </div>
</body>
</html>

<?php
    } else {
        header("location: index.php");
        exit;
    }

    unset($_SESSION['errorprompt']);
    mysqli_close($connect);

?>