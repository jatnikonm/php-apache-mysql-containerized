<?php
session_start();
#
# Example PHP server-side script for generating
# responses suitable for use with jquery-tokeninput
#

# Connect to the database
include"../../conf.php";

# Perform the query
$cari=mysql_real_escape_string($_GET["q"]);
$query = "SELECT PeopleId as id, concat (PeopleName,' (',PeoplePosition,')') as name from people WHERE PeopleIsActive='1' and PrimaryRoleId != '" . $_SESSION["PrimaryRoleId"] . "' and PeopleId != '1' and PeopleId != '" . $_SESSION["PeopleID"] . "' and RoleAtasan != '' and RoleAtasan != '" . $_SESSION["PrimaryRoleId"] . "' and (PeopleName  LIKE '%$cari%' OR PeoplePosition LIKE '%$cari%') ORDER BY PeopleId DESC LIMIT 10";
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
