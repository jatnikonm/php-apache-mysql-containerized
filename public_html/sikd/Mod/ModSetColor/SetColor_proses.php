<?
	if ($task == "edit"){
		try {
			$sql = "update master_color set ";
			$sql .= "Color = '$data[1]' ";		
			$sql .= "where CUsed = '$id'";
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
?>