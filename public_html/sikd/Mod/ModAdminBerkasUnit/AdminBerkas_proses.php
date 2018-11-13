<?php
	if($task == "new" || 
		$task == "newFix"){
		//detect with number
		$sql = "select * from berkas 
				where BerkasKey = '" . $_SESSION["AppKey"] . "' 
					and BerkasNumber = '" . trim($data[3]) . trim($data[4]) . "'";
		$res = mysql_query($sql);
		if(mysql_num_rows($res) > 0 ){
			echo "<script>alert('Data dengan Nomor Berkas " . trim($data[3]) . trim($data[4]) . " sudah ditemukan !');</script>";
			die("<script>history.go(-1);</script>");
		}
	
		$nowdate = date('Y-m-d');
		$id = getNumberMain('BerkasKey', 'BerkasId', 'berkas');
				
		$sql = "insert into berkas values( ";
		$sql .= "'" . $_SESSION["AppKey"] . "', ";
		$sql .= "'" . $id . "', ";
		$sql .= "'$data[1]', ";
		$sql .= "'$data[2]', ";
		$sql .= "'" . trim($data[3]) . trim($data[4]) . "', ";
		$sql .= "'$data[5]', ";
		
		//retensi Aktif
		if($_REQUEST["rentesiAktif"] == "split"){
			$sql .= "'" . $_POST["thn"] . "/" . $_POST["bln"] . "/" . $_POST["hr"] . "', ";
			
			if($_POST["thn"] != "" && is_numeric($_POST["thn"])){
				$nowdate = add_date($nowdate, $_POST["thn"], 'year');
			}
			
			if($_POST["bln"] != "" && is_numeric($_POST["bln"])){
				$nowdate = add_date($nowdate, $_POST["bln"], 'month');
			}
			
			if($_POST["hr"] != "" && is_numeric($_POST["hr"])){
				$nowdate = add_date($nowdate, $_POST["hr"], 'day');
			}
			$sql .= "'$nowdate',";
			
		}elseif($_REQUEST["rentesiAktif"] == "tgl"){
			$nowdate = mkdate($_POST["tgl"]);
			$sql .= "'tgl', ";
			$sql .= "'" . mkdate($_POST["tgl"]) . "', ";
		}
		
		$nowdate2 = $nowdate;
		
		//retensi InAktif
		if($_REQUEST["rentesiInAktif"] == "split"){
			$sql .= "'" . $_POST["thn2"] . "/" . $_POST["bln2"] . "/" . $_POST["hr2"] . "', ";
			
			if($_POST["thn2"] != "" && is_numeric($_POST["thn2"])){
				$nowdate2 = add_date($nowdate2, $_POST["thn2"], 'year');
			}
			
			if($_POST["bl2n"] != "" && is_numeric($_POST["bln2"])){
				$nowdate2 = add_date($nowdate2, $_POST["bln2"], 'month');
			}
			
			if($_POST["hr2"] != "" && is_numeric($_POST["hr2"])){
				$nowdate2 = add_date($nowdate2, $_POST["hr2"], 'day');
			}
			$sql .= "'$nowdate2',";
			
		}elseif($_REQUEST["rentesiInAktif"] == "tgl"){
			$nowdate2 = mkdate($_POST["tgl2"]);
			$sql .= "'tgl', ";
			$sql .= "'" . mkdate($_POST["tgl2"]) . "', ";
		}
		//die($nowdate2 . " jadi " . strtotime($nowdate2) . "  - " . $nowdate . " jadi " . strtotime($nowdate));		
		if(strtotime($nowdate2) < strtotime($nowdate)){
			echo "<script>alert('Tanggal InAktif Tidak Boleh Lebih Kecil dari Tanggal Aktif !');</script>";
			die("<script>history.go(-1);</script>");
		}
		
		$sql .= "'$data[7]', ";
		$sql .= "'$data[8]', ";
		$sql .= "'$data[9]', ";
		$sql .= "'" . $_SESSION["PeopleID"] . "', ";
		$sql .= "'" . date("Y-m-d") . "', ";
		$sql .= "'open', ";
		$sql .= "'$data[6]' ";
		$sql .= " ) ";
		//die($sql);
		mysql_query($sql);	
		
		if($task == "newFix"){
			$statement = "vReturnValue[0] = '" . trim($data[3]) . trim($data[4]) . " - " . trim($data[5]) . "';
						  vReturnValue[1] = '" . $id . "';";
			die("<script>
					alert('Data Berhasil Disimpan !');
					var vReturnValue = new Array();
					" . $statement . "
					parent.respAddBerkas(vReturnValue[0], vReturnValue[1]);
				</script>");	
		}else{
			die("<script>
					parent.doneWindow();
				</script>");
		}
	}
	
	if($task == "edit"){
		$sql = "select * from berkas 
				where BerkasKey = '" . $_SESSION["AppKey"] . "'
					and BerkasNumber = '" . trim($data[3]) . trim($data[4]) . "' 
					and BerkasId != '$id'";
		$res = mysql_query($sql);
		if(mysql_num_rows($res) > 0 ){
			echo "<script>alert('Data dengan Nomor Berkas " . trim($data[3]) . trim($data[4]) . " sudah ditemukan !');</script>";
			die("<script>history.go(-1);</script>");
		}
		
		//detect date created
		$sql = "select CreationDate from berkas 
				where BerkasKey='" . $_SESSION["AppKey"] . "' 
					and BerkasId = '$id'";
		$res = mysql_query($sql);
		while($row = mysql_fetch_array($res)){
			$nowdate = $row["CreationDate"];
			$nowdate2 = $row["CreationDate"];
		}
		
		$sql = "update berkas set ";
		$sql .= "RoleId = '$data[1]', ";
		$sql .= "BerkasName = '$data[5]', ";
		//retensi Aktif
		if($_REQUEST["rentesiAktif"] == "split"){
			$sql .= "RetensiTipe_Active = '" . $_POST["thn"] . "/" . $_POST["bln"] . "/" . $_POST["hr"] . "', ";
			
			if($_POST["thn"] != "" && is_numeric($_POST["thn"])){
				$nowdate = add_date($nowdate, $_POST["thn"], 'year');
			}
			
			if($_POST["bln"] != "" && is_numeric($_POST["bln"])){
				$nowdate = add_date($nowdate, $_POST["bln"], 'month');
			}
			
			if($_POST["hr"] != "" && is_numeric($_POST["hr"])){
				$nowdate = add_date($nowdate, $_POST["hr"], 'day');
			}
			$sql .= "RetensiValue_Active = '$nowdate',";
			
		}elseif($_REQUEST["rentesiAktif"] == "tgl"){
			$nowdate = mkdate($_POST["tgl"]);
			$sql .= "RetensiTipe_Active = 'tgl', ";
			$sql .= "RetensiValue_Active = '" . mkdate($_POST["tgl"]) . "', ";
		}
		
		$nowdate2 = $nowdate;
		//retensi InAktif
		if($_REQUEST["rentesiInAktif"] == "split"){
			$sql .= "RetensiTipe_InActive = '" . $_POST["thn2"] . "/" . $_POST["bln2"] . "/" . $_POST["hr2"] . "', ";
			
			if($_POST["thn2"] != "" && is_numeric($_POST["thn2"])){
				$nowdate2 = add_date($nowdate2, $_POST["thn2"], 'year');
			}
			
			if($_POST["bln2"] != "" && is_numeric($_POST["bln2"])){
				$nowdate2 = add_date($nowdate2, $_POST["bln2"], 'month');
			}
			
			if($_POST["hr2"] != "" && is_numeric($_POST["hr2"])){
				$nowdate2 = add_date($nowdate2, $_POST["hr2"], 'day');
			}
			
			$sql .= "RetensiValue_InActive = '$nowdate2',";
			
		}elseif($_REQUEST["rentesiInAktif"] == "tgl"){
			$nowdate2 = mkdate($_POST["tgl2"]);
			$sql .= "RetensiTipe_InActive = 'tgl', ";
			$sql .= "RetensiValue_InActive = '" . mkdate($_POST["tgl2"]) . "', ";
		}
		
		if(strtotime($nowdate2) < strtotime($nowdate)){
			echo "<script>alert('Tanggal InAktif Tidak Boleh Lebih Kecil dari Tanggal Aktif !');</script>";
			die("<script>history.go(-1);</script>");
		}
		
		$sql .= "SusutId='$data[7]', ";
		$sql .= "BerkasLokasi='$data[8]', ";
		$sql .= "BerkasDesc='$data[9]', ";
		$sql .= "BerkasCountSince='$data[6]' ";
		$sql .= "where BerkasKey='" . $_SESSION["AppKey"] . "' ";
		$sql .= " and BerkasId='$id'";
		//die($sql);
		mysql_query($sql);	
		die("<script>
					alert('Data Berhasil Disimpan !');
					parent.doneWindow();
			</script>");	
	}
	
	if($task == "delete"){
		$ids = implode(",", $_REQUEST["ids"]);
		$id = explode(",", $ids);
		try {
			for($a=0; $a<count($id); $a++){
				
				if(checkUsed($id[$a]) == "false"){
					$sql = "delete from berkas 
							where BerkasKey='" . $_SESSION["AppKey"] . "' 
								and BerkasId = '$id[$a]' ";
					mysql_query($sql);				
				}
			}			
			echo "<script>alert('Data Berhasil Dihapus ! \n Jika data ternyata belum terhapus, data tsb masih digunakan. !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		} catch (Exception $e) {
			echo "<script>alert('Gagal manghapus data !');</script>";
			die("<script>location.href='index2.php?option=$option&task=list';</script>");	
		}	
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
		
		//insert into history
		$sql = "insert into berkas_history values(
				'" . $_SESSION["AppKey"] . "',
				'$id',
				'" . $_SESSION["PeopleID"] . "',
				'" . $_SESSION["PrimaryRoleId"] . "',
				'" . date('Y-m-d') . "',
				'close')";
		mysql_query($sql);
		
		
		die("<script>
			alert('Berkas Berhasil Ditutup !');
			parent.doneWindow();
			</script>");
	}
	
	if($task == "OpenBerkas"){
		$sql = "update berkas set BerkasStatus='open' where BerkasId='" . $id . "'";
		mysql_query($sql);	
		
		$sql = "insert into berkas_history values(
				'" . $_SESSION["AppKey"] . "',
				'$id',
				'" . $_SESSION["PeopleID"] . "',
				'" . $_SESSION["PrimaryRoleId"] . "',
				'" . date('Y-m-d') . "',
				'open')";
		mysql_query($sql);
		
		die("<script>
					alert('Berkas Berhasil Dibuka !');
					parent.doneWindow();
			</script>");	
	}
	
	
	if($task == "SusutBerkas"){
		//Musnah
		if($data[2] == $_SESSION['AppKey'] . '.1'){
			//detect working folder 
			$sql = "select NFileDir 
					from inbox 
					where NKey = '" . $_SESSION["AppKey"] . "'
							and BerkasId = '$id'";
			$res = mysql_query($sql);
			while($row = mysql_fetch_array($res)){
				$fileDir = $row[0];
			}
			
			if($fileDir != ''){
				$path = 'FilesUploaded/' . $fileDir . "/";
				if(is_dir($path)){
					$mydir = opendir($path);
					while(false !== ($file = readdir($mydir))) {
						if($file != "." && $file != "..") {
							if(file_exists($path.$file)){
								unlink($path.$file);
							}
						}
					}
					closedir($mydir);
					rmdir($path);
				}
			}
		}
		
		$sql = "update berkas set SusutId='$data[2]', BerkasStatus = 'susut' 
				where BerkasKey = '" . $_SESSION["AppKey"] . "' 
					and BerkasId='$id'";
		mysql_query($sql);
		die("<script>
					alert('Penyusutan Berkas Berhasil Diproses !');
					parent.doneWindow();
			</script>");	
	}
	
	function checkUsed($BId){
		$valReturn = "false";
		try{
			$query = "select * from inbox 
					where NKey='" . $_SESSION["AppKey"] . "' 
						and BerkasId = '" . $BId . "'";
			$result = mysql_query($query);
			if (mysql_num_rows($result) > 0){
				$valReturn = "true";	
			}
		}catch (Exception $e) {
			$valReturn = "false";
		}
		return $valReturn;
	}
	
	function add_date($givendate, $diff, $part) {
		$newdate = strtotime ( '+'  . $diff . ' ' . $part , strtotime ( $givendate ) ) ;	
		$newdate = date ( 'Y-m-d' , $newdate );
		return $newdate;
	}
	
?>