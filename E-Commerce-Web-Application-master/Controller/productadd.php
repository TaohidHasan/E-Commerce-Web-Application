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
	<title>Add Product</title>
</head>
<body>
<?php
$pnameErrMsg = $priceErrMsg = $quantityErrMsg =$desErrMsg = "";
$productStatus="";
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

		$pname = test_input($_POST['pname']);
		$price = test_input($_POST['price']);
		$quantity = test_input($_POST['quantity']);
		$des = test_input($_POST['des']);
		if(empty($pname)){
			$pnameErrMsg = "Product Name is Empty";
			$errorcount++;
		}
		else{
			if (!preg_match("/^[a-zA-Z-' ]*$/",$pname)) {
				$errorcount++;
				$priceErrMsg = "Only letters and spaces";
			}}
			if(empty($des)){
			$desErrMsg = "Description is Empty";
			$errorcount++;
		}
		
			if(empty($price)){
			$priceErrMsg = "Price is Empty";
			$errorcount++;
		}
		else{
			if (!preg_match("/^[0-9]*$/",$price)) {
				$errorcount++;
				$priceErrMsg = "Only letters and spaces";}}
				if(empty($quantity)){
			$quantityErrMsg = "Price is Empty";
			$errorcount++;
		}
		else{
			if (!preg_match("/^[0-9]*$/",$quantity)) {
				$errorcount++;
				$quantityErrMsg = "Only letters and spaces";}}
			

			if($errorcount==0){
			if(filesize("../model/productdata.json")<=0){
			$arr = array(array('id' => $id,'productid' => 1,'pname' => $pname,'price' => $price,'quantity' => $quantity,'descip' => $des));
			$f = fopen("../model/productdata.json", "a");
			fwrite($f, json_encode($arr));
			fclose($f);
			}
			else if(filesize("../model/productdata.json")>0){
			
			$f = fopen("../model/productdata.json", 'r');
			$s = fread($f, filesize("../model/productdata.json"));
			$data = json_decode($s);
			$arr2 = array('id' => $id,'productid' => count($data)+1,'pname' => $pname,'price' => $price,'quantity' => $quantity,'descip' => $des);
			array_push($data, $arr2);
			fclose($f);
			$f = fopen("../model/productdata.json", "w");
			fwrite($f, json_encode($data));
			fclose($f);
			}

			$productStatus="Product Info sent Successfull";
		}

		else{
			$productStatus="Product Infosending failed";
		}	








	}




?>




<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" novalidate>
<fieldset>
	<legend>Add Product</legend>
	<label for="pname">Product Name</label>
	<input type="text" name="pname" id="pname">
	<span style="color: red">
		<?php
			echo $pnameErrMsg;
		?>
	</span>
	<br><br>
	<label for="price">Price</label>
	<input type="number" name="price" id="price">
	<span style="color: red">
		<?php
			echo $priceErrMsg;
		?>
	</span>
	<br><br>
	<label for="quantity">Quantity</label>
	<input type="number" name="quantity" id="uantity">
	<span style="color: red">
		<?php
			echo $quantityErrMsg;
		?>
	</span>
	<br><br>
	<label >Product Description</label><br>
	<textarea name="des" rows="10" cols="30"></textarea>
			<span style="color: red">
		<?php
			echo $desErrMsg;
		?>
	</span>
		<br><br>
		<input type="submit" name="submit" value="Add">
</fieldset>

</form>

</body>
<h2>
<?php
			echo $productStatus;
		?>
		</h2>
</html>

<?php
require '../Controller/fotter.php';

?>