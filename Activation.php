<?php require_once("include/Session.php"); ?>
<?php require_once("include/db.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php
global $connection;
if (isset($_GET['token'])) {
	$TokenFromURL = $_GET['token'];
$Query = "UPDATE admin_panel SET active = 'On' WHERE token = '$TokenFromURL'";
$Execute = mysqli_query($connection,$Query);
if ($Execute) {
	$_SESSION["SuccessMessage"] = "Account Activated Succesfully";
			Redirect_To("Login.php");
}else{
	$_SESSION["message"] = "Something Went Wrong Try Again";
				Redirect_To("User_Registration.php");
}
}




?>