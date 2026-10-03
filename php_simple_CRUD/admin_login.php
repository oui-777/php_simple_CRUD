<?php
session_start();
include_once 'dbconnect.php';
if (isset($_POST['login'])) {
	$admin_name = mysqli_real_escape_string($conn, $_POST['admin-name']);
	$admin_password = mysqli_real_escape_string($conn, $_POST['admin-password']);
	// ดึงข้อมูลผู้ใช้ที่ชื่อตรงกัน และมีสถานะเป็น Admin (A)
	$SQL = "SELECT * FROM users WHERE user_name='$admin_name' AND user_type='A'";
	$result = mysqli_query($conn, $SQL);
	// เช็คว่ามีรายชื่อ Admin นี้ในระบบหรือไม่
	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_array($result);
		// ตรวจสอบรหัสผ่าน
		if (password_verify($admin_password, $row['user_passsws'])) {
			$_SESSION['session_admin_name'] = $admin_name;
			header("Location: show_user.php");
			exit();
		} else {
			$login_error = "Invalid admin name or password.";
		}
	} else {
		$login_error = "Invalid admin name or password.";
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>PHP Admin | Login</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
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
					<li><a href="register.php">Sign Up</a></li>
					<li class="active"><a href="admin_login.php">Admin</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4 well">
				<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
					<fieldset>
						<legend>Login</legend>

						<div class="form-group">
							<label for="name">Admin Name</label>
							<input type="text" name="admin-name" placeholder="Admin Name" required
								class="form-control" />
						</div>

						<div class="form-group">
							<label for="name">Password</label>
							<input type="password" name="admin-password" placeholder="Your Password" required
								class="form-control" />
						</div>

						<div class="form-group">
							<input type="submit" name="login" value="Login" class="btn btn-primary" />
						</div>
					</fieldset>
				</form>
				<!--8.display message -->
				<span class="text-danger">
					<?php if (isset($errormsg)) {
						echo $errormsg;
					} ?>
				</span>

			</div>
		</div>
	</div>
</body>

</html>