<?php
session_start();

    $task = $_REQUEST["task"];
    if($task=="berkas"){
		$Nid = $_REQUEST["Nid"];
		$Bid = $_REQUEST["Bid"];
		include ("../../conf.php");
		$sql  = "Select BerkasId from Berkas Where BerkasId = '".$Bid."'";
		$sql .= " and BerkasKey='".$_SESSION["AppKey"]."'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$BerkasId = $row["BerkasId"];
		$sql = "update inbox set BerkasId = '" . $BerkasId . "'
					where NKey='" . $_SESSION["AppKey"] . "'
						and NId='$Nid'";
		//echo $sql;
		mysql_query($sql);
	
			//die();
			$option = "MailTL";
			$location .= "location.href='index2.php?option=" . $option . "&task=list&id=" . $Nid . "';";

    }



	if($task == "berkasikan"){
		//check if BerkasId = 1 == pemBerkas-an awal
		//Pindahkan file dari /Temp ke /NFileDir
		$sql = "select NFileDir, BerkasId,
						FileName_fake
				from inbox i, inbox_files ifs
				where i.NId = ifs.NId
					and FileKey	= '" . $_SESSION["AppKey"] . "'
					and	NKey = '" . $_SESSION["AppKey"] . "'
					and i.NId = '$id'
					and i.BerkasId = '1'";
		//echo $sql;
		$res = mysql_query($sql);
		if(mysql_num_rows($res) > 0){
			while($row = mysql_fetch_array($res)){
				$newPath = 'FilesUploaded/' . $row["NFileDir"];
				$filename = $row["FileName_fake"];
			}
		}
		mysql_free_result($res);

		//die($newPath . '/' . $filename);
		if($newPath != ''){
			if(!@is_dir($newPath)){
				if(!@mkdir($newPath)){
					$location = "alert('Gagal Melakukan Pemberkasan !  Pastikan Folder FilesUploaded dapat diakses !');";
				}

				if($filename != ""){
					if(file_exists('FilesUploaded/Temp/' . $filename)){
						rename('FilesUploaded/Temp/' .$filename, $newPath . '/' . $filename);
						chmod($newPath . '/' . $filename, 0777);
					}
				}
			}
		}

		$sql = "update inbox set BerkasId = '" . $data[1] . "'
				where NKey='" . $_SESSION["AppKey"] . "'
					and NId='$id'";
		mysql_query($sql);

		//die();
		$location .= "location.href='index2.php?option=" . $option . "&task=detail&id=" . $id . "';";
	}

	//---------------------------------------------------------------------------------------------------------------------------------------
	//										 				Disposisi
	//----------------------------------------------------------------------------------------------------------------------------------------
	if($task == 'newdisposisi'){

		$NId = $_POST["NId"];
		$GId = $_SESSION["PeopleID"] . "." . date('dmyhis');

		switch($task){
			case "newforward":
				$receieverAs = 'to_forward';
				$msg = "Teruskan";
				break;
			case "newdisposisi":
				$receieverAs = 'cc1';
				$msg = "Disposisi";
				break;
			case "newreply":
				$receieverAs = 'to_reply';
				$msg = "Balasan";
				break;
			case "newusul":
				$receieverAs = 'to_usul';
				$msg = "Usulan";
				break;						
		}
		
		$_SESSION["to"] = $_POST["txt_kepada"];
		$_SESSION["cc"] = $_POST["txt_CC"];
		$_SESSION["msg"] = $_POST["txt4"];
		$dateCreated = date('Y-m-d H:i:s');

		//part 1 to
		if($_POST["txt_kepada"] != ''){
			$kepada = $_POST["txt_kepada"];
			if(count($kepada) > 0){
				for($i=0;$i<count($kepada);$i++){
					//if(checkExistingReceiver($NId, $kepada[$i], $GId) == "false"){
						//$sql = "insert into inbox_receiver (NKey, NId, GIR_Id, From_Id, RoleId_From, To_Id, RoleId_To, ReceieverAs, Msg, Status_Receive, ReceiveDate, To_Id_Desc) values(";
						$sql = "insert into inbox_receiver values(";
						$sql .= "'" . $_SESSION["AppKey"] . "', ";
						$sql .= "'" . $NId . "', ";
						$sql .= "'" . $GId . "', ";						
						$sql .= "'" . $_SESSION["PeopleID"] . "', ";
						$sql .= "'" . $_SESSION["RoleAtasan"] . "', ";
						$sql .= "'" . $kepada[$i] . "', ";
						$sql .= "(select PrimaryRoleId from people where PeopleID = '$kepada[$i]'), ";
						$sql .= "'$receieverAs', ";
						$sql .= "'$data[3]', ";
						$sql .= "'unread', ";
						$sql .= "'" . $dateCreated . "', 
								(select RoleName from role where RoleId=(select PrimaryRoleId from people where PeopleID = '$kepada[$i]'))) ";
						mysql_query($sql);
						//echo $sql;
					//}
				}
			}
		}
		
		//part 3 kepada2
		if($_POST["txt_kepada2"] != ''){
			$to2 = split(',',$_POST["txt_kepada2"]);
			if(count($to2) > 0){
				for($i=0;$i<count($to2);$i++){
					if(checkExistingReceiver($NId, $to2[$i], $GId) == "false"){
						$sql = "insert into inbox_receiver values(";
						$sql .= "'" . $_SESSION["AppKey"] . "', ";
						$sql .= "'" . $NId . "', ";
						$sql .= "'" . $GId . "', ";						
						$sql .= "'" . $_SESSION["PeopleID"] . "', ";
						$sql .= "'" . $_SESSION["RoleAtasan"] . "', ";
						$sql .= "'" . clean($to2[$i]) . "', ";
						$sql .= "(select PrimaryRoleId from people where PeopleID = '$to2[$i]'), ";
						$sql .= "'cc1', ";
						$sql .= "'$data[3]', ";
						$sql .= "'unread', ";
						$sql .= "'" . $dateCreated . "', 
								(select RoleName from role where RoleId=(select PrimaryRoleId from people where PeopleID = '$to2[$i]')) ) ";
						mysql_query($sql);
					}
				}
			}
		}
		 		
		//part 2 CC
		if($_POST["txt_CC"] != ''){
			$cc = split(',',$_POST["txt_CC"]);
			if(count($cc) > 0){
				for($i=0;$i<count($cc);$i++){
					if(checkExistingReceiver($NId, $cc[$i], $GId) == "false"){
						$sql = "insert into inbox_receiver values(";
						$sql .= "'" . $_SESSION["AppKey"] . "', ";
						$sql .= "'" . $NId . "', ";
						$sql .= "'" . $GId . "', ";						
						$sql .= "'" . $_SESSION["PeopleID"] . "', ";
						$sql .= "'" . $_SESSION["RoleAtasan"] . "', ";
						$sql .= "'" . clean($cc[$i]) . "', ";
						$sql .= "(select PrimaryRoleId from people where PeopleID = '$cc[$i]'), ";
						$sql .= "'bcc', ";
						$sql .= "'$data[3]', ";
						$sql .= "'unread', ";
						$sql .= "'" . $dateCreated . "', 
								(select RoleName from role where RoleId=(select PrimaryRoleId from people where PeopleID = '$cc[$i]')) ) ";
						mysql_query($sql);
					}
				}
			}
		}

		
		// insert inbox_disposisi
		$jumDisposisi=$_POST["jumDisposisi"];
		$x = 0;
		$insertArg='-';		
		while($x<$jumDisposisi){
			$x++;
			$txt_cekDis = $_POST["txt_cekDis_$x"];
		
			if(!empty($txt_cekDis)){
				$insertArg .= "|" . $txt_cekDis;
			}
		}
		$insertArg = str_replace('-|','',$insertArg);
		
		$sql = "insert into inbox_disposisi values(";
		$sql .= "'" . $NId . "', ";
		$sql .= "'" . $GId . "', ";						
		$sql .= "'$data[4]', ";
		$sql .= "'$data[5]', ";
		$sql .= "'$insertArg') ";	
		mysql_query($sql);
	
		if($task == 'newdisposisi'){
			$location = "location.href='window.php?option=MailTL&filetopen=MailTLRD&width=615&task=step2&modeRD=" . $task . "&NId=" . $NId . "&GIR_Id=" . $GId . "';";
		}else{
			$location = "alert('" . $msg . " Berhasil Dikirim !');
						parent.doneWindow();";
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------------
	//										 				Reply, Usul 
	//----------------------------------------------------------------------------------------------------------------------------------------
	if(($task == 'newforward') || 
		($task == 'newreply') || 
		($task == 'newusul') ){
		
		$NId = $_POST["NId"];
		$GId = $_SESSION["PeopleID"] . "." . date('dmyhis');
		
		switch($task){
			case "newforward":
				$receieverAs = 'to_forward';
				$msg = "Teruskan";
				break;
			case "newdisposisi":
				$receieverAs = 'cc1';
				$msg = "Disposisi";
				break;
			case "newreply":
				$receieverAs = 'to_reply';
				$msg = "Balasan";
				break;
			case "newusul":
				$receieverAs = 'to_usul';
				$msg = "Usulan";
				break;						
		}
		
		$_SESSION["to"] = $_POST["txt_kepada"];
		$_SESSION["cc"] = $_POST["txt_CC"];
		$_SESSION["msg"] = $_POST["txt4"];
		$dateCreated = date('Y-m-d H:i:s');
				
		//part 1 to
		if($_POST["txt_kepada"] != ''){
			$kepada = split(',',$_POST["txt_kepada"]);
		
			if(count($kepada) > 0){
				for($i=0;$i<count($kepada);$i++){
					if(checkExistingReceiver($NId, $kepada[$i], $GId) == "false"){
						$sql = "insert into inbox_receiver values(";
						$sql .= "'" . $_SESSION["AppKey"] . "', ";
						$sql .= "'" . $NId . "', ";
						$sql .= "'" . $GId . "', ";						
						$sql .= "'" . $_SESSION["PeopleID"] . "', ";
						$sql .= "'" . $_SESSION["RoleAtasan"] . "', ";
						$sql .= "'" . clean($kepada[$i]) . "', ";
						$sql .= "(select PrimaryRoleId from people where PeopleID = '$kepada[$i]'), ";
						$sql .= "'$receieverAs', ";
						$sql .= "'$data[3]', ";
						$sql .= "'unread', ";
						$sql .= "'" . $dateCreated . "', 
								(select RoleName from role where RoleId=(select PrimaryRoleId from people where PeopleID = '$kepada[$i]'))) ";
						mysql_query($sql);
						//echo $sql;
					}
				}
			}
		}	
		
		//part 2 CC
		if($_POST["txt_CC"] != ''){
			$cc = split(',',$_POST["txt_CC"]);
			if(count($cc) > 0){
				for($i=0;$i<count($cc);$i++){
					if(checkExistingReceiver($NId, $cc[$i], $GId) == "false"){
						$sql = "insert into inbox_receiver values(";
						$sql .= "'" . $_SESSION["AppKey"] . "', ";
						$sql .= "'" . $NId . "', ";
						$sql .= "'" . $GId . "', ";						
						$sql .= "'" . $_SESSION["PeopleID"] . "', ";
						$sql .= "'" . $_SESSION["RoleAtasan"] . "', ";
						$sql .= "'" . clean($cc[$i]) . "', ";
						$sql .= "(select PrimaryRoleId from people where PeopleID = '$cc[$i]'), ";
						$sql .= "'bcc', ";
						$sql .= "'$data[3]', ";
						$sql .= "'unread', ";
						$sql .= "'" . $dateCreated . "', 
								(select RoleName from role where RoleId=(select PrimaryRoleId from people where PeopleID = '$cc[$i]')) ) ";
						mysql_query($sql);
					}
				}
			}
		}
		
		// insert inbox_disposisi
		$jumDisposisi=$_POST["jumDisposisi"];
		$x = 0;
		$insertArg='-';		
		while($x<$jumDisposisi){
			$x++;
			$txt_cekDis = $_POST["txt_cekDis_$x"];
		
			if(!empty($txt_cekDis)){
				$insertArg .= "|" . $txt_cekDis;
			}
		}
		$insertArg = str_replace('-|','',$insertArg);
		
		$sql = "insert into inbox_disposisi values(";
		$sql .= "'" . $NId . "', ";
		$sql .= "'" . $GId . "', ";						
		$sql .= "'$data[4]', ";
		$sql .= "'$data[5]', ";
		$sql .= "'$insertArg') ";	
		mysql_query($sql);
	
		if( ($task == 'newreply') || ($task == 'newusul' ) || ($task == 'newforward' ) ){
			$location = "location.href='window.php?option=MailTL&filetopen=MailTLRD&width=615&task=step2&modeRD=" . $task . "&NId=" . $NId . "&GIR_Id=" . $GId . "';";
		}else{
			$location = "alert('" . $msg . " Berhasil Dikirim !');
						parent.doneWindow();";
		}
	}
	
	//--------------------------------------------------------------------------------------------------------
	//			Finale
	//--------------------------------------------------------------------------------------------------------
	if(($task == "newfinal")||($task == "editfinal")){		
		$GId = clean($_REQUEST["GId"]); 
		$NId = clean($_REQUEST["NId"]);
		if(checkExistingFinal($NId) == "false"){
			$sql = "insert into inbox_receiver value (";
			$sql .= "'" . $_SESSION["AppKey"] . "', ";
			$sql .= "'" . $NId . "', ";
			$sql .= "'" . $GId . "', ";						
			$sql .= "'" . $_SESSION["PeopleID"] . "', ";
			$sql .= "'" . $_SESSION["RoleAtasan"] . "', ";
			$sql .= "'all', ";
			$sql .= "'-', ";
			$sql .= "'final', ";
			$sql .= "'$data[4]', ";
			$sql .= "'unread', ";
			$sql .= "'" . date('Y-m-d H:i:s') . "', 'all' ) ";
			
		}else{
			$sql = "update inbox_receiver set Msg = '$data[4]' 
					where NId = '" . $NId . "'
						and ReceiverAs = 'final' ";
		}
		//echo $sql;
		mysql_query($sql);
		$location = "alert('Dokumen Final Berhasil Dikirim !');
					parent.doneWindow();";
	}
		
	
	//--------------------------------------------------------------------------------------------------------
	//													Edit 
	//--------------------------------------------------------------------------------------------------------
	if(($task == 'editdisposisi')||
		($task == 'editforward')||
		($task == 'editreply')){
		
		switch($task){
			case "editdisposisi":
				$receieverAs = 'cc1';
				$msg = "Disposisi";
				break;
			case "editforward":
				$receieverAs = 'to_forward';
				$msg = "Teruskan";
				break;				
			case "editreply":
				$receieverAs = 'to_reply';
				$msg = "Balasan";
				break;				
		}
		
		$NId = $_POST["NId"];
		$GId = $_POST['GIR_Id'];
		$dateCreated = date('Y-m-d H:i:s');
		
		//check Existing
		$sql = "select 
					(SELECT (GROUP_CONCAT(irr.To_Id SEPARATOR ',')) 
						FROM inbox_receiver irr 
						WHERE irr.GIR_Id = ir.GIR_Id 
							AND irr.ReceiverAs = 'cc1' 
						GROUP BY irr.GIR_Id ) as kepada
				from inbox_receiver ir 
				where ir.NKey='" . $_SESSION["AppKey"] . "'
					and ir.GIR_Id = '" . $GId . "'
					and ir.NId='" . $NId . "'
				group by ir.GIR_Id";
		$res = mysql_query($sql);
		while($row = mysql_fetch_array($res)){
			$exist_kepada = $row["kepada"];
		}
		
		//delete all existing kepada
		$kepada = split(',',$exist_kepada);
		if(count($kepada) > 0){
			for($i=0;$i<count($kepada);$i++){
				if(checkExistingReceiverContinue($NId, $kepada[$i], $GId) == "false"){
					$sql = "delete from inbox_receiver 
							where NKey = '" . $_SESSION["AppKey"] . "' 
								and	NId = '" . $NId . "'
								and GIR_Id = '" . $GId . "'	
								and To_Id = '" . $kepada[$i] . "' 
								and ReceiverAs='$receieverAs'";
					mysql_query($sql);
				}
			}
		}
		
		//part 1 to
		if($_POST["txt_kepada"] != ''){
			$kepada = split(',',$_POST["txt_kepada"]);
		
			if(count($kepada) > 0){
				for($i=0;$i<count($kepada);$i++){
					if(checkExistingReceiver($NId, $kepada[$i], $GId) == "false"){
						$sql = "insert into inbox_receiver values(";
						$sql .= "'" . $_SESSION["AppKey"] . "', ";
						$sql .= "'" . $NId . "', ";
						$sql .= "'" . $GId . "', ";						
						$sql .= "'" . $_SESSION["PeopleID"] . "', ";
						$sql .= "'" . $_SESSION["RoleAtasan"] . "', ";
						$sql .= "'" . clean($kepada[$i]) . "', ";
						$sql .= "(select PrimaryRoleId from people where PeopleID = '$kepada[$i]'), ";
						$sql .= "'$receieverAs', ";
						$sql .= "'$data[3]', ";
						$sql .= "'unread', ";
						$sql .= "'" . $dateCreated . "', 
								(select RoleName from role where RoleId=(select PrimaryRoleId from people where PeopleID = '$kepada[$i]'))) ";
						mysql_query($sql);
						//echo $sql;
					}
				}
			}
		}	
		
		//delete all existing CC
		$sql = "delete from inbox_receiver 
				where NKey = '" . $_SESSION["AppKey"] . "' 
					and	NId = '" . $NId . "'
					and GIR_Id = '" . $GId . "'	
					and ReceiverAs = 'bcc'";
		mysql_query($sql);
				
		//part 2 CC
		if($_POST["txt_CC"] != ''){
			$cc = split(',',$_POST["txt_CC"]);
			if(count($cc) > 0){
				for($i=0;$i<count($cc);$i++){
					if(checkExistingReceiver($NId, $cc[$i], $GId) == "false"){
						$sql = "insert into inbox_receiver values(";
						$sql .= "'" . $_SESSION["AppKey"] . "', ";
						$sql .= "'" . $NId . "', ";
						$sql .= "'" . $GId . "', ";						
						$sql .= "'" . $_SESSION["PeopleID"] . "', ";
						$sql .= "'" . $_SESSION["RoleAtasan"] . "', ";
						$sql .= "'" . clean($cc[$i]) . "', ";
						$sql .= "(select PrimaryRoleId from people where PeopleID = '$cc[$i]'), ";
						$sql .= "'bcc', ";
						$sql .= "'$data[3]', ";
						$sql .= "'unread', ";
						$sql .= "'" . $dateCreated . "', 
								(select RoleName from role where RoleId=(select PrimaryRoleId from people where PeopleID = '$cc[$i]')) ) ";
						mysql_query($sql);
					}
				}
			}
		}
		
		//update msg
		$sql = "update inbox_receiver 
				set Msg='$data[4]'
				where NKey = '" . $_SESSION["AppKey"] . "' 
					and	NId = '" . $NId . "'
					and GIR_Id = '" . $GId . "'	";
		mysql_query($sql);
		
		//inbox_files
		if($task == 'editreply'){
			$sql = "update inbox_files set FileStatus=";
			if($data[3] == "1"){
					$sql .= "'available' ";
			}else{
					$sql .= "'private' ";
			}
			$sql .= " where FileKey = '" . $_SESSION["AppKey"] . "' 
					and	NId = '" . $NId . "'
					and GIR_Id = '" . $GId . "'	";
			mysql_query($sql);
		}
		
		if(($task == 'editusul') || ($task == 'editforward') ||
			($task == 'editreply')){
			$location = "location.href='window.php?option=MailTL&filetopen=MailTLRD&width=675&task=step2&modeRD=reply&NId=" . $NId . "&GIR_Id=" . $GId . "';";
		}else{
			$location = "alert('" . $msg . " Berhasil Dikirim !');
						parent.doneWindow();";
		}
	}
	//--------------------------------------------------------------------------------------------------------
		
	if(($task == "addFile") || ($task == "finalFile")){
		$GId = clean($_REQUEST["GId"]); 
		$NId = clean($_REQUEST["NId"]);
		//echo $data[3] . $task . " --<br />";
		if($_FILES["file"]["name"] != ""){
		
			if(($_FILES["file"]["size"] > 10000000)){
				echo "<script>alert('Ukuran File Tidak boleh lebih dari 10MB');</script>";
				die("<script>history.go(-1);</script>");
			}
		
			//check if file Extension are allowed
			$NAME = $_FILES["file"]["name"];
			$n=strrchr(trim($NAME,'/\\'),'.'); 
			if((strpos('\\',$n)!==false) && (strpos('/',$n)!==false)){
				$n='';
			}
							
			$sql = "select * from master_file_allowed 
					where TipeExt = '$n'";
			$res = mysql_query($sql);
			if(mysql_num_rows($res) == 0){
				echo "<script>alert('Jenis file dari File Elektronik Tidak diizinkan oleh Server !');</script>";
				die("<script>history.go(-1);</script>");
			}
			
			//get Working Directories
			$sql = "select NFileDir from inbox i
					WHERE NKey	= '" . $_SESSION["AppKey"] . "' 
						and i.NId = '" . $NId . "' ";
			$res = mysql_query($sql);
			while($row = mysql_fetch_array($res)){
				$WorkingDir = $row["NFileDir"];
			}
			//die($WorkingDir);
			
			$path = "FilesUploaded/" . $WorkingDir . "/";
			if(!is_dir($path)){
				mkdir($path);
			}
			
			$newname = $_SESSION["PeopleID"] . '_' . date('ymdhis') . $n;
			if(!UploadFile($path, $newname)){
				echo "<script>alert('Error Uploading Files !');</script>";
				die("<script>history.go(-1);</script>");
			}		
			//die($path);
			$sql = "insert into inbox_files values(
					'" . $_SESSION["AppKey"] . "',
					'" . $GId . "',
					'" . $NId . "',
					'" . $_SESSION["PeopleID"] . "',
					'" . $_SESSION["RoleAtasan"] . "',
					'" . $_FILES["file"]["name"] . "',
					'" . $newname . "',";
			if($data[3] == "1"){
					$sql .= "'available', ";
			}else{
					$sql .= "'private', ";
			}
			$sql .= "'" . date('Y-m-d H:i:s') . "',	'')";
			//die($data[3] . "<br />" . $sql);
			mysql_query($sql);					
			
			if($task == "finalFile"){
				if(checkExistingFinal($NId) == "false"){
					$sql = "insert into inbox_receiver value (";
					$sql .= "'" . $_SESSION["AppKey"] . "', ";
					$sql .= "'" . $NId . "', ";
					$sql .= "'" . $GId . "', ";						
					$sql .= "'" . $_SESSION["PeopleID"] . "', ";
					$sql .= "'" . $_SESSION["RoleAtasan"] . "', ";
					$sql .= "'all', ";
					$sql .= "'-', ";
					$sql .= "'final', ";
					$sql .= "'$data[4]', ";
					$sql .= "'unread', ";
					$sql .= "'" . date('Y-m-d H:i:s') . "', 'all')) ";
				}else{
					$sql = "update inbox_receiver set Msg = '$data[4]' 
							where NId = '" . $NId . "'
								and ReceiverAs = 'final' ";
				}
				mysql_query($sql);
			}
		}
		die("<script>location.href='frame.php?option=Mail&task=edit&filetopen=Mail_Files&NId=$NId&GIR_Id=$GId';</script>");
	}
		
	
	if($task == "deleteTL"){
		$GIR_Id = $_REQUEST['GIR_Id'];
		$NId = $_REQUEST['NId'];
		
/*		$query = "select * from inbox_receiver 
				where NKey='" . $_SESSION["AppKey"] .  "'
					and NId = '$NId'
					and From_Id = '" . $_SESSION["PeopleID"] . "' 
					and RoleId_From = '" . $_SESSION["PrimaryRoleId"] . "'
					and GIR_Id = '$GIR_Id' ";
		$res = mysql_query($query);
		if(mysql_num_rows($res) > 0){
			echo "<script>alert('Sistem tidak dapat membatalkan tindaklanjut surat ini. \n Karena surat tersebut sudah ditindaklanjuti !');</script>";
			die("<script>history.go(-1);</script>");
		}
*/
		//------------- delete if on FilesUploaded ------------------
		$sql = "select i.NFileDir, ifs.FileName_fake 
				from inbox i, inbox_files ifs 
				where i.NId = ifs.NId 
					and i.NKey = ifs.FileKey 
					and i.NId = ifs.NId 
					and i.NKey='" . $_SESSION["AppKey"] . "' 
					and ifs.GIR_Id= '$GIR_Id'";
					
		$res = mysql_query($sql);
		
		while($row = mysql_fetch_array($res)){
			$WorkingDir = $row["NFileDir"];
			$filename = $row["FileName_fake"];

			if($filename != ""){
				$path = "FilesUploaded/" . $WorkingDir . "/";
				if(file_exists($path . $filename)){
					unlink($path . $filename);
				}
			}
		}
		
		//----------------------------------------------------------------

		$sql = "delete from inbox_files 
				where NId = '$NId' 
				and GIR_Id = '$GIR_Id'";
		mysql_query($sql);
		
		$sql = "delete from inbox_receiver  
				where NId = '$NId' 
				and GIR_Id = '$GIR_Id'";
		mysql_query($sql);
		
		
		//delete inbox_disposisi
		$query = "delete from inbox_disposisi 
				 	where NId = '$NId' 
					and GIR_Id = '$GIR_Id' ";
		mysql_query($query);
				
		$msg = "Pembatalan tindaklanjut surat berhasil dilakukan !";
		
		$location = "alert('" . $msg . " !');
					location.href='index2.php?option=MailTLPimpinan&id=" . $NId . "';";
	}
	
	if($task == "delfile"){
		$GIR_Id = $_POST["GIR_Id"];
		$NId = $_POST['NId'];
					
		$sql = "delete from inbox_receiver  
				where NId = '$NId' 
				and GIR_Id = '$GIR_Id'";
		mysql_query($sql);
		
		$msg = "Pembatalan tindaklanjut surat berhasil dilakukan !";
		$location = "alert('$msg');
					parent.doneWindow();";
	}
	
	if($task == "tutupBerkas"){
		$sql = "select * from berkas 
				where BerkasKey='" . $_SESSION["AppKey"] . "' 
					and BerkasId='$id'";
		$res = mysql_query($sql);
		while($row = mysql_fetch_array($res)){
			$CountSince = $row["BerkasCountSince"];
			
			$tipeAktive = $row["RetensiTipe_Active"];
			$valueAktive = $row["RetensiValue_Active"];
			
			$tipeInAktive = $row["RetensiTipe_InActive"];			
			$valueInAktive = $row["RetensiValue_InActive"];
		}
		
		$sql = "update berkas set BerkasStatus='closed', ";
		if ($CountSince == "closed") {

			$nowday = date('Y-m-d');
			$spl = split("/", $tipeAktive);
			
			if ($spl[0] != "" && is_numeric($spl[0])) {
				$nowday = add_date($nowday, $spl[0], "year");
			}

			if ($spl[1] != "" && is_numeric($spl[1])) {
				$nowday = add_date($nowday, $spl[1], "month");
			}

			if ($spl[2] != "" && is_numeric($spl[2])) {
				$nowday = add_date($nowday, $spl[2], "day");
			}

			$sql .= " RetensiValue_Active='" . $nowday . "', ";


			$nowday2 = $nowday;
			$spl2 = split("/", $tipeInAktive);
			
			if ($spl2[0] != "" && is_numeric($spl2[0])) {
				$nowday2 = add_date($nowday2, $spl2[0], "year");
			}

			if ($spl2[1] != "" && is_numeric($spl2[1])) {
				$nowday2 = add_date($nowday2, $spl2[1], "month");
			}

			if ($spl2[2] != "" && is_numeric($spl2[2])) {
				$nowday2 = add_date($nowday2, $spl2[2], "day");
			}

			$sql .= " RetensiValue_InActive='" . $nowday2 . "', ";
		}
		$sql .= "BerkasLokasi='$data[3]' ";
		if($data[1] != $data[2]){
			if($data[4] == "true"){
				$sql .= ", RoleId='$data[2]' ";
			}
		}
		$sql .= "where BerkasKey='" . $_SESSION["AppKey"] . "' 
					and BerkasId='$id'";
		mysql_query($sql);
		//die(mysql_error());
		//insert into history
		$sql = "insert into berkas_history values(
				'" . $_SESSION["AppKey"] . "',
				'$id',
				'" . $_SESSION["PeopleID"] . "',
				'" . $_SESSION["RoleAtasan"] . "',
				'" . date('Y-m-d') . "',
				'close')";
		mysql_query($sql);
		//die(mysql_error());
		
		$location = "alert('Berkas Berhasil Ditutup !');
					parent.doneWindow();";
	}
	
	if($task == "Ref"){
		$sql = "insert into inbox_reference values(
				'" . $_SESSION["AppKey"] . "',
				'" . $id . "', ";
		if($data[5] == 'surat'){
			$sql .= "'" . $data[2] . "'";
		}else{
			$sql .= "'" . $data[3] . "'";
		}
		$sql .=	", '" . $data[4] . "',
				'" . $data[5] . "' 
				)";
		mysql_query($sql);
		
		if($data[4] == 'reply'){
			$sql = "update inbox set BerkasId = '" . $data[3] . "' 
					where NId='$id'";
			mysql_query($sql);
		}
		$location = "parent.location.reload(true);";
	}
	
	if($task == 'delRef'){
		$sql = "delete from inbox_reference 
				where RefKey = '" . $_SESSION["AppKey"] . "'
					and NId = '" . clean($_REQUEST["NId"]) . "' 
					and Id_Ref='" . clean($_REQUEST["RefId"]) . "'";
		//die($sql);
		mysql_query($sql);
		$location = "location.href='index2.php?option=MailTL&task=detail&id=" . clean($_REQUEST["NId"]) . "';";
	}
	
	if($task == "saveHA"){
		
		if($data[1] != ''){
			$cc = split(',',$data[1]);
			if(count($cc) > 0){
				for($i=0;$i<count($cc);$i++){
					//echo checkExistingReceiverHA($id, $cc[$i], '0') . "<br />";
					if(checkExistingReceiverHA($id, $cc[$i], '0') == "false"){
						$sql = "insert into inbox_receiver values(";
						$sql .= "'" . $_SESSION["AppKey"] . "', ";
						$sql .= "'" . $id . "', ";
						$sql .= "'0', ";						
						$sql .= "'" . $_SESSION["PeopleID"] . "', ";
						$sql .= "'" . $_SESSION["RoleAtasan"] . "', ";
						$sql .= "'" . clean($cc[$i]) . "', ";
						$sql .= "(select PrimaryRoleId from people where PeopleID = '$cc[$i]'), ";
						$sql .= "'bcc_HA', ";
						$sql .= "'-', ";
						$sql .= "'unread', ";
						$sql .= "'" . date('Y-m-d H:i:s') . "', 
								(select RoleName from role where RoleId=(select PrimaryRoleId from people where PeopleID = '$cc[$i]'))
								) ";
						mysql_query($sql);
						//echo $sql . "<br />";
					}
				}
			}
		}	
		//die($data[1]);
		$location = "location.href = 'frame.php?option=MailTL&filetopen=MailTLHA&NId=" . $id . "';";
	}
	
	if($task == 'delHA'){
		$sql = "delete from inbox_receiver 
				where NKey = '" . $_SESSION["AppKey"] . "'
					and NId = '" . clean($_REQUEST["NId"]) . "' 
					and To_Id='" . clean($_REQUEST["peopleId"]) . "' 
					and RoleId_To='" . clean($_REQUEST["roleId"]) . "' 
					and ReceiverAs='bcc_HA';";
		//die($sql);
		mysql_query($sql);
		$location = "location.href = 'frame.php?option=MailTL&filetopen=MailTLHA&NId=" . clean($_REQUEST["NId"]) . "';";
	}
	
	die("<script>" . $location . "</script>");
	
	function checkExistingFinal($NId){
		$retVal = "false";
		$sql = "select * from inbox_receiver 
				where NId = '$NId'
					and ReceiverAs = 'final' 
					and Msg != 'usul_hapus'";
		$res = mysql_query($sql);
		if(mysql_num_rows($res) > 0){
			$retVal = "true";
		}
		
		return $retVal;
	}
	
	function checkExistingReceiver($NId, $To_Id, $GIR_Id){
		$retVal = "false";
		$query = "select * from inbox_receiver 
				where NKey='" . $_SESSION["AppKey"] .  "'
					and NId='$NId'
					and To_Id='$To_Id' 
					and GIR_Id='$GIR_Id' 
					and RoleId_To = (select PrimaryRoleId from people 
									where PeopleKey='" . $_SESSION["AppKey"] . "' 
										and PeopleId = '$To_Id')";
		$res = mysql_query($query);
		if(mysql_num_rows($res) > 0){
			$retVal = "true";
		}
		
		return $retVal;
	}
	
	function checkExistingReceiverContinue($NId, $From_Id, $GIR_Id){
		$retVal = "false";
		$query = "select * from inbox_receiver 
				where NKey='" . $_SESSION["AppKey"] .  "'
					and NId = '$NId'
					and From_Id='$From_Id' 
					and GIR_Id > '$GIR_Id' 
					and RoleId_To = (select PrimaryRoleId from people 
									where PeopleKey='" . $_SESSION["AppKey"] . "' 
										and PeopleId = '$To_Id')";
		$res = mysql_query($query);
		if(mysql_num_rows($res) > 0){
			$retVal = "true";
		}
		
		return $retVal;
	}
	
	function checkExistingReceiverHA($NId, $To_Id, $GIR_Id){
		$retVal = "false";
		$query = "select * from inbox_receiver 
				where NKey='" . $_SESSION["AppKey"] .  "'
					and NId='$NId'
					and To_Id='$To_Id' 
					and RoleId_To = (select PrimaryRoleId from people 
									where PeopleKey='" . $_SESSION["AppKey"] . "' 
										and PeopleId = '$To_Id')";
		$res = mysql_query($query);
		if(mysql_num_rows($res) > 0){
			$retVal = "true";
		}
		
		return $retVal;
	}
	
	function add_date($givendate, $diff, $part) {
		$newdate = strtotime ( '+'  . $diff . ' ' . $part , strtotime ( $givendate ) ) ;	
		$newdate = date ( 'Y-m-d' , $newdate );
		return $newdate;
	}
?>