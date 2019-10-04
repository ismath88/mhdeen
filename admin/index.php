<?php
	include("includes/config.inc");
	include("includes/class.php");

	if(isset($_POST['login']))
	{
	   	$user =new user();
		$user->login($_POST['username'],$_POST['br_pass'],'form_unit.php');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> Admin panel</title>
<link rel="icon" href="images/favicon.png" />
<link  href="css/style1.css" rel="stylesheet" type="text/css" />

</head>

<body>
<!--Container Start-->
    <div id="container">
	   <!-- LOGO -->
			<div id="logo" > 
				<div id="logo_head"><img src="img/admin3.jpg" /></div>
				<div id="top_head"> Admin Panel </div>
				<div class="both"></div>
			</div>		
	   <!-- END LOGO -->
	   <!-- Menu -->
	        <div id="menu"></div>
	   <!-- End Menu -->
	   <!--Start Contents-->
	        <div id="contents">
				  <div id="head">
				      Login Section </div>
				  <div id="page_contents">
				    <div id="cover_of_contents" style="margin:auto; padding:100px 0 100px 300px;">
					<style type="text/css">
					  #login #field_datas{
					  padding:10px;
					  width:100px;
					  }
					  *html #login #field_datas{
					  padding:0px;
					  width:100px;
					  }
					  *html #login{
					  padding:25px;
					  height:auto;
					  border:0;
					  }
					</style>					
					   <div id="login" class="curve" style="background:#FFFFFF" >		
	
						
							 <form name="frm" method="post" action="">
						  <div id="field_datas" style="width:100%" align="center" style="color:#FF0000; text-transform:capitalize;"><?php echo $error; ?></div>
						  <div id="field_datas" class="table_heading">username<span class="text_red">*</span> </div>
						  <div id="field_datas"><input type="text" name="username" id="username" size="25" value="" /></div>
						  <div class="both"></div>
						  <div id="field_datas" class="table_heading">Password<span class="text_red">*</span></div>
						  <div id="field_datas"><input type="password" name="br_pass" id="br_pass" size="25" /></div>
						  <div class="both"></div>
						  <div id="field_datas"></div>
						  <div id="field_datas" align="center" class="but"><input id="small_button" type="submit" class="button" name="login" value="Submit" /></div>
						  <div class="both"></div>
						  </form>
											
							
								
					   </div>   
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
