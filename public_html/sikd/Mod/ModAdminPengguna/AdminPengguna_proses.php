<?php
	if ($task == "new"){
		try {
			$sql = "select * from people ";
			$sql .= "WHERE PeopleKey = '" . $_SESSION["AppKey"] . "' ";
			$sql .= " 	AND lower(PeopleUsername) =  lower('$data[9]') ";
			$sql .= "	AND PeopleIsActive = '1' ";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				die("<script>
						alert('Username Login Sudah Ditemukan Dengan Nama Yang Sama !');
						window.name = 'MyWindowDetail';
						window.close();
						//window.location='window.php?option=AdminPengguna&task=new&width=700&filetopen=AdminPenggunaDetail';
					</script>");
				return false;
			}			
				
			$sql = "insert into people values( ";
			$sql .= "'" . $_SESSION["AppKey"] . "', ";
			$sql .= "'" . getNumberMain('PeopleKey', 'PeopleId', 'people') . "', ";
			$sql .= "'$data[4]', ";
			$sql .= "'$data[5]', ";
			$sql .= "'$data[9]', ";
			$sql .= "MD5('" . $data[9] .  $data[11] . "'), ";
			$sql .= "'". mkdate($data[6]) . "', ";
			$sql .= "'". mkdate($data[7]) . "', ";
			if($data[8] == ""){
				$sql .= "'0', ";
			}else{
				$sql .= "'1', ";
			}
			$sql .= "'$data[2]', ";
			$sql .= "'$data[3]', ";
			$sql .= "'$data[14]') ";
			
			mysql_query($sql);		
			die("<script>
					parent.respDetails('reload');
				</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
			die("<script>history.go(-1);</script>");
		}		
	}
	
	if ($task == "edit"){
		try {
			$sql = "select * from people ";
			$sql .= "WHERE PeopleKey = '" . $_SESSION["AppKey"] . "' ";
			$sql .= " 	AND lower(PeopleUsername) =  lower('$data[9]') ";
			$sql .= "	AND PeopleIsActive = '1' ";
			$sql .= "	AND PeopleId != '$id'";
			//die($sql);
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				die("<script>
						alert('Username Login Sudah Ditemukan Dengan Nama Yang Sama !');
						window.name = 'MyWindowDetail';
						window.close();
					</script>");
				return false;
			}			
			
			//detect jika Ganti Unit Kerja
			if($data[1] != $data[2]){								
				$sql = "insert into people_history values(";
				$sql .= "'" . $_SESSION["AppKey"] . "', ";
				$sql .= "'" . getNumberMain('HKey', 'HId', 'people_history') . "', ";
				$sql .= "'" . $id . "', ";
				$sql .= "(select RoleName from role where RoleID = '$data[1]'), ";
				$sql .= "'$data[1]', ";
				$sql .= "(select RoleDesc from role where RoleId='$data[1]'), ";
				$sql .= "'" . date('Y-m-d') . "')";
				//$sql .= "'" . date('Y-m-d') . "')";
				//sdie($sql);
				mysql_query($sql);		
			}
			
			$sql = "update people set ";
			$sql .= "PrimaryRoleId = '$data[2]', ";
			if($data[4] != ''){
				$sql .= "PeopleName = '$data[4]', ";
			}
			$sql .= "PeoplePosition = '$data[5]', ";
			$sql .= "RoleAtasan = '$data[14]', ";
			$sql .= "PeopleActiveStartDate = '" . mkdate($data[6]) . "', ";
			$sql .= "PeopleActiveEndDate = '" . mkdate($data[7]) . "', ";
			if($data[8] == ""){
				$sql .= "PeopleIsActive = '0', ";
			}else{
				$sql .= "PeopleIsActive = '1', ";
			}
			$sql .= " GroupId = '$data[3]' ";	
					
			if($data[11] != ""){
				$sql .= ", PeopleUsername = '$data[9]', ";
				$sql .= "PeoplePassword = MD5('" . $data[9] . $data[11] . "') ";
			}

			$sql .= " where PeopleKey='" . $_SESSION["AppKey"] . "' and PeopleId = '$id'";	
			mysql_query($sql);		
			die("<script>
					parent.respDetails('reload');
				</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
			die("<script>history.go(-1);</script>");
		}		
	}
	
	if ($task == "delete"){
		$ids = implode("','", $_REQUEST["ids"]);
		try {
			$sql = "delete from people ";
			$sql .= "where PeopleKey='" . $_SESSION["AppKey"] . "'
					AND PeopleId in ('$ids') 
					AND PeopleId not in (select To_Id from inbox_receiver) 
					AND PeopleId not in (select From_Id from inbox_receiver) ";
			mysql_query($sql);		
			echo "<script>alert('Data Berhasil Dihapus ! \n Jika data ternyata belum terhapus, data tsb masih digunakan. !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}	
	}
	
	if($task == "resetpasswd"){
	
		$Pid = $_REQUEST['Pid'];
		try {
			$sql1 = "select PeopleUsername from people ";
			$sql1 .= "where PeopleKey='" . $_SESSION["AppKey"] . "' and PeopleId = '$Pid'";
			$result = mysql_query($sql1);
			$res = mysql_fetch_array($result);
			
			
			$sql = "update people set PeoplePassword = MD5('" . $res[0] . '123' . "') ";
			$sql .= "where PeopleKey='" . $_SESSION["AppKey"] . "' and PeopleId = '$Pid'";
			mysql_query($sql);
					
			echo "<script>alert('Reset Password Berhasil Dilakukan !, Password Anda Saat ini menjadi : 123 !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}	

	}

?>