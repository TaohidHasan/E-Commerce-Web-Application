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
	<title>Contact Us</title>
</head>
<body>
	<?php
	$cmntErrMsg =$nameErrMsg = $phnErrMsg = $emailErrMsg = "";
	$cmntStatus="";
	$errorcount=0;
	$count=0;
	if ($_SERVER['REQUEST_METHOD'] === "POST") {

		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		if(isset($_SESSION['id']))
	{
	$id=$_SESSION['id'];}
	elseif (isset($_COOKIE['id'])) {
		

		$id=$_COOKIE['id'];
		
	}

		$name = test_input($_POST['name']);
		$phn = test_input($_POST['phn']);
		$email = test_input($_POST['email']);
		$cmnt = test_input($_POST['cmnt']);
		if(empty($name)){
			$nameErrMsg = "Name is Empty";
			$errorcount++;
		}
		else{
			if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
				$errorcount++;
				$nameErrMsg = "Only letters and spaces";
			}}
			if(empty($email)){
			$emailErrMsg = "Email is Empty";
			$errorcount++;
		}
		else{
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errorcount++;
				$nameErrMsg = "Only letters and spaces";
			}}
			if(empty($cmnt)){
			$cmntErrMsg = "Comment is Empty";
			$errorcount++;
		}
		if(empty($phn)){
			$phnErrMsg = "Mobile  is Empty";
			$errorcount++;
		}
		else{
			if (!preg_match("/^[0-9]*$/",$phn)) {
				$errorcount++;
				$phnErrMsg = "Only Numbers";
			}}

			if($errorcount==0){
			if(filesize("../model/sellercmntdata.json")<=0){
			$arr = array(array('id' => $id,'name' => $name,'phn' => $phn,'email' => $email,'cmnt' => $cmnt));
			$f = fopen("../model/sellercmntdata.json", "a");
			fwrite($f, json_encode($arr));
			fclose($f);
			}
			else if(filesize("../model/sellercmntdata.json")>0){
			
			$f = fopen("../model/sellercmntdata.json", 'r');
			$s = fread($f, filesize("../model/sellercmntdata.json"));
			$data = json_decode($s);
			$arr2 = array('id' => $id,'name' => $name,'phn' => $phn,'email' => $email,'cmnt' => $cmnt);
			array_push($data, $arr2);
			fclose($f);
			$f = fopen("../model/sellercmntdata.json", "w");
			fwrite($f, json_encode($data));
			fclose($f);
			}

			$cmntStatus="Comment sent Successfull";
		}

		else{
			$cmntStatus="Comment sending failed";
		}	








	}




	?>
	

	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>
<fieldset>
	<legend>Contact Us</legend>
	<label for="name">Name</label>
	<input type="text" name="name" id="name" autofocus>
			<span style="color: red">
		<?php
			echo $nameErrMsg;
		?>
		</span>
	<br><br>
	<label for="phn">Phone Number</label>
	<input type="text" name="phn" id="phn">
			<span style="color: red">
		<?php
			echo $phnErrMsg;
		?>
		</span>
	<br><br>
	<label for="email">Email</label>
	<input type="email" name="email" id="email">
			<span style="color: red">
		<?php
			echo $emailErrMsg;
		?>
		</span>
	<br><br>
	<label >Comment</label><br>
	<textarea name="cmnt" rows="10" cols="30"></textarea>
			<span style="color: red">
		<?php
			echo $cmntErrMsg;
		?>
		</span>
	<br><br>
	<input type="submit" name="submit" value="Send">
</fieldset>

</form>
<h1><?php
			echo $cmntStatus;
?></h1>

</body>
</html>
<?php
require '../Controller/fotter.php';

?>