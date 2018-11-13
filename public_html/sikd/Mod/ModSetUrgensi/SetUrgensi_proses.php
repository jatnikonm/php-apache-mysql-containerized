<?php
	if ($task == "new"){
		try {
			$sql = "select * from master_urgensi ";
			$sql .= "WHERE UrgensiId like '" . $_SESSION["AppKey"] . "%' ";
			$sql .= " 	AND lower(UrgensiName) =  lower('$data[1]') ";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Jenis Naskah Baru Sudah Ditemukan Dengan Nama Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
				
			$sql = "insert into master_urgensi values( ";
			$sql .= "'" . $_SESSION["AppKey"] . "." . getNumberGeneral('UrgensiId','master_urgensi') . "',";
			$sql .= "'$data[1]')";
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
	if ($task == "edit"){
		try {
			$sql = "select * from master_urgensi ";
			$sql .= "WHERE UrgensiId like '" . $_SESSION["AppKey"] . "%' ";
			$sql .= " 	AND lower(UrgensiName) =  lower('$data[1]') ";
			$sql .= "	AND UrgensiId != '$id'";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Jenis Naskah Baru Sudah Ditemukan Dengan Nama Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
			
	
			$sql = "update master_urgensi set ";
			$sql .= "UrgensiName = '$data[1]' ";		
			$sql .= "where UrgensiId = '$id'";
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
	if ($task == "delete"){
		$ids = implode("','", $_REQUEST["ids"]);
		try {
			$sql = "delete from master_urgensi ";
			$sql .= "where UrgensiId in ('$ids') ";
			$sql .= " AND UrgensiId not in (select UrgensiId from inbox)";
			mysql_query($sql);		
			echo "<script>alert('Data Berhasil Dihapus ! \n Jika data ternyata belum terhapus, data tsb masih digunakan. !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}	
	}
	
?>