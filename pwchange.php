<?php
session_start();
if(!isset($_SESSION["user_id"]))header("Location: index.html?login_needed");
require("connect.php");
if(isset($_POST["password"])&&isset($_POST["new_password"])&&isset($_POST["new_password_chk"]))
{
	$password=mysqli_real_escape_string($connection,$_POST["password"]);
	$new_password=mysqli_real_escape_string($connection,$_POST["new_password"]);
	$new_password_chk=mysqli_real_escape_string($connection,$_POST["new_password_chk"]);
	if($new_password!=$new_password_chk)
	{
		header("Location: pwchange.html?error_chk");
		exit();
	}
	$query="SELECT * FROM users WHERE _id=".$_SESSION["user_id"]." AND password=PASSWORD('".$password."');";
	$result=mysqli_query($connection,$query);
	$count=mysqli_num_rows($result);
	if($count==1)
	{
		mysqli_query($connection,"UPDATE users SET password=PASSWORD('".$new_password."') WHERE _id=".$_SESSION["user_id"].";");
		header("Location: pwchange.html?pw_change_success");
		exit();
	}
	header("Location: pwchange.html?error_password");
	exit();
}
header("Location: pwchange.html?error");
?>