<?php
	if ($task == "login"){
		
		//check for captcha
/*		require_once("include/securimage.php");
		$securimage = new Securimage();
      
	  	$captcha = $data[3];
		
		if ($securimage->check($captcha) == false) {
			echo "<script>alert('Anda Salah Memasukkan Kode !');</script>";
			die("<script>location.href='index.php'</script>");
		}
		
*/		$sql = "select p.PeopleId, p.PeopleUsername,  p.GroupId, g.GroupName, p.PeopleName, p.PeoplePosition, r.RoleId, r.RoleName, r.RoleDesc, r.gjabatanId, p.RoleAtasan, r.RoleParentId ";
		$sql .= "from people p ";
		$sql .= "join role r on r.RoleId = p.PrimaryRoleId ";
		$sql .= "join groups g on g.GroupId = p.GroupId ";
		$sql .= "where PeopleKey='" . $_SESSION["AppKey"] . "' ";
		$sql .= " and PeopleIsActive='1' ";
		$sql .= " and PeopleUsername='" . $data[1] . "' and PeoplePassword=MD5('" . $data[1] . $data[2] . "') ";
		//die($sql);
		$result = mysql_query($sql);
		if (mysql_num_rows($result) > 0){
			while($row = mysql_fetch_array($result)){
				$_SESSION["PeopleID"] = $row["PeopleId"];
				$_SESSION["GroupId"] = $row["GroupId"];
				$_SESSION["GroupName"] = $row["GroupName"];
				$_SESSION["PeopleUsername"] = $row["PeopleUsername"];
				$_SESSION["PName"] = $row["PeopleName"];
				$_SESSION["NamaJabatan"] = $row["PeoplePosition"];
				$_SESSION["PrimaryRoleId"] = $row["RoleId"];
				$_SESSION["NamaBagian"] = $row["RoleDesc"];
				$_SESSION["gjabatanId"] = $row["gjabatanId"];
				$_SESSION["RoleAtasan"] = $row["RoleAtasan"];
				$_SESSION["RoleParentId"] = $row["RoleParentId"];
			}
			$_SESSION["menu"] = "user";
			$_SESSION["sess_id"] = $_SESSION["PeopleID"] . date('YmdHis');
			//on session creation
			$_SESSION['timestamp']=time();

/*			//check if already login
			$sql = "delete from peoplesession 
					where PeopleId = '" . $_SESSION["PeopleID"] . "' 
						and SessionId != '" . $_SESSION["sess_id"] . "' ";
			mysql_query($sql);
			
			$sql = "insert into peoplesession values(";
			$sql .= "'" . $_SESSION["AppKey"] . "', ";
			$sql .= "'" . $_SESSION["PeopleID"] . "', ";
			$sql .= "'" . $_SESSION["sess_id"] . "', ";
			$sql .= "'" . date('Y-m-d H:i:s') . "', ";
			$sql .= "'" . $_SERVER['REMOTE_ADDR'] . "')";
			mysql_query($sql);
*/
			die("<script>location.href='index2.php'</script>");
		}else{
			echo("<script>alert('Login Tidak Ditemukan !');</script>");
			die("<script>location.href='index.php'</script>");
		}
	}elseif ($task == "logout"){
		
		$sql = "delete from peoplesession where PeopleId = '" . $_SESSION["PeopleID"] . "'";
		mysql_query($sql);
		
		$sql = "delete from chat where `to`='" . $_SESSION["PeopleID"] . "' and recd='1' ";
		mysql_query($sql);
		
		unset($_SESSION["PeopleID"]);
		unset($_SESSION["GroupId"]);
		unset($_SESSION["GroupName"]);
		unset($_SESSION["PeopleUsername"]);
		unset($_SESSION["Name"]);
		unset($_SESSION["NamaJabatan"]);
		unset($_SESSION["PrimaryRoleId"]);
		unset($_SESSION["NamaBagian"]);
		unset($_SESSION["menu"]);
		unset($_SESSION["sess_id"]);
		unset($_SESSION["NamaInstansi"]);
		unset($_SESSION["AppKey"]);
		unset($_SESSION["gjabatanId"]);
		unset($_SESSION["RoleAtasan"]);
		unset($_SESSION["RoleParentId"]);
		session_destroy();
		die("<script>location.href='index.php'</script>");
	}else{
		session_destroy();
		die("<script>location.href='index.php'</script>");
	}
?>