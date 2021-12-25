<?php
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
        <div class="row"></div>
        <div class="history-box">
            <h1>History</h1>
            <form action="" method="get" id="form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6">
                        <input class="searchbox" type="text" name="searchbox" placeholder="">
                    </div>
                    <div class="col-sm-4" Align=left>
                        <input class="btn-40per" type="submit" name="search" value="Search">
                    </div>
                </div>
            </form>
            <div class="history-detail">
                <table>
                    <tr>
                        <th width="50">
                            <div align="center">serviceID</div>
                        </th>
                        <th width="200">
                            <div align="center">ชื่อสัตว์เลี้ยง</div>
                        </th>
                        <th width="150">
                            <div align="center">ชนิด</div>
                        </th>
                        <th width="150">
                            <div align="center">สายพันธุ์</div>
                        </th>
                        <th width="100">
                            <div align="center">น้ำหนัก</div>
                        </th>
                        <th width="150">
                            <div align="center">สี</div>
                        </th>
                        <th width="200">
                            <div align="center">ชื่อเจ้าของ</div>
                        </th>
                        <th width="50">
                            <div align="center">ห้อง</div>
                        </th>
                        <th width="100">
                            <div align="center">check in</div>
                        </th>
                        <th width="100">
                            <div align="center">check out</div>
                        </th>
                    </tr>
                    <?php
                    $search = isset($_GET['search']) ? $_GET['search'] : '';

                    $query = "SELECT * FROM service WHERE serviceID LIKE '%$search%' OR petname LIKE '%$search%' OR pettype LIKE '%$search%' OR species LIKE '%$search%' OR owner LIKE '%$search%' OR room LIKE '%$search%' ";
                    $result = mysqli_query($connect, $query);
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td align='center'><?php echo $row["serviceID"]; ?></td>
                            <td> &nbsp; <?php echo $row["petname"]; ?></td>
                            <td> &nbsp; <?php echo $row["pettype"]; ?></td>
                            <td> &nbsp; <?php echo $row["species"]; ?></td>
                            <td align='center'> &nbsp; <?php echo $row["weight"]; ?></td>
                            <td align='center'> &nbsp; <?php echo $row["color"]; ?></td>
                            <td> &nbsp; <?php echo $row["owner"]; ?></td>
                            <td align='center'><?php echo $row["room"]; ?></td>
                            <td> &nbsp; <?php echo $row["checkin"]; ?></td>
                            <td> &nbsp; <?php echo $row["checkout"]; ?></td>
                        </tr>
                    <?php
                    }
                    echo "
                </table>";
                    mysqli_close($connect);
                    ?>

            </div>
            <div class="row">
                <div class="col-sm-10"></div>
                <div class="col-sm-2">
                    <input class="btn" type="button" name="back" value="Back" onclick="location.href='mainpage.php'">
                </div>
            </div>
        </div>
    </div>

</body>

</html>