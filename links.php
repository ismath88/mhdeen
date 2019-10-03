<?php 
include("includes/config.inc");
include("includes/function.php");
	include("includes/class.php");
	include("includes/menu.php");
	include("includes/sessions.php");
	if(!$_GET['cid']){
		 $sel = mysql_query("select id from  link_categories where parent_id = 0 order by link_cat ASC limit 1");
		 $cats = mysql_fetch_object($sel);
		 $_GET['cid'] = $cats->id;
	}
	if(isset($_POST['save']) )
	{
	
	 if($_POST['cat']):
	 
		if(!$_GET['id']):
		
			mysql_query("insert into link_categories set link='".mysql_real_escape_string($_POST['links'])."',
														 link_cat='".mysql_real_escape_string($_POST['title'])."',
			
														 parent_id='".$_POST['cat']."'
							" );
			
			header("location:links.php?msg=Link Saved Successfully&cid=".$_POST['cat']);
		
		else:
			
			mysql_query("update link_categories set 
						 link='".mysql_real_escape_string($_POST['links'])."',
						 link_cat='".mysql_real_escape_string($_POST['title'])."',
														 parent_id='".$_POST['cat']."' where id = ".$_GET['id']);
			
			header("location:links.php?id=".$_GET['id']."&msg=Link Updated Successfully&".($_GET['cid']?'cid='.$_GET['cid']:''));
			
		endif;
	 endif;
	}
	
	elseif(count($_POST['delAnn'])){
			
			mysql_query(" delete from link_categories where id  IN (".implode(',',$_POST['delAnn']).")  ");
			
			header("location:links.php?&msg=Link Deleted Successfully&".($_GET['cid']?'cid='.$_GET['cid']:''));
			
	}
	
	if((int) $_GET['id']):
		
		$sel = mysql_query("select * from link_categories where id =".$_GET['id']);	

	    $rows = mysql_fetch_object($sel);

	endif;
	
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
				      Links Section</div>
				  <div id="page_contents">
				    <div id="cover_of_contents" style="margin:auto; padding:10px">
					<div style="text-align:right">
								
							</div>
							<div style="text-align:right">
								<a href="#" onclick="document.cats.submit();"> [ - ] Delete Link</a> | <a href="categories.php"> [ + ] Add New Link</a>
							</div>
					<form id="cats" name="cats" method="post" enctype="multipart/form-data">	
							
							
					<?php if($_GET['msg']): ?>
						<div style="color:#006633; padding:5px 0; text-align:center; font-weight:bold"><?php echo $_GET['msg']; ?></div>
					<?php endif; ?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top">
    <td width="41%"><table cellpadding="5" cellspacing="5" >
      <tr>
        <td>Select Category </td>
        <td>
			<select name="cat">
				<option value="">-Select Catgegory-</option>
				<?php $sel = mysql_query("select * from  link_categories where parent_id = 0 order by link_cat ASC") or die ( mysql_error() );
					  while($row=mysql_fetch_object($sel)){?>	
				<option value="<?php echo $row->id ?>" <?php if($row->id==$rows->parent_id){?> selected="selected"<?php } ?> ><?php echo $row->link_cat?></option>
				<?php }?>
			</select>
		</td>
      </tr>
      <tr>
        <td width="118">Enter Title </td>
        <td width="196"><input type="text" id="title" name="title" value="<?php echo $rows->link_cat?>" /></td>
      </tr>
	  <tr>
        <td width="118">Enter Link </td>
        <td width="196"><input type="text" id="links" name="links" value="<?php echo $rows->link?>" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="submit" value="Save" id="save" name="save" />
            <input type="hidden" value="<?php echo $rows->id ?>" name="editid" />        </td>
      </tr>
    </table></td>
    <td width="59%"> 
	
	<?php 
	
		$sel = mysql_query("select a.link_cat as cat,b.link_cat as title,b.id,b.link as links from  link_categories a,link_categories b where b.parent_id = a.id ".($_GET['cid']?' and a.id = '.$_GET['cid']:' ')." order by b.link_cat ASC") or die ( mysql_error() );	

	    $nor = mysql_num_rows($sel);
		
		
	?>
	<div align="right" style="padding-bottom:5px"> Sort by Categories : 
		<select onchange="if(this.value!='')location.href='links.php?cid='+this.value">
				<option value="">-Select Catgegory-</option>
				<?php $sels = mysql_query("select * from  link_categories where parent_id = 0  order by link_cat ASC") or die ( mysql_error() );
					  while($rowcat=mysql_fetch_object($sels)){?>	
				<option value="<?php echo $rowcat->id ?>"
				<?php if($rowcat->id==$_GET['cid']):?> selected="selected" <?php endif; ?>
				><?php echo $rowcat->link_cat?></option>
				<?php }?>
			</select>
	</div>
	 <table width="100%" border="1" cellspacing="0" cellpadding="5" align="center" id="report_table">
                        <tr>
                          <th width="7%"><input type="checkbox" name="checkAll" value=""  id="checkAll"onclick="checkAllFields(this);" /></th>
                          <th width="36%" >Category Name</th>
                          <th width="25%" >Website</th>
						   <th width="32%" >Link</th>
                        </tr>
                        <?php 
	if($nor){
	while($row=mysql_fetch_object($sel)){?>
                        <tr onmouseover="this.className='test'; " onmouseout="this.className=''" class="">
                          <td align="center"><input name="delAnn[]" type="checkbox" value="<?php echo $row->id;?>" /></td>
                          <td align="center"><a href="links.php?id=<?php echo $row->id;?>"><?php echo $row->title;?></a></td>
						  <td align="center"><a href="links.php?id=<?php echo $row->id;?>"><?php echo $row->cat;?></a></td>
						  <td align="center"><?php echo $row->links;?></td>
                        </tr>
                        <?php }} else{?>
						<tr><td colspan="4" align="center">(No Links)</tr>
						<?php } ?>
                      </table>
					  
					   </td>
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
