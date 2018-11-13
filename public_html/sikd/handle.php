<?php
	session_start();
	
	if($_SESSION["masuk"] == ""){
		die("<script>location.href = 'index.php'</script>");
	}
	require_once("conf.php");
	require_once("include/functions.php");
	
	$option = clean($_REQUEST["option"]);
	$task = $_REQUEST["task"];
	$id = $_REQUEST["id"];
	$count = $_REQUEST["count"];
	for($a=1;$a<=$count;$a++){
		$data[$a] = $_REQUEST["txt" . $a];
		$data[$a] = str_replace("'", "", $data[$a]);
		$data[$a] = str_replace("--", "", $data[$a]);
	}
	
	$filepath = "Mod/Mod" . $option . "/" . $option . "_proses.php";
	
	if(file_exists($filepath)){
		include($filepath);
	}else{
		echo "<script>alert('Wrong Arguments')</script>";
		die("<script>location.href = 'index.php'</script>");
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
	
	function UploadFile($path, $newname){		
		$FolderPath = $path;	
		if ($_FILES["file"]["error"] == 0){
			if (file_exists($FolderPath . $newname)){
				unlink($FolderPath . $newname);
				//return false;
			}
			
			try{
				$move = move_uploaded_file($_FILES["file"]["tmp_name"],	$FolderPath . $newname);
			}catch (Exception $e) {
    			die ('File did not upload : ' . $e->getMessage());
				return false;
			}
			
			return true;
		}
	}

?>
