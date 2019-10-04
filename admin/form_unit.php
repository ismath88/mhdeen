<?php
  date_default_timezone_set("Asia/Kuala_Lumpur");
include("includes/config.inc");
include("includes/function.php");
include("includes/class.php");
include("includes/menu.php");
include("includes/sessions.php");

$time = (int) $_SERVER['REQUEST_TIME'];


if (isset($_POST['submit'])) {

//date_default_timezone_set("Asia/Kuala_Lumpur");


    $fname = trim(time() . $_FILES['flag']['name']);
    $path = 'flag/' . $fname;
    $unit = $_POST['unit'];
    $currency = $_POST['currency'];
    $we_buy = $_POST['we_buy'];
    $we_sell = $_POST['we_sell'];
    $cur_code = $_POST['cur_code'];

$time = (int) $_SERVER['REQUEST_TIME'];


    
    if (move_uploaded_file($_FILES['flag']['tmp_name'], $path)) {

        $uploded_name = $fname;
    }

    if ((int) $_GET['id']):

        $insert = "update  unitprices set cur_code = '" . $cur_code . "' , unit ='" . $unit . "', curry = '" . $currency . "'," .
                ($uploded_name ? ("src = '" . $uploded_name . "',") : '')
                . " upd_date = '" . $time . "' , description = '" . mysql_real_escape_string($_POST['desc']) . "'
					where id = " . $_GET['id'];

        //$insert = "update yester_unitprices set cbuy = '" . $we_buy . "',csell='" . $we_sell . "' WHERE cid = " . $_GET['id'];
        mysql_query($insert);
        $msg = "Currency Updated";


    elseif ((int) $_GET['rate_id']):
    
      $insert = "update yester_unitprices set cbuy = '" . $we_buy . "',csell='" . $we_sell . "' WHERE lid = " . $_GET['rate_id'];

        mysql_query($insert);
        $msg = "Rates Updated";

    else:

        $insert = "insert into unitprices (unit,curry,cur_code,buy,sell,src,upd_date,in_exchange,description) values 
			('" . $unit . "','" . $currency . "','" . $cur_code . "','" . $buy . "','" . $sell . "','" . $fname . "','" . $time . "',0,'" . mysql_real_escape_string($_POST['desc']) . "')";


        mysql_query($insert);
        $last_insert_id = mysql_insert_id();

        $insert = "insert into yester_unitprices(cid,cbuy,csell,cto_date,status) values('" . $last_insert_id . "','" . $we_buy . "','" . $we_sell . "','" . $time . "','CURR')";
        mysql_query($insert);

        $msg = "Currency Added";

    endif;



    if ($_POST['editid'])
    
    
        $query = "update  unitprices set upd_date = " . $time . " where id =".$_POST['editid'];
       
        mysql_query($query);
        
}

if ($_POST['saveorder']) {



    foreach ($_POST['saveord'] as $id => $value):

        $query = "update unitprices set `order`='" . $value . "' where id=" . $id;
        mysql_query($query);
    endforeach;
}

if ($_POST['saveexchange']) {


    if (count($_POST['exch']) > 0):

        $query = "update unitprices set `in_exchange`='0' where id not in (" . implode(',', $_POST['exch']) . ")";
        mysql_query($query) or die(mysql_error());
        $query = "update unitprices set `in_exchange`='1' where id in (" . implode(',', $_POST['exch']) . ")";
        mysql_query($query) or die(mysql_error());

    endif;
}

if (count($_POST['opt'])) {
    echo count($_POST['opt']);
    //echo " delete from unitprices where id IN (" . implode(',', $_POST['opt']) . ") ";
    mysql_query(" delete from unitprices where id IN (" . implode(',', $_POST['opt']) . ") ");
    mysql_query(" delete from yester_unitprices where cid IN (" . implode(',', $_POST['opt']) . ") ");
    $msg = "Deleted Successfully";
}

if ((int) $_GET['id']):

    $sel = mysql_query("select * from unitprices where id =" . $_GET['id']);

    $row = mysql_fetch_object($sel);


endif;

