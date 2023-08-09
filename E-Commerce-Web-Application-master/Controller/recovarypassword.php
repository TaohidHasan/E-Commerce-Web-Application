<?php
session_start();
require '../Controller/header.php';
if(!isset($_SESSION["id"]))
{
	header("Location: ../views/sellerlogin.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<?php
	$newpassErr=$retypepassErr="";
	$newpass=$retypepass="";
	$passchangeStatus="";
	$errorcount=0;
	$count=0;
	if ($_SERVER['REQUEST_METHOD'] === "POST") {

		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		$newpass = test_input($_POST['newpassword']);
		$retypepass = test_input($_POST['retypepassword']);
		if(empty($newpass)){
			$newpassErr = "New password is Empty";
			$errorcount++;
		}
		if(empty($retypepass)){
			$retypepassErr = "Confirm Password is Empty";
			$errorcount++;
		}
		else
		{
			if($newpass!=$retypepass)
			{
				$retypepassErr = "Passwors mismatch";
				$errorcount++;
		}
			}
			$id=$_SESSION["id"];
			if($errorcount==0 and $newpass!="" and $retypepass!=""){
				if(filesize("../model/sellerdata.json")>0){
					$f = fopen("../model/sellerdata.json", 'r');
					$s = fread($f, filesize("../model/sellerdata.json"));
					$data = json_decode($s);
					fclose($f);
					for ($x = 0; $x < count($data); $x++) {
						if($data[$x]->id===$id){
							$data[$x]->password=$newpass;
							
							$f = fopen("../model/sellerdata.json", "w");
							fwrite($f, json_encode($data));
							fclose($f);
							$passchangeStatus="Password Updated";
							echo "<a href='../views/sellerlogin.php'>Go To Login</a>";
							session_unset();
							session_destroy();
							break;
						}
						else
							$loginStatus="Error";
					}
						
				}				
			}
		}






	?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Recover Password</title>
</head>
<body>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>
	<fieldset>
		<legend>
			Recover Password
		</legend>
		<label for="newpassword" >New Password</label>
		<input type="password" name="newpassword" id="newpassword" autofocus>
		<span style="color: red">
		<?php
			echo $newpassErr;
		?>
		</span>
		<br><br>
		<label for="retypepassword" >Confirm Password</label>
		<input type="password" name="retypepassword" id="retypepassword" >
		<span style="color: red">
		<?php
			echo $retypepassErr;
		?>
		</span>
		<br><br>
		<input type="Submit" name="changepassword" id="changepassword" value="Change Password">
	</fieldset>
</form>
		<?php
			echo $passchangeStatus;
		?>
		
</body>
</html>
<?php
require '../Controller/fotter.php';

?>
