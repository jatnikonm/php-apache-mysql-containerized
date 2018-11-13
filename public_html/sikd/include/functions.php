<?php
	function clean($val) {
		$str = @trim($val);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		$str = mysql_real_escape_string($str);
		$str = str_replace("'","", $str);
		$str = str_replace("insert","", $str);
		$str = str_replace("update","", $str);
		$str = str_replace("delete","", $str);
		$str = str_replace("select","", $str);
		$str = str_replace(" or '","", $str);
		return $str;
	}
	
	function generateKey($ln = 10){
		$possible = "012346789abcdefghijklmnopqrstuvwxyzABCDFGHIJKLMNOPQRSTUVWXYZ";
		$maxlength = strlen($possible);
		$length = $ln;	    
		while ($i < $length) { 
	
		  	$char = substr($possible, mt_rand(0, $maxlength-1), 1);
			if (!strstr($password, $char)) { 
				$password .= $char;
				$i++;
			}	
		}
		
		return $password;
	}
?>