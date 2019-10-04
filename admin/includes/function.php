<?php
function convert_date($date,$separator='-')
{
	list($first,$second,$third)=split("[./-]",$date);
	return $third.$separator.$second.$separator.$first;
}

function convert_number($number) 
{ 
    if (($number < 0) || ($number > 999999999)) 
    { 
    throw new Exception("Number is out of range");
    } 

	$Cn = floor($number / 10000000);  /* crore (giga) */ 
    $number -= $Cn * 10000000;
    $Gn = floor($number / 100000);  /* lakh (giga) */ 
    $number -= $Gn * 100000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 

    $res = ""; 

    if ($Cn) 
    { 
        $res .= convert_number($Cn) . " Lakhs"; 
    } 
	
	if ($Gn) 
    { 
        $res .= convert_number($Gn) . " Lakhs"; 
    } 

    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($kn) . " Thousand"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($Hn) . " Hundred"; 
    } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
        "Seventy", "Eigthy", "Ninety"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " and "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= "-" . $ones[$n]; 
            } 
        } 
    } 

    if (empty($res)) 
    { 
        $res = "zero"; 
    } 

    return $res; 
} 

function delete_row($table,$keyname="",$keyvalue="")
{
	$res;
	if(($keyname!="")&&($keyvalue!=""))
	{
		switch(is_array($keyvalue))
		{
			case true:
					 $len=count($keyvalue);	
					 $query="";
					 for($i=0;$i<$len;$i++)	
					 {
						$query.="delete from ".$table." where ".$keyname."='".$keyvalue[$i]."'";
					 }
					 break;
			case false:
						$query="delete from ".$table." where ".$keyname."='".$keyvalue."'";	
					  break;
		}
	
	}
	else
	{
		$query="delete from ".$table;
	}
	//echo $query;
	$res=mysql_query($query) or die(mysql_error());
	$nar=mysql_affected_rows();
	if($res)
	{
		return true;
	}
	else
	{
		return false;
	}
}

//function for inserting row
function insert_row($table,$name,$value)
{
	if(is_array($name))
	{
	$name=implode(",",$name);
	}
	if(is_array($value))
	{
		$len=count($value);
		$values=" values ( ";
		for($i=0;$i<$len;$i++)
		{
			$values.="'".$value[$i]."'";
			if($i!=$len-1)$values.=",";
		}
		$values.=" )";
	}
	else
	{
		$values="values ('".$value."')";
	}
	$query="insert into ".$table." (".$name.")".$values ;
	$res=mysql_query($query) or die( mysql_error());
	$lid = mysql_insert_id();
	
	if($res)
	{
		return ($lid);
	}
	else
	{
		return false;
	}
}

//function for updating row
function update_row($table,$name,$value,$condition=NULL)
{
	if((is_array($name))&&(is_array($value)))
	{
		$len=count($name);
		$len1=count($value);
		$values="";
		for($i=0;$i<$len;$i++)
		{
		$values.="$name[$i]='$value[$i]'";
		if($i!=$len-1)$values.=",";
		}
	}
	else
	{
		 $values="$name='$value'";
	}
	if($condition)
	{
	$where=" where ".$condition;
	}
	$query="update ".$table." set ".$values.$where;
	$res=mysql_query($query) or die (mysql_error());
	$nar=mysql_affected_rows();
	if($nar)return true; else return false;
}

?>