<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Welcome To M.H.Din -Licensed Money Service Business</title>
        <link href="css/styles.css" rel="stylesheet" type="text/css" />
        <link   rel="stylesheet"    type="text/css"     href="greybox/gb_styles.css"/>

        <link rel="icon" href="images/mhdeen.png" />
        <script type="text/javascript">
            function slides(opt) {
                msrs = (opt == 1) ? '0' : '-38px';
                document.getElementById('pBtn').style.top = msrs;
            }
        </script>
        <script type="text/javascript">
            var GB_ROOT_DIR = "greybox/";
        </script>

        <script  type="text/javascript" src="greybox/AJS.js" ></script>
        <script  type="text/javascript" src="greybox/AJS_fx.js" ></script>
        <a href="index.php"></a>
        <script  type="text/javascript" src="greybox/gb_scripts.js" ></script>

    </head>
    <body>

        <div class="container">

            <?php include('includes/header.php'); ?>


            <div class="content">


                <div class="content_controller" style="position:relative; overflow:hidden;" onmouseover="slides(1)"

                     onmouseout="slides(0)">

                    <!--div class="printer" id="pBtn" onclick="wins = window.open('current_report.php','Report','width=1000,height=700,top=10,left=10,scrollbars=1');">
                        Click Here To Print Exchange Rates
                    </div-->


                    <table cellspacing="0" cellpadding="5" border='1' width="100%" class="price_rpt">
                        <tr style="text-align:center">

                            <th width="7%">Flag</th>
                            <th width="5%">Unit</th>
                            <th width="6%">Code</th>
                            <th width="26%">Currency</th>
                            <th width="6%">We Buy</th>
                            <th width="6%">We Sell</th>
                            <th width="20%">Last Update</th>


                            <!--th width="19%">Last 2 Weeks Rates </th--!>
                        </tr>
                            <?php
                            $sel = mysql_query("select a.*,b.csell,b.cbuy,DATE_FORMAT(FROM_UNIXTIME(a.upd_date), 
								'%m/%e/%Y at %h:%i %p') as up_date_old,a.upd_date as up_date  from 
								unitprices a LEFT OUTER JOIN yester_unitprices b ON a.id = b.cid AND b.status = 'CURR' 
								WHERE in_exchange = 1
								order by  `order` ASC");
                            $num = mysql_num_rows($sel);
                            if ($num): $mrows = 0;
                                while ($row = mysql_fetch_object($sel)) :
                                    ?>
                                        <tr align="center" class="<?php echo $mrows % 2 == 0 ? 'Meven' : 'Modd'; ?>">

                                            <td>
                                    <?php if ($row->src): ?>
                                                        <img src="admin/flag/<?php echo $row->src ?>" height="30" width="48" />
                                    <?php else: echo 'Not Availbale'; ?>
                                    <?php endif; ?>								</td>
                                            <td><strong><?php echo $row->unit ?></strong></td>
                                            <td><strong><?php echo $row->cur_code ?></strong></td>
                                            <td><strong><?php echo $row->curry ?></strong></td>
                                            <td><strong><?php echo sprintf('%01.3f', ($row->cbuy ? $row->cbuy : $row->buy)) ?></strong></td>
                                            <td><strong><?php echo sprintf('%01.3f', ($row->csell ? $row->csell : $row->sell)) ?></strong></td>
                                                                                                
                                                                                                            <td><strong><?php echo date('d/m/Y h:i A', $row->up_date); ?></strong></td>	
                                            <!--td ><a class="view_rates" href="last_report.php?id=<?php echo $row->id; ?>" onclick="return GB_showCenter('Last 7 Days Exchange Rates For <?php echo $row->cur_code ?> (<?php echo $row->curry ?>)', this.href,700,1100)">View</a></td--!>
                                        </tr>
                                    <?php $mrows++;
                                endwhile;
                                ?>

<?php endif; ?>
                    </table>

                </div>

            </div>

<?php include('includes/footer.php'); ?>

        </div>

    </body>
</html>
