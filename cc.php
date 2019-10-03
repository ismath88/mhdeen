<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Currency Calculator - MH DIN</title>
<link rel="icon" href="images/mhdeen.png" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript">
	function calculateAmt(pref){

			curr = document.getElementById(pref+'_curr');
			
			curr_objs = curr.value.split(':'); // { 0:{ SELL | BUY }, 1 : UNIT, 2 : CURRENCY NAME  }
			
			amt  = document.getElementById(pref+'_amt');

			if(amt.value!=''){
			
				amt.value  = amt.value.replace(/[^0-9\.]/g,'');
				
				document.getElementById(pref+'_res').parentNode.className = 'curr_results';
				
				units = curr_objs[1].split('');
				
				//CurrUnit =  units.length == 2 ? ( units[0] * ( units[1].toLowerCase()=='m'?1000000 : 1 ) ) : units[0];
				
				CurrUnit =  isNaN(Number(curr_objs[1]))?
						(units.length > 1 ? 
										( units[0] * ( units[1].toLowerCase()=='m'?1000 : 1 ) ) 
										: units[0])
						:curr_objs[1];
				
				document.getElementById(pref+'_res').innerHTML = 'Result : '+((amt.value*curr_objs[0]/CurrUnit).toFixed(3));
				
				
			}
	}
	
	function getUnit(unt){
		
		units = unt.split('');
		
		CurrUnit =  isNaN(Number(unt))?
						(units.length > 1 ? 
										( units[0] * ( units[1].toLowerCase()=='m'?1000 : 1 ) ) 
										: units[0])
						:unt;
						
		return CurrUnit;
		
	}
	
	function icalc(){
			
			var strAmount  = document.getElementById('iamount');
			var BuyAmount  = document.getElementById('i_buy_curr');
			var SellAmount = document.getElementById('i_sell_curr');
			
			strAmount.value  = strAmount.value.replace(/[^0-9\.]/g,'');
			
			buy_objs = BuyAmount.value.split(':'); // { 0:{ SELL | BUY }, 1 : UNIT, 2 : CURRENCY NAME, 3 : CODE}
			sell_objs = SellAmount.value.split(':'); // { 0:{ SELL | BUY }, 1 : UNIT, 2 : CURRENCY NAME, 3 : CODE }
			
			buy_unit = getUnit(buy_objs[1]);
			sell_unit = getUnit(sell_objs[1]);
			
			amounts = (( strAmount.value * (buy_objs[0] / buy_unit ) ) /  (sell_objs[0]/sell_unit)).toFixed(3);
			
			document.getElementById('i_res_parent').className= 'curr_results';
			
			document.getElementById('i_gt_result').innerHTML = 
			'Result : '+(strAmount.value?strAmount.value:0)+' '+ buy_objs[3]+' = '+amounts+' '+sell_objs[3];
			 
	}
	
	function changeAmt(){
			
			sellIndex =  document.getElementById('i_sell_curr').options.selectedIndex;
			buyIndex =  document.getElementById('i_buy_curr').options.selectedIndex;
			
			document.getElementById('i_sell_curr').options.selectedIndex =  buyIndex;
			document.getElementById('i_buy_curr').options.selectedIndex	 =  sellIndex;
			
			if(document.getElementById('iamount').value)icalc();
	}
	
