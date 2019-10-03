<?php 
	
	if(isset($_POST['submitrecord_disabled'])):
	
		$refNo = '#MM'.((int)$_SERVER['REQUEST_TIME']);
		
		$subject = "[".$refNo."] New Order [WE ".(strtoupper($_POST['buysellbtn']))."] from Moneymaster.com.my";
		
		$html = "Hi ,<br /><br />  Mr. ".$_POST['name']." have placed new order! ";
		
		$html .= '<br /><br /><table cellpadding="5" cellspacing="0" border="1" width="100%">
				 	<tr><th>Currency</th><th>Currency Amount</th><th>Equivalent Amount</th></tr>';		
					
				foreach($_POST['currencies'] as $currency => $value ):
						
						if($value != ''):
							
							$currency_det = explode(':',$value);
							
							$html .= '<tr>
										  <td>'.$currency_det[2].' @ '.sprintf('%01.3f',$currency_det[0])
										  	   .' / '.$currency_det[1].' </td>
										  <td align="right">'.sprintf('%01.3f',$_POST['amts'][$currency]).'</td>
										  <td align="right">'.sprintf('%01.3f',$_POST['Eqamts'][$currency]).'</td>
									  </tr>';
							
						endif;
						
				endforeach;
				
		$html .= '<tr><td align="right" colspan="3" style="font-weight:bold"> Total : 
					<span style="color:#009966">'.sprintf('%01.3f',array_sum($_POST['Eqamts'])).'</span></td></tr></table>';
					
		$html .= "<hr /><strong>Contact Details : </strong><br />Email : ".$_POST['email']."<br/>Phone : ".$_POST['phone'];		
		
		
		$html .= '<br /><br /> Thanks';	
		
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		
		// More headers
		$headers .= 'From: <admin@moneymaster.com.my>' . "\r\n";
		
		mail('order@moneymaster.com.my',$subject,$html,$headers);
		
		$responder_subject = "[".$refNo."] Your Orer Recieved on Moneymaster.com";
		
		$responder = "You Order no is : ".$refNo."<br />
Kindly call this number 1800 22 3030 to confirm the stock availability and mention your ref number. Sameday collection. ";
		
		mail($_POST['email'],$responder_subject,$responder,$headers);
						  
		header("location:order.php?msg=Congratulations! Order placed successfully!. Order No is : ".str_replace('#','',$refNo));
		
		
	endif;
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>::Order - My Money Master::</title>
<link rel="icon" href="images/favicon.png" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	#Source_unit{
		display:none;
	}
	.enForm{
		display:none;
	}
	#success{
		text-align:center;
		padding:5px;
		color:#006633;
		font-weight:bold;
		font-size:15px;
	}
	
</style>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
	
	var base_currency = 'MYR';
	var TotAmts = parseFloat(0);
	var TotAmtsArr = new Array();
	function addRows(){
			
			trs = jQuery('.order_table').find('tr').length;
			
			trCLass = ((trs+1)%2 == 0 )?'even':'odd';
			
			tr = document.createElement('tr');
			
			tr.className = trCLass+' rows-'+(trs);
			
			tr.innerHTML = '<td >'+jQuery('#Source_unit').html()+'</td>';
			
			jQuery('.order_table').append(tr);
			
	}
	function calculateAmt(ele){
		
		TotAmts = 0;
		
		curr = jQuery(ele).find('.currencies')[0]; 
		
		amt  = jQuery(ele).find('.amts')[0];
		
		amt.value = amt.value.replace(/[^0-9\.]/g,'');

		if(amt.value && curr.value){
			
			//totAmt = parseFloat(amt.value*ccw_rates[base_currency]/ccw_rates[curr.value]).toFixed(ccw_precision);
			
			ratesAndUnit = curr.value.split(':');
			
			units = ratesAndUnit[1].split('');

			CurrUnit =  isNaN(Number(ratesAndUnit[1]))?
						(units.length > 1 ? 
										( units[0] * ( units[1].toLowerCase()=='m'?1000 : 1 ) ) 
										: units[0])
						:ratesAndUnit[1];
			
			
			Rates   = (ratesAndUnit[0]*amt.value / CurrUnit).toFixed(3);
			
			jQuery(ele).find('.eqamts')[0].value = Rates;

			jQuery('.order_table').find('.eqamts').each(function(key,val){
					TotAmts  += parseFloat(jQuery(this).val());
			})
			jQuery('#total_price').html(TotAmts.toFixed(3));
				
		}
		else
		{
			jQuery(ele).find('.eqamts')[0].value = 0;
		}
			
			
			
	}
	function openPopUp(){
		if(TotAmts>0){ if(jQuery('.enForm').css('display')=='none')jQuery('.enForm').slideToggle('bottom');}
		else{ jQuery('.enForm').slideToggle('top');alert(" Total Amount greater than 0 "); }
	}
	function validation(){
		var Emailval = /^[a-zA-Z0-9_.+-]+@[a-z0-9._A-Z]+\.[A-Za-z.]{2,6}$/;
		var phno = /[^0-9\+\-]/g;
		if(document.frm.name.value=='Enter Name..'){
			alert("Please enter the name");
			return false;
		}
		if(!Emailval.test(document.frm.email.value)){
			alert("Enter Valid Email");
			return false;
		}
		if(phno.test(document.frm.phone.value)){
			alert("Please enter the valid phone number");
			return false;
		}
	}
	
	function chcurrBox(st){
		
		//	class="currencies" name="currencies[]" onchange="calculateAmt(this.parentNode.parentNode)"

		st.form.submit();
		
	}
	
	function chcurrBoxAction(st){
		
		jQuery('.currency_rows').each(function(){
					
					jQuery(this).html(jQuery('#'+st+'info').html());
					
					CurrencyList = jQuery(this).find('select');
					
					CurrencyList.attr({'class':'currencies','name':'currencies[]',
									  'onchange':'calculateAmt(this.parentNode.parentNode)'})
		})
		
	}
	
	jQuery(document).ready(function(){
			
		chcurrBoxAction('<?php echo $_POST['buysellbtn']?$_POST['buysellbtn']:'sell'?>');	
			
	})
