<?php include('includes/dbconnect.php');?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="images/favicon.png" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
	
	var i = 0;
	var rtrLENTH = 0;
	var oldEle;
	var onRtr;
	
	function Rotator(){
		
		if(i==rtrLENTH) i=0;
		
		if(oldEle) oldEle.css('display','none');
		
		jQuery('#rotator'+i).fadeIn('slow');
		oldEle = jQuery('#rotator'+i);
		
		clearInterval(onRtr);
		
		i++;
	}
	
	function sratRotator(){
		onRtr = setInterval('Rotator()',5000);
	} 

	jQuery(document).ready(function(){
			
			rtrLENTH = jQuery('.rotator_cnt').length;
			Rotator();
			sratRotator();
			
	})
</script>
</head>

<body style="background:none">
	
	<div class="content" style="width:100%" >
	<div style="padding:10px; text-align:center; ">
	 <div >
		<img src="graph.php?id=<?php echo $_GET['id'] ?>" style="border: 4px solid #CACCD3; 
    box-shadow: 0 0 6px #535A5E;-moz-box-shadow: 0 0 6px #535A5E;-webkit-box-shadow: 0 0 6px #535A5E;" />
	  </div>
		
	  <div style="margin:10PX 0;">
		  <div style="float:left; width:50%">
			<table cellpadding="2" cellspacing="0" border="0" width="100%" class="price_rpt">
			<tr>
				<th>Flag</th>
				<th>Unit</th>
				<th>We Buy</th>
				<th>We Sell</th>
				<th>Rates On</th>
			</tr>
		<?php
			
			$query = mysql_query(" select src,unit,curry,b.csell,cbuy, DATE_FORMAT(FROM_UNIXTIME(cto_date),'%m/%e/%Y at %h:%i %p') as rates_on,DATE_FORMAT(FROM_UNIXTIME(cto_date),'%m/%e/%Y') as rates_on2 from unitprices a LEFT OUTER JOIN yester_unitprices b on b.cid= a.id where a.id = '".$_GET['id']."' and a.in_exchange = 1 order by cto_date DESC limit 1,7");
			
			while($rows = mysql_fetch_object($query)):
			$copyied_rows[] = $rows;
		?>
			<tr>
				<td><?php if($rows->src): ?>
													<img src="admin/flag/<?php echo $rows->src?>"  />
										
											<?php endif;?>				
				</td>
				<td><strong><?php echo $rows->unit; ?></strong></td>
				<td><strong><?php echo SPRINTF('%01.3f',$rows->cbuy); ?></strong></td>
				<td><strong><?php echo SPRINTF('%01.3f',$rows->csell); ?></strong></td>
				<td><strong><?php echo $rows->rates_on; ?></strong></td>
			</tr>
		<?php	
			endwhile;
		?>
		</table>
		  </div>	
		   <div style="float:right; width:49%"	>
				<div class="rotator_container">
					<?php  for($i=0;$i<count($copyied_rows);$i++): ?>
							
							<div id="rotator<?php echo $i;?>" class="rotator_cnt" style="display:none">
									
									<div class="rotator_head">
										Rates On <?php echo $copyied_rows[$i]->rates_on2; ?>
									</div>
									<div style="text-align:right; font-weight:bold; color:#5175A0; font-size:13px;">
									UNIT : <?php echo $copyied_rows[$i]->unit; ?></div>
									<div class="rate-field">we Bought </div>
									  <div class="rate-fld"><?php echo SPRINTF('%01.3f',$copyied_rows[$i]->cbuy); ?></div>
									<div style="border-bottom:1px solid #A1C5E3">&nbsp;</div>  
									<div class="rate-field">we Sold </div>
									   <div class="rate-fld"><?php echo SPRINTF('%01.3f',$copyied_rows[$i]->csell); ?></div>
							</div>
							
					<?php	endfor; ?>
				</div>
		  </div>	
		  <div class="both"></div>	
	  </div>
	  	  
	</div>
	
	</div>
</body>
</html>
