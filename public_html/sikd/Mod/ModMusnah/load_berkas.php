<?php
session_start();
include "../../conf.php";
$task = $_REQUEST['task'];
$Nos = $_REQUEST['nos'];

        $sql = "select berkasid from permohonan_musnah where idmusnah='$Nos'";
        $query = mysql_query($sql);
        $fetch = mysql_fetch_array($query);
        echo $fetch[0];
?>