</script>

</head>

<body>
		
		<div class="container">
		
				<?php include('includes/header.php');?>
				
				<div class="content">
						
						<div class="content_controller">
							
							<div class="left_column">
								<h3>Order</h3>
								<form name="frm" method="post">
								
								Order Type : <input type="radio"  value="sell" name="buysellbtn" 
											<?php if($_POST['buysellbtn']=='sell' || 
											$_POST['buysellbtn']==''):?> checked="checked" <?php endif; ?>	 
											onclick="chcurrBox(this)"   />Buy  
											 <input type="radio" value="buy" name="buysellbtn" onclick="chcurrBox(this)"
											 <?php if($_POST['buysellbtn']=='buy'):?> checked="checked" <?php endif; ?>	 />Sell
								
								<div  id="Source_unit">
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr class="even" >	
											<td align="left" width="272">
												<div class="currency_rows"></div>
											</td>
											<td align="right"><input type="text" name="amts[]" class="amts"
															 onkeyup="calculateAmt(this.parentNode.parentNode)" /></td>
											<td align="right"><input type="text" name="Eqamts[]" class="eqamts" readonly="1" /></td>
										</tr>
									</table>
								</div>
								<?php if($_GET['msg']):?>
									<div id="success">
											<?php echo $_GET['msg'];?>
									</div>
								<?php endif;?>
								<table width="99%" cellspacing="0" border="0" class="order_table">
									<tr class="grd_title">	
									  <th>
									    <table cellpadding="0" cellspacing="0" border="0" width="100%">
											<td width="272">Select Foreign Currency</td>
											<td align="right">Currency Amount</td>
											<td align="right">Equivalent Amount</td>
										</table>
									  </th>
									</tr>
										
								</table>
								<div class="menu" style="width:100%; padding:5px 0">
									<a href="javascript:;" style="margin:0;"
									   onclick="addRows()"	
									><span><span>+ Add Currency</span></span></a>
									<div class="both"></div>
								</div>
								<div class="total_price">
										Total : <span id="total_price">0.00</span><br />
<!-- 										<input type="button" onclick="openPopUp()" name="submitrecords" value="Submit Order" />	 -->
								</div>
<!--								<div class="enForm">
								<fieldset>
									<legend>Send Information</legend>
									<input type="text" name="name" value="Enter Name.." 
									onfocus="if(this.value=='Enter Name..')this.value=''"
									onblur="if(this.value=='')this.value='Enter Name..'" />
									<input type="text" name="email" value="Enter Email.."
									onfocus="if(this.value=='Enter Email..')this.value=''"
									onblur="if(this.value=='')this.value='Enter Email..'" />
									<input type="text" name="phone" value="Phone Number.." 
									onfocus="if(this.value=='Phone Number..')this.value=''"
									onblur="if(this.value=='')this.value='Phone Number..'"/>
									<input type="submit" name="submitrecord" value="Send info" onclick="return validation()" 
									style="padding:3px;" />
								</fieldset>
								</div>  -->
								<script type="text/javascript">
								addRows()
								</script>
							</form>
							</div>
							<div class="right_column">	
								<?php include('includes/currencies.php'); ?>
							</div>	
							
							<div class="both"></div>
							
						</div>
						
						<div style="display:none">
						    <div id="buyinfo">
								<select >
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
								</select>
							</div>
							<div id="sellinfo">	
								<select >
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
							</div>	
						</div>
				
				</div>
				
				<?php include('includes/footer.php'); ?>
				
		</div>
		
</body>
</html>
