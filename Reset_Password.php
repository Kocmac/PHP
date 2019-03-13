<?php require_once("include/Session.php"); ?>
<?php require_once("include/Style.css"); ?>
<?php require_once("include/Functions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_GET['token'])) {
	$TokenFromURL = $_GET['token'];
if (isset($_POST["Submit"])) {

$Password = mysqli_real_escape_string($connection,$_POST["Password"]);
$ConfirmPassword = 	mysqli_real_escape_string($connection,$_POST["ConfirmPassword"]);


if (empty($Password) or empty($ConfirmPassword)) {
	$_SESSION["message"] = "All fields must be filled out";
}elseif ($Password !== $ConfirmPassword) {
	$_SESSION["message"] = "Both Password Value must be Same";
}elseif (strlen($Password) <4 ) {
	$_SESSION["message"] = "Password Should Include at least 4 Values";

}else{
	global $connection;
	$hashed_Password = Password_Encryption($Password);
  $Query = "UPDATE admin_panel SET password = '$hashed_Password' WHERE token = '$TokenFromURL'";
  $Execute = mysqli_query($connection,$Query);
  if($Execute){
    $_SESSION["SuccessMessage"] = "Password Changed Succesfully";
  			Redirect_To("Login.php");
  }else{
    $_SESSION["message"] = "Something Went Wrong Try Again";
  				Redirect_To("Login.php");
  }

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
			<title>Create New Password</title>

</head>

		<body>
<div>
<?php echo message(); ?>
<?php echo SuccessMessage(); ?></div>
<div id="centerform">
	<form action="Reset_Password.php?token=php echo $TokenFromURL?>" method="post">
		<fieldset>

	<span class="info">New Password:</span><br><input type="Password" name="Password" value=""><br>
	<span class="info">Confirm Password:</span><br><input type="Password" name="ConfirmPassword" value="">
	<br><input type="Submit" name="Submit" value="Submit"><br>

		</fieldset>

		</form>
</div>
		</body>

</html>
