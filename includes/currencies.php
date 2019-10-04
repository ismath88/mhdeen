<?php 

	$sel = mysql_query("select cur_code from unitprices where cur_code!='' AND in_exchange = 1 order by unit");	
	
	while($row = mysql_fetch_object($sel))	:
			
			$codes[] = $row->cur_code;
			
	endwhile;
	
?>
<!--Currency Converter widget by FreeCurrencyRates.com -->
<style>
.gcw_main{width:230px;font-family:Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;font-size:11px;border:#cccccc 1px solid;text-align:center;color:#000000;background-color:#F9F9F9;margin:0 auto;}
.gcw_header{margin:4px;padding:5px;text-align:center;border:#A3A3A3 1px solid;background-color:#333333;}
.gcw_header a{text-decoration:none;color:#eeeeee;font-size:13px;font-weight:bold;}
.gcw_input{color:#222222;font-weight:bold;background-color:#ffffff;border:#cccccc 1px solid;text-align:right;padding:2px 0;margin:1px 0;display:inline;font-size:11px;}
.gcw_select{color:#000;display:inline;}
#gcw_date{font-size:10px;color:#222222;}
</style>
<div class='gcw_main'><div class='gcw_header'><a href='http://www.freecurrencyrates.com/myconverter#cur=MYR-<?php echo implode('-',$codes)?>;amt=MYR1' id='ccw_cnhfybwf'>1 Malaysian Ringgit Equals to</a></div><div id='gcw_rates'></div><script src='http://www.freecurrencyrates.com/converter-widget?width=230&currs=MYR,<?php echo implode(',',$codes)?>&precision=3&language=en&flags=1&currchangable=0' charset='UTF-8'></script></div>
<!--End of Currency Converter widget by FreeCurrencyRates.com -->
<script type="text/javascript">
	boxesLength = <?php echo count($codes)?>; for(i=0;i<boxesLength;i++){
					//document.getElementById('ccw_inp'+i).readOnly = true;
				//	document.getElementById('ccw_inp'+i).onkeyup = function(){ return false; };
				}
</script>