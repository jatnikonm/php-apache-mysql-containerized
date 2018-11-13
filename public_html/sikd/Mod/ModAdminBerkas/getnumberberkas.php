<?php
  include "../../conf.php";

  $klas = $_REQUEST['klas'];

  $sql = "Select Max(BerkasNumber) as MaxNum From berkas Where Klasifikasi = '$klas'";
  $query = mysql_query($sql) or die ("Mysql_Error");
  $fetch = mysql_fetch_array($query);
  if ($fetch['MaxNum']==""){
    echo "1";
  } else {echo $fetch['MaxNum']+1;}
?>