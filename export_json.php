<?php
require("connect.php");
$json_filename="export_".date("Ymd_His").".json";
$result=mysqli_query($connection,"SELECT * FROM informations");
$json="[\n";
while($row=mysqli_fetch_assoc($result))
{
	$line="{";
	foreach($row as $property=>$col)$line.='"'.$property.'":"'.str_replace("\n","\\n",str_replace("\r\n","\\n",str_replace('"','\\"',$col))).'",';
	$json.=substr($line,0,strlen($line)-1)."},\n";
}
$json=substr($json,0,strlen($json)-2)."\n]";
header("Content-type: application/json");
header("Content-Disposition: attachment; filename=".$json_filename."");
echo($json);
?>