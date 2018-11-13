<?php
	if ($task == "new"){
		try {
			$sql = "select * from classification ";
			$sql .= "WHERE ClKey='" . $_SESSION["AppKey"] . "' ";
			$sql .= "	AND ClParentId='$data[5]' ";
			$sql .= " 	AND lower(ClCode) = lower('" . getParentCode($data[5]) . "$data[1]') ";
			//die($sql);
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Klasifikasi Baru Sudah Ditemukan Dengan Kode Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			

	
			$sql = "insert into classification values( 
					'" . $_SESSION["AppKey"] . "', 
					'" . getNumber() . "', 
					'$data[5]',
					'" . getParentCode($data[5]) . "$data[1]',
					'$data[2]', 
					'$data[3]',
					'$data[6]',
					'$data[7]',
                    '$data[10]'";
					if($data[8] == ""){
						$sql .= ",'0','0'";
					}else{
						$sql .= ",'1','1'";
					}
					$sql .= ")";
					//die($sql);
		
			mysql_query($sql);			
			
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");
		}		
	}
	
	if ($task == "edit"){
		
		$sql = "select * from classification ";
		$sql .= "WHERE ClKey='" . $_SESSION["AppKey"] . "' ";
		$sql .= " 	AND ClCode='" . getParentCode($data[4]) . "$data[1]' ";
		$sql .= "	AND ClId != '$id'";
		$result = mysql_query($sql);
		if (mysql_num_rows($result) > 0){
			echo "<script>alert('Data Klasifikasi Baru Sudah Ditemukan Dengan Kode Yang Sama !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");
			return false;
		}		
			
			if($data[8] == ""){
		try {
			//detect if it have children
			$sql = "select * from classification ";
			$sql .= "WHERE ClKey='" . $_SESSION["AppKey"] . "' ";
			$sql .= "	AND ClParentId = '$id' AND CIStatus='1' ";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Klasifikasi Tidak Dapat Diubah Karena Ada Klasifikasi Yang Masih Aktif Yang Menginduk Pada Klasifikasi ini !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
			
			/*//detect if it has been used
			$sql = "select * from berkas ";
			$sql .= "WHERE BerkasKey='" . $_SESSION["AppKey"] . "' ";
			$sql .= "	AND ClId = '$id' ";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Klasifikasi Tidak Dapat Diubah Karena Masih Ada Berkas yang menggunakan Klasifikasi ini !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}	*/
} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}	
			}
		//echo $data[1];
		$sql = "update classification set ";
		
			if($data[1] != ""){
				$sql .= " ClCode = '" . getParentCode($data[4]) . "$data[1]',";
			}
			if($data[8] == ""){
				$sql .= "CIStatus = '0', ";
			}else{
				$sql .= "CIStatus = '1', ";
			}
		$sql .= "   ClName = '$data[2]', 
					ClDesc = '$data[3]',
					RetensiThn_Active = '$data[6]',
					RetensiThn_InActive = '$data[7]',
                    SusutId = '$data[10]'
				WHERE ClKey='" . $_SESSION["AppKey"] . "' 
					AND ClId='$id'";
		//die($sql);
		try {
			mysql_query($sql);			
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
		mysql_query("UPDATE `classification` SET ClStatusParent ='".ceckStatus(getParentCode2($id))."'
where ClCode like '" . getParentCode2($id) . "$data[1]%' and ClCode!='" . getParentCode2($id) . $data[1]."'");
//die;
	}
	
	if ($task == "delete"){
		try {
			//detect if it have children
			$sql = "select * from classification ";
			$sql .= "WHERE ClKey='" . $_SESSION["AppKey"] . "' ";
			$sql .= "	AND ClParentId = '$id' ";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Klasifikasi Tidak Dapat Dihapus Karena Masih Ada Data Yang Menginduk pada Klasifikasi ini !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
			
			//detect if it has been used
			$sql = "select * from berkas ";
			$sql .= "WHERE BerkasKey='" . $_SESSION["AppKey"] . "' ";
			$sql .= "	AND ClId = '$id' ";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Klasifikasi Tidak Dapat Dihapus Karena Masih Ada Berkas yang menggunakan Klasifikasi ini !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
			
			$sql = "delete from classification ";
			$sql .= "WHERE ClKey='" . $_SESSION["AppKey"] . "' ";
			$sql .= "	AND ClId = '$id' ";
			mysql_query($sql);
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
	die("<script>location.href='index2.php?option=$option&task=list';</script>");
	
	function getNumber(){
		$query = "select (max(ClId)+1) as id ";
		$query .= "from classification ";
		$query .= "where ClKey='" . $_SESSION["AppKey"] . "'";
		$result = mysql_query($query);
		if (mysql_num_rows($result) > 0){
			while($row = mysql_fetch_array($result)){
				$id = $row[0];
			}
		}
		return $id;
	}
	
	function getParentCode($ClId){
		$query = "select ClCode as id ";
		$query .= "from classification ";
		$query .= "where ClKey='" . $_SESSION["AppKey"] . "' ";
		$query .= " and ClId = '" . $ClId . "'";
		//echo $query . "<br />";
		$result = mysql_query($query);
		if (mysql_num_rows($result) > 0){
			while($row = mysql_fetch_array($result)){
				$id = $row[0];
			}
		}
		if($id != "SK"){
			$id .= ".";
		}
		
		if($id == "SK"){
			$id="";
		}
		return $id;
	}
	
	function getParentCode2($ClId){
		$query = "select ClCode as id ";
		$query .= "from classification ";
		$query .= "where ClKey='" . $_SESSION["AppKey"] . "' ";
		$query .= " and ClId = '" . $ClId . "'";
		//echo $query . "<br />";
		$result = mysql_query($query);
		if (mysql_num_rows($result) > 0){
			while($row = mysql_fetch_array($result)){
				$id = $row[0];
			}
		}
		
		return $id;
	}
	
	function ceckStatus($ClId){
		$query = "select CIStatus as id ";
		$query .= "from classification ";
		$query .= "where ClKey='" . $_SESSION["AppKey"] . "' ";
		$query .= " and ClCode = '" . $ClId . "'";
		//echo $query . "<br />";
		$result = mysql_query($query);
		if (mysql_num_rows($result) > 0){
			while($row = mysql_fetch_array($result)){
				$id = $row[0];
			}
		}
		
		return $id;
	}
?>