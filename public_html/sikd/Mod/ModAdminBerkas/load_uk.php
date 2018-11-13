<?php
session_start();
include "../../conf.php";
 $task = $_REQUEST['task'];
      if($task=="luk"){
      echo "<option value='".$_SESSION['RoleId']."'>".$_SESSION['NamaJabatan']."</option>";
      $sql = mysql_query("Select RoleId, RoleName From role Where RoleParentId LIKE '".$_SESSION['PrimaryRoleId']."%' ");
      while($fetch = mysql_fetch_array($sql)){
          echo "<option value='".$fetch[0]."'>".$fetch[1]."</option>";
      }
    }

?>