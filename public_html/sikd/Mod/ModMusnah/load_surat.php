<?php
session_start();
include "../../conf.php";
include "../../include/fungsi_indotgl.php";
$task = $_REQUEST['task'];

function cek_surat($id_Surat){

}

    if($task=="lists"){
    $ids = $_REQUEST["id"];
        //$sql = "select idmusnah, nomor, tgl From Permohonan_musnah";
        $sql = "SELECT permohonan_musnah.idmusnah, permohonan_musnah.nomor, permohonan_musnah.tgl, berita_acara.PermohonanId
                FROM
                permohonan_musnah
                Left Join berita_acara ON permohonan_musnah.idmusnah = berita_acara.PermohonanId ";
        $query = mysql_query($sql);

        echo "<option>-</option>";
        $kosong = 0;
        while($fetch = mysql_fetch_array($query))
        {
        //    if(empty($fetch[3])){
            echo "<option value='".$fetch[0]."'>".$fetch[3].$fetch[1]."/".tgl_indo($fetch[2])."</option>";
            ++$kosong;
        //    }
        }

        if($kosong==0){
          echo "<script>alert('Tidak ada permohonan usul musnah !!');</script>";
          echo "<script>location.href='index2.php?option=musnah&task=list';</script>";
        }
    }

    if($task=="get"){
     $ids = $_REQUEST["id"];
       $sql = "SELECT permohonan_musnah.nomor, permohonan_musnah.tgl, berita_acara.BeritaId,
                berita_acara.Nomor, berita_acara.Tgl, berita_acara.UploadSurat, berita_acara.PermohonanId
                FROM permohonan_musnah
                Inner Join berita_acara ON berita_acara.PermohonanId = permohonan_musnah.idmusnah
                where berita_acara.BeritaId = '".$ids."' ";
       $query = mysql_query($sql);
       $data = mysql_fetch_array($query);
       for($i=0;$i<count($data);$i++)
       echo "#".$data[$i];

    }
?>
