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

if (empty($Email)){
	$_SESSION["message"] = "Email recuired";
	Redirect_To("Recover_Account.php");

}elseif (!CheckEmailExist($Email)) {
	$_SESSION["message"] = "Email not found";
	Redirect_To("User_Registration.php");

}else{
	global $connection;
	$Query = "SELECT * FROM admin_panel WHERE EMAIL = '$Email'";
	$Execute = mysqli_query($connection,$Query);

	if ($admin=mysqli_fetch_array($Execute)) {
    $admin["username"];
    $admin["token"];

$subject  = 'Reset Password';
$message  = 'Hi ' . $admin["username"] . ', Here is the link to Reset your Password  http://localhost/PHPCOURSE/user_registration/Reset_Password.php?token=' .$admin["token"];
$SenderEmail  = 'From: vasiliadis.kosmas@gmail.com';
		if(mail($Email, $subject, $message, $SenderEmail)){
			$_SESSION["SuccessMessage"] = "Check Email for Resetting Password";
			Redirect_To("Login.php");
		    echo "Email sent";
		}else{
		    echo "Email sending failed";
		    $_SESSION["message"] = "Something Went Wrong Try Again";
				Redirect_To("User_Registration.php");
	}
	}else {
		$_SESSION["message"] = "Something Went Wrong";
		Redirect_To("User_Registration.php");
	}
#Or--------------------------
/*if (mysqli_query($connection, $Query)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($connection);
}*/
#-----------------------------

}
}

?>


<!DOCTYPE html>

<html>
<head>
			<title>Forgot Password</title>

</head>

		<body>
<div>
<?php echo message(); ?>
<?php echo SuccessMessage(); ?></div>
<div id="centerform">
	<form action="Recover_Account.php" method="post">
		<fieldset>
	<span class="info">Email:</span><br><input type="Email" name="Email" value=""><br>
	<br><input type="Submit" name="Submit" value="Submit"><br>

		</fieldset>

		</form>
</div>
		</body>

</html>
