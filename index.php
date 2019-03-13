<?php require_once("include/Session.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php Confirm_login(); ?>

 <!DOCTYPE html>
<html>
<head>
<title>Welcome</title>
</head>
<body>
<?php
if(isset($_SESSION["User_Id"])){
echo "My ID is ". $_SESSION["User_Id"] . " with the name " . $_SESSION["User_Name"] . " and E-mail " . $_SESSION["User_Email"];}
?>
<h1>Welcome</h1>
<a href="Logout.php">Logout Now</a>

<p></p>

</body>
</html>
