<DOCTYPE>

<html>
		<head>
			<title>hashing_basics</title>
			
		</head>

		<body>
			
<?php
$password ="vasiliadis";
$Blowfish_hash_format = "$2y$10$" ;
$salt = "kosmasvasiliadis214208041985";
echo "Length :" .strlen($salt);
$formatting_blowfish_with_salt = $Blowfish_hash_format .$salt;
$hash = crypt($password,$formatting_blowfish_with_salt);
echo "<br>";
echo "$hash";

?>


		</body>

</html>