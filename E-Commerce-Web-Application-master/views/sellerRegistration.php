<?php
require '../Controller/header.php';

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Seller Registration</title>
</head>
<body><?php 
	$firstnameErrMsg =$passwordErrMsg=$usernameErrMsg= $lastnameErrMsg = $genderErrMsg = $emailErrMsg = $mobileErrMsg = $addressErrMsg =$ApasswordErrMsg =$pickupErrMsg = $sqtErrMsg = $areaErrMsg = "";
	$registrationStatus="";
	$errorcount=0;
	$count=0;
	$First_Name = "";
		$Last_Name = "";
		$Email = "";
		$Mobileno = "";
		$adress = "";
		$pickup = "";
		
		
	
		$Username = "";
		
		$sqt = "";
	
	if ($_SERVER['REQUEST_METHOD'] === "POST") {

		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		$First_Name = test_input($_POST['firstname']);
		$Last_Name = test_input($_POST['lastname']);
		$Email = test_input($_POST['email']);
		$Mobileno = test_input($_POST['mobileNo']);
		$adress = test_input($_POST['address']);
		$pickup = test_input($_POST['pickup']);
		$Gender = isset($_POST['gender']) ? test_input($_POST['gender']):NULL;
		$Area = isset($_POST['area']) ? test_input($_POST['area']):NULL;
		$Password = test_input($_POST['password']);
		$APassword = test_input($_POST['againpassword']);
		$Username = test_input($_POST['username']);
		$sq = isset($_POST['sq']) ? test_input($_POST['sq']):NULL;
		$sqt = test_input($_POST['sqt']);
		

		if(empty($First_Name)){
			$firstnameErrMsg = "First Name is Empty";
			$errorcount++;
		}
		else{
			if (!preg_match("/^[a-zA-Z-' ]*$/",$First_Name)) {
				$errorcount++;
				$firstnameErrMsg = "Only letters and spaces";
			}}
		if(empty($Last_Name)){
			$lastnameErrMsg = "Last Name is Empty";
			$errorcount++;
		}
		else {
			if (!preg_match("/^[a-zA-Z-' ]*$/",$Last_Name)) {
				$errorcount++;
				$lastnameErrMsg = "Only letters and spaces";
			}
		}
		if(empty($Gender)){
			$genderErrMsg = "Gender is Empty";
			$errorcount++;
		}
		if(empty($Password)){
			$passwordErrMsg = "Password is Empty";
			$errorcount++;
		}
		if(empty($pickup)){
			$pickupErrMsg = "PickUp address is Empty";
			$errorcount++;
		}
		if(empty($sqt)){
			$sqtErrMsg = "Scurity question is Empty";
			$errorcount++;
		}
		if(empty($Username)){
			$usernameErrMsg = "Username is Empty";
			$errorcount++;
		}
		if(empty($Area)){
			$AreaErrMsg = "Country is Empty";
			$errorcount++;
		}
		if(empty($Mobileno)){
			$mobileErrMsg = "Mobile  is Empty";
			$errorcount++;
		}
		else{
			if (!preg_match("/^[0-9]*$/",$Mobileno)) {
				$errorcount++;
				$mobileErrMsg = "Only Numbers";
			}}
		if(empty($Email)){
			$emailErrMsg = "Email  is Empty";
			$errorcount++;
		}
		else {
			if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
				$emailErrMsg .= "Please correct your email";
				$errorcount++;
			}
		}
		if(empty($adress)){
			$addressErrMsg = "Address is Empty";
			$errorcount++;
		}	

		if(empty($APassword)){
			$ApasswordErrMsg = "Retype Password is Empty";
			$errorcount++;
		}
		else
		{
			if($APassword!=$Password)
			{
				$ApasswordErrMsg = "Password does not match";
				$errorcount++;
			}
		}


		if($errorcount==0){
			if(filesize("../model/sellerdata.json")<=0){
			$arr = array(array('id' => 1,'firstname' => $First_Name, 'lastname' => $Last_Name ,'gender' => $Gender,'email'=> $Email,'mobile_no'=>$Mobileno,'address'=> $adress,'area'=>$Area,'password'=>$Password,'username'=>$Username,'pickup'=>$pickup,'sq'=> $sq,'sqt'=> $sqt));
			$f = fopen("../model/sellerdata.json", "a");
			fwrite($f, json_encode($arr));
			fclose($f);
			}
			else if(filesize("../model/sellerdata.json")>0){
			
			$f = fopen("../model/sellerdata.json", 'r');
			$s = fread($f, filesize("../model/sellerdata.json"));
			$data = json_decode($s);
			$arr2 = array('id' => count($data)+1,'firstname' => $First_Name, 'lastname' => $Last_Name ,'gender' => $Gender,'email'=> $Email,'mobile_no'=>$Mobileno,'address'=> $adress,'area'=>$Area,'password'=>$Password,'username'=>$Username,'pickup'=>$pickup,'sq'=> $sq,'sqt'=> $sqt);
			array_push($data, $arr2);
			fclose($f);
			$f = fopen("../model/sellerdata.json", "w");
			fwrite($f, json_encode($data));
			fclose($f);
			}

			$registrationStatus="Registration Successfull";
		}

		else{
			$registrationStatus="Registration failed";
		}	
	}		
