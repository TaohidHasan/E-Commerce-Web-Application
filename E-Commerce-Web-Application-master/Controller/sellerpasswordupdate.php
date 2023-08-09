<?php
session_start();
require '../Controller/headin.php';
if(!isset($_SESSION["id"]))
{
	if(!isset($_COOKIE["id"])){
	header("Location: sellerlogin.php");}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Change Password</title>
</head>
<body>





<?php
if(isset($_SESSION['id']))
	{
	$id=$_SESSION['id'];}
	elseif (isset($_COOKIE['id'])) {
		

		$id=$_COOKIE['id'];
		
	}

$Password="";
$newpassword="";
$cpassword="";
$passErrMsg =$newpassErrMsg = $cpassErrMsg = ""; 
$uppdateStatus="";
$errorcount=0;
if(filesize("../model/sellerdata.json")>0){
					$f = fopen("../model/sellerdata.json", 'r');
					$s = fread($f, filesize("../model/sellerdata.json"));
					$data = json_decode($s);
					fclose($f);
					if ($_SERVER['REQUEST_METHOD'] === "POST"){

							function test_input($data) {
							$data = trim($data);
							$data = stripslashes($data);
							$data = htmlspecialchars($data);
							return $data;
						}

							$Password = test_input($_POST['password']);
							$newpassword = test_input($_POST['newpassword']);
							$cpassword = test_input($_POST['confirmpassword']);
							$f = fopen("../model/sellerdata.json", 'r');
					$s = fread($f, filesize("../model/sellerdata.json"));
					$data = json_decode($s);
					fclose($f);
					 
						
							$mainpass=$data[$id-1]->password;


						
							if(empty($Password)){
								$passErrMsg = "Old Password is Empty";
								$errorcount++;
							}
							else
							{
								if($Password!=$mainpass)
								{
									$passErrMsg = "Old Password Does Not Match";
									$errorcount++;
								}
							}


							if(empty($newpassword)){
								$newpassErrMsg = "New Password is Empty";
								$errorcount++;
							}
							if(empty($cpassword)){
								$cpassErrMsg = "Old Password is Empty";
								$errorcount++;
							}
							else
							{
								if($newpassword!=$cpassword)
								{
									$cpassErrMsg = "New password and Cofirm Password does not match";
									$errorcount++;
								}
							}
							if($errorcount==0)
							{
								
						
							$data[$id-1]->password=$newpassword;
	
							
							$f = fopen("../model/sellerdata.json", "w");
							fwrite($f, json_encode($data));
							fclose($f);
							$uppdateStatus="Password Updated";
							}
						
							





						
					}

}







?>

<a href="sellerlogout.php"><button>Log Out</button></a>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>
	<fieldset>
		<legend>Change Password</legend>
		<label for="password">Old Password</label>
		<input type="password" name="password" id="password">
		<span style="color: red">
		<?php
			echo $passErrMsg;
		?>
		</span>
		<br><br>
		<label for="newpassword">New Password</label>
		<input type="password" name="newpassword" id="newpassword">
		<span style="color: red">
		<?php
			echo $newpassErrMsg;
		?>
		</span>
		<br><br>
		<label for="confirmpassword">Confirm Password</label>
		<input type="password" name="confirmpassword" id="confirmpassword">
		<span style="color: red">
		<?php
			echo $cpassErrMsg;
		?>
		</span>
		<br><br>
		<input type="submit" name="changepassword" id="changepassword" value="Change Password">
	</fieldset>
	
</form>
<h2>
<?php
echo $uppdateStatus;

?>
</h2>
</body>
</html>
<?php
require '../Controller/fotter.php';

?>