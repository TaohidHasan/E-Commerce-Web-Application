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
	<title>Profile</title>
</head>
<body>
	<?php
	if(isset($_SESSION['id']))
	{
	$id=$_SESSION['id'];}
	elseif (isset($_COOKIE['id'])) {
		

		$id=$_COOKIE['id'];
		
	}
	$First_Name = "";
		$Last_Name = "";
		$Email = "";
		$Mobileno =0;
		$adress = "";
		$pickup = "";
		$Gender = "";
		$Area = "";		
			$firstnameErrMsg =$passwordErrMsg=$usernameErrMsg= $lastnameErrMsg = $genderErrMsg = $emailErrMsg = $mobileErrMsg = $addressErrMsg =$pickupErrMsg = $areaErrMsg = "";
	$uppdateStatus="";
	$errorcount=0;
	$count=0;
		$Username = "";
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
						$Username = test_input($_POST['username']);
								$First_Name = test_input($_POST['firstname']);
								$Last_Name = test_input($_POST['lastname']);
								$Email = test_input($_POST['email']);
								$Mobileno = test_input($_POST['mobileno']);
								$adress = test_input($_POST['addres']);
								$pickup = test_input($_POST['pickup']);
								$Gender = isset($_POST['gender']) ? test_input($_POST['gender']):NULL;
								$Area = isset($_POST['area']) ? test_input($_POST['area']):NULL;
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
				if(empty($pickup)){
			$pickupErrMsg = "PickUp address is Empty";
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
if($errorcount==0)
{
		$f = fopen("../model/sellerdata.json", 'r');
					$s = fread($f, filesize("../model/sellerdata.json"));
					$data = json_decode($s);
					fclose($f);
					
						
							$data[$id-1]->username=$Username;
							$data[$id-1]->firstname=$First_Name;
							$data[$id-1]->lastname=$Last_Name;
							$data[$id-1]->gender=$Gender;
							$data[$id-1]->email=$Email;
							$data[$id-1]->mobile_no=$Mobileno;
							$data[$id-1]->address=$adress;
							$data[$id-1]->area=$Area;
							$data[$id-1]->pickup=$pickup;




							
							$f = fopen("../model/sellerdata.json", "w");
							fwrite($f, json_encode($data));
							fclose($f);
							$uppdateStatus="Information Updated";







					







}
}

					
						
							$First_Name=$data[$id-1]->firstname;
							$Last_Name=$data[$id-1]->lastname;
							$Email=$data[$id-1]->email;
							$Mobileno=$data[$id-1]->mobile_no;
							$adress=$data[$id-1]->address;
							$pickup=$data[$id-1]->pickup;
							$Area=$data[$id-1]->area;
							
							$Username=$data[$id-1]->username;
							$gender=$data[$id-1]->gender;
							if($gender=="Male")
							{
								$gsm="Checked";
								$gsf="";
							}
							else
							{
								$gsm="";
								$gsf="Checked";
							}
							if($Area=="mirpur")
							{
								$sm="selected";
								$sg="";
								$su="";
								$sga="";


							}
							elseif ($Area=="gulshan")
							{
								$sg="selected";
								$sm="";
								$su="";
								$sga="";
							}
							elseif ($Area=="uttora")
							{
								$su="selected";
								$sg="";
								$sm="";
								$sga="";
							}
							elseif ($Area=="gantoli")
							{
								$sga="selected";
								$sg="";
								$su="";
								$sm="";
							}





							
							
							
						
					
				
}

	?>





<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>
	<fieldset>
		<legend>Update/view Profile</legend>
		<label for="id">ID</label>
		<input type="text" name="id" id="id" placeholder="<?php echo $id?>" readonly>
		<br><br>
		<label for="username">User Name</label>
		<input type="text" name="username" id="username" value="<?php echo $Username?>">
		<span style="color: red">
		<?php
			echo $usernameErrMsg;
		?>
		</span>
		<br><br>
		<label for="firstname">First Name</label>
		<input type="text" name="firstname" id="firstname" value="<?php echo $First_Name?>">
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
		
		<input type="radio" name="gender" id="male" value="Male" <?php echo $gsm?>>
		<label for="male">Male</label>
		
		<input type="radio" name="gender" id="female" value="Female" <?php echo $gsf?>>
		
		<label for="female">Female</label>
		<span style="color: red">
		<?php
			echo $genderErrMsg;
		?>
		</span>
		<br><br>
		<label for="email">Email</label>
		<input type="email" name="email" id="email" value="<?php echo $Email?>">
		<span style="color: red">
		<?php
			echo $emailErrMsg;
		?>
		</span>
		
		<br><br>
		<label for="mobileno">Mobile No</label>
		<input type="text" name="mobileno" id="mobileno" value="<?php echo $Mobileno?>">
		<br><br>
		<label for="area">Area</label>
		<select id="area" name="area">
			<option value="mirpur" <?php echo $sm?>>Mirpur</option>
			<option value="gulshan" <?php echo $sg?>>Gulshan</option>
			<option value="uttora" <?php echo $su?>>Uttora</option>
			<option value="gantoli" <?php echo $sga?>>Gabtoli</option>
		</select>
		<span style="color: red">
		<?php
			echo $areaErrMsg;
		?>
		</span>
		<br><br>
		<label for="addres">Address</label>
		<input type="text" name="addres" id="addres" value="<?php echo $adress?>">
		<span style="color: red">
		<?php
			echo $addressErrMsg;
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
		<input type="submit" name="update" id="update" value="Update Info">
	</fieldset>
	<h2>
<?php
echo $uppdateStatus;

?>
</h2>

</form>

</body>
</html>
<?php
require '../Controller/fotter.php';

?>
