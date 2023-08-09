<?php
session_start();
require '../Controller/header.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Forgot Password</title>
</head>
<body>
	<?php
		$sqtErr=$usernameErrMsg="";
		$sq=$sqt=$Username ="";
		$status="";
		$count1=0;
			$errorcount=0;
			if ($_SERVER['REQUEST_METHOD'] === "POST"){
			function test_input($data) {
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}
			$sq = isset($_POST['sq']) ? test_input($_POST['sq']):NULL;
			$sqt = test_input($_POST['sqt']);
			$Username = test_input($_POST['username']);
			if(empty($sqt)){
				$sqtErr= "Security Question is empty";
				$errorcount++;
			}
			if(empty($Username)){
				$usernameErrMsg = "Username is Empty";
				$errorcount++;
			}	
			}
			if($errorcount==0 and $Username!="" and $sqt!=""){
				if(filesize("../model/sellerdata.json")>0){
					$f = fopen("../model/sellerdata.json", 'r');
					$s = fread($f, filesize("../model/sellerdata.json"));
					$data = json_decode($s);
					for ($x = 0; $x < count($data); $x++) {
						if($data[$x]->username===$Username and $data[$x]->sqt===$sqt and $data[$x]->sq===$sq){
							$_SESSION["id"]=$data[$x]->id;
							header("Location: recovarypassword.php");
							$count1++;
							break;
						}
						else
							$status="Information Mismatch";
					}
						
				}				
			}
			
	?>




			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>
				<fieldset>
					<legend>
						Forgot Password
					</legend>
					<label for="username">Username</label>
						<input type="text" name="username" id="username" value="<?php echo $Username?>">
						<span style="color: red">
						<?php
							echo $usernameErrMsg;
						?>
					</span>
						<br><br>
					<label for="sq">Security Question You answered</label>
					<br><br>

						<select id="sq" name="sq">
							<option value="sq1">What is your nick name?</option>
							<option value="sq2">What is your home town?</option>
							<option value="sq3">What was your school?</option>
							
						</select>


						<input type="text" name="sqt" id="sqt" value="<?php echo $sqt?>">
						<span style="color: red">
						<?php
							echo $sqtErr;
						?>
					</span>
						<br><br>
						<input type="Submit" name="Recover">
				</fieldset>
			</form>
			<h1><?php
			echo $status;
			?></h1>

</body>
</html>
<?php
require '../Controller/fotter.php';

?>
