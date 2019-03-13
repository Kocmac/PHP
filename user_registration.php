<?php require_once("include/Session.php"); ?>
<?php require_once("include/Style.css"); ?>
<?php require_once("include/Functions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_POST["Submit"])) {
$Username = mysqli_real_escape_string($connection,$_POST["Username"]);
$Email = mysqli_real_escape_string($connection,$_POST["Email"]);
$Password = mysqli_real_escape_string($connection,$_POST["Password"]);
$ConfirmPassword = 	mysqli_real_escape_string($connection,$_POST["ConfirmPassword"]);
$Token = bin2hex(random_bytes(16));

if (empty($Username) or empty($Email) or empty($Password) or empty($ConfirmPassword)) {
	$_SESSION["message"] = "All fields must be filled out";
	Redirect_To("User_Registration.php");

}elseif ($Password !== $ConfirmPassword) {
	$_SESSION["message"] = "Both Password Value must be Same";
	Redirect_To("User_Registration.php");

}elseif (strlen($Password) <4 ) {
	$_SESSION["message"] = "Password Should Include at least 4 Values";
	Redirect_To("User_Registration.php");

}elseif (CheckEmailExist($Email)) {
	$_SESSION["message"] = "Email Is Already in Use";
	Redirect_To("User_Registration.php");

}else{
	global $connection;
	$hashed_Password = Password_Encryption($Password);
	$Query = "INSERT INTO admin_panel (username,email,password,token,active)
	VALUES ('$Username', '$Email', '$hashed_Password','$Token','OFF')";
	$Execute = mysqli_query($connection,$Query);

	if ($Execute) {

$subject  = 'Confirm Account';
$message  = 'Hi ' . $Username . ', Here is the link to confirm your account http://localhost/PHPCOURSE/user_registration/Activation.php?token=' .$Token; 
$SenderEmail  = 'From: vasiliadis.kosmas@gmail.com';
		if(mail($Email, $subject, $message, $SenderEmail)){
			$_SESSION["SuccessMessage"] = "Check Email for Activation";
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
			<title>Register Now</title>
			
</head>

		<body>
<div>
<?php echo message(); ?>
<?php echo SuccessMessage(); ?></div>
<div id="centerform">
	<form action="User_Registration.php" method="post">
		<fieldset>
	<span class="info">Username:</span><br><input type="Text" name="Username" value=""><br>
	<span class="info">Email:</span><br><input type="Email" name="Email" value=""><br>
	<span class="info">Password:</span><br><input type="Password" name="Password" value=""><br>
	<span class="info">Confirm Password:</span><br><input type="Password" name="ConfirmPassword" value="">
	<br><input type="Submit" name="Submit" value="Register"><br>

		</fieldset>	

		</form>		
</div>	
		</body>

</html>