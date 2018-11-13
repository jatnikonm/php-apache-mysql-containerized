<?php
	if ($task == "new"){
		try {
			$sql = "insert into master_instansi values(  
					null,
					'$data[1]', 
					'$data[2]', 
					'$data[3]', 
					'$data[4]', 
					'" . mkdate($data[5]) . "', 
					'$data[6]', 
					'$data[7]', ";
			if($data[8] == ""){
				$sql .= "'0', ";
			}else{
				$sql .= "'1', ";
			}					
			$sql .=	"'" . $_SESSION["PeopleID"] . "', 
					'" . date("Y-m-d H:i:s") . "')";
			
			echo $_REQUEST["txt8"] . ". ";
			//die($sql);		
			mysql_query($sql);		
			die("<script>location.href='index2.php?option=$option&task=list';</script>");
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}		
	}
	
	if ($task == "delete"){
		$ids = clean($_REQUEST["id"]);
		try {
			$sql = "delete from master_instansi ";
			$sql .= "where id in ('$ids') ";
			mysql_query($sql);		
			echo "<script>alert('Data Berhasil Dihapus !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}	
	}
?>