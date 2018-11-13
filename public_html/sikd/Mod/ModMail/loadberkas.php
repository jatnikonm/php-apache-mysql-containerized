<?php
// PDO connect *********
session_start();

include ("../../conf.php");
$idberkas= $_POST["task"];
$req = $_REQUEST["req"];

$q = strtolower($_GET["q"]);

if($req=="load"){
 $sql = "select BerkasId, concat(BerkasId, ' - ', Klasifikasi,'/',BerkasNumber, ' - ', BerkasName) as BerkasName from berkas
         where BerkasId = '$idberkas'";
 $berkasname = mysql_fetch_array(mysql_query($sql));
 echo $berkasname[1];
}else {
  if(empty($idberkas))
  {
 	$sql = "select BerkasId, concat(BerkasId, ' - ', Klasifikasi,'/',BerkasNumber, ' - ', BerkasName) as BerkasName from berkas
			 where BerkasKey = '" . $_SESSION["AppKey"] . "'
			 and RoleId = '" . $_SESSION["PrimaryRoleId"] . "'
			 and BerkasStatus = 'open'
			 and (BerkasName like '%$q%' OR BerkasNumber LIKE '%$q%')
			 order by CreationDate desc ";
    //echo $sql;
	$result = mysql_query($sql);

	if($result)
	{
		while($row=mysql_fetch_array($result))
		{
			echo $row["BerkasName"]."\n";
		}
	}
  } 
  else{
     $sql = "select BerkasId from berkas 
	 		 where BerkasKey = '" . $_SESSION["AppKey"] . "'
			 and RoleId = '" . $_SESSION["PrimaryRoleId"] . "' 
			 and BerkasNumber = '".$idberkas."' 
			 and (BerkasName like '%$q%' OR BerkasNumber LIKE '%$q%')
			 " ;
			 
     $result=mysql_query($sql);
     $BerkasNum = mysql_fetch_array($result);
     echo $BerkasNum[0];
  }
 }
?>
