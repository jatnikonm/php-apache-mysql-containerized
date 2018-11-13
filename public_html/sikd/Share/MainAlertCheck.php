<?php session_start(); 

	$alert = 'none';
	require_once("../conf.php");
	require_once("../include/functions.php");
	$option = ($_REQUEST["option"]);
	
	if($option == "fileDel"){		
		if(($_SESSION["GroupId"] == "1") || ($_SESSION["GroupId"] == "2")){
			$sql = "select * 
					from permohonanusul 
					where status='up' and ket=''";
		}else{
			$sql = "";
		}
		
		if($sql != ""){
			$res = mysql_query($sql);
			if(mysql_num_rows($res) > 0){
				$alert = "block";
			}else{
				$alert = "none";
			}		
			mysql_free_result($res);
		}else{
			$alert = 'none';
		}
		
		echo $alert;
	}
	
	if($option == "mail"){
		//and To_Id_Desc = '" . $_SESSION["NamaJabatan"] . "'
		$sql = "select * 
			from inbox_receiver 
			where StatusReceive='unread' 
				and ( RoleId_To='" . $_SESSION["PrimaryRoleId"] . "' ";
		if($_SESSION["GroupId"] == 4){
			$sql .= " and RoleId_To = '" . $_SESSION["PrimaryRoleId"] . "'";
		}else{
			$sql .= " or RoleId_To = '" . $_SESSION["PrimaryRoleId"] . "'";
		}
		$sql .= ")";
		$res = mysql_query($sql);
		if(mysql_num_rows($res) > 0){
			$alert = "block";
		}else{
			$alert = "none";
		}		
		mysql_free_result($res);
		//echo $sql;
		echo $alert;
	}
	
	if($option == "userOnline"){
		$sql = "select s.PeopleId, p.PeopleName
				from peoplesession s, people p
				where s.PeopleId = p.PeopleId 
					and s.PeopleId != '" . $_SESSION["PeopleID"] . "'";
		$res = mysql_query($sql);
		if(mysql_num_rows($res) > 0){
			while($rw = mysql_fetch_array($res)){
				?>
				<a href="javascript:void(0);" onclick="chatWith('<?php echo $rw["PeopleId"]; ?>', '<?php echo $rw["PeopleName"]; ?>')"><?php echo $rw["PeopleName"]; ?></a><br />
				<?php
			}
		}		
		mysql_free_result($res);
	}
?>