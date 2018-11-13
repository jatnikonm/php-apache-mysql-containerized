<?php
include "../../conf.php";
$task = $_REQUEST['task'];
$NId  = $_REQUEST['NId'];


 if($task == "addFile"){
		if($_FILES["file"]["name"] != ""){
			$NAME = $_FILES["file"]["name"];
			$n=strrchr(trim($NAME,'/\\'),'.');
			if((strpos('\\',$n)!==false) && (strpos('/',$n)!==false)){
				$n='';
			}

			//check if file Extension are allowed
			$sql = "select * from master_file_allowed
					where TipeExt = '$n'";
			$res = mysql_query($sql);
			if(mysql_num_rows($res) == 0){
				echo "<script>alert('Jenis file dari File Elektronik Tidak diizinkan oleh Server !');</script>";
				die("<script>history.go(-1);</script>");
			}
			mysql_free_result($res);

			//detect folder
			$sql = "select NFileDir
					from inbox
					where NId = '$id'";
			$res = mysql_query($sql);
			while($row = mysql_fetch_array($res)){
				$path = 'FilesUploaded/' . $row[0];
			}
			mysql_free_result($res);

			if(!@is_dir($path)){
				mkdir($path, 0777);
				copy('FilesUploaded/index.html', $path . '/index.html');
				copy('FilesUploaded/index.php', $path . '/index.php');
			}
			//---------------------------------
			$idGuid = date('ymdhis');

			$newname = $_SESSION["PeopleID"];
			$newname .= '_' . $idGuid . $n;

			if(($_FILES["file"]["size"] > 10000000)){
				echo "<script>alert('Ukuran File Tidak boleh lebih dari 10MB');</script>";
				die("<script>history.go(-1);</script>");
			}

			if(!UploadFile($path . "/", $newname)){
				die("<script>
						alert('Error Upload File !');
						history.go(-1);
					</script>");
			}
			chmod($path . "/" . $newname, 0777);


			$GIR_Id = clean($_REQUEST["GIR_Id"]);

			//---------------------- insert ----------------------
			$sql = "insert into inbox_files values(
				'" . $_SESSION["AppKey"] . "',
				'" . $GIR_Id . "',
				'" . $id . "',
				'" . $_SESSION["PeopleID"] . "',
				'" . $_SESSION["PrimaryRoleId"] . "',
				'" . $_FILES["file"]["name"] . "',
				'" . $newname . "',";

				if ($_FILES["file"]["name"] == ""){
					$sql .= "'none',";
				}else{
					$sql .= "'available',";
				}

			$sql .= "'" . date('Y-m-d H:i:s') . "', '')";
			//die($sql);
			mysql_query($sql);
			//-----------------------------------------------------

			//die("<script>location.href='frame.php?option=$option&task=edit&filetopen=Mail_Files&NId=$id&GIR_Id=$GIR_Id';</script>");
		}
	}

	if($task == "delFile"){
		$sql = "select f.NFileDir
			from inbox f
			where f.NId = '" . $_REQUEST["id"] . "' ";
		$res = mysql_query($sql);
		while($row = mysql_fetch_array($res)){
			$path = "FilesUploaded/" . $row["NFileDir"] . "/";
		}
		mysql_free_result($res);

		// ------------------ delete file ------------------
		$file = clean($_REQUEST["FName"]);

		if(file_exists($path . $file)){
			unlink($path . $file);
		}

		// ----------------- delete record ------------------
		$sql = "delete from inbox_files
				where NId = '" . clean($_REQUEST["id"]) . "'
					and GIR_Id = '" . clean($_REQUEST["GIR_Id"]) . "'
					and FileName_fake = '" . clean($_REQUEST["FName"]) . "'";

		mysql_query($sql);
		die("<script>location.href='frame.php?option=$option&task=edit&filetopen=Mail_Files&NId=" . clean($_REQUEST["id"]) . "&GIR_Id=" . clean($_REQUEST["GIR_Id"]) . "';</script>");
	}

if($task=="load"){
echo " <thead><tr>
		<th style=\"width:2%;\">No</th>
		<th style=\"width:1%;\">#</th>
		<th style=\"width:96%;\">Nama File</th>
		<th style=\"width:1%;\">#</th>
	  </tr></thead>";
   $sql = "SELECT FileName_real, FileName_fake From inbox_files Where NId = '$NId'";
   $query = mysql_query($sql) or die ("mysql_error");
   echo "<tbody>";
   $no=1;
   while ($fetch = mysql_fetch_array($query)){
     echo "<tr>";
     echo "<td>".$no++."</td>";
     echo "<td>&nbsp;</td>";
     echo "<td>".$fetch[0]."</td>";
     echo "<td><img src='delete.png' width=10% onclick=delete('".$fetch[1]."') /></td>";
     echo "</tr>";
   }
   echo "<tbody>";
  }
?>