<?php
/*	$sql = "select * from peoplesession 
		where PeopleId = '" . $_SESSION["PeopleID"] . "' 
			and SessionId = '" . $_SESSION["sess_id"] . "' ";
	$result = mysql_query($sql);
	if (mysql_num_rows($result) == 0){
		unsetSession();
		echo "<script>alert('Login anda digunakan oleh orang lain !');</script>";
		die("<script>location.href='index.php'</script>");
	}
*/	
	//check unit Kerja
	$sql = "select RoleStatus, gjabatanId from role 
		where RoleKey = '" . $_SESSION["AppKey"] . "'
				and RoleId = '" . $_SESSION["PrimaryRoleId"] . "' ";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
		if($row[0] == "0"){
			unsetSession();
			die("<script>location.href='index.php';</script>");
		}
	}
	
	$location = "location.href='handle.php?option=AdminRestart&task=restart'";
	$sql = "select tb_key from tb_setting";
	$res = mysql_query($sql);
	if(mysql_num_rows($res) > 0){
		while($row = mysql_fetch_array($res)){
			if($row["tb_key"] === NULL){
				die("<script>" . $location . "</script>");
			}
			
			if($row["tb_key"] == ""){
				die("<script>" . $location . "</script>");
			}
		}
	}else{
		die("<script>" . $location . "</script>");
	}
	
	
	function unsetSession(){
		unset($_SESSION["PeopleID"]);
		unset($_SESSION["GroupId"]);
		unset($_SESSION["GroupName"]);
		unset($_SESSION["UserName"]);
		unset($_SESSION["Name"]);
		unset($_SESSION["NamaJabatan"]);
		unset($_SESSION["PrimaryRoleId"]);
		unset($_SESSION["NamaBagian"]);
		unset($_SESSION["menu"]);
		unset($_SESSION["sess_id"]);
		unset($_SESSION["gjabatanId"]);
		session_destroy();
	}
?>