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
        $sql = "SELECT permohonan_serah.idserah, permohonan_serah.nomor, permohonan_serah.tgl, berita_acara.PermohonanId
                FROM
                permohonan_serah
                Left Join berita_acara ON permohonan_serah.idserah = berita_acara.PermohonanId ";
        $query = mysql_query($sql);

        echo "<option>-</option>";
        $kosong = 0;
        while($fetch = mysql_fetch_array($query))
        {
            if(empty($fetch[3])){
            echo "<option value='".$fetch[0]."'>".$fetch[3].$fetch[1]."/".tgl_indo($fetch[2])."</option>";
            ++$kosong;
            }
        }

        if($kosong==0){
          echo "<script>alert('Tidak ada permohonan usul serah !!');</script>";
          echo "<script>location.href='index2.php?option=serah&task=list';</script>";
        }
    }

    if($task=="get"){
     $ids = $_REQUEST["id"];
       $sql = "SELECT permohonan_serah.nomor, permohonan_serah.tgl, berita_acara.BeritaId,
                berita_acara.Nomor, berita_acara.Tgl, berita_acara.UploadSurat, berita_acara.PermohonanId
                FROM permohonan_serah
                Inner Join berita_acara ON berita_acara.PermohonanId = permohonan_serah.idserah
                where berita_acara.BeritaId = '".$ids."' ";
       $query = mysql_query($sql);
       $data = mysql_fetch_array($query);
       for($i=0;$i<count($data);$i++)
       echo "#".$data[$i];

    }
?>
