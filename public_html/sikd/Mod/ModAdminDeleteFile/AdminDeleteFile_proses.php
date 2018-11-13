<?php
	if($task == delete){
		$ids = implode(",", $_REQUEST["ids"]);
		$id = explode(",", $ids);
		for($a=0; $a<count($id); $a++){
			HapusData($id[$a]);
		}
	}
	
	die("<script>location.href='index2.php?option=$option&task=list';</script>");
	
	function HapusData($id){
		$sql = "select i.NFileDir, ifs.FileName_fake 
				from inbox i, inbox_files ifs 
				where i.NId = ifs.NId 
					and i.NKey = ifs.FileKey 
					and i.NId = ifs.NId 
					and i.NKey='" . $_SESSION["AppKey"] . "' 
					and ifs.GIR_Id='" . $id . "'";
		$res = mysql_query($sql);
		while($row = mysql_fetch_array($res)){
			$WorkingDir = $row["NFileDir"];
			$filename = $row["FileName_fake"];
			
			if($filename != ""){
				$path = "FilesUploaded/" . $WorkingDir . "/";
				if(file_exists($path . $filename)){
					unlink($path . $filename);
				}
			}
		}
		
		$sql = "delete from inbox_files 
				where FileKey='" . $_SESSION["AppKey"] . "' 
					and GIR_Id='" . $id . "' 
					and FileStatus = 'usul_hapus'";
		mysql_query($sql);
		

		$sql = " delete from inbox_receiver 
				where NKey='" . $_SESSION["AppKey"] . "' 
					and GIR_Id='" . $id . "' 
					and Msg = 'usul_hapus' ";
		mysql_query($sql);
	}
?>