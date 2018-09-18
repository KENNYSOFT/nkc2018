<?php
require("connect.php");
$csv_filename="export_".date("Ymd_His").".csv";
$csv_export="";
$result=mysqli_query($connection,"SELECT * FROM informations;");
while($property=mysqli_fetch_field($result))
{
	if($property->name=="note")continue;
	$csv_export.=$property->name.",";
}
$csv_export.="\n";
while($row=mysqli_fetch_assoc($result))
{
	foreach($row as $property=>$col)
	{
		if($property=="note")continue;
		$csv_export.='"'.str_replace('"','""',iconv("UTF-8","EUC-KR",$col)).'",';
	}
	$csv_export.="\n";
}
header("Content-type: text/x-csv");
header("Content-Disposition: attachment; filename=".$csv_filename."");
echo($csv_export);
?>