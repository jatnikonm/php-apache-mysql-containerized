<?php
	if ($task == "new"){
		try {
			$sql = "select * from master_bahasa ";
			$sql .= "WHERE LangId like '" . $_SESSION["AppKey"] . "%' ";
			$sql .= " 	AND lower(LangName) =  lower('$data[1]') ";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Bahasa Baru Sudah Ditemukan Dengan Nama Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
				
			$sql = "insert into master_bahasa values( ";
			$sql .= "'" . $_SESSION["AppKey"] . "." . getNumberGeneral('LangId', 'master_bahasa') . "',";
			$sql .= "'$data[1]')";
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
	if ($task == "edit"){
		try {
			$sql = "select * from master_bahasa ";
			$sql .= "WHERE LangId like '" . $_SESSION["AppKey"] . "%' ";
			$sql .= " 	AND lower(LangName) =  lower('$data[1]') ";
			$sql .= "	AND LangId != '$id'";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Bahasa Baru Sudah Ditemukan Dengan Nama Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
			
	
			$sql = "update master_bahasa set ";
			$sql .= "LangName = '$data[1]' ";		
			$sql .= "where LangId = '$id'";
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
	if ($task == "delete"){
		$ids = implode("','", $_REQUEST["ids"]);
		try {
			$sql = "delete from master_bahasa ";
			$sql .= "where LangId in ('$ids') ";
			$sql .= " AND LangId not in (select LangId from inbox)";
			mysql_query($sql);		
			echo "<script>alert('Data Berhasil Dihapus ! \n Jika data ternyata belum terhapus, data tsb masih digunakan. !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal Menghapus data !');</script>";
		}	
	}
?>