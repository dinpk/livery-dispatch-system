<?php 

$db_host = "localhost";
$db_name = "liverydispatchsystem";
$db_user = "root";
$db_password = "asdf";

function db_connection() {
	$dbcon = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);
	if (mysqli_connect_errno()) die("Could not connect to the database, please contact your system administrator.");
	mysqli_query($dbcon, "SET NAMES 'utf8'");
	return $dbcon;
}


if (isset($_POST["login"])) {

	$username = isset($_POST["username"]) ? trim($_POST["username"]) : "";
	$password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
	if (empty($username) || empty($password)) {
		$message = "<div style='color:red;'>Provide username and password</div><br>";
	} else {
		$dbcon = db_connection();
		$results = mysqli_query($dbcon, "SELECT password, permission_items, first_name, last_name FROM staff WHERE username = '$username'");
		if ($row = mysqli_fetch_assoc($results)) {
			if (!password_verify($password, $row['password'])) {
				$message = "<div  style='color:red;'>Invalid username or password</div><br>";
			} else {
				session_start();
				$_SESSION["loggedin"] = true;
				$_SESSION["username"] = $row['username'];
				$_SESSION["permission_items"] = json_decode($row['permission_items']);
				$_SESSION["staff_name"] = $row['first_name'] . " " . $row['last_name'];
				header("Location: index.php");
				exit;
			}
     } else {
        $message = "<div  style='color:red;'>Invalid username or password</div><br>";
     }
     mysqli_close($dbcon);	
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <?php include('php/_head.php'); ?>
	<style>
		body {
			background-image:url(https://picsum.photos/1900/1000?random=1);
			background-size:cover;
			font-family:Arial;
			padding:0;
			
		}
		main {
			width:100vw;
			height:100vh;
			display:flex;
			justify-content:center;
			align-items:center;
			margin:0;
		}
		section {
			border:4px solid white;
			padding:20px;
		}
		form {
			background-color:white;
			padding:30px;
			border:1px solid black;
			
		}
		input {
			padding:4px 15px 4px 15px;
			width:100%;
			display:block;
		}
	</style>
</head>
<body>

	<main>
		<section>
			<form method="post">
				<h1>Login</h1>

				<?php if (isset($message)) print $message; ?>

				<input type="text" name="username" autofocus value="<?php if (isset($username)) print $username ?>" placeholder="Username" required><br>

				<input type="password" name="password" placeholder="password" required><br>

				<br>

				<input type="submit" name="login" value="Login"> 

			</form>
		</section>
	</main>

</body>
</html>
