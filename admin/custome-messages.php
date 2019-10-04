<?php 
include("includes/config.inc");
include("includes/function.php");
	include("includes/class.php");
	include("includes/menu.php");
	include("includes/sessions.php");
	
	 if($_POST['save']):
	 		
		    mysql_query("insert into messages values(1,'".mysql_real_escape_string(nl2br($_POST['welcome']))."','
														".mysql_real_escape_string(nl2br($_POST['welcome']))."','"
														 .mysql_real_escape_string(nl2br($_POST['cclose']))."') ON DUPLICATE KEY UPDATE ".
														 " welcome = '".mysql_real_escape_string(nl2br($_POST['welcome']))."', ".
														 " thankyou = '".mysql_real_escape_string(nl2br($_POST['thankyou']))."' ,".
														 " closeMsg ='".mysql_real_escape_string(nl2br($_POST['cclose']))."'  ") or die(mysql_error());
			
			//header("location:custome-messages.php?msg=Message Saved Successfully");
		
		
	 endif;
	
	
	$sel = mysql_query("select * from messages");	

	$row = mysql_fetch_object($sel);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> Admin panel</title>
<link  href="css/style1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/script.js"></script>
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
				      Custome Message </div>
				  <div id="page_contents">
				    <div id="cover_of_contents" style="margin:auto; padding:10px">
					<div style="text-align:right">
								
							</div>
						
					<form id="cats" name="cats" method="post" enctype="multipart/form-data">	
							
							
					<?php if($_GET['msg']): ?>
						<div style="color:#006633; padding:5px 0; text-align:center; font-weight:bold"><?php echo $_GET['msg']; ?></div>
					<?php endif; ?>
					<table cellpadding="5" cellspacing="5" width="100%" >
                      <tr>
                        <td>Welcome Message </td>
                        <td><textarea name="welcome" cols="100"><?php echo stripslashes(strip_tags($row->welcome));?></textarea></td>
                      </tr>
                      <tr>
                        <td width="317">Thankyou Message </td>
                        <td width="592"><textarea name="thankyou" cols="100"><?php echo stripslashes(strip_tags($row->thankyou));?></textarea></td>
                      </tr>
					  <tr>
                        <td width="317">Counter Closed </td>
                        <td width="592"><textarea name="cclose" cols="100"><?php echo stripslashes(strip_tags($row->closeMsg));?></textarea></td>
                      </tr>
                      <tr>
                        <td colspan="2" align="center"><input type="submit" value="Save" id="save" name="save" />
                            <input type="hidden" value="<?php echo $row->id ?>" name="editid" />                        </td>
                      </tr>
                    </table>
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