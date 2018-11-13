<?php
	if ($task == "new"){
		try {
			$sql = "select Nomor, Tgl from berita_acara ";
			$sql .= "WHERE  Nomor = '".$data[1]."'";
			$sql .= " AND Tgl = '".$data[2]."'";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Surat Berita Acara Ditemukan Dengan Data Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=pindahberkas&task=list';</script>");
				return false;
			}
            $idGuid = date('ymdhis');
			$filename = $_FILES['files']['name'];
            $file_temp = $_FILES['files']['tmp_name'];
            $path = "FilesUploaded/". str_replace(".","",$_SESSION["PrimaryRoleId"]) ."-baup-". $idGuid;
            $pathfile = $path."/".$filename;
            $priode = $_REQUEST['thn1']."-".$_REQUEST['thn2'];
			$sql = "insert into berita_acara values( ";
			$sql .= "'" . $_SESSION["AppKey"] . "','','$data[3]', ";
			$sql .= "'$data[1]','" . mkdate($data[2]) . "' ";

            if(!empty($filename))
            $sql .= ",'p','$pathfile')";
            else
            $sql .= ",'p','')";

		   mysql_query($sql);

           if(!empty($filename)){
             mkdir($path,0777);
             move_uploaded_file(strip_tags($file_temp), $pathfile);
            }

            $sql = "update permohonanusul set ket = 'OK' where PermohonanId = '$data[3]' ";
            mysql_query($sql);


            $xx = explode('#',$_REQUEST['berkasid']);

            for($i=1;$i<=count($xx)-1;$i++)
            {
             echo $sqr = "update berkas set KetAkhir = 'pindah' where BerkasId = '".$xx[$i]."'";
              mysql_query($sqr);
            }


		die("<script>location.href='index2.php?option=pindahberkas&task=list';</script>");
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}
	}
	
	if ($task == "edit"){
		try {
		    //$priode = $_REQUEST['thn1']."-".$_REQUEST['thn2'];
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
             $sqly = "select uploadsurat from berita_acara where BerkasId = '$id'";
             $pathhapus = mysql_fetch_array(mysql_query($sqly));
             unlink($pathhapus[0]);
            }
			$sql .= "where BerkasId = '$id'";
			mysql_query($sql);

            if(!empty($filename) and ($pathfile <> $_REQUEST['temp_file'])){
              move_uploaded_file(strip_tags($file_temp), $pathfile);
            }

		   die("<script>location.href='index2.php?option=pindahberkas&task=list';</script>");
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}
	}
	
	if ($task == "delete"){
		$id = $_REQUEST["id"];
		try {
		    $sql = "select UploadSurat, PermohonanId from berita_acara where BerkasId = '$id'";
            $path = mysql_fetch_array(mysql_query($sql));
            $usulid = $path[1];

			$sql = "delete from berita_acara ";
			$sql .= "where BerkasId = '$id' ";
			mysql_query($sql);
            unlink($path[0]);
            $folder = explode("/",$path[0]);
            rmdir($folder[0]."/".$folder[1]);

            $sqql = "UPDATE permohonanusul SET ket = '' WHERE PermohonanId = '$usulid'";
            mysql_query($sqql);

			die("<script>location.href='index2.php?option=pindahberkas&task=list';</script>");
		} catch (Exception $e) {
			echo "<script>alert('Gagal Menghapus data !');</script>";
		}
	}


?>