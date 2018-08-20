<?php
require("connect.php");
$xml_filename="export_".date("Ymd_His").".xml";
$result=mysqli_query($connection,"SELECT * FROM informations");
$xml='<?xml version="1.0" encoding="UTF-8" ?>'."\r\n";
while($row=mysqli_fetch_assoc($result))
{
	$xml.='<item id="'.$row["_id"].'">'."\r\n";
	foreach($row as $property=>$col)
	{
		if($property=="_id")continue;
		$xml.="\t".'<'.$property.'>'.htmlspecialchars($col).'</'.$property.'>'."\r\n";
	}
	$xml.="</item>\r\n";
}
header("Content-type: application/xml");
header("Content-Disposition: attachment; filename=".$xml_filename."");
echo($xml);
?>