?>







<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>
	<fieldset>
		<legend>Genaral</legend>
		<label for="firstname">First Name</label>
		<input type="text" name="firstname" id="firstname" autofocus value="<?php echo $First_Name?>">
		<span style="color: red">
		<?php
			echo $firstnameErrMsg;
		?>
		</span>
		<br><br>
		<label for="lastname">Last Name</label>
		<input type="text" name="lastname" id="lastname" value="<?php echo $Last_Name?>">
		<span style="color: red">
		<?php
			echo $lastnameErrMsg;
		?>
		</span>
		<br><br>
		<label for="gender">Gender: </label>
		
		<input type="radio" name="gender" id="male" value="Male">
		<label for="male">Male</label>
		
		<input type="radio" name="gender" id="female" value="Female">
		<label for="female">Female</label>
		<span style="color: red">
		<?php
			echo $genderErrMsg;
		?>
		</span>
	</fieldset>
	<fieldset>
		<legend>Contact</legend>
		<label for="email">Email</label>
		<input type="email" name="email" id="email" value="<?php echo $Email?>">
		<span style="color: red">
		<?php
			echo $emailErrMsg;
		?>
		</span>
		
		<br><br>
		<label for="mobileNo">Mobile No</label>
		<input type="text" name="mobileNo" id="mobileNo" value="<?php echo $Mobileno?>">
		<span style="color: red">
		<?php
			echo $mobileErrMsg;
		?>
		</span>
		
	</fieldset>
	<fieldset>
		<legend>Address</legend>
		<label for="address">Street/House/Road</label>
		<input type="text" name="address" id="address" value="<?php echo $adress?>">
		<span style="color: red">
		<?php
			echo $addressErrMsg;
		?>
		</span>
		
		<br><br>
		<label for="area">Area</label>
		<select id="area" name="area">
			<option value="mirpur">Mirpur</option>
			<option value="gulshan">Gulshan</option>
			<option value="uttora">Uttora</option>
			<option value="gantoli">Gabtoli</option>
		</select>
		<span style="color: red">
		<?php
			echo $areaErrMsg;
		?>
		</span>
		<br><br>

		<label for="pickup">Product Pickup Adress</label>
		<input type="text" name="pickup" id="pickup" value="<?php echo $pickup?>">
		<span style="color: red">
		<?php
			echo $pickupErrMsg;
		?>
		</span>
		
		<br><br>
	</fieldset>
	<fieldset>
		<legend>Log in Info</legend>
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?php echo $Username?>">
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

		<label for="againpassword">Confirm Password</label>
		<input type="password" name="againpassword" id="againpassword">
		<span style="color: red">
		<?php
			echo $ApasswordErrMsg;
		?>
		</span>
		<br><br>
		<label for="sqt">Security Question</label>

		<select id="sq" name="sq">
			<option value="sq1">What is your nick name?</option>
			<option value="sq2">What is your home town?</option>
			<option value="sq3">What was your school?</option>
			
		</select>


		<input type="text" name="sqt" id="sqt" value="<?php echo $sqt?>">
		<span style="color: red">
		<?php
			echo $sqtErrMsg;
		?>
		</span>
	</fieldset>
	<br>
	<input type="Submit" value="Registration">
</form>
<h1><?php
			echo $registrationStatus;
?></h1>
<h4>If you already have an account <a href="sellerlogin.php">login</a></h6>

</body>
</html>
<?php
require '../Controller/fotter.php';

?>
