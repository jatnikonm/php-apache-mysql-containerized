<?php
	if ($task == "new"){
		try {
			$sql = "select * from master_gjabatan ";
			$sql .= "WHERE gjabatanId like '" . $_SESSION["AppKey"] . "%' ";
			$sql .= " 	AND lower(gjabatanName) =  lower('$data[1]') ";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Grup Jabatan Baru Sudah Ditemukan Dengan Nama Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
				
			$sql = "insert into master_gjabatan values( ";
			$sql .= "'" . $_SESSION["AppKey"] . "." . getNumberGeneral('gjabatanId', 'master_gjabatan') . "',";
			$sql .= "'$data[1]')";
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
	if ($task == "edit"){
		try {
			$sql = "select * from master_gjabatan ";
			$sql .= "WHERE gjabatanId like '" . $_SESSION["AppKey"] . "%' ";
			$sql .= " 	AND lower(gjabatanName) =  lower('$data[1]') ";
			$sql .= "	AND gjabatanId != '$id'";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Grup Jabatan Baru Sudah Ditemukan Dengan Nama Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
			
	
			$sql = "update master_gjabatan set ";
			$sql .= "gjabatanName = '$data[1]' ";		
			$sql .= "where gjabatanId = '$id'";
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
	if ($task == "delete"){
		
		$ids = implode("','", $_REQUEST["ids"]);
		try {
			$sql = "delete from master_gjabatan ";
			$sql .= "where gjabatanId in ('$ids') ";
			$sql .= " AND gjabatanId not in (select gjabatanId from master_disposisi)";
			mysql_query($sql);		
			echo "<script>alert('Data Berhasil Dihapus ! \n Jika data ternyata belum terhapus, data tsb masih digunakan. !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal Menghapus data !');</script>";
		}	
			
	}
?>