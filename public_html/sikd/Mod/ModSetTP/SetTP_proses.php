<?php
	if ($task == "new"){
		try {
			$sql = "select * from master_tperkembangan ";
			$sql .= "WHERE TPId like '" . $_SESSION["AppKey"] . "%' ";
			$sql .= " 	AND lower(TPName) =  lower('$data[1]') ";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Jenis Naskah Baru Sudah Ditemukan Dengan Nama Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
				
			$sql = "insert into master_tperkembangan values( ";
			$sql .= "'" . $_SESSION["AppKey"] . "." . getNumberGeneral('TPId','master_tperkembangan') . "',";
			$sql .= "'$data[1]')";
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
	if ($task == "edit"){
		try {
			$sql = "select * from master_tperkembangan ";
			$sql .= "WHERE TPId like '" . $_SESSION["AppKey"] . "%' ";
			$sql .= " 	AND lower(TPName) =  lower('$data[1]') ";
			$sql .= "	AND TPId != '$id'";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Jenis Naskah Baru Sudah Ditemukan Dengan Nama Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
			
	
			$sql = "update master_tperkembangan set ";
			$sql .= "TPName = '$data[1]' ";		
			$sql .= "where TPId = '$id'";
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
	if ($task == "delete"){
		$ids = implode("','", $_REQUEST["ids"]);
		try {
			$sql = "delete from master_tperkembangan ";
			$sql .= "where TPId in ('$ids') ";
			$sql .= " AND TPId not in (select TPId from inbox)";
			mysql_query($sql);		
			echo "<script>alert('Data Berhasil Dihapus ! \n Jika data ternyata belum terhapus, data tsb masih digunakan. !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}	
	}
	
?>