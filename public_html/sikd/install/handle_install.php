<?php
	session_start();
	
	require_once("../include/functions.php");
	require_once('../include/directory_delete.php');
	
	if($_SESSION["masuk"] == ""){
		die("<script>location.href = 'index.php'</script>");
	}
		
	$option = $_REQUEST["option"];
	$task = $_REQUEST["task"];
	$id = $_REQUEST["id"];
	$count = $_REQUEST["count"];
	for($a=1;$a<=$count;$a++){
		$data[$a] = $_REQUEST["txt" . $a];
		$data[$a] = str_replace("'", "", $data[$a]);
		$data[$a] = str_replace("--", "", $data[$a]);
	}
	
	$filepath = "ModAdminRestart/AdminRestart_proses.php";
	
	//die($filepath);
	if(file_exists($filepath)){
		include($filepath);
	}else{
		echo "<script>alert('Wrong Arguments')</script>";
		die("<script>location.href = '../index.php'</script>");
	}
	
	function getNumberGeneral($ColId, $tbName){
		$query = "select (max(convert(substr($ColId, 12), UNSIGNED)) + 1) as id ";
		$query .= "from $tbName ";
		$query .= "where $ColId like '" . $_SESSION["AppKey"] . "%'";
		$result = mysql_query($query);
		if (mysql_num_rows($result) > 0){
			while($row = mysql_fetch_array($result)){
				$id = $row[0];
			}
		}
		return $id;
	}
	
	function getNumberMain($ColKey, $ColId, $tbName){
		$query = "select (max(convert($ColId, UNSIGNED)) + 1) as id ";
		$query .= "from $tbName ";
		$query .= "where $ColKey = '" . $_SESSION["AppKey"] . "'";
		
		$result = mysql_query($query);
		if (mysql_num_rows($result) > 0){
			while($row = mysql_fetch_array($result)){
				$id = $row[0];
			}
		}else{
			$id = 1;
		}
		
		if($id === NULL ){
			$id = 1;
		}
		return $id;
	}
	
	function mkdate($str){
		$arrDate = split('/', $str);
		return ($arrDate[2] . '-' . $arrDate[1] . '-' . $arrDate[0]);
	}
	
?>
