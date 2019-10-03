<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Current Exchange Rates</title>
<style type="text/css" media="print">
	.settings{
		display:none;
	}
</style>
<style type="text/css">
	.settings{
		padding:10px;
		border-bottom:1px solid #BFBFBF;
		background:#dfdfdf;
		font-family:Arial, Helvetica, sans-serif; font-size:12px;
		text-align:right;
		font-weight:bold;
	}
	body{
		margin:0;
		padding:0;
	}
	#print_area{
		font-weight:normal;
		font-size:11px;
	}
	#print_area table{
		border-left:1px solid #000;
		border-top:1px solid #000;
	}
	#print_area td,#print_area th{
		border-bottom:1px solid #000;
		border-right:1px solid #000;
		font-size:12px;
		padding:1px;
	}
</style>
</head>
<script type="text/javascript">
	
	function setPrintCount(val){
		
		document.getElementById('print_area').innerHTML = '';
		
		for(var i = 0 ; i < val ; i++){	
			
			document.getElementById('print_area').innerHTML += '<div style="width:3.3in; padding-left:5px; height:4.5in ; float:left;">'+
			document.getElementById('source').innerHTML+'</div>';

			if((i+1)%2 == 0) document.getElementById('print_area').innerHTML +='<div style="clear:both"></both>';
			
		}	
		document.getElementById('ptimes').value = val;
	}	
</script>
<body onload="setPrintCount(1)">

<?php include('includes/dbconnect.php');?>	

<div class="settings">
	Choose how many times to print: <select id="ptimes" onchange="setPrintCount(this.value)">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
									</select>
									
									<input type="button" value="Print" onclick="window.print()"/>
</div>
	
	<div style="font-family:arial;font-size:15px;padding:5px 0; font-weight:bold;">			
			
				
				<div style="display:none;" id="source"><div style="text-align:left;font-weight:bold;">
					MH DIN Sdn Bhd.Exchange Rates On <?php echo date('d/m/Y')?>
						
				</div><table cellspacing="0" cellpadding="0" border="0" width="95%" style="font-family:arial;font-size:12px;">
				
							  <tr style="background:#000000; color:#FFFFFF">
							   <th>Unit</th>
								<th>Code</th>
								<th>Currency</th>
								<th>We Buy</th>
								<th>We Sell</th>
								
							  </tr>
							  <?php 
							  		
								$sel = mysql_query("select a.*,b.csell,b.cbuy,DATE_FORMAT(FROM_UNIXTIME(a.upd_date), 
								'%m/%e/%Y at %h:%i %p') as up_date  from 
								unitprices a LEFT OUTER JOIN yester_unitprices b ON a.id = b.cid AND b.status = 'CURR' 
								WHERE in_exchange = 1
								order by  `order` ASC");	
								$num = mysql_num_rows($sel);
								if($num):
									while($row = mysql_fetch_object($sel))	:
							  ?>
							  <tr align="center">
								
						
								<td><?php echo $row->unit?></td>
								<td><?php echo $row->cur_code?></td>
								<td><?php echo $row->curry?></td>
								<td><?php echo sprintf('%01.3f',($row->cbuy?$row->cbuy:$row->buy))?></td>
								<td><?php echo sprintf('%01.3f',($row->csell?$row->csell:$row->sell))?></td>
								
							  </tr>
							  <?php endwhile;  ?>
							
							  <?php endif; ?>
							</table></div>
						
						<div id="print_area"></div>
							
				</div>

</body>
</html>
