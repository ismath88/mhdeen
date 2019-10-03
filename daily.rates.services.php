<?php 	
	include("includes/dbconnect.php");
	
	if($_REQUEST['curr_validation'] == 'MyValidatorPwdisMyMoneyMaster'):
		   
		   $sel = mysql_query("select a.curry as currency_name,
		   a.cur_code as currecny_code,b.csell,b.cbuy,
		   DATE_FORMAT(FROM_UNIXTIME(a.upd_date),'%m/%e/%Y at %h:%i %p') as up_date  from 
		   unitprices a LEFT OUTER JOIN yester_unitprices b ON a.id = b.cid AND b.status = 'CURR' 
		   WHERE a.cur_code = '".strtoupper($_REQUEST['currency_code'])."'
		   order by  `order` ASC") or die(mysql_error());	
		
		   $num = mysql_num_rows($sel);
		   
		   if($num):
		   
				while($rows = mysql_fetch_object($sel)):
					
						//$service_result[]=$rows; 
						echo 'Currency Name : '.$rows->currency_name.
							 " \n Rate Buying :".$rows->cbuy.' \n Rate Selling :'.$rows->csell;
							
				endwhile;
				
				//print json_encode($service_result);
		   
		   else:
				
				print json_encode(array('failed'=>1));
				
		   endif;
							   
	endif;
	
	mysql_close();
?>