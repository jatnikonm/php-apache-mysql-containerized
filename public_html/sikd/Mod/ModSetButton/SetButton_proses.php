<?
	if ($task == "edit"){
		try {
			$sql = "update master_btn set ";
			$sql .= "btn_text = '$data[1]' ";		
			$sql .= "where btn_func = '$id'";
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
?>