<?php
	
	if($task == "new"){
		for($i=1;$i<=$count;$i++){
			$_SESSION["data_" . $i] = $data[$i];	
		}
		
		$NId = $_SESSION["PeopleID"] . "." . date('dmyhis');
		$idGuid = date('ymdhis');
		$sql = "select * from inbox where NId = '" .$NId . "' ";
		//die($sql);
		$res = mysql_query($sql);
		if(mysql_num_rows($res) > 0){
			echo "<script>alert('Nomor Surat Sudah Digunakan !');</script>";
			die("<script>history.go(-1);</script>");	
		}
		
		//check Nomor Agenda
		if(clean($data[28]) != ""){
			$sql = "select * from inbox where NAgenda = '" . clean($data[28]) . "' 
				and NTipe = '" . clean($data[23]) . "'";
			//die($sql);
			$res = mysql_query($sql);
			if(mysql_num_rows($res) > 0){
				echo "<script>alert('Nomor Agenda Sudah Digunakan !');</script>";
				die("<script>history.go(-1);</script>");	
			}
		}
						
		//check eather it is inbox or outbox
		if($data[23] == "inbox"){
			$path = "FilesUploaded/" . $_SESSION["PeopleID"] . "-in-" . $idGuid ;
		}elseif($data[23] == "inboxuk"){
			$path = "FilesUploaded/" . $_SESSION["PeopleID"] . "-in-tl-" . $idGuid ;
		}elseif($data[23] == "outbox"){
			$path = "FilesUploaded/" . $_SESSION["PeopleID"] . "-out-" . $idGuid ;
		}elseif($data[23] == "outboxmemo"){
			$path = "FilesUploaded/" . $_SESSION["PeopleID"] . "-memo-" . $idGuid ;
		}elseif($data[23] == "outboxnotadinas"){
			$path = "FilesUploaded/" . $_SESSION["PeopleID"] . "-notadinas-" . $idGuid ;
		}elseif($data[23] == "outboxins"){
			$path = "FilesUploaded/" . $_SESSION["PeopleID"] . "-keluar-" . $idGuid ;
		}
		
		if(!is_dir($path)){
			mkdir($path, 0777);
		}
		
		//die("here");
		//    insert into inbox
		//-----------------------------------------------------------------
		$sql = "insert into inbox values(";
		$sql .= "'" . $_SESSION["AppKey"] . "', ";
		$sql .= "'" . $NId . "', ";
		$sql .= "'" . date('Y-m-d H:i:s') . "', ";
		$sql .= "'" . $_SESSION["PeopleID"] . "', ";
		$sql .= "'" . $_SESSION["PrimaryRoleId"] . "', ";
		$sql .= "'" . clean($data[1]) . "', ";
		$sql .= "'" . clean($data[2]) . "', ";
		$sql .= "'" . mkdate($data[3]) . "', ";
		$sql .= "'" . clean($data[4]) . "', ";
		$sql .= "'" . clean($data[5]) . "', ";
		$sql .= "'" . clean($data[6]) . "', ";
		$sql .= "'" . clean($data[7]) . "', ";
		$sql .= "'" . clean($data[8]) . "', ";
		$sql .= "'" . clean($data[9]) . "', ";

		if ($data[23] == "outbox"){
			$sql .= "'internal', ";
			$sql .= "'" . clean($_SESSION["PrimaryRoleId"]) . "', ";
			$sql .= "'" . clean($_SESSION["PeopleID"]) . "', ";
			$sql .= "'" . clean($_SESSION["NamaJabatan"]) . "', ";
		}elseif ($data[23] == "outboxmemo"){
			$sql .= "'internal', ";
			$sql .= "'" . clean($_SESSION["PrimaryRoleId"]) . "', ";
			$sql .= "'" . clean($_SESSION["PeopleID"]) . "', ";
			$sql .= "'" . clean($_SESSION["NamaJabatan"]) . "', ";
		}elseif ($data[23] == "outboxnotadinas"){
			$sql .= "'internal', ";
			$sql .= "'" . clean($_SESSION["PrimaryRoleId"]) . "', ";
			$sql .= "'" . clean($_SESSION["PeopleID"]) . "', ";
			$sql .= "'" . clean($_SESSION["NamaJabatan"]) . "', ";
		}elseif ($data[23] == "outboxins"){
			$sql .= "'internal', ";
			$sql .= "'" . clean($_SESSION["PrimaryRoleId"]) . "', ";
			$sql .= "'" . clean($_SESSION["PeopleID"]) . "', ";
			$sql .= "'" . clean($_SESSION["NamaJabatan"]) . "', ";
		}else{
			$sql .= "'external', ";
			$sql .= "'" . clean($data[10]) . "', ";
			$sql .= "'" . clean($data[11]) . "', ";
			$sql .= "'" . clean($data[12]) . "', ";
		}

		$sql .= "'" . str_replace('FilesUploaded/', '', $path) . "', ";
		
		$sql .= "'" . clean($data[16]) . "', ";
		$sql .= "'" . clean($data[17]) . "', ";
		$sql .= "'" . clean($data[18]) . "', ";
		$sql .= "'" . clean($data[19]) . "', ";
		$sql .= "'" . clean($data[20]) . "', ";
		$sql .= "'" . clean($data[21]) . "', ";
		$sql .= "'" . clean($data[22]) . "', ";
				
		switch( clean($data[23]) ){
			case "outbox":
				if($data[13] == ''){
					$sql .= "'1', ";
				}else{
					$sql .= "'" . clean($data[13]) . "', ";
				}
				$sql .= "'outbox', ";
				break;

			case "outboxmemo":
				if($data[13] == ''){
					$sql .= "'1', ";
				}else{
					$sql .= "'" . clean($data[13]) . "', ";
				}
				$sql .= "'outboxmemo', ";
				break;

			case "outboxnotadinas":
				if($data[13] == ''){
					$sql .= "'1', ";
				}else{
					$sql .= "'" . clean($data[13]) . "', ";
				}
				$sql .= "'outboxnotadinas', ";
				break;

			case "outboxins":
				if($data[13] == ''){
					$sql .= "'1', ";
				}else{
					$sql .= "'" . clean($data[13]) . "', ";
				}
				$sql .= "'outboxins', ";
				break;
				
			case "inbox":
				if($data[13] == ''){
					$sql .= "'1', ";
				}else{
					$sql .= "'" . clean($data[13]) . "', ";
				}
				$sql .= "'inbox', ";
				break;
			
			case "inboxuk":
				if($data[13] == ''){
					$sql .= "'1', ";
				}else{
					$sql .= "'" . clean($data[13]) . "', ";
				}
				$sql .= "'inboxuk', ";
				$_POST["txt_kepada"] = $data[14];
				break;
		}
		
		$sql .= "'" . clean($data[28]) . "',
				'" . clean($data[29]) . "' ";

		$sql .= ") ";
		//die($sql . "<br />");
		mysql_query($sql);
		
		//    insert into inbox_receiver
		//-------------------------------------------------------------------------------------
		$GId = $_SESSION["PeopleID"] . "." . date('dmyhis');
		//die($GId);
		
		//    part 1
		
		if($_POST["txt_kepada"] != ''){
			$kepada = split(',',$_POST["txt_kepada"]);
		
			if(count($kepada) > 0){
				for($i=0;$i<count($kepada);$i++){
					
					if((checkExistingReceiver($kepada[$i], $GId) == "false") && ($kepada[$i] != '')){
						
						$sql = "insert into inbox_receiver values(";
						$sql .= "'" . $_SESSION["AppKey"] . "', ";
						$sql .= "'" . $NId . "', ";
						$sql .= "'" . $GId . "', ";
						if (clean($data[23]) == "outbox") {
							$sql .= "'" . $_SESSION["PeopleID"] . "', ";
							$sql .= "'" . $_SESSION["PrimaryRoleId"] . "', ";
						}else if (clean($data[23]) == "outboxmemo") {
							$sql .= "'" . $_SESSION["PeopleID"] . "', ";
							$sql .= "'" . $_SESSION["PrimaryRoleId"] . "', ";
						}else if (clean($data[23]) == "outboxnotadinas") {
							$sql .= "'" . $_SESSION["PeopleID"] . "', ";
							$sql .= "'" . $_SESSION["PrimaryRoleId"] . "', ";
						}else if (clean($data[23]) == "outboxins") {
							$sql .= "'" . $_SESSION["PeopleID"] . "', ";
							$sql .= "'" . $_SESSION["PrimaryRoleId"] . "', ";
						}else{
							$sql .= "'0', ";
							$sql .= "'', ";
						}
						
						$sql .= "'$kepada[$i]', ";
						$sql .= "(select PrimaryRoleId from people where PeopleID = '$kepada[$i]'), ";

						if ($data[23] == "outboxmemo"){
							$sql .= "'to_memo', 
									'', 
									'unread', "; 
						}elseif ($data[23] == "outboxnotadinas"){
							$sql .= "'to_notadinas', 
									'', 
									'unread', "; 
						}elseif ($data[23] == "outbox"){
							$sql .= "'to_konsep', 
									'', 
									'unread', "; 
						}elseif ($data[23] == "outboxins"){
							$sql .= "'to_keluar', 
									'', 
									'unread', "; 
						}elseif ($data[23] == "inboxuk"){
							$sql .= "'to_tl', 
									'', 
									'read', "; 
						}else{
							$sql .= "'to', 
									'', 
									'unread', "; 
						}

						$sql .= "'" . date('Y-m-d H:i:s') . "', 
								(select PeoplePosition from people where PeopleID = '$kepada[$i]')) ";
						//echo $sql . "<br />";
						mysql_query($sql);
					}
				}
			}
		}	
		//die();
		//    part 2
		if($_POST["txt_CC"] != ''){
			$cc = split(',',$_POST["txt_CC"]);
			if(count($cc) > 0){
				for($i=0;$i<count($cc);$i++){
					if(checkExistingReceiver($cc[$i], $GId) == "false"){
						$sql = "insert into inbox_receiver values(";
						$sql .= "'" . $_SESSION["AppKey"] . "', ";
						$sql .= "'" . $NId . "', ";
						$sql .= "'" . $GId . "', ";
						if (clean($data[23]) == "outbox") {
							$sql .= "'" . $_SESSION["PeopleID"] . "', ";
							$sql .= "'" . $_SESSION["PrimaryRoleId"] . "', ";
						}else if (clean($data[23]) == "outboxmemo") {
							$sql .= "'" . $_SESSION["PeopleID"] . "', ";
							$sql .= "'" . $_SESSION["PrimaryRoleId"] . "', ";
						}else if (clean($data[23]) == "outboxnotadinas") {
							$sql .= "'" . $_SESSION["PeopleID"] . "', ";
							$sql .= "'" . $_SESSION["PrimaryRoleId"] . "', ";
						}else if (clean($data[23]) == "outboxins") {
							$sql .= "'" . $_SESSION["PeopleID"] . "', ";
							$sql .= "'" . $_SESSION["PrimaryRoleId"] . "', ";
						}else{
							$sql .= "'0', ";
							$sql .= "'', ";
						}
						
						$sql .= "'" . clean($cc[$i]) . "', ";
						$sql .= "(select PrimaryRoleId from people where PeopleID = '$cc[$i]'), ";					
						
						$sql .= "'bcc', ";
						$sql .= "'', ";
						$sql .= "'unread', ";
						$sql .= "'" . date('Y-m-d H:i:s') . "', (select PeoplePosition from people where PeopleID = '$cc[$i]')) ";
						//echo $sql . "<br />";
						mysql_query($sql);
					}
				}
			}
		}	
				
		for($i=1;$i<$count;$i++){
			unset($_SESSION["data_" . $i]);	
		}
				
		//	insert inbox_reference
		if($data[27] != ''){
			$sql = "insert into inbox_reference values(
					'" . $_SESSION["AppKey"] . "',
					'" . $NId . "',";
			if($data[27] == 'surat'){
				$sql .= "'" . $data[25] . "',";
			}else{
				$sql .= "'" . $data[26] . "',";
			}
			$sql .= "'reply', 
					 '" . $data[27] . "')";
			//echo $sql . "<br />";
			mysql_query($sql);
		}
				
		$location = "location.href='index2.php?option=Mail&task=step2&id=" . $NId . "&GIR_Id=" . $GId . "';";
		
		for($i=1;$i<=$count;$i++){
			unset($_SESSION["data_" . $i]);	
		}
		//die();
	}
	
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
			
			die("<script>location.href='frame.php?option=$option&task=edit&filetopen=Mail_Files&NId=$id&GIR_Id=$GIR_Id';</script>");			
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

	if($task == "sendoutbox") {
		die("<script>
				alert('Nota Dinas Berhasil dikirim !');
				location.href='index2.php?option=MailOutbox&task=list';
			</script>");			
	}

	if($task == "sendoutboxmemo") {
		die("<script>
				alert('Memo Berhasil dikirim !');
				location.href='index2.php?option=LogMemo&task=list';
			</script>");			
	}

	if($task == "sendoutboxnotadinas") {
		die("<script>
				alert('Surat Berhasil dikirim !');
				location.href='index2.php?option=MailOutboxNotadinas&task=list';
			</script>");			
	}

	if($task == "sendoutboxins") {
		die("<script>
				alert('Surat Keluar Berhasil dikirim !');
				location.href='index2.php?option=LogIns&task=list';
			</script>");			
	}

	if($task == "sendinbox") {
		die("<script>
				alert('Surat Berhasil dikirim !');
				location.href='index2.php?option=LogSuratMasuk&task=list';
			</script>");			
	}
	
	if($task == "sendinboxuk") {
		die("<script>
				alert('Surat Berhasil disimpan !');
				location.href='index2.php?option=MailInboxUk&task=list';
			</script>");			
	}
			
	if($task == "edit"){
		
		//check Nomor Agenda
		if(clean($data[28]) != ""){
			$sql = "select * from inbox 
					where NAgenda = '" . clean($data[28]) . "' 
						and NTipe = (select NTipe from inbox where NId = '$id')
						and NId != '$id'";
			$res = mysql_query($sql);
			if(mysql_num_rows($res) > 0){
				echo "<script>alert('Nomor Agenda Sudah Digunakan !');</script>";
				die("<script>history.go(-1);</script>");	
			}
		}
				
		$sql = "update inbox set 
					JenisId='" . clean($data[1]) . "', TPId='" . clean($data[2]) . "', 
					Tgl='" . mkdate($data[3]) . "', Nomor='" . clean($data[4]) . "', 
					Hal='" . clean($data[5]) . "', UrgensiId='" . clean($data[6]) . "', 
					SifatId='" . clean($data[7]) . "', KatId='" . clean($data[8]) . "', 
					APId='" . clean($data[9]) . "', 
					MediaId='" . clean($data[16]) . "', LangId='" . clean($data[17]) . "', 
					NIsi='" . clean($data[18]) . "', VitId='" . clean($data[19]) . "', 
					NJml='" . clean($data[20]) . "', MeasureId='" . clean($data[21]) . "', 
					NLokasi='" . clean($data[22]) . "', NAgenda='" . clean($data[28]) . "', 
					Tesaurus='" . clean($data[29]) . "'   
				where NKey='" . $_SESSION["AppKey"] . "' 
					and NId='" . $id . "' ";
		//die($sql);
		mysql_query($sql);	
		$msg = "Metadata berhasil disimpan !";
		$location = "parent.respOpenMetadata('ok');";
					
		for($i=1;$i<=$count;$i++){
			unset($_SESSION["data_" . $i]);	
		}
	}	
	
	if($task == "delete"){
		$task2 = $_POST["task2"];
		$ids = implode(",", $_REQUEST["ids"]);
		$ArrId = split(",", $ids);
		echo count($ArrId);
		
		if(count($ArrId) > 0){
			for($i=0;$i<count($ArrId);$i++){
				if(checkTL($ArrId[$i]) == "false"){
					//delete files first
					$sql = "select FileName_fake from inbox_files  
							where FileKey = '" . $_SESSION["AppKey"] . "' 
									and NId = '$ArrId[$i]'";
					$res = mysql_query($sql);
					while($row = mysql_fetch_array($res)){
						$file = 'FilesUploaded/Temp/' . trim($row["FileName_fake"]);
						if(file_exists($file)){
							unlink($file);
						}
					}
					
					$sql = "delete from inbox_files  
							where FileKey = '" . $_SESSION["AppKey"] . "'
								and NId = '$ArrId[$i]'";
					echo $sql . "<br />";
					mysql_query($sql);
					
					$sql = "delete from inbox_receiver  
							where NKey = '" . $_SESSION["AppKey"] . "' 
								and NId = '$ArrId[$i]'";
					echo $sql . "<br />";
					mysql_query($sql);
					
					$sql = "delete from inbox  
							where NKey = '" . $_SESSION["AppKey"] . "' 
								and NId = '$ArrId[$i]'";
					//echo $sql . "<br />";
					mysql_query($sql);					
				}
			}			
		}
		
		$msg = "";
		$location = "location.href='index2.php?option='" . $option . '&task=' . $task2 . ";";
		
		for($i=1;$i<$count;$i++){
			unset($_SESSION["data_" . $i]);	
		}
	}
	
	$response = "<script>";
	if($msg != ''){
		$response .= "alert('$msg');";
	}
	$response .= $location;
	$response .= "</script>";
	
	die($response);
	
	function checkExistingReceiver($To_Id, $GIR_Id){
		$retVal = "false";
		$query = "select * from inbox_receiver 
				where To_Id='$To_Id' and GIR_Id='$GIR_Id' ";
		$res = mysql_query($query);
		if(mysql_num_rows($res) > 0){
			$retVal = "true";
		}
		
		return $retVal;
	}
	
	function checkTL($id){
		$retVal = "false";
		$sql = "select * from inbox_receiver 
				where NId = '$id' 
					and ReceiverAs IN ('to_reply', 'to_usul', 'cc1') ";
		$res = mysql_query($sql);
		if(mysql_num_rows($res) > 0){
			$retVal = "true";
		}
		
		return $retVal;
	}
	
	
?>