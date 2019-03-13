<?php require_once("include/Session.php"); ?>
<?php require_once("include/Style.css"); ?>
<?php require_once("include/Functions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_POST["Submit"])) {
$Email = mysqli_real_escape_string($connection,$_POST["Email"]);
$Password = mysqli_real_escape_string($connection,$_POST["Password"]);

if (empty($Email) or empty($Password)) {
	$_SESSION["message"] = "All fields must be filled out";
	Redirect_To("Login.php");
}else {
	if(ConfirmingAccount()) {
	$Found_Account = Login_Attemt($Email,$Password);
	if ($Found_Account) {
    $_SESSION["User_Id"] = $Found_Account['id'];
    $_SESSION["User_Name"] = $Found_Account['username'];
    $_SESSION["User_Email"] = $Found_Account['email'];
    if(isset($_POST["Remember"])) {
                $ExpireTime = time()+86400;
                setcookie("SettingEmail",$Email,$ExpireTime);

    }
		Redirect_To("Welcome.php");
	}else{
		$_SESSION["message"] = "Invalid Email/Password";
	Redirect_To("Login.php");
	}
	}else{
	$_SESSION["message"] = "Account Confirmation Required";
	Redirect_To("Login.php");
	}
	}
}
?>
<div>

<!DOCTYPE html>

<html>
<head>
			<title>Login</title>

</head>

		<body>
<?php echo message(); ?>
<?php echo SuccessMessage(); ?></div>
<div id="centerform">
	<form action="Login.php" method="post">
		<fieldset>
	<span class="info">Email:</span><br><input type="Email" name="Email" value=""><br>
	<span class="info">Password:</span><br><input type="Password" name="Password" value=""><br>
  <input type="checkbox" name="Remember"><span class = "info"> &nbsp;Remember me<span/><br>
  <br><a href="Recover_Account.php"><span class = "info">Forgot Password<span></a>
	<br><input type="Submit" name="Submit" value="Login"><br>

		</fieldset>

		</form>
</div>
		</body>

</html>
