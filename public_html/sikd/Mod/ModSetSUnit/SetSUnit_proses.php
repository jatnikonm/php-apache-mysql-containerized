<?php
	if ($task == "new"){
		try {
			$sql = "select * from master_satuanunit ";
			$sql .= "WHERE MeasureUnitId like '" . $_SESSION["AppKey"] . "%' ";
			$sql .= " 	AND lower(MeasureUnitName) =  lower('$data[1]') ";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data satuanunit Baru Sudah Ditemukan Dengan Nama Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
				
			$sql = "insert into master_satuanunit values( ";
			$sql .= "'" . $_SESSION["AppKey"] . "." . getNumberGeneral('MeasureUnitId', 'master_satuanunit') . "',";
			$sql .= "'$data[1]')";
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
	if ($task == "edit"){
		try {
			$sql = "select * from master_satuanunit ";
			$sql .= "WHERE MeasureUnitId like '" . $_SESSION["AppKey"] . "%' ";
			$sql .= " 	AND lower(MeasureUnitName) =  lower('$data[1]') ";
			$sql .= "	AND MeasureUnitId != '$id'";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data satuanunit Baru Sudah Ditemukan Dengan Nama Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
			
	
			$sql = "update master_satuanunit set ";
			$sql .= "MeasureUnitName = '$data[1]' ";		
			$sql .= "where MeasureUnitId = '$id'";
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
	if ($task == "delete"){
		$ids = implode("','", $_REQUEST["ids"]);
		try {
			$sql = "delete from master_satuanunit ";
			$sql .= "where MeasureUnitId in ('$ids') ";
			$sql .= " AND MeasureUnitId not in (select MeasureId from inbox)";
			mysql_query($sql);		
			echo "<script>alert('Data Berhasil Dihapus ! \n Jika data ternyata belum terhapus, data tsb masih digunakan. !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal Menghapus data !');</script>";
		}	
	}
	
?>