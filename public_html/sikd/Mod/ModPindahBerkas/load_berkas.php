<?php
session_start();
include "../../conf.php";
$thnA = $_REQUEST['thnA'];
$thnB = $_REQUEST['thnB'];
$id = $_REQUEST['id'];
$task = $_REQUEST['task'];

if($task=='edit'){
  $sql = "SELECT berkasid FROM permohonanusul WHERE PermohonanId = '$id'";
  $idberkas = mysql_fetch_array(mysql_query($sql));
  $idberkas = explode("#",$idberkas[0]);
}

$sql = "SELECT
        berkas.BerkasId,
        berkas.Klasifikasi,
        berkas.BerkasNumber,
        berkas.BerkasName,
        berkas.CreationDate
        FROM
        berkas
        WHERE
        berkas.Klasifikasi <> '0' and berkas.RoleId = '".$_SESSION['PrimaryRoleId']."'";


 $query = mysql_query($sql);
 $no = 1;
 while($fetch = mysql_fetch_array($query)){
  $y1 = mktime($fetch[7]);
  $y = date('Y',$y1);
  $checked = "";
  if($task=="edit"){
   for($i=0;$i<=count($idberkas);$i++){
   if($fetch[0]==$idberkas[$i])
    $checked = "checked=checked";
   }
    $output[] = array ('<div align="right" >'.$no.'.</div>','<div align="center" ><input type="checkbox" name="ch[]" '.$checked.'  value="'.$fetch[0].'">'.$data.'</div>',$fetch[1]."/".$fetch[2], $fetch[3]);
    $no++;
  }else{
    if($thnA<=$y and $thnB>=$y){
    $output[] = array ('<div align="right" >'.$no.'.</div>','<div align="center" ><input type="checkbox" name="ch[]" '.$checked.'  value="'.$fetch[0].'">'.$data.'</div>',$fetch[1]."/".$fetch[2], $fetch[3]);
    $no++;
  }
  }
  }
  echo json_encode($output);

?>