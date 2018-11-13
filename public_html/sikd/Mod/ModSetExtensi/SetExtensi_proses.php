<?php
	if ($task == "new"){
		try {
			$sql = "select * from master_file_allowed ";
			$sql .= "WHERE TipeId like '" . $_SESSION["AppKey"] . "%' ";
			$sql .= " 	AND lower(TipeExt) =  lower('$data[1]') ";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Tipe Ekstensi Baru Sudah Ditemukan Dengan Nama Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
				
			$sql = "insert into master_file_allowed values( ";
			$sql .= "'" . $_SESSION["AppKey"] . "." . getNumberGeneral('TipeId', 'master_file_allowed') . "',";
			$sql .= "'$data[1]')";
			//die($sql);
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
	if ($task == "edit"){
		try {
			$sql = "select * from master_file_allowed ";
			$sql .= "WHERE TipeId like '" . $_SESSION["AppKey"] . "%' ";
			$sql .= " 	AND lower(TipeExt) =  lower('$data[1]') ";
			$sql .= "	AND TipeId != '$id'";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Media Arsip Baru Sudah Ditemukan Dengan Nama Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
			
	
			$sql = "update master_file_allowed set ";
			$sql .= "TipeExt = '$data[1]' ";		
			$sql .= "where TipeId = '$id'";
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
	if ($task == "delete"){
		$ids = implode(",", $_REQUEST["ids"]);
		$id = explode(",", $ids);
		
		//die($id[1]);
		try {
			for($a=0; $a<count($id); $a++){
				
				if(checkUsed($id[$a]) == "false"){
					$sql = "delete from master_file_allowed ";
					$sql .= "where TipeId = '$id[$a]' ";
					mysql_query($sql);				
				}
			}			
			echo "<script>alert('Data Berhasil Dihapus ! \n Jika data ternyata belum terhapus, data tsb masih digunakan. !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}	
	}
	
	function checkUsed($ext){
		$valReturn = "false";
		try{
			$query = "select * from inbox_files 
					where FileName_real 
					like concat('%', (select TipeExt from master_file_allowed where TipeId = '" . $ext . "')) ";
			$result = mysql_query($query);
			if (mysql_num_rows($result) > 0){
				$valReturn = "true";	
			}
		}catch (Exception $e) {
			$valReturn = "false";
		}
		return $valReturn;
	}
?>