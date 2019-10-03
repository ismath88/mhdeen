<?php
if (isset($_POST['sub'])) {

    $name = $_POST['name'];
    $cname = $_POST['cname'];
    $email = $_POST['email'];
    $query = $_POST['query'];
    $subject = $_POST['subject'];


    //$to = "fhaplteam@gmail.com";
    $to = "admin@mhdin.com.my";
    $subject = 'Enquiry From M.H.Din Sdn Bhd : ' . $_POST['subject'];
    $message = $_POST['query'];
    $from = $_POST['email'];
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    //$headers .= 'From: vedha@mercer.nswebhost.com' . "\r\n" .'Reply-To: no@mercer.nswebhost.com' . "\r\n" ;
    $headers .= 'From: ' . $name . '<' . $from . '>';

    $message .= "hi<br /><br />" . $query . "<br/><br />Thanks,<br />" . $name . ',<br/>' . $cname . ',<br/>' . $email;

    $a = mail($to, $subject, $message, $headers);
    if (!$a) {
        $msg = "Your Msg Has Been Not Send ";
    } else {
        header("location:contact-us.php?msg=Thank for your message. we will respond to you soon as possible.
 ");
    }
}
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Contact Us - M.H.Din:</title>
        <link rel="icon" href="images/mhdeen.png" />
        <link href="css/styles.css" rel="stylesheet" type="text/css" />
        <script>
            function validateForm()
            {
                var a = document.forms["con"]["name"].value;
                if (a == null || a == "")
                {
                    alert("Your Name Must");
                    return false;
                }

                validRegExp = /^[^@]+@[^@]+.[a-z]{2,}$/i;
                var b = document.con.email.value;
                if (b.search(validRegExp) == -1)
                {
                    alert(" Your Email Must");
                    return false;
                }

                var c = document.forms["con"]["subject"].value;
                if (c == null || c == "")
                {
                    alert("Your Subject Must");
                    return false;
                }


                var d = document.forms["con"]["query"].value;
                if (d == null || d == "")
                {
                    alert("Your Query Must");
                    return false;
                }
            }
        </script>
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-785704-5']);
            _gaq.push(['_addDevId', 'i9k95']); // Google Analyticator App ID with Google 

            _gaq.push(['_trackPageview']);

            (function () {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();
        </script>
    </head>

    <body>

        <div class="container">

            <?php include('includes/header.php'); ?>

            <div class="content">

                <div class="content_controller">

                    <!--div style="float:left; width:28%; font-size:14px; line-height:25px;"><h3>Contact Us</h3-->
                    <div style="float:left; width:35%; font-size:14px; line-height:25px;"><h3>Contact Us</h3>
                        <div style="border-right: 2px solid gray;">  <a style="color:#ff0000"><strong>M.H.Din Sdn Bhd.</strong></a><br />
                        No 62 Jalan Bukit Bintang,
                        <br/>
                        Kuala Lumpur,55100.<br />
                        Malaysia<br/>
                            <strong><b>Phone Line:</b> </strong>03-21102240<br />
                            <strong><b>Email:</b> </strong><a style="color:#0000ff">bbplaza@mhdin.com.my</a><br />
                            <strong><b>Business Hours:</b> </strong><a style="color:#ff0000">9 Am To 10 Pm<a><br />
                                    <hr/>
                                    <hr/>
                                    <a style="color:#ff0000"><strong>M.H.Din Sdn Bhd.</strong></a><br />

                                    Lot 1, Piccolo Mondo Side Walk Café,
                                    <br />No. Lot 1324, Seksyen 67, <br />Hadapan Bangunan Wisma Peladang,<br />
                                    Jalan Bukit Bintang, <br/>
                                    55100 KualaLumpur<br />
                                    Malaysia<br/>
                                        <strong><b>Phone Line:</b> </strong>03-21431600<br />
                                        
                                        <strong><b>Email:</b> </strong><a style="color:#0000ff">piccolo@mhdin.com.my<a><br />
                                                <strong><b>Business Hours:</b> </strong><a style="color:#ff0000">10 Am To 10 Am<a><br />
                                                        
                                                       
                                                         <hr/>
                                    <hr/>
                                    <a style="color:#ff0000"><strong>M.H.Din Sdn Bhd.</strong></a><br />

                                    LG 33.Sunway Putra Mall,
                                    <br />100 Jalan Putra,50350, <br />Kuala Lumpur.<br />
                                 
                                    Malaysia<br/>
                                        <strong><b>Phone Line:</b> </strong>03-40446786<br />
                                        <strong><b>Mobile:</b> </strong>0192222786<br />
                                        
                                        <strong><b>Email:</b> </strong><a style="color:#0000ff">piccolo@mhdin.com.my<a><br />
                                                <strong><b>Business Hours:</b> </strong><a style="color:#ff0000">10 Am To 10 Am<a><br />
                                                        </div>
                                                        </div>

                                                        <!--div style="float:right;width:71%; border-left:3px solid #B7B7B7;text-align: center; ">
                                                            <img src="images/contact-u.png" title="click to view larger" height="327" style="border:5px solid #B7B7B7;cursor: pointer;" onclick="window.open('map1.php', 'Report', 'width=950,height=600,top=10,left=10,scrollbars=2');"/>
                                                            <hr/>
                                                            <hr/>
                                                            <img src="images/map.jpg" title="click to view larger" width="548" height="327" style="border:5px solid #B7B7B7;cursor: pointer;" onclick="window.open('map2.php', 'Report', 'width=950,height=600,top=10,left=10,scrollbars=2');"/-->
                                                            <div class="en_form" >
                                                                <div class="en-title">Kindly send your complaints and suggestion to admin@mhdin.com.my to serve you better in near future.
                                                                </div>
                                                                <form action="#" name="con" method="post">
                                                                    <?php // if ($_GET['msg']): ?>
                                                                    <div style="text-align:center; font-weight:bold; padding:5px; color:#006633">
                                                                        <?php //echo $_GET['msg']; ?>
                                                                    </div>
                                                                    <?php //endif; ?>

                                                                    <table cellpadding="5"  cellspacing="0" align="center">

                                                                        <tbody><tr><td colspan="2"><div class="msg"></div></td></tr>

                                                                            <tr><td width="150"><div class="field_name">Name<id class="field_star">*</id></div></td><td width="275"><input name="name" class="field_textbox" type="text"></td></tr>
                                                                            <tr><td width="150"><div class="field_name">Company Name</div></td><td width="275"><input name="cname" class="field_textbox" type="text"></td></tr>

                                                                            <tr><td><div class="field_name">Email<span class="field_star">*</span></div></td><td><input name="email" class="field_textbox" type="text"></td></tr>


                                                                            <tr><td><div class="field_name">Telephone</div></td><td><input name="tele" class="field_textbox" type="text"></td></tr>

                                                                            <tr><td><div class="field_name">Subject<span class="field_star">*</span></div></td><td><input name="subject" class="field_textbox" type="text"></td>
                                                                            </tr><tr valign="top"><td><div class="field_name"> Queries<span class="field_star">*</span></div></td>
                                                                                <td><textarea rows="8" style="width: 200px;" name="query" class="field_texarea"></textarea></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td></td>
                                                                                <td> <input name="sub" value="Submit" class="field_submit" onclick="return validateForm()" type="submit">
                                                                                        <input name="reset" value="Reset" type="reset"></td>
                                                                                            </tr>
                                                                                            </tbody>
                                                                                            </table>
                                                                                            </form>
                                                                                            <div class="both"></div>
                                                                                            </div>
                                                                                            </div>
                                                                                            <div class="both"></div>
                                                                                            <!--/div-->

                                                                                            </div>

                                                                                            <?php include('includes/footer.php'); ?>

                                                                                            </div>

                                                                                            </body>
                                                                                            </html>
