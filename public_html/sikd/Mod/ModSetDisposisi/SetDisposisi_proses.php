<?php
	if ($task == "new"){
		try {
			$sql = "select * from master_disposisi ";
			$sql .= "WHERE DisposisiId like '" . $_SESSION["AppKey"] . "%' ";
			$sql .= " 	AND lower(DisposisiName) =  lower('$data[1]') AND  gjabatanId = ('$data[2]') ";		
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Disposisi Baru Sudah Ditemukan Dengan Nama Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
				
			$sql = "insert into master_disposisi values( ";
			$sql .= "'" . $_SESSION["AppKey"] . "." . getNumberGeneral('DisposisiId', 'master_disposisi') . "',";
			$sql .= "'$data[1]',";
			$sql .= "'$data[2]')";
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
	if ($task == "edit"){
		try {
			$sql = "select * from master_disposisi ";
			$sql .= "WHERE DisposisiId like '" . $_SESSION["AppKey"] . "%' ";
			$sql .= " 	AND lower(DisposisiName) =  lower('$data[1]') AND  gjabatanId = ('$data[2]') ";
			$sql .= "	AND DisposisiId != '$id'";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Disposisi Baru Sudah Ditemukan Dengan Nama Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
			
	
			$sql = "update master_disposisi set ";
			$sql .= "DisposisiName = '$data[1]', ";		
			$sql .= "gjabatanId = '$data[2]' ";		
			$sql .= "where DisposisiId = '$id'";
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
	if ($task == "delete"){
		
		$ids = implode("','", $_REQUEST["ids"]);
		try {
			$sql = "delete from master_disposisi ";
			$sql .= "where DisposisiId in ('$ids') ";
			$sql .= " AND DisposisiId not in (select Disposisi from inbox_disposisi)";
			mysql_query($sql);		
			echo "<script>alert('Data Berhasil Dihapus ! \n Jika data ternyata belum terhapus, data tsb masih digunakan. !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal Menghapus data !');</script>";
		}	
			
	}
?>