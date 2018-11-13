<?php
echo $x=$_POST["datanya"];
$cari=substr_count($x, ",");
//$cari=$cari+1;
for($i=0;$i<=$cari;$i++){
$p=explode(",",$x);
$data[$i]=$p[$i];
echo "<br>".$data[$i];

}

?>