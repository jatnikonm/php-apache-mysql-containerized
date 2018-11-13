<?php
	//check Existing user & password
	$sql = "select * from people 
			where PeopleUsername='" . $_SESSION["PeopleUsername"] . "' 
				and PeopleId='" . $_SESSION["PeopleID"] . "'
				and PeoplePassword=MD5('" . $_SESSION["PeopleUsername"] . $data[1] . "')";
	$res = mysql_query($sql);
	if(mysql_num_rows($res) == 0){
		echo "<script>alert('Password anda saat ini salah !');</script>";
		die("<script>history.go(-1);<script>");
	}
	
	$sql = "update people 
			set PeoplePassword=MD5('" . $_SESSION["PeopleUsername"] . $data[2] . "')
			where PeopleUsername='" . $_SESSION["PeopleUsername"] . "' 
				and PeopleId='" . $_SESSION["PeopleID"] . "' 
				and PeoplePassword=MD5('" . $_SESSION["PeopleUsername"] . $data[1] . "')";
	//die($sql);
	mysql_query($sql);
	
	die("  <script>alert('Password berhasil diubah !');
			parent.TINY.box.hide();</script>");
	 
?>