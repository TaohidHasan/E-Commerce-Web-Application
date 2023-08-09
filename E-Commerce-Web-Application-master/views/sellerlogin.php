<?php
session_start();
require '../Controller/header.php';
if(isset($_SESSION["id"]))
{
	header("Location: welcome.php");
}
elseif (isset($_COOKIE["id"])) {
	header("Location: welcome.php");
	
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Log In</title>
</head>
<body>
	<?php
		$passwordErrMsg=$usernameErrMsg="";
		$Password=$Username ="";
		$loginStatus="";
		$count1=0;
			$errorcount=0;
			if ($_SERVER['REQUEST_METHOD'] === "POST"){
			function test_input($data) {
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}

			$Password = test_input($_POST['password']);
			$Username = test_input($_POST['username']);
			$rm = isset($_POST['rm']) ? test_input($_POST['rm']):NULL;
			if(empty($Password)){
				$passwordErrMsg = "Password is Empty";
				$errorcount++;
			}
			if(empty($Username)){
				$usernameErrMsg = "Username is Empty";
				$errorcount++;
			}	
			}
			if($errorcount==0 and $Username!="" and $Password!=""){
				if(filesize("../model/sellerdata.json")>0){
					$f = fopen("../model/sellerdata.json", 'r');
					$s = fread($f, filesize("../model/sellerdata.json"));
					$data = json_decode($s);
					fclose($f);
					for ($x = 0; $x < count($data); $x++) {
						if($data[$x]->username===$Username and $data[$x]->password===$Password){
							$_SESSION["id"]=$data[$x]->id;
							if($rm!=null)
								{
									setcookie("id",$data[$x]->id,time()+10000,"/");
									
								}
							header("Location: welcome.php");
							$count1++;
							break;
						}
						else
							$loginStatus="Login Error";
					}
						
				}				
			}
			
	?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"method="POST" novalidate>
	<fieldset>
		<legend>Log in Info</legend>
		<label for="username">Username</label>
		<input type="text" name="username" id="username" autofocus value="<?php echo $Username?>">
		<span style="color: red">
		<?php
			echo $usernameErrMsg;
		?>
		</span>
		<br><br>
		<label for="password">Password</label>
		<input type="password" name="password" id="password">
		<span style="color: red">
		<?php
			echo $passwordErrMsg;
		?>
		</span>
		<br><br>
		<input type="checkbox" name="rm" id="rm">
		<label for="rm">Remember me?</label>
	</fieldset>
	<br>
	<input type="Submit" value="Log in">
	<h1><?php
			echo $loginStatus;
?></h1>
</form>
<p>Don't have an account? <a href="sellerRegistration.php">Register</a></p>
<a href="../Controller/sellerforgetpassword.php">Forgot Password?</a>
</body>
</html>
<?php
require '../Controller/fotter.php';

?>
