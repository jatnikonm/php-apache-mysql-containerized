<?php 
	$path = "FilesUploaded/TemplateDoc";
	
	if($task == "upload"){
		if($_FILES["file"]["name"] != ""){
			$NAME = $_FILES["file"]["name"];
			$n=strrchr(trim($NAME,'/\\'),'.'); 
			if((strpos('\\',$n)!==false) && (strpos('/',$n)!==false)){
				$n='';
			}
		}
		
		$idGuid = date('ymdhis');

		$newname = $_SESSION["PeopleID"];
		$newname .= '_' . $idGuid . $n;
		
		if(($_FILES["file"]["size"] > 10000000)){
			echo "<script>alert('Ukuran File Tidak boleh lebih dari 10MB');</script>";
			die("<script>history.go(-1);</script>");
		}
		
		if(!UploadFile($path . "/", $newname)){
			die("<script>
					alert('Error Upload File !');
					history.go(-1);
				</script>");
		}
		chmod($path . "/" . $newname, 0777);
		
		$sql = "insert into master_doc_template values(
				'$idGuid', 
				'$data[1]', 
				'$newname', 
				'" . date("Y-m-d h:i:s") . "')";
		mysql_query($sql);
		
		die("<script>parent.doneWindow();</script>");
	}
	
	if($task=="delete"){
		$ids = implode("','", $_REQUEST["ids"]);
		$sql = "select doc_file from master_doc_template where doc_id='" . $ids . "';";
		$res = mysql_query($sql);
		while($row = mysql_fetch_array($res)){
			$doc_file = $row[0];
		}

		if($doc_file != ""){
			if(file_exists($path . '/' . $doc_file)){
				unlink($path . '/' . $doc_file);
			}
		}
		
		$sql = "delete from master_doc_template where doc_id='" . $ids . "';";
		mysql_query($sql);
		
		die("<script>location.href='index2.php?option=" . $option . "';</script>");
	}
?>