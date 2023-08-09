<?php
session_start(); 
session_unset();
session_destroy();
setcookie("id",null,time()-3600,'/');
header("Location: ../views/sellerlogin.php");
?>