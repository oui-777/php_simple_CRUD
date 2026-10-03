<?php
session_start();
include_once 'dbconnect.php';
// เช็คสถานะแอดมิน
if (!isset($_SESSION['session_admin_name'])) {
    header("Location: admin_login.php");
    exit();
}
//9.1. fetch records
$SQL = "SELECT * FROM users ORDER BY user_id DESC";
$result = mysqli_query($conn, $SQL);
//9.2. delete record
// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $get_user_id = intval($_GET['id']); // Sanitize the input to prevent SQL Injection
    $SQL = "DELETE FROM users WHERE user_id=" . $get_user_id;
    mysqli_query($conn, $SQL);
    // redirect to show_user.php after deletion
    header("Location: show_user.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>PHP Admin | Users</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>

<body>
    <!-- แถบเมนูด้านบน -->
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">PHP Simple CRUD</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Sign Up</a></li>
                    <li class="active"><a href="admin_login.php">Admin</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- ส่วนตารางข้อมูล -->
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">
                <br>
                <legend>Show All Users</legend>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>E-Mail</th>
                                <th>Password</th>
                                <th>User Type</th>
                                <th colspan="2" style="text-align:center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_array($result)) { ?>
                                <tr>
                                    <td><?php echo $row['user_id']; ?></td>
                                    <td><?php echo $row['user_name']; ?></td>
                                    <td><?php echo $row['user_email']; ?></td>
                                    <td><?php echo $row['user_passsws']; ?></td>
                                    <td>
                                        <?php
                                        if ($row['user_type'] == 'U') {
                                            echo "User";
                                        } elseif ($row['user_type'] == 'A') {
                                            echo "Admin";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="update_user.php?id=<?php echo $row['user_id']; ?>"
                                            class="btn btn-info">Edit</a></td>
                                    <!-- ปุ่ม Delete ที่เชื่อมกับ JavaScript -->
                                    <td><input type="button" value="Delete" class="btn btn-danger"
                                            onclick="deleteUser(<?php echo $row['user_id']; ?>)" /></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- 12.display number of records -->
    <div class="panel-footer">
        <?php
        $num_rows = mysqli_num_rows($result);
        echo "<p>Total Users: " . $num_rows . "</p>";
        ?>
    </div>
    </div>
    </div>
    </div>
    <!-- 11.JavaScript for delete actions -->
    <script>
        function deleteUser(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                window.location.href = "show_user.php?id=" + userId;
            }
        }
    </script>
</body>

</html>