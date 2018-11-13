<?php
	require_once("../../conf.php");	
	require_once("../../include/functions.php");
	
	$key = clean($_REQUEST["q"]);
	$cat = clean($_REQUEST["cat"]);
	$dataOut = "";
	
	switch($cat){
		case "people_kepada":
			$sql = "select p.PeopleId as kode, 
						   concat(p.PeopleName, ' (', p.PeoplePosition, ')') as nama,
						   concat(p.PeopleName, ' (', p.PeoplePosition, ')') as dataout
					from people p, role r
					where p.PrimaryRoleId = r.RoleId
						 and (p.PeopleName like '%" . $key . "%'
						or p.PeoplePosition like '%" . $key . "%'
						or r.RoleDesc like '" . $key . "%'
						or r.RoleName like '" . $key . "%')";
			break;
	}
	
	//echo $sql . "<br />";
	$res = mysql_query($sql);
	while ($row = mysql_fetch_array($res)){
		$dataOut .= $row["nama"] . "|" . $row["kode"] . "\n";
	}
	mysql_free_result($res);
	
	echo $dataOut;
?>