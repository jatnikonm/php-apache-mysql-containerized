<?
	$task2 = $_REQUEST["task2"];
	if($task2 == "delete"){
	
		$ids = implode(",", $_REQUEST["ids"]);
		$id = explode(",", $ids);
		try {
			for($a=0; $a<count($id); $a++){
				if(checkUsed($id[$a]) == "false"){
					$sql = "select NFileDir from inbox 
						where NKey = '" . $_SESSION["AppKey"] . "'
								and NId = '$id[$a]' ";
					$res = mysql_query($sql);
					while($row = mysql_fetch_array($res)){
						$fileDir = $row["NFileDir"];
					}
					
					if($fileDir != ''){
						$path = 'FilesUploaded/' . $fileDir . "/";
						if(is_dir($path)){
							$mydir = opendir($path);
							while(false !== ($file = readdir($mydir))) {
								if($file != "." && $file != "..") {
									if(file_exists($path.$file)){
										unlink($path.$file);
									}
								}
							}
							closedir($mydir);
							rmdir($path);
						}
					}
					//die();
					$sql = "delete from inbox_files 
							where FileKey = '" . $_SESSION["AppKey"] . "'
								and NId = '$id[$a]' ";
					mysql_query($sql);
					
					$sql = "delete from inbox_receiver 
							where NKey = '" . $_SESSION["AppKey"] . "'
								and NId = '$id[$a]' ";
					mysql_query($sql);		
																				
					$sql = "delete from inbox 
							where NKey = '" . $_SESSION["AppKey"] . "'
								and NId = '$id[$a]' ";
					mysql_query($sql);
				}
			}			
			
			echo "<script>alert('Data Berhasil Dihapus ! \n Jika data ternyata belum terhapus, data tsb masih digunakan. !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal manghapus data !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		}	
	}
	
	function checkUsed($nid){
		//check if already used
		$sql = "select count(*) from inbox_receiver 
				where NKey = '" . $_SESSION["AppKey"] . "' 
					and NId='$nid' 
					and ReceiverAs in ('cc1', 'to_reply', 'to_usul') ";
		$res = mysql_query($sql);
		if(mysql_num_rows($res) > 1){
			return "true";
		}else{
			return "false";
		}
	}
?>