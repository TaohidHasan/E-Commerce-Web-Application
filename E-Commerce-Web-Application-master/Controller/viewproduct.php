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
	<title>View Product</title>
</head>
<body>








	<?php 
	if(isset($_SESSION['id']))
	{
	$id=$_SESSION['id'];}
	elseif (isset($_COOKIE['id'])) {
		

		$id=$_COOKIE['id'];
		
	}
if(filesize("../model/productdata.json")<=0){
		echo"No users Available";
	}
	else{

$f = fopen("../model/productdata.json", 'r');
	$s = fread($f, filesize("../model/productdata.json"));
	$data = json_decode($s);

	echo "<table>";
	echo "<tr>";
	echo "<th>Product ID</th>";
	echo "<th>Product Name</th>";
	echo "<th>Price</th>";
	echo "<th>Quantity</th>";
	echo "<th>Description</th>";
	
	echo "</tr>";
	for ($x = 0; $x < count($data); $x++) {
		if($id==$data[$x]->id){
	echo "<tr>";
  	echo "<td>" . $data[$x]->productid . "</td>";
	echo "<td>" . $data[$x]->pname . "</td>";
	echo "<td>" . $data[$x]->price . "</td>";
	echo "<td>" . $data[$x]->quantity . "</td>";
	echo "<td>" . $data[$x]->descip . "</td>";
	
	echo "</tr>";
	}}
	echo "</table>";
	fclose($f);
	}
	?>

	

</body>
</html>
<?php
require '../Controller/fotter.php';

?>


