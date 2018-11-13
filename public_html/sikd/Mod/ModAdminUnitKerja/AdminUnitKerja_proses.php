<?php
	if ($task == "new"){
		try {
			$sql = "select * from role ";
			$sql .= "WHERE RoleKey='" . $_SESSION["AppKey"] . "' ";
			$sql .= "	AND RoleParentId='$data[1]' ";
			$sql .= " 	AND lower(RoleDesc) = lower('$data[4]') ";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Unit Kerja Baru Sudah Ditemukan Dalam Satu Alur Struktural !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}			
			
			
			//Getting Code, Based on Parent Code
			$sql = "select concat('$data[2].', max(RoleId)) from (";
			$sql .= "select CONVERT(substring(RoleId, " . (strlen($data[2]) + 2) . "), SIGNED) as RoleId from role ";
			$sql .= "Where RoleKey='" . $_SESSION["AppKey"]  . "' ";
			$sql .= "  and RoleParentId = '$data[2]') dtd ";
			//echo $sql;
			$result = mysql_query($sql);
			if(mysql_num_rows($result) > 0){
				while($row = mysql_fetch_array($result)){
					$CodeRoleTemp = $row["0"];
				}
			}else{
				$CodeRoleTemp = 0;
			}
			
			$CodeRole = GetRoleId($CodeRoleTemp, $data[2]);
			//die($CodeRoleTemp . ' - ' . $data[2] . ' - ' . $CodeRole);

			$sql = "insert into role (RoleKey, RoleId, RoleParentId, RoleName, RoleDesc, RoleStatus, gjabatanId) values(
						'" . $_SESSION["AppKey"] . "', 
						'" . $CodeRole . "', 
						'$data[2]',
						'$data[3]',
						'$data[4]'";
			if($data[5] == ""){
				$sql .= ",'0'";
			}else{
				$sql .= ",'1'";
			}
			$sql .= ", '$data[6]'";
			$sql .= ")";

			mysql_query($sql);	
			echo("<script>alert('Data Berhasil Disimpan !');</script>");		
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");
		}		
	}
	
	if ($task == "edit"){
		
		$sql = "select * from role ";
		$sql .= "WHERE RoleKey='" . $_SESSION["AppKey"] . "' ";
		$sql .= " 	AND RoleDesc='$data[4]' ";
		$sql .= "	AND RoleParentId != '$data[1]'";
		$sql .= "	AND RoleId != '$id'";
		$result = mysql_query($sql);
		if (mysql_num_rows($result) > 0){
			echo "<script>alert('Data Unit Kerja Sudah Ditemukan Dalam Struktur Yang Sama !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");
			return false;
		}			
		
		try {
			$sql = "update role set ";
			$sql .= "RoleName = '$data[3]',";
			$sql .= "RoleDesc = '$data[4]',";
			$sql .= "gjabatanId = '$data[6]' ";
			if($data[5] == ""){
				$sql .= ",RoleStatus = '0' ";
			}else{
				$sql .= ",RoleStatus = '1' ";
			}
			$sql .= "WHERE RoleKey='" . $_SESSION["AppKey"] . "' ";
			$sql .= "	AND RoleId='$id'";
			mysql_query($sql);
			echo("<script>alert('Data Berhasil Disimpan !');</script>");			
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");
		}		
	}
	
	if ($task == "delete"){
		try {
			
			//check if as Parent
			$sql = "select * from role ";
			$sql .= "WHERE RoleKey='" . $_SESSION["AppKey"] . "' ";
			$sql .= "	AND RoleParentId = '$id' ";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Unit Kerja Tidak Dapat Dihapus Karena Unit Kerja Masih Memiliki Sub Unit Kerja !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}	
			
			//check dari people
			$sql = "select * from people ";
			$sql .= "WHERE PeopleKey='" . $_SESSION["AppKey"] . "' ";
			$sql .= "	AND PrimaryRoleId = '$id' ";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Unit Kerja Tidak Dapat Dihapus Karena Masih Ada User Yang Menginduk pada Unit Kerja ini !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}
			
			//check dari Berkas
			$sql = "select * from berkas ";
			$sql .= "WHERE BerkasKey='" . $_SESSION["AppKey"] . "' ";
			$sql .= "	AND RoleId = '$id' ";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Data Unit Kerja Tidak Dapat Dihapus Karena Masih Ada Berkas pada Unit Kerja ini !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}	
			
			$sql = "delete from role ";
			$sql .= "WHERE RoleKey='" . $_SESSION["AppKey"] . "' ";
			$sql .= "	AND RoleId = '$id' ";
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
	
	function GetRoleId($child, $parent) {
        $valReturn = "";
        $urut = 0;

        try{
            $urut = (str_replace($parent . ".", "", $child)) + 1;
        }catch (Exception $e) {
            $urut = 1;
        }

        $valReturn = $parent . "." . $urut;

        return $valReturn;
    }
	
	
?>