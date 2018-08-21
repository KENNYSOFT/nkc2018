<?php
session_start();
if(!isset($_SESSION["user_id"]))header("Location: index.html?login_needed");
require("connect.php");
$result=mysqli_query($connection,"SELECT COUNT(*) FROM informations;");
$tot=intval(mysqli_fetch_row($result)[0]);
$id=intval($_POST["_id"]);
unset($_POST["_id"]);
if($_POST["sampling_method"]=="기타")$_POST["sampling_method"]=$_POST["sampling_method_etc"];
unset($_POST["sampling_method_etc"]);
$new=array();
foreach($_POST as $col=>$val)
{
	if(strlen($val)==0)$new[$col]="NULL";
	else $new[$col]="'".mysqli_real_escape_string($connection,$val)."'";
}
$query="";
$log="";
if($id<=$tot)
{
	$result=mysqli_query($connection,"SELECT * FROM informations WHERE _id=".$id.";");
	$old=mysqli_fetch_assoc($result);
	foreach($old as $col=>&$val)
	{
		if($val==NULL)$val="NULL";
		else $val="'".mysqli_real_escape_string($connection,$val)."'";
	}
	$query="UPDATE informations SET ";
	foreach($new as $col=>$val)
	{
		$query.=$col."=".$val.",";
		if(!isset($old[$col])||$old[$col]==NULL)$old[$col]="NULL";
		if($val!=$old[$col])$log.="INSERT INTO logs(user_id,text_id,attribute,old_value,new_value) VALUES(".$_SESSION["user_id"].",".$id.",'".$col."',".$old[$col].",".$val.");\n";
	}
	$query=substr($query,0,-1)." WHERE _id=".$id.";";
}
else
{
	$query="INSERT INTO informations(";
	foreach($new as $col=>$val)$query.=$col.",";
	$query=substr($query,0,-1).") VALUES(";
	foreach($new as $col=>$val)
	{
		$query.=$val.",";
		if($val!="NULL")$log.="INSERT INTO logs(user_id,text_id,attribute,old_value,new_value) VALUES(".$_SESSION["user_id"].",".$id.",'".$col."',NULL,".$val.");\n";
	}
	$query=substr($query,0,-1).");";
}
$result=mysqli_query($connection,$query);
if(!$result)Header("Location: input2.html?id=".$id."&error");
mysqli_query($connection,$log);
Header("Location: input2.html?id=".$id."&save_success");
?>