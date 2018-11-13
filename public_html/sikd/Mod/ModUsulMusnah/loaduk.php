<?php
include "../../conf.php";

$sql = "Select RoleId, RoleDesc, RoleName From role Where RoleId <> 'uk' and RoleId <> 'root'";
$query = mysql_query($sql);
echo "<option value = 0>- Pilih Unit Kerja -</option>";
While($role = mysql_fetch_array($query)){
  echo "<option value =".$role[0].">".$role[1]."</option>";
}


?>