<?php
// นำเข้าไฟล์เชื่อมต่อฐานข้อมูล
include_once 'dbconnect.php';

$name_error = "";
$success_message = "";
$database_error = "";
$err_flag = false;

// เช็คว่ามีการกดปุ่ม 'signup' (ปุ่มสมัครสมาชิก) มาหรือไม่
if(isset($_POST['signup'])) {
    $name = $_POST['user-name'];
    $email = $_POST['user-email'];
    $password = $_POST['user-password'];
    $cpassword = $_POST['user-cpassword'];

    // ตรวจสอบชื่อว่ามีแค่ตัวอักษรและช่องว่าง
    if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $name_error = "Only letters and white space allowed in name.";
        $err_flag = true;
    }

    // ถ้ารหัสผ่านและการยืนยันไม่ตรงกัน (อาจารย์ไม่ได้เขียนไว้ แต่เราเพิ่มให้เพื่อความสมบูรณ์)
    if ($password !== $cpassword) {
        $database_error = "Passwords do not match!";
        $err_flag = true;
    }

    // ถ้าไม่มี Error ใดๆ ให้บันทึกลงฐานข้อมูล
    if(!$err_flag) {
        // เข้ารหัสผ่านก่อนบันทึก
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // คำสั่ง SQL สำหรับเพิ่มข้อมูล
        $SQL = "INSERT INTO users (user_name, user_email, user_passsws, user_type) 
                VALUES ('$name', '$email', '$hashed_password', 'U')";
        
        if(mysqli_query($conn, $SQL)) {
            $success_message = "Successfully Registered!";
        } else {
            $database_error = "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>User Registration</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<!-- add header -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">PHP Simple CRUD</a>
		</div>
		<!-- menu items -->
		<div class="collapse navbar-collapse" id="navbar1">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="login.php">Login</a></li>
				<li class="active"><a href="register.php">Sign Up</a></li>
				<li><a href="admin_login.php">Admin</a></li>
			</ul>
		</div>
	</div>
</nav>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 well">
			<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
				<fieldset>
					<legend>Sign Up</legend>

					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="user-name" placeholder="Enter Full Name" required value="" class="form-control" />
					</div>

					<div class="form-group">
						<label for="name">Email</label>
						<input type="text" name="user-email" placeholder="Email" required value="" class="form-control" />
					</div>

					<div class="form-group">
						<label for="name">Password</label>
						<input type="password" name="user-password" placeholder="Password" required class="form-control" />
					</div>

					<div class="form-group">
						<label for="name">Confirm Password</label>
						<input type="password" name="user-cpassword" placeholder="Confirm Password" required class="form-control" />
					</div>

					<div class="form-group">
						<input type="submit" name="signup" value="Sign Up" class="btn btn-primary" />
					</div>
				</fieldset>
			</form>
			<!--3.display message -->

		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4 text-center">
		Already Registered? <a href="login.php">Login Here</a>
		</div>
	</div>
</div>
</body>
</html>
