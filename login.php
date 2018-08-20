<?php
session_start();
require("connect.php");
if(isset($_POST["id"])&&isset($_POST["password"]))
{
	$id=mysqli_real_escape_string($connection,$_POST["id"]);
	$password=mysqli_real_escape_string($connection,$_POST["password"]);
	$query="SELECT * FROM users WHERE id='".$id."' AND password=PASSWORD('".$password."');";
	$result=mysqli_query($connection,$query) or die(mysqli_error($connection));
	$count=mysqli_num_rows($result);
	if($count==1)
	{
		$row=mysqli_fetch_assoc($result);
		$_SESSION["user_id"]=$row["_id"];
		$_SESSION["user_name"]=$row["name"];
	}
}
header("Location: index.html");
?>