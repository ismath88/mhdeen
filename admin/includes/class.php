<?php
class sessions
{
	var $session;
	function __construct()
	{
		if(!session_start())
		{
			echo 'Session starting error';
			exit();
		}
	}	
	function set($array)
	{
		$this->session =$array;
		foreach($array as $key =>$value)
		{
			//echo $key."<br>";
			 $_SESSION[$key]	=$value;
		}
	}
	function  get($name)
	{
		return $_SESSION[$name];
	}
	function clear($array)
	{
		foreach($array as $value)
		{
			unset($_SESSION[$value]);
			//session_unset($_SESSION[$value]);
		}
	}
}



class user 
{
	function __construct()
	{
	
	}
	
	function login($id,$password,$link='index.php')	
	{	
	   
		$password = mysql_real_escape_string($password);
		
		$query="select * from admin where username='".mysql_real_escape_string($id)."' and 
		password='".mysql_real_escape_string($password)."' "; 
		$res = mysql_query($query) or mysql_error();
		$nor = mysql_num_rows($res);
		$session = new sessions();
		if($nor)
		{
			$row = mysql_fetch_object($res);
		    $username =$row->username;
			$value = array('username'=>$username,'type'=>'super');
			$session->set($value);
			header("location:".$link);
		}
		else
		{
		   
			
			$error='login failed';
			
		}
	
	
		}
		
	}	


?>