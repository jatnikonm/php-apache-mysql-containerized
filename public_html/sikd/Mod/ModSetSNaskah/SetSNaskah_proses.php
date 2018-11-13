<?php
	if ($task == "new"){
		try {
			$sql = "select * from master_sifat ";
			$sql .= "WHERE SifatId like '" . $_SESSION["AppKey"] . "%' ";
			$sql .= " 	AND lower(SifatName) =  lower('$data[1]') ";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Jenis Naskah Baru Sudah Ditemukan Dengan Nama Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
				
			$sql = "insert into master_sifat values( ";
			$sql .= "'" . $_SESSION["AppKey"] . "." . getNumberGeneral('SifatId','master_sifat') . "',";
			$sql .= "'$data[1]')";
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
	if ($task == "edit"){
		try {
			$sql = "select * from master_sifat ";
			$sql .= "WHERE SifatId like '" . $_SESSION["AppKey"] . "%' ";
			$sql .= " 	AND lower(SifatName) =  lower('$data[1]') ";
			$sql .= "	AND SifatId != '$id'";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Jenis Naskah Baru Sudah Ditemukan Dengan Nama Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
			
	
			$sql = "update master_sifat set ";
			$sql .= "SifatName = '$data[1]' ";		
			$sql .= "where SifatId = '$id'";
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
	if ($task == "delete"){
		$ids = implode("','", $_REQUEST["ids"]);
		try {
			$sql = "delete from master_sifat ";
			$sql .= "where SifatId in ('$ids') ";
			$sql .= " AND SifatId not in (select SifatId from inbox)";
			mysql_query($sql);		
			echo "<script>alert('Data Berhasil Dihapus ! \n Jika data ternyata belum terhapus, data tsb masih digunakan. !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}	
	}
?>