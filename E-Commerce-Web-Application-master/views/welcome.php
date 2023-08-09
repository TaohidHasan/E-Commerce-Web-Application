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
	<title>Welcome</title>
</head>
<body>

	<?php

					$f = fopen("../model/sellerdata.json", 'r');
					$s = fread($f, filesize("../model/sellerdata.json"));
					$data = json_decode($s);
					fclose($f);
					if(isset($_SESSION['id']))
					{
					$firstname=$data[$_SESSION['id']-1]->firstname;
					$lastname=$data[$_SESSION['id']-1]->lastname;}
					elseif (isset($_COOKIE['id'])) {
						$firstname=$data[$_COOKIE['id']-1]->firstname;
					$lastname=$data[$_COOKIE['id']-1]->lastname;
					}



	?>
<h3>welcome <?php
echo $firstname." ".$lastname; 
?>

</h3>






</body>
<fieldset>
<img src="../Controller/welcome.jpg"  width="1300" height="300">
</fieldset>
</html>
<?php
require '../Controller/fotter.php';

?>