</script>
<body>
		
		<div class="container">
		
				<?php include('includes/header.php');?>
				
				<div class="content">
						
						<div class="content_controller">
							
							<div class="left_column">
								<h3>Currency Calculator</h3>
								<table width="100%" border="0" cellspacing="0" cellpadding="5" class="curr_calc">
									  <tr class="thheader">
										<th width="50%">Selling</th>
										<th>Buying</th>
									  </tr>
									  <tr>
										<td>1. Please select the Foreign Currency You Require</td>
										<td>1. Please select the Foreign Currency You Are Selling.</td>
									  </tr>
									  <tr>
										<td>
											<select class="currencies" id="sell_curr" name="currencies[]" onchange="calculateAmt('sell')">
													<option value="">Select Currency</option>
													<?php  
														$sel = mysql_query("select a.*,b.lid,b.csell,b.cbuy from 
								unitprices a LEFT OUTER JOIN yester_unitprices b ON a.id = b.cid AND b.status = 'CURR'
								WHERE in_exchange = 1
								order by  `order` ASC "); 
														while($rows = mysql_fetch_object($sel)): ?>
														<option
														value="<?php echo sprintf('%01.3f',$rows->csell)?>:<?php echo $rows->unit?>:<?php echo 
																$rows->curry?>"
														><?php echo $rows->curry?> @ <?php echo sprintf('%01.3f',$rows->csell)?></option>			
													<?php 			
														endwhile;
													?>
										  </select>
										</td>
										<td><select class="currencies" id="buy_curr" name="currencies[]" onchange="calculateAmt('buy')">
													<option value="">Select Currency</option>
													<?php  
														$sel = mysql_query("select a.*,b.lid,b.csell,b.cbuy from 
								unitprices a LEFT OUTER JOIN yester_unitprices b ON a.id = b.cid AND b.status = 'CURR'
								WHERE in_exchange = 1
								order by  `order` ASC ");
														while($rows = mysql_fetch_object($sel)): ?>
														<option
														value="<?php echo sprintf('%01.3f',$rows->cbuy)?>:<?php echo $rows->unit?>:<?php echo 
																$rows->curry?>"
														><?php echo $rows->curry?> @ <?php echo sprintf('%01.3f',$rows->cbuy)?></option>			
													<?php 			
														endwhile;
													?>
												</select></td>
									  </tr>
									  <tr valign="top">
										<td>2. Enter the Amount in MYR that you wish to buy of this currency.?</td>
										<td>2. Enter the Amount of this currency that you want to sell?</td>
									  </tr>
									  <tr>
										<td>
											<input type="text" id="sell_amt" onkeyup="calculateAmt('sell')" />
										</td>
										<td><input type="text" id="buy_amt" onkeyup="calculateAmt('buy')" /></td>
									  </tr>
									  <tr >
										<td id="sell_res">&nbsp;</td>
										<td id="buy_res">&nbsp;</td>
									  </tr>
									 
								</table>
								
								<h3>International Currency Calculator</h3>
								<table width="100%" border="0" cellspacing="0" cellpadding="5" class="curr_calc">
									  
									  <tr>
										<td width="14%">Amount</td>
										<td width="22%"><input type="text" id="iamount" onkeyup="icalc()" style="text-align:right" value="0" /></td>
										<td width="6%" align="right">From</td>
										<td width="58%"><select class="currencies" id="i_buy_curr" name="select" onchange="icalc()" >
                                          <?php  
														$sel = mysql_query("select a.*,b.lid,b.csell,b.cbuy from 
								unitprices a LEFT OUTER JOIN yester_unitprices b ON a.id = b.cid AND b.status = 'CURR'
								WHERE in_exchange = 1
								order by  `order` ASC "); 
														while($rows = mysql_fetch_object($sel)): ?>
                                          <option
														value="<?php echo sprintf('%01.3f',$rows->cbuy)?>:<?php echo $rows->unit?>:<?php echo $rows->curry?>:<?php echo $rows->cur_code;?>"
														><?php echo $rows->curry?> @ <?php echo sprintf('%01.3f',$rows->cbuy)?></option>
                                          <?php 			
														endwhile;
													?>
                                        </select></td>
									  </tr>
									  
									  <tr>
									    <td>&nbsp;</td>
									    <td>&nbsp;</td>
									    <td align="right">&nbsp;</td>
									    <td><div style="padding-left:93px"><img src="images/change_type.png" onclick="changeAmt()" /></div></td>
							      </tr>
									  <tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td align="right">To</td>
										<td><select class="currencies" id="i_sell_curr" name="currencies[]" onchange="icalc()" >
													
													<?php  
														$sel = mysql_query("select a.*,b.lid,b.csell,b.cbuy from 
								unitprices a LEFT OUTER JOIN yester_unitprices b ON a.id = b.cid AND b.status = 'CURR'
								WHERE in_exchange = 1
								order by  `order` ASC "); 
														while($rows = mysql_fetch_object($sel)): ?>
														<option
														value="<?php echo sprintf('%01.3f',$rows->csell)?>:<?php echo $rows->unit?>:<?php echo $rows->curry?>:<?php echo $rows->cur_code;?>"
														><?php echo $rows->curry?> @ <?php echo sprintf('%01.3f',$rows->csell)?></option>			
													<?php 			
														endwhile;
													?>
												</select>										</td>
									  </tr>
									 
									  <tr id="i_res_parent">

										<td colspan="4" align="center"><div id="i_gt_result"></div></td>
									  </tr>
								</table>
								

							</div>
							<div class="right_column">	
								<?php include('includes/currencies.php'); ?>
							</div>	
							
							<div class="both"></div>
						</div>
				
				</div>
				
				<?php include('includes/footer.php'); ?>
				
		</div>
		
</body>
</html>
