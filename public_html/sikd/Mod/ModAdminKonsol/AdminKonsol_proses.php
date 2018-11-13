<?
	require_once('include/directory_delete.php');
	$MainDir = 'FilesUploaded/Konsolidasi/';
	$dir = 'exp-' . $_SESSION["AppKey"];
	$fileTxt = 'exp-' . $_SESSION["AppKey"] . '.txt';
	$strData = '';
	
	//get for setting
	$sql = "select t.*
			from tb_setting t 
			where t.tb_key = '" . $_SESSION["AppKey"] . "'";
	$res = mysql_query($sql);
	if(mysql_num_rows($res) > 0){
		while($row = mysql_fetch_array($res)){
			if($strData != ''){
				$strData .= "\n";
			}
			$strData = 'others_setting|+|tb_key|+|';
			for($a=0;$a<mysql_num_fields($res);$a++){
				$strData .= "|+|" . $row[$a]; 
			}
		}	
	}
			
	//detect that already closed and susut for Berkas
	$sql = "select BerkasKey, BerkasId, 
					RoleDesc, ClName,
					BerkasNumber, BerkasName,
					BerkasLokasi, BerkasDesc
			from berkas b 
			join role r on b.RoleId = r.RoleId 
			join classification c on c.ClId = b.ClId
			where b.BerkasKey = '" . $_SESSION["AppKey"] . "' 
					and b.BerkasStatus = 'susut' 
					and b.SusutId = '" . $_SESSION["AppKey"] . ".2' ";
	$res = mysql_query($sql);
	if(mysql_num_rows($res) > 0){
		while($row = mysql_fetch_array($res)){
			if($strData != ''){
				$strData .= "\n";
			}
			$strData .= 'others_berkas|+|BerkasKey|+|BerkasId';
			for($a=0;$a<mysql_num_fields($res);$a++){
				$strData .= "|+|" . $row[$a]; 
			}
		}	
	}
	
	//get the inbox
	$sql = "select i.NKey, i.NId, i.NTglReg, 
			 mj.JenisName, mt.TPName, i.Tgl, 
			 i.Nomor, i.Hal, 
			 mu.UrgensiName, ms.SifatName, mk.KatName, ma.APName, 
		 	 i.Pengirim, 
			 (case i.Pengirim 
			 		when 'internal' then (select RoleDesc from role where RoleId = i.CreationRoleId) 
					when 'external' then InstansiPengirim end) as InstansiPengirim,					
			 (case i.Pengirim when 'internal' then (select PeopleName from people where PeopleId = i.CreatedBy )
					when 'external' then NamaPengirim end) as NamaPengirim, 
			 (case i.Pengirim when 'internal' then (select PeoplePosition from people where PeopleId = i.CreatedBy )
					when 'external' then JabatanPengirim end) as JabatanPengirim,
			 (case when ((select To_Id from inbox_receiver ir where ir.NId = i.NId and ir.ReceiverAs = 'to') > 0) 
					then (case when ((select count(HId) from people_history ph 
								where ph.PeopleId = (select To_Id from inbox_receiver ir where ir.NId = i.NId and ir.ReceiverAs = 'to') 
									and ph.RoleId = (select RoleId_To from inbox_receiver ir where ir.NId = i.NId and ir.ReceiverAs = 'to')
									and ph.HDate >= i.Tgl) > 0) 
						then (select distinct(concat(p2.PeopleName, ', ', ph2.PeoplePosition))
							from people p2 
							join people_history ph2 on p2.PeopleId = ph2.PeopleId
							where ph2.PeopleId = (select To_Id from inbox_receiver where NId = i.NId and ReceiverAs = 'to')
								and ph2.RoleId = (select RoleId_To from inbox_receiver ir where ir.NId = i.NId and ir.ReceiverAs = 'to')
								and ph2.HDate >= i.Tgl)
						else (select concat(p.PeopleName, ', ', r.RoleName) 
								from people p
							join role r on p.PrimaryRoleId = r.RoleId
							where PeopleId = 
								(select To_Id from inbox_receiver ir where ir.NId = i.NId and ir.ReceiverAs = 'to' ))
						end)
					 
					else (select To_Id from inbox_receiver ir where ir.NId = i.NId and ir.ReceiverAs = 'to') 
				  end) as Kepada,
			 i.NFileDir,
			 mm.MediaName, mb.LangName, 
			 i.NIsi, mv.VitName, 
			 i.NJml, msu.MeasureUnitName, 
			 i.NLokasi, i.BerkasId 
			 from inbox i 
			 join master_jnaskah mj on mj.JenisId = i.JenisId 
			 left join master_tperkembangan mt on mt.TPId = i.TPId 
			 join master_urgensi mu on mu.UrgensiId = i.UrgensiId
			 left join master_sifat ms on ms.SifatId = i.SifatId
			 join master_kategoriarsip mk on mk.KatId = i.KatId
			 left join master_aksespublik ma on ma.APId = i.APId 
			 left join master_media mm on mm.MediaId = i.MediaId
			 left join master_bahasa mb on mb.LangId = i.LangId 
			 left join master_vital mv on mv.VitId = i.VitId 
			 left join master_satuanunit msu on msu.MeasureUnitId = i.MeasureId 
			 join berkas b on b.BerkasId = i.BerkasId
			where b.BerkasKey = '" . $_SESSION["AppKey"] . "' 
					and b.BerkasStatus = 'susut' 
					and b.SusutId = '" . $_SESSION["AppKey"] . ".2' ";
	$res = mysql_query($sql);
	if(mysql_num_rows($res) > 0){
		while($row = mysql_fetch_array($res)){
			if($strData != ''){
				$strData .= "\n";
			}
			$strData .= 'others_inbox|+|NKey|+|NId';
			for($a=0;$a<mysql_num_fields($res);$a++){
				if(mysql_field_name($res, $a) == 'NFileDir'){
					$strData .= "|+|others/" . $dir . "/" . $row[$a];
				}else{
					$strData .= "|+|" . $row[$a]; 
				}
			}
		}
	}
	
	//get the inbox_files
	$sql = " select FileKey, GIR_Id, infs.NId,
				(case when infs.PeopleID = '1' then (concat(i.InstansiPengirim, ', ', i.NamaPengirim))  
					else (select PeoplePosition from people where PeopleID = infs.PeopleID) end) as PeopleSender,  
				infs.FileName_real,
				infs.FileName_fake,
				(case (select ir.Msg from inbox_receiver ir 
							where ir.NId = infs.NId 
								and infs.GIR_Id = ir.GIR_Id 
								and ir.ReceiverAs in ('to', 'to_usul', 'to_reply')) 
						when '' then (select ii.Hal from inbox ii where ii.NId = infs.NId) 
						else (select ir.Msg from inbox_receiver ir 
							where ir.NId = infs.NId 
								and infs.GIR_Id = ir.GIR_Id 
								and ir.ReceiverAs in ('to', 'to_usul', 'to_reply')) end) as Pesan,
				infs.EditedDate
	from inbox_files infs 
		join inbox i on i.NId = infs.NId 
		join berkas b on b.BerkasId = i.BerkasId 
	where infs.FileKey = '" . $_SESSION["AppKey"] . "' 
			and b.BerkasKey = '" . $_SESSION["AppKey"] . "' 
			and b.BerkasStatus = 'susut' 
			and b.SusutId = '" . $_SESSION["AppKey"] . ".2' ";
	$res = mysql_query($sql);
	//die(mysql_error());
	if(mysql_num_rows($res) > 0){
		while($row = mysql_fetch_array($res)){
			if($strData != ''){
				$strData .= "\n";
			}
			$strData .= 'others_inbox_files|+|FileKey|+|GIR_Id';
			for($a=0;$a<mysql_num_fields($res);$a++){
				$strData .= "|+|" . $row[$a]; 
			}
		}
	}
		
	//remove all Content before
	remove_directory($MainDir . $dir);
		
	//delete all exsiting konsolidasi
	mkdir($MainDir . $dir);
		
	//create files for backup
	$fh = fopen($MainDir . $dir . '/' . $fileTxt, 'wb');
	fwrite($fh, $strData);
	fclose($fh);	
	
	//detect all Folder included
	$sql = "select i.NFileDir
			from inbox i 
			join berkas b on i.BerkasId = b.BerkasId
			where b.BerkasKey = '" . $_SESSION["AppKey"] . "' 
					and b.BerkasStatus = 'susut' 
					and b.SusutId = '" . $_SESSION["AppKey"] . ".2' ";
	$res = mysql_query($sql);
	if(mysql_num_rows($res) > 0){
		while($row = mysql_fetch_array($res)){
			if(!is_dir($MainDir . $dir . '/' . $row[0])){
				mkdir($MainDir . $dir . '/' . $row[0]);
			}
			recurse_copy('FilesUploaded/' . $row[0], $MainDir . $dir . '/' . $row[0]);
		}
	}
	
	die("<script>
		alert('Proses Konsolidasi Data Selesai !');
		history.go(-1);
		</script>");
	
	function recurse_copy($src, $dst) { 
		$dir = opendir($src); 
		@mkdir($dst); 
		while(false !== ( $file = readdir($dir)) ) { 
			if (( $file != '.' ) && ( $file != '..' )) { 
				if ( is_dir($src . '/' . $file) ) { 
					recurse_copy($src . '/' . $file,$dst . '/' . $file); 
				} 
				else { 
					copy($src . '/' . $file,$dst . '/' . $file); 
				} 
			} 
		} 
		closedir($dir); 
	} 
	
?>