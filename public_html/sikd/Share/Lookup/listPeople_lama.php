<?php

#
# Example PHP server-side script for generating
# responses suitable for use with jquery-tokeninput
#

# Connect to the database
include"../../conf.php";
//mysql_pconnect("localhost", "root", "") or die("Could not connect");
//mysql_select_db("db_sikd_lapan") or die("Could not select database");
# Perform the query
 $cari = mysql_real_escape_string($_GET["q"]);
 $role = mysql_real_escape_string($_GET["role"]);
 
 $query = "SELECT PeopleId as id, concat (PeopleName,' (',PeoplePosition,')') as name from people 
 		WHERE PeopleIsActive='1' 
			and PeopleId!='".$_SESSION["PeopleID"]."' 
			and (PeopleName LIKE '%$cari%' OR PeoplePosition LIKE '%$cari%') ";
 if($role != ''){
 	$query .= " and PrimaryRoleId LIKE '" . $role . "%' ";
 }			
 $query .= "ORDER BY PeopleId DESC LIMIT 10";
$arr = array();
$rs = mysql_query($query);

# Collect the results
while($obj = mysql_fetch_object($rs)) {
    $arr[] = $obj;
}

# JSON-encode the response
$json_response = json_encode($arr);

# Optionally: Wrap the response in a callback function for JSONP cross-domain support
if($_GET["callback"]) {
    $json_response = $_GET["callback"] . "(" . $json_response . ")";
}

# Return the response
echo $json_response;

?>
