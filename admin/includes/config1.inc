<?
set_time_limit(0);
$host="localhost";
$user="sigarama_newplan";
$pwd="f@D;GLHz%,$u"; 
$db="sigarama_sigaram"; 
$conn=mysql_connect($host,$user,$pwd);
mysql_select_db($db);
if(!$conn)
{
echo mysql_error();
}
date_default_timezone_set('Asia/Calcutta');
?>