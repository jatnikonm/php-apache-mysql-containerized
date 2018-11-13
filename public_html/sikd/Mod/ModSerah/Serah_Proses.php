<?php
	if ($task == "new"){
		try {
			$sql = "select Nomor, Tgl from berita_acara ";
			$sql .= "WHERE  Nomor = '".$data[1]."'";
			$sql .= " AND Tgl = '".$data[2]."'";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Berita Acara Ditemukan Dengan Data Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}
            $idGuid = date('ymdhis');
			$filename = $_FILES['files']['name'];
            $file_temp = $_FILES['files']['tmp_name'];
            $path = "FilesUploaded/". str_replace(".","",$_SESSION["PrimaryRoleId"]) ."-m-". $idGuid;
            $pathfile = $path."/".$filename;
            $priode = $_REQUEST['priode'];
			$sql = "insert into berita_acara values( ";
			$sql .= "'" . $_SESSION["AppKey"] . "','',";
			$sql .= "'".$_REQUEST['NoS1']."', '$data[1]', '" . mkdate($data[2]) . "' ";
            if(!empty($filename))
            $sql .= ",'s','$pathfile')";
            else
            $sql .= ",'s','')";
            //echo $sql;
			mysql_query($sql);

            if(!empty($filename)){
             mkdir($path,0777);
             move_uploaded_file(strip_tags($file_temp), $pathfile);
            }


            //Ubah status berkas dan item arsip
            $berkasId = $_REQUEST['berkasId'];

            $arr_id = explode("#",$berkasId);

            for($f=1;$f<count($arr_id);$f++)
            {
                 //---- musnah berkas status
                 $ddr = "update berkas set KetAkhir = 'serah' where BerkasId ='".$arr_id[$f]."' ";
                 mysql_query($ddr);

                 //---- musnah item status
                 $ddit = 'Select NId From inbox Where BerkasId = "'.$arr_id[$f].'"';
                 $getddit = mysql_query($ddit);

                 while ($fetch = mysql_fetch_array($getddit)){
                   //echo $rr = "update inbox_file set Filename_Real = musnah, Filename_Fake = musnah where Nid = '".$fetch[Nid]."'";
                   $sql_g = "Update inbox_files set Keterangan = 'serah' where inbox_files.NId = '".$fetch[Nid]."'";
                   mysql_query($sql_g);

//                   $sql_q = "SELECT inbox.NFileDir, inbox_files.FileName_fake
//                            FROM inbox
//                            Inner Join inbox_files ON inbox_files.NId = inbox.NId
//                            WHERE inbox.NId =  '".$fetch[Nid]."'";
//                   $query = mysql_query($sql_q);
//                   $cd = mysql_fetch_array($query);
//                     if(file_exists('nama_folder/nama_fle_yang_ingin_di_cek')){
//                       unlink("FilesUploaded/".$cd[0]."/".$cd[1]);
//                       rmdir("FilesUploaded/".$cd[0]);
//                     }
                 }
            }


		  die("<script>location.href='index2.php?option=$option&task=list';</script>");
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}
	}
	
	if ($task == "edit"){
		try {
		    //$priode = $_REQUEST['priode'];
	        $id = $_REQUEST['id'];
            $filename = $_FILES['files']['name'];
            $file_temp = $_FILES['files']['tmp_name'];
            if(!empty($filename)){
            $path = $_REQUEST['temp_file'];
            $path = explode("/",$path);
            $path = $path[0]."/".$path[1];
            $pathfile = $path."/".$filename;
            }

			$sql = "update berita_acara set ";
			$sql .= "Nomor='".$data[1]."',
                     Tgl='" . mkdate($data[2]) . "' ";
            if(!empty($filename)) {
             $sql .= ",UploadSurat='". $pathfile ."' ";
             $sqly = "select UploadSurat from berita_acara where BeritaId = '$id'";
             $pathhapus = mysql_fetch_array(mysql_query($sqly));
             unlink($pathhapus[0]);
            }
			$sql .= "where BeritaId = '$id'";
			mysql_query($sql);

            if(!empty($filename) and ($pathfile <> $_REQUEST['temp_file'])){
              move_uploaded_file(strip_tags($file_temp), $pathfile);
            }


         die("<script>location.href='index2.php?option=$option&task=list';</script>");
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}
	}
	
	if ($task == "delete"){
		$idnomor = $_REQUEST["id"];
		try {
		    $sql = "select UploadSurat from berita_acara where BeritaId = '$idnomor'";
            $path = mysql_fetch_array(mysql_query($sql));
			$sql = "delete from berita_acara ";
			$sql .= "where BeritaId = '$idnomor' ";
			mysql_query($sql);
            unlink($path[0]);
            $folder = explode("/",$path[0]);
            rmdir($folder[0]."/".$folder[1]);

			die("<script>location.href='index2.php?option=$option&task=list';</script>");
		} catch (Exception $e) {
			echo "<script>alert('Gagal Menghapus data !');</script>";
		}
	}

 if ($task == "ok"){
  try {

        $sql = "update permohonanusul set ";
        $sql .= "ket = 'OK'";
        $sql .= " where PermohonanId = '$id'";
        mysql_query($sql);
         die("<script>location.href='index2.php?option=$option&task=list';</script>");
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}

 }

?>