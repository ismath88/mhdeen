<?php 
include("includes/config.inc");
include("includes/function.php");
	include("includes/class.php");
	include("includes/menu.php");
	include("includes/sessions.php");
	
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	$headers .= 'From: <sales@moneymaster.com.my>' . "\r\n";
	
	$html   = "Dear Subscriber,<br /><br />";
	$html  .= "  We have changed new rates new rates for today. 
				 <a href='http://www.moneymaster.com.my'>click here to check current rates</a><br /><br />
				 Thanks,<br />
				 My Money Master,<br />
				 www.moneymaster.com.my
				 ";
	
	if(isset($_POST['submit'])):
	
		$query = mysql_query(" select * From  subscribers");
		
		while($rows = mysql_fetch_array($query)):
				
				mail($rows['emails'],"Today Rates on MY Money Master",$html,$headers);
				
		endwhile;
		
	endif;
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> Admin panel</title>
<link  href="css/style1.css" rel="stylesheet" type="text/css" />

</head>

<body>
<!--Container Start-->
    <div id="container">
	   <!-- LOGO -->
			<div id="logo" > 
				<div id="logo_head"></div>
				<div id="top_head"> Admin Panel </div>
				<div class="both"></div>
			</div>		
	   <!-- END LOGO -->
	  <!-- Menu -->
		<div id="menu">
			<?php $menu=new menu(); echo $menu->top_menu ?>	
	  	</div>
	   	<!-- End Menu -->
	   <!--Start Contents-->
	        <div id="contents">
				  <div id="head">
				      Send Rates </div>
				  <div id="page_contents">
				    <div id="cover_of_contents" style="margin:auto; padding:10px">
					<div style="text-align:right">
								<a href="logout.php">Logout</a>
					  </div>
					</div>
					
					<form id="frm" name="frm" method="post" >	
							
							<div align="center" style="padding:100px 0"><input type="submit" name="submit" value="Click here to send today rates" onclick="this.value='Sending...'" /></div>
							
					</form>
				  </div> 
					<div class="both" style="background:#A8A9CA"></div>
				  </div>
			</div>
	   <!--End Contents-->
    </div>
<!--Container End-->
<script language="javascript" type="text/javascript" src="js/height_adj.js"></script>

</body>
</html>
