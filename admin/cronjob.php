<?php
$date=(int) $_SERVER['REQUEST_TIME'];
include("includes/config.inc");


$rows = mysql_query("select * from `yester_unitprices` WHERE DATE(FROM_UNIXTIME(cto_date)) =  DATE(FROM_UNIXTIME('".$date."'))");

if(mysql_num_rows($rows)==0):

	$query="select a.id,a.buy,a.sell,b.cbuy,b.csell 
	from `unitprices` a LEFT OUTER JOIN `yester_unitprices` b ON a.id = b.cid and b.status = 'CURR' WHERE a.in_exchange = 1 ";
	$result=mysql_query($query);
	
	mysql_query("update yester_unitprices set status = 'OLD' ");
	
	while($row=mysql_fetch_array($result))
	 {
		
		 $buy  = $row['cbuy']?$row['cbuy']:$row['buy'];
		 $sell = $row['csell']?$row['csell']:$row['sell'];
		 
		 $insert="insert into `yester_unitprices` (cid,cbuy,csell,cto_date,status) values ('".$row['id']."','".
				 $buy."','".$sell."','".$date."','CURR') ";
				 
		 mysql_query($insert);
	 }

endif;

header("location:form_unit.php");	 

?>