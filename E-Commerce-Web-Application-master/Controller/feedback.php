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
	<title>Feedback</title>
</head>
<body>
	








	<?php 
	if(isset($_SESSION['id']))
	{
	$id=$_SESSION['id'];}
	elseif (isset($_COOKIE['id'])) {
		

		$id=$_COOKIE['id'];
		
	}
if(filesize("../model/productfeedback.json")<=0){
		echo"No users Available";
	}
	else{

$f = fopen("../model/productfeedback.json", 'r');
	$s = fread($f, filesize("../model/productfeedback.json"));
	$data = json_decode($s);

	echo "<table>";
	echo "<tr>";
	echo "<th>Customer Name</th>";
	echo "<th>Product Name</th>";
	echo "<th>Quantity</th>";
	echo "<th>Feedback</th>";
	
	echo "</tr>";
	
		
	echo "<tr>";
  echo "<td>" . $data[$id-1]->cname . "</td>";
	echo "<td>" .$data[$id-1]->pname . "</td>";
	
	echo "<td>" . $data[$id-1]->quantity . "</td>";
	echo "<td>" . $data[$id-1]->feedback . "</td>";
	
	echo "</tr>";
	
	echo "</table>";
	fclose($f);
	}
	?>

	

</body>
</html>
<?php
require '../Controller/fotter.php';

?>