if ((int) $_GET['rate_id']):

    $sel = mysql_query("select a.*,b.csell,b.cbuy,b.cid from 
								unitprices a LEFT OUTER JOIN yester_unitprices b ON a.id = b.cid 
								WHERE b.lid =" . $_GET['rate_id']);

    $row = mysql_fetch_object($sel);


endif;
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
                <div id="logo_head"></div>
                <div id="top_head"> Admin Panel </div>
                <div class="both"></div>
            </div>		
            <!-- END LOGO -->
            <!-- Menu -->
            <div id="menu">
                <?php
                $menu = new menu();
                echo $menu->top_menu
                ?>	
            </div>
            <!-- End Menu -->
            <!--Start Contents-->
            <div id="contents">
                <div id="head">
                    Currency Section</div>
                <div id="page_contents">
                    <div id="cover_of_contents" style="margin:auto; padding:10px">
                        <div style="text-align:right">
                            <a href="logout.php">Logout</a>
                        </div>
                        <form id="fest" name="fest" method="post" enctype="multipart/form-data">	
                            <?php
                            if ($_GET['id'] || $_GET['rate_id']):
                                ?>	
                                <div style="text-align:right">
                                    <a href="form_unit.php"> [ X ] Cancel</a>
                                </div>
                                <?php if ($msg): ?>
                                    <div style="color:#006633; padding:5px 0; font-weight:bold"><?php echo $msg; ?></div>
                                <?php endif; ?>
                                <table cellpadding="5" cellspacing="5" >

                                    <tr>
                                        <td width="118">UNIT</td> <td width="196"> <input type="text" id="unit" name="unit" value="<?php echo $row->unit ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>CODE</td>
                                        <td><input type="text" id="cur_code" name="cur_code" value="<?php echo $row->cur_code ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>CURRENCY </td> <td><input type="text" id="currency" name="currency" value="<?php echo $row->curry ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>WE BUY</td> <td><input type="text" id="we_buy" name="we_buy" value="<?php echo $row->cbuy ? $row->cbuy : $row->buy ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>WE SELL </td> <td><input type="text" id="we_sell" name="we_sell" value="<?php echo $row->csell ? $row->csell : $row->sell ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td valign="top">DESCRIPTION</td>
                                        <td><textarea name="desc" style="width:200px; height:100px" id="desc"><?php echo stripslashes($row->description); ?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Flag</td> <td><input type="file" id="flag" name="flag" /><br />
                                            <?php if ($row->src): ?>
                                                <img src="flag/<?php echo $row->src ?>"  height='37' width='54'/>

                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center"><input type="Submit" id="submit" name="submit" /><input type="hidden" value="<?php echo $row->cid ? $row->cid : $row->id ?>" name="editid" /> </td>
                                    </tr>
                                </table>

                            <?php else: ?>

                                <div style="text-align:right">
                                    <a href="#" onclick="document.fest.submit();"> [ - ] Delete Currency</a> | <a href="form_unit.php?id=--"> [ + ] Add New Currency</a>
                                </div>
                                <?php if ($msg): ?>
                                    <div style="color:#006633; text-align:center padding:5px 0; font-weight:bold"><? echo $msg; ?></div>
                                <?php endif; ?>	
                                <table cellspacing="0" cellpadding="5" width="100%" border="1">
                                    <tr>
                                        <td colspan="8" align="right"><a href="#" onclick="wins = window.open('printing.php', 'ExchangeRates', 'top=50,left=50,width=683,height=1500');
                                                wins.focus();">Print Recent Exchange Rates</a> | <a href="cronjob.php">Run The file Daliy once </a></td>
                                        <td><input type="submit" id="saveexchange" name="saveexchange" value="Save Exchange" /></td>
                                        <td><a href="cronjob.php"></a> 
                                            <input type="submit" id="saveorder" name="saveorder" value="saveorder" /></td>
                                    </tr>
                                    <tr>
                                        <th><input type="checkbox" name="chbox" /></th>
                                        <th>Unit</th>
                                        <th>Flag</th>
                                        <th>Code</th>
                                        <th>Currency</th>
                                        <th>We Buy</th>
                                        <th>We Sell</th>
                                        <th>Last Updated</th>
                                        <th>Exchange</th>
                                        <th> Order </th>
                                    </tr>
                                    <?php
                                    $sel = mysql_query("select a.*,b.lid,b.csell,b.cbuy,DATE_FORMAT(FROM_UNIXTIME(a.upd_date), 
								'%m/%e/%Y at %h:%i %p') as ups_date,a.upd_date as up_date   from 
								unitprices a LEFT OUTER JOIN yester_unitprices b ON a.id = b.cid AND b.status = 'CURR'
								order by in_exchange DESC , `order` ASC") or die(mysql_error());
                                    $num = mysql_num_rows($sel);
                                    if ($num):
                                        while ($row = mysql_fetch_object($sel)) :

                                            if ($row->in_exchange == 1):
                                                $rate_link = '<a href="form_unit.php?rate_id=' . $row->lid . '">';
                                                $rate_link_end = '</a>';
                                            else:
                                                $rate_link = '';
                                                $rate_link_end = '';
                                            endif;
                                            ?>
                                            <tr align="center">
                                                <td><input type="checkbox" name="opt[]" value="<?php echo $row->id ?>"  /></td>
                                                <td><?php echo $row->unit ?></td>
                                                <td>
                                                    <?php if ($row->src): ?>
                                                        <img src="flag/<?php echo $row->src ?>"  height='37' width='54'/>
                                                    <?php else: echo 'Not Availbale'; ?>
                                                    <?php endif; ?>								</td>
                                                <td><?php echo $row->cur_code ?></td>
                                                <td><a href="form_unit.php?id=<?php echo $row->id ?>"><?php echo $row->curry ?></a></td>
                                                <td><?php echo $rate_link . ($row->cbuy ? $row->cbuy : $row->buy) . $rate_link_end ?></td>
                                                <td><?php echo $rate_link . ($row->csell ? $row->csell : $row->sell) . $rate_link_end ?></td>
                                                <td><?php echo date('d/m/Y h:i:s A',$row->up_date); ?></td>
                                                 <!--td><?php //echo $row->ups_date ?></td-->
                                                <td><input type="checkbox" name="exch[]" <?php if ($row->in_exchange == 1): ?> checked="checked" <?php endif; ?> value="<?php echo $row->id; ?>"  /></td>
                                                <td><input type="text" id="saveord" style="width:30px;" name="saveord[<?php echo $row->id ?>]" value="<?php echo $row->order ?>" /> </td>
                                            </tr>
                                            <?php
                                        endwhile;
                                    else:
                                        ?>
                                        <tr>
                                            <td colspan="10" align="center">( No Records )</td>
                                        </tr>
                                    <?php endif; ?>
                                </table>


                            <?php endif; ?>

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
        <script type="text/javascript">
<?php if ((int) $_GET['rate_id']): ?>
                                            document.getElementById('unit').readOnly = true;
                                            document.getElementById('cur_code').readOnly = true;
                                            document.getElementById('currency').readOnly = true;
                                            document.getElementById('flag').readOnly = true;
                                            document.getElementById('desc').readOnly = true;
<?php elseif ((int) $_GET['id']): ?>
                                            document.getElementById('we_buy').readOnly = true;
                                            document.getElementById('we_sell').readOnly = true;
<?php endif; ?>

        </script>
    </body>
</html>