<?php
$connection=mysqli_connect("localhost","nkc2018","nkc2018");
if(!$connection)die("Database Connection Failed: ".mysqli_error($connection));
$select_db=mysqli_select_db($connection,"nkc2018");
if(!$select_db)die("Database Selection Failed: ".mysqli_error($connection));
?>