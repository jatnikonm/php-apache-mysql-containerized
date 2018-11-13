<?php

	if($task2 == "delete"){
		$ids = implode(",", $_REQUEST["ids"]);
		$id = explode(",", $ids);
		
		try {
			for($a=0; $a<count($id); $a++){
				if(checkUsed($id[$a]) == "false"){
					//------------ if already on folder -------------------
					$sql = "select NFileDir from inbox 
							where NKey = '" . $_SESSION["AppKey"] . "'
								and NId = '$id[$a]' ";
					$res = mysql_query($sql);
					while($row = mysql_fetch_array($res)){
						$fileDir = $row[0];
					}
					//echo $sql . "; --+ " . $fileDir . "<br />";
				
					if($fileDir != ''){
						$path = "FilesUploaded/" . $fileDir;
						
						//geting Filename
						// the delete it
						$sql = "select FileName_fake from inbox_files 
								where FileKey = '" . $_SESSION["AppKey"] . "'
									and NId = '$id[$a]' ";
						//echo $sql . "; --+ ";
						$res = mysql_query($sql);
						while($row = mysql_fetch_array($res)){
							$fileName = $row[0];
							if(file_exists($path . '/' . $fileName)){
								unlink($path . '/' . $fileName);
							}
							//echo $path . '/' . $fileName . ";";
						}						
						//echo "< br/>";
						
						if(is_dir($path)){
							//$mydir = opendir($path);
							//die($path);
							rmdir($path);
						}
					}
					//die();
					
					//------------- delete if on FilesUploaded/Temp ------------------
					$sql = "select FileName_fake from inbox_files 
						where FileKey = '" . $_SESSION["AppKey"] . "'
								and NId = '$id[$a]' ";
					$res = mysql_query($sql);
					while($row = mysql_fetch_array($res)){
						$files = trim($row["FileName_fake"]);
						if(file_exists('FilesUploaded/Temp/' . $files)){
							unlink('FilesUploaded/Temp/' . $files);
						}
					}
					//----------------------------------------------------------------
					
					$sql = "delete from inbox_receiver 
							where NKey = '" . $_SESSION["AppKey"] . "'
								and NId = '$id[$a]' ";
					mysql_query($sql);
					
					$sql = "delete from inbox_files 
							where FileKey = '" . $_SESSION["AppKey"] . "'
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
			echo "<script>alert('Gagal menghapus data !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		}	
	}
	
	if ($task == "delete"){
		$id = ($_REQUEST["ids"]);
		try{

					//------------ if already on folder -------------------
					$sql = "select NFileDir from inbox 
							where NKey = '" . $_SESSION["AppKey"] . "'
								and NId = '$id' ";
					$res = mysql_query($sql);
					while($row = mysql_fetch_array($res)){
						$fileDir = $row[0];
					}
					//echo $sql . "; --+ " . $fileDir . "<br />";
				
					if($fileDir != ''){
						$path = "FilesUploaded/" . $fileDir;
						
						//geting Filename
						// the delete it
						$sql = "select FileName_fake from inbox_files 
								where FileKey = '" . $_SESSION["AppKey"] . "'
									and NId = '$id' ";
						//echo $sql . "; --+ ";
						$res = mysql_query($sql);
						while($row = mysql_fetch_array($res)){
							$fileName = $row[0];
							if(file_exists($path . '/' . $fileName)){
								unlink($path . '/' . $fileName);
							}
							//echo $path . '/' . $fileName . ";";
						}						
						//echo "< br/>";
						
						if(is_dir($path)){
							//$mydir = opendir($path);
							//die($path);
							rmdir($path);
						}
					}
					//die();
					
					//------------- delete if on FilesUploaded/Temp ------------------
					$sql = "select FileName_fake from inbox_files 
						where FileKey = '" . $_SESSION["AppKey"] . "'
								and NId = '$id' ";
					$res = mysql_query($sql);
					while($row = mysql_fetch_array($res)){
						$files = trim($row["FileName_fake"]);
						if(file_exists('FilesUploaded/Temp/' . $files)){
							unlink('FilesUploaded/Temp/' . $files);
						}
					}

			$sql = "delete from inbox_receiver 
					where NKey = '" . $_SESSION["AppKey"] . "'
						and NId = '$id' ";
			mysql_query($sql);
			
			$sql = "delete from inbox_files 
					where FileKey = '" . $_SESSION["AppKey"] . "'
						and NId = '$id' ";
			mysql_query($sql);
													
			$sql = "delete from inbox 
					where NKey = '" . $_SESSION["AppKey"] . "'
						and NId = '$id' ";
			mysql_query($sql);	
			
			echo "<script>alert('Data Berhasil Dihapus ! \n Jika data ternyata belum terhapus, data tsb masih digunakan. !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		}catch (Exception $e) {
			echo "<script>alert('Gagal menghapus data !');</script>";
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