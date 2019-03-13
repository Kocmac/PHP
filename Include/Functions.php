<?php require_once("include/db.php"); ?>

<?php
	function Redirect_To($NewLocation) {
			header("Location:" .$NewLocation);
			exit;
			}
	function Password_Encryption($Password) {
			$Blowfish_Hash_Format = "$2y$10$" ;
			$Salt_Length=22;
			$Salt = Generate_Salt($Salt_Length);
			$Formatting_Blowfish_With_Salt = $Blowfish_Hash_Format .$Salt;
			$Hash = crypt($Password,$Formatting_Blowfish_With_Salt);
					return $Hash;
			}
	function Generate_Salt($length) {
			$Unique_Random_String = md5(uniqid(mt_rand(),true));
			$Base64_String = base64_encode($Unique_Random_String);

			$Modified_Base_String = str_replace('+','.', $Base64_String);
			$Salt = substr($Modified_Base_String, 0 , $length);
				return $Salt;
			}
	function Password_Check($Password,$Existing_Hash)  {
			$Hash = crypt($Password, $Existing_Hash);
			if ($Hash===$Existing_Hash)	{
				return true;
			}	else {
				return false;
			}

		}
	function CheckEmailExist ($Email) {
		global $connection;
		$Query = "SELECT * FROM admin_panel WHERE email = '$Email'";
		$Execute = mysqli_query($connection,$Query);
		if(mysqli_num_rows($Execute)>0) {
			return true;
		}else {
			return false;
		}

	}
	function Login_Attemt ($Email,$Password) {
		global $connection;
		$Query = "SELECT * FROM admin_panel WHERE email = '$Email'";
		$Execute = mysqli_query($connection,$Query);
		if ($Execute){

		while($admin = mysqli_fetch_assoc($Execute)){
				if(Password_Check($Password,$admin["password"])) {
					return $admin;
				}
		}
		}
		else {

		return null;
		}
	}

	function ConfirmingAccount() {
		global $connection;
		$Query = "SELECT * FROM admin_panel WHERE active = 'On'";
		$Execute = mysqli_query($connection,$Query);
		if(mysqli_num_rows($Execute)>0) {
			return true;
		}else {
			return false;
		}
	}
	function Login(){
		if(isset($_SESSION["User_Id"])||isset($_COOKIE["SettingEmail"])) {
			return true;
		}
	}
	function Confirm_login(){
		if(!login()){
		$_SESSION["message"] = "You have to Login";
		Redirect_To("Login.php");
		}
	}
?>
