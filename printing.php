<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php 
	include("includes/config.inc");
	include("includes/class.php");
							
	$sel = mysql_query("select a.*,b.csell,b.cbuy,DATE_FORMAT(FROM_UNIXTIME(a.upd_date), 
	'%m/%e/%Y at %h:%i %p') as up_date , DATE_FORMAT(FROM_UNIXTIME(b.cto_date), 
	'%m/%e/%Y at %h:%i %p') as cto_date  from 
	unitprices a LEFT OUTER JOIN yester_unitprices b ON a.id = b.cid AND b.status = 'CURR' 
	WHERE in_exchange = 1
	order by  `order` ASC");	
	$num = mysql_num_rows($sel);
?>
	<div style="display:none;" id="source">
		
		<table width="98%" border="0" style="border:1px solid #000000; border-right:none" cellspacing="0" cellpadding="0">
		<tr style="background:#000000; color:#FFFFFF">
			<th style="border-bottom:1px solid #000000;border-right:1px solid #000000">CODE</th>
			<th style="border-bottom:1px solid #000000;border-right:1px solid #000000">BUY</th>
			<th style="border-bottom:1px solid #000000;border-right:1px solid #000000">SELL</th>
		</tr>

	<?php while($row = mysql_fetch_object($sel))	: $date = $row->cto_date?>
		
		<tr align="center">
			<td style="border-bottom:1px solid #000000;border-right:1px solid #000000"><?php echo $row->cur_code?></td>
			<td style="border-bottom:1px solid #000000;border-right:1px solid #000000"><?php echo sprintf('%01.3f',$row->cbuy?$row->cbuy:$row->buy)?></td>
			<td style="border-bottom:1px solid #000000;border-right:1px solid #000000"><?php echo sprintf('%01.3f',$row->csell?$row->csell:$row->sell)?></td>
		</tr>
		
	<?php endwhile; ?>
	
	</table>
	
	</div>
	<input type="hidden" value="<?php echo $date; ?>" id="date"  />
	
	
	<div id="print_area" style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">
	
	</div>
	
	
	<script type="text/javascript">
		
		for(var i = 0 ; i < 6 ; i++){	
			
			document.getElementById('print_area').innerHTML += '<div style="width:2.2in; padding-left:5px; height:4.5in ; float:left;">'+
																'<div style="padding:5px 0; font-weight:bold">'+
																document.getElementById('date').value +
																'</div>'+
																document.getElementById('source').innerHTML+
																'</div>';

			if((i+1)%3 == 0) document.getElementById('print_area').innerHTML +='<div style="clear:both"></both>';
			
		}	
		
		window.print();
	</script>
	
</body>
</html>