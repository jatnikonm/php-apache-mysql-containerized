<?php
	if ($task == "new"){
		try {
			$sql = "select * from master_media ";
			$sql .= "WHERE MediaId like '" . $_SESSION["AppKey"] . "%' ";
			$sql .= " 	AND lower(MediaName) =  lower('$data[1]') ";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Media Arsip Baru Sudah Ditemukan Dengan Nama Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
				
			$sql = "insert into master_media values( ";
			$sql .= "'" . $_SESSION["AppKey"] . "." . getNumberGeneral('MediaId', 'master_media') . "',";
			$sql .= "'$data[1]')";
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
	if ($task == "edit"){
		try {
			$sql = "select * from master_media ";
			$sql .= "WHERE MediaId like '" . $_SESSION["AppKey"] . "%' ";
			$sql .= " 	AND lower(MediaName) =  lower('$data[1]') ";
			$sql .= "	AND MediaId != '$id'";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Media Arsip Baru Sudah Ditemukan Dengan Nama Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
			
	
			$sql = "update master_media set ";
			$sql .= "MediaName = '$data[1]' ";		
			$sql .= "where MediaId = '$id'";
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
	if ($task == "delete"){
		$ids = implode("','", $_REQUEST["ids"]);
		try {
			$sql = "delete from master_media ";
			$sql .= "where MediaId in ('$ids') ";
			$sql .= " AND MediaId not in (select MediaId from inbox)";
			mysql_query($sql);		
			echo "<script>alert('Data Berhasil Dihapus ! \n Jika data ternyata belum terhapus, data tsb masih digunakan. !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}	
	}
	
	function getNumber(){
		$query = "select (max(convert(substr(TipeId, 12), UNSIGNED)) + 1) as id ";
		$query .= "from master_media ";
		$query .= "where MediaId like '" . $_SESSION["AppKey"] . "%'";
		$result = mysql_query($query);
		if (mysql_num_rows($result) > 0){
			while($row = mysql_fetch_array($result)){
				$id = $row[0];
			}
		}
		return $id;
	}
?>