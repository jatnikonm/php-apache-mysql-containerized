<?php
	if ($task == "new"){
		try {
			$sql = "select nomor, tgl from permohonan_serah ";
			$sql .= "WHERE  nomor = '".$data[1]."'";
			$sql .= " AND tgl = '".$data[2]."'";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0){
				echo "<script>alert('Surat Permohonan Ditemukan Dengan Data Yang Sama !');</script>";
				die("<script>location.href='index2.php?option=$option&task=list';</script>");
				return false;
			}
            $idGuid = date('ymdhis');
			$filename = $_FILES['files']['name'];
            $file_temp = $_FILES['files']['tmp_name'];
            $path = "FilesUploaded/". str_replace(".","",$_SESSION["PrimaryRoleId"]) ."-um-". $idGuid;
            $pathfile = $path."/".$filename;
			$sql = "insert into permohonan_serah values( ";
			$sql .= "'" . $_SESSION["AppKey"] . "','',";
			$sql .= "'$data[1]', '" . mkdate($data[2]) . "', ";
            $sql .= "'".$_REQUEST['cid']."' ";
            if(!empty($filename))
            $sql .= ",'$pathfile','usul')";
            else
            $sql .= "'','usul')";
            //echo $sql;
			mysql_query($sql);

            if(!empty($filename)){
             mkdir($path,0777);
             move_uploaded_file(strip_tags($file_temp), $pathfile);
            }

        die("<script>location.href='index2.php?option=$option&task=list';</script>");
		} catch (Exception $e) {
			echo "<script>alert('Gagal menyimpan data !');</script>";
		}
	}
	
    	if ($task == "edit"){
		try {
		    $priode = $_REQUEST['thn1']."-".$_REQUEST['thn2'];
	        $id = $_REQUEST['id'];
            $filename = $_FILES['files']['name'];
            $file_temp = $_FILES['files']['tmp_name'];
            if(!empty($filename)){
            $path = $_REQUEST['temp_file'];
            $path = explode("/",$path);
            $path = $path[0]."/".$path[1];
            $pathfile = $path."/".$filename;
            }
			$sql = "update permohonan_serah set ";
			$sql .= "nomor='".$data[1]."',
                     tgl='" . mkdate($data[2]) . "',
                     berkasid='".$_REQUEST['cid']."' ";

            if(!empty($filename))
            $sql .= ",UploadSurat = '". $pathfile ."' ";

			$sql .= "where idserah = '$id'";
            //echo $sql;
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
		echo $id = $_REQUEST["id"];
		try {
		    $sql = "select UploadSurat from permohonan_serah where idserah = '$id'";
            $path = mysql_fetch_array(mysql_query($sql));
			$sql = "delete from permohonan_serah ";
			$sql .= "where idserah = '$id' ";
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