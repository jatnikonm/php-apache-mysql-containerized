<?php
session_start();
include "../../conf.php";

$task = $_REQUEST['task'];

    if($task=="list"){
    $ids = $_REQUEST["id"];
        $sql = "select * From permohonanusul Where PermohonanId = '$ids'";
        $query = mysql_query($sql);
        $fetch = mysql_fetch_array($query);
        for($i=0;$i<=(count($fetch));$i++){
            if (!empty($fetch[$i]))
            echo $fetch[$i]."#";
        }
    } else {
      $sql = "SELECT
        permohonanusul.PermohonanId,
        permohonanusul.NoSurat,
        permohonanusul.TglSurat,
        permohonanusul.Priode,
        permohonanusul.status,
        permohonanusul.UploadSurat,
        permohonanusul.PermohonanKey,
        permohonanusul.ket
        FROM
        permohonanusul where status = 'up' and RoleId = '".$_SESSION["PrimaryRoleId"]."'";

 $query = mysql_query($sql);
 $no=1;
 while($fetch=mysql_fetch_array($query)){
  if(empty($fetch[8]))
  $ket = "Proses";
  else
  $ket = "Ok";
  $tgls=strftime('%d/%m/%Y', strtotime($fetch[2]));
  $output[] = array ('<div align="right" >'.$no.'.</div>',$fetch[1],'<div align="center">'.$tgls.'</div>', '<div align="center">'.$fetch[4].'</div>',
  '<div align="center">'.$ket.'</div>',
  '<div align="center">
  <i class="btn_edit" onclick=setDetails("edit","'.$fetch[0].'") style="cursor:pointer" title="Ubah Data"></i>
  <i class="btn_del" onclick=setDelete("'.$fetch[0].'") style="cursor:pointer" title="Hapus Data"></i>
  </div>');
  $no++;
  }
 echo json_encode($output);
 }
?>
