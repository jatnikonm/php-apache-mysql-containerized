<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Detail Surat';
</script>

<link rel="stylesheet" href="style/demo_table_jui.css" type="text/css" media="screen" />
<link rel="stylesheet" href="style/jquery-ui-1.8.4.custom.css" type="text/css" media="screen" />

<div id="usual" class="idtab">
	<form name="form1" id="form1" method="post" action="handle.php">
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="<?php echo $task; ?>" />
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="count" value="1" />
		<input type="hidden" id="hid_RD" />
		<input type="hidden" id="hid_RD_method" />
		<input type="hidden" id="hid_RD_GIRID" />
		<input type="hidden" id="hid_RD_kepada" />
		<input type="hidden" id="hid_RD_CC" />

	<?php
		$GId_Finale = $id . "." . $_SESSION["PeopleID"];
		$sp_reply = "none";
		$sp_usul = "none";
		$sp_disposisi = "none";
		$sp_tutupBerkas = "none";
		$sp_ubahMeta = "inline";
		$sp_forward = "none";
		$sp_final = "none";
		$sp_prntDisp = "none";
		
		$lblBerkas = 'Sudah Diberkaskan di ';
		$lblBerkasBtn = 'Berkaskan Ulang';
		$trBerkas = "none";
		$trBerkasBtn = "none";
		$trBerkasDesc = "none";
		$trBerkasStatusClosed = "none";
		
		$tab1 = "none";
		$tab2 = "none";
		$tab3 = "none";
		$tab4 = "none";
		$tab5 = "none";
        $tab6 = "none";
		
		$divRef = "none";
		$gridRef = "none";
		
		unset($_SESSION["to"]);
		unset($_SESSION["cc"]);
		unset($_SESSION["msg"]);
		//-----------------------------------------------------------------------------------------------
		//								clean up
		//-----------------------------------------------------------------------------------------------
		/*$sql = "select r.GIR_Id 
				from inbox_receiver r, inbox i
				where i.NId = r.NId
					and r.ReceiverAs = 'to'
					and r.ReceiveDate != i.NTglReg 
					and r.NId = '" . $id . "'";
		$res = mysql_query($sql);
		if(mysql_num_rows($res) > 0){
			while($row = mysql_fetch_array($res)){
				$GIR_Id = $row[0];
			}
			
			$sql = "delete from 
					inbox_receiver 
					where GIR_Id = '" . $GIR_Id . "'
					and ReceiverAs = 'to' 
					and NId = '" . $id . "'";
			mysql_query($sql);
		}
		mysql_free_result($res);*/
		
		//-----------------------------------------------------------------------------------
		//							detect receiver as
		//-----------------------------------------------------------------------------------
			
		 $sql = "select NTipe, ReceiverAs, ir.To_Id, i.BerkasId 
				from inbox_receiver ir, inbox i
				where i.NId = ir.NId
					and ir.RoleId_To = '" . $_SESSION["PrimaryRoleId"] . "' 
					and ir.NId = '" . $id . "' ";
		 if (($_SESSION["GroupId"] == "1") and ($_SESSION["GroupId"] == "2") and ($_SESSION["GroupId"] == "5")){
		 //if ($_SESSION["GroupId"] != "3"){
		 	$sql .= "	and (ir.To_Id = '" . $_SESSION["PeopleID"] . "' or ir.To_Id_Desc = '" . $_SESSION["NamaJabatan"] . "')";
		 }
		 $sql .= "order by ir.ReceiveDate desc
				  limit 0, 1";
		//echo $sql;		
		$res = mysql_query($sql);
		if(mysql_num_rows($res) > 0){
			while($row = mysql_fetch_array($res)){
			
				if ($row["ReceiverAs"] == "bcc_HA"){
					$sp_reply = "none";
					$sp_forward = "none";
					$sp_usul = "none";
					$sp_final = "none";
					$sp_disposisi = "none";
					$sp_ubahMeta = "none";
					$sp_tutupBerkas = "none";
					$sp_prntDisp = "none";
					$divRef = 'none'; // ----- Not Allowed for add Referensi ------
					$trBerkasDesc = "table-row";
				}else if ($row["ReceiverAs"] == "bcc"){
					$sp_reply = "none";
					$sp_forward = "none";
					$sp_usul = "none";
					$sp_final = "none";
					$sp_disposisi = "none";
					$sp_ubahMeta = "none";
					$sp_tutupBerkas = "none";
					$sp_prntDisp = "none";
					$divRef = 'none'; // ----- Not Allowed for add Referensi ------
					$trBerkasDesc = "table-row";
				}else{
					
					//detect if User had Follower, if any -- for Disposisi purpose
					$sql2 = "select * 
							from role 
							where RoleId like '" . $_SESSION["PrimaryRoleId"] . ".%'";
					$res2 = mysql_query($sql2);
					if(mysql_num_rows($res2) == 0){
						$sp_disposisi = "none";
					}else{
						$sp_disposisi = 'inline';
					}
		
					$sp_ubahMeta = "inline";
					$sp_tutupBerkas = "inline";
					$divRef = 'inline';	// ----- Allow for add Referensi ------
		
					if ($row["NTipe"] == "outbox") {

// Jika Ingin Mengaktifkan Teruskan, Hidupkan fungsi $sp_forward
//						$sp_forward = "inline";
						$sp_usul = "inline";
						$sp_reply = "none";
					}else{
						$sp_reply = "inline";
						
// Jika Ingin Mengaktifkan Teruskan, Hidupkan fungsi $sp_forward
//						$sp_forward = "inline";
						$sp_usul = "none";
					}
					$sp_final = "block";
					
					//---- Administrator Pusat ----
					//	doesn't have to do ...
					if ($_SESSION["GroupId"] == "1") { 
						$sp_forward = "none";
						$sp_disposisi = "none";
						$sp_ubahMeta = "none";
						$sp_tutupBerkas = "none";
						$sp_usul = "none";
					}		
					
					if ($row["ReceiverAs"] == "to"){
						$trBerkas = "table-row";
						$trBerkasBtn = "table-row";
						$trBerkasDesc = "none";
						$trBerkasStatusClosed = "none";
					}else{
						$trBerkasDesc = "table-row";
					}
				}
			}				
		}
		mysql_free_result($res);
		
				
		//-----------------------------------------------------------------------------------
		
		//detect if Berkas is Already Closed
		$sql = "select BerkasId, BerkasStatus, 
				(case b.BerkasId when '1' then '- Belum Diberkaskan -' else convert(concat(b.BerkasNumber, ' - ', b.BerkasName), CHAR(150)) end) as BerkasName, 
				RetensiValue_Active, RetensiValue_InActive 
				from berkas b 
				where BerkasKey = '" . $_SESSION["AppKey"] . "'
					and BerkasId = (select BerkasId from inbox 
									where NKey = '" . $_SESSION["AppKey"] . "' and NId='" . $id . "')";		
		$res = mysql_query($sql);
		while($row = mysql_fetch_array($res)){
			$_SESSION["BerkasId"] = $row["BerkasId"];
						
			if ($row["BerkasId"] == "1") {	
				$sp_reply = "none";
				$sp_usul = "none";
				$sp_disposisi = "none";
				$sp_tutupBerkas = "none";
				$sp_ubahMeta = "none";
				$sp_forward = "none";
				$sp_final = "none";
				$sp_prntDisp = 'none';
				
				$tab1 = "inline";
				$tab2 = "none";
				$tab3 = "none";
				$tab4 = "none";
				$tab5 = "none";
                $tab6 = "none";
				
				$lblBerkas = 'Diberkaskan di ';
				$lblBerkasBtn = 'Berkaskan';
				$trBerkasDesc = "none";
				$trBerkasStatusClosed = "none";
				$divRef = 'none';
				
			}else{
				$tab1 = "inline";
				$tab2 = "inline";
				$tab3 = "inline";
				$tab4 = "inline";
				$tab5 = "inline";
                $tab6 = "inline";
			}
			
			if (($row["BerkasStatus"] == "closed") || ($row["BerkasStatus"] == "susut")) {
				$_SESSION["BerkasStatus"] = $row["BerkasStatus"];
				
				switch($_SESSION["BerkasStatus"]){
					case "closed":
						$descStatus = 'Berkas Sudah Ditutup';
						break;
					case "susut":
						$descStatus = 'Berkas Sudah di Susutkan';
						break;						
				}
				
				$sp_reply = "none";
				$sp_usul = "none";
				$sp_disposisi = "none";
				$sp_tutupBerkas = "none";
				$sp_ubahMeta = "none";
				$sp_forward = "none";
				$sp_final = "none";
				$sp_prntDisp = 'none';
				$divRef = 'none';
				
				$trBerkas = "none";
				$trBerkasBtn = "none";
				$trBerkasDesc = "table-row";
				$trBerkasStatusClosed = "table-row";
				
				if(strtotime($row["RetensiValue_Active"]) - strtotime(date('Y-m-d')) > 1){
					$tab1 = "inline";
					$tab2 = "inline";
					$tab3 = "inline";
					$tab4 = "inline";
					$tab5 = "inline";
                    $tab6 = "inline";
				}else{
					$tab1 = "inline";
					$tab2 = "none";
					$tab3 = "none";
					$tab4 = "none";
					$tab5 = "none";
                    $tab6 = "none";
				}
			}
		}
		mysql_free_result($res);
				
		if (($_REQUEST["task"] == "view") || ($_REQUEST["task"] == "viewBerkas") || ($_REQUEST["task"] == "outbox") || ($_REQUEST["task"] == "detailUk")) {
			$sp_reply = "none";
			$sp_usul = "none";
			$sp_disposisi = "none";
			$sp_tutupBerkas = "none";
			$sp_ubahMeta = "none";
			$sp_forward = "none";
			$sp_final = "none";
			$sp_prntDisp = "none";
			
			$lblBerkas = 'Diberkaskan di ';
			$lblBerkasBtn = 'Berkaskan';
			$trBerkas = "none";
			$trBerkasBtn = "none";
			$trBerkasDesc = "table-row";
			$trBerkasStatusClosed = "none";
			$divRef = 'none';
			
			$tab1 = "inline";
			$tab2 = "inline";
			$tab3 = "inline";
			$tab4 = "inline";
			$tab5 = "inline";
            $tab6 = "inline";
			
			//check if this person is the one who create this mail
			$sql = "select i.CreatedBy from inbox i 
						where i.NId = '" . $id . "' and CreatedBy = '" . $_SESSION["PeopleID"] . "'";
			$res = mysql_query($sql);
			if(mysql_num_rows($res) > 0){
				$sp_ubahMeta = "inline";
			}
			mysql_free_result($res);
		}
				
		if($_SESSION["PeopleID"] == "1"){
			$sp_reply = "none";
			$sp_usul = "none";
			$sp_disposisi = "none";
			$sp_tutupBerkas = "none";
			$sp_ubahMeta = "none";
			$sp_forward = "none";
			$sp_final = "none";
			$sp_prntDisp = "none";
			
			$lblBerkas = 'Sudah Diberkaskan di ';
			$lblBerkasBtn = 'Berkaskan Ulang';
			$trBerkas = "none";
			$trBerkasBtn = "none";
			$trBerkasDesc = "table-row";
			$trBerkasStatusClosed = "none";
			
			$tab1 = "inline";
			$tab2 = "inline";
			$tab3 = "inline";
			$tab4 = "inline";
			$tab5 = "inline";
			$tab6 = "inline";

			$divRef = 'none';
			$gridRef = "none";			
		}
		
		//update if already open/read
		//Diaktifkan jika sekretaris membuka status surat tetap unread
//		$sql = "update inbox_receiver 
//				set StatusReceive ='read' 
//				where NKey='" . $_SESSION["AppKey"] . "' 
//					and NId = '$id' 
//					and To_Id = '" . $_SESSION["PeopleID"] . "' 
//					and RoleId_To='" . $_SESSION["PrimaryRoleId"] . "'";

		$sql = "update inbox_receiver 
				set StatusReceive ='read' 
				where NKey='" . $_SESSION["AppKey"] . "' 
					and NId = '$id' 
					and RoleId_To='" . $_SESSION["PrimaryRoleId"] . "'";
					
		mysql_query($sql);
		
		//------------------------------------------------------------------------------------------------------
		//											detect if already upload Final
		//------------------------------------------------------------------------------------------------------
		$sql = "select * from inbox_receiver 
				where NId = '$id'
					and ReceiverAs = 'final' 
					and Msg != 'usul_hapus'";
		$res = mysql_query($sql);
		if(mysql_num_rows($res) > 0){
			$sp_reply = "none";
			$sp_usul = "none";
			$sp_disposisi = "none";
			$sp_ubahMeta = "inline";
			$sp_forward = "none";
			$sp_final = "none";
			$sp_prntDisp = "none";
			$tab4 = "none";
			$tab5 = "none";
			$tab6 = "none";
			
			$sp_tutupBerkas = "inline";
			$sp_ubahMeta = "none";
			$sp_forward = "none";
			$sp_final = "none";
			$divRef = 'inline';
			
			$trBerkas = "none";
			$trBerkasBtn = "none";
			$trBerkasDesc = "table-row";
			$trBerkasStatusClosed = "table-row";
		}
		mysql_free_result($res);
		//------------------------------------------------------------------------------------------------------

		//------------------------------------------------------------------------------------------------------
		//											detect if Surat Tanpa Tindak Lanjut
		//------------------------------------------------------------------------------------------------------
		$sql = "select * from inbox_receiver 
				where NId = '$id'
					and ReceiverAs = 'to_tl'";
		$res = mysql_query($sql);
		if(mysql_num_rows($res) > 0){
			$sp_reply = "none";
			$sp_forward = "none";
			$sp_usul = "none";
			$sp_final = "none";
			$sp_disposisi = "none";
			$sp_ubahMeta = "inline";
			$sp_tutupBerkas = "none";
			$sp_prntDisp = "none";
			$divRef = 'none'; // ----- Not Allowed for add Referensi ------
			$trBerkasDesc = "table-row";
			$tab4 = "none";
			$tab5 = "none";
		}
		mysql_free_result($res);
		//------------------------------------------------------------------------------------------------------
				
		//detect person the closer
		if($_SESSION["BerkasStatus"] == "closed"){
	
		$sp_tutupBerkas = "none";
			
			$sql = "select max(ActionDate), 
						PeopleId, 
						r.RoleDesc, 
						(case when ((select count(ph.PeopleId) from people_history ph 
									where ph.PeopleId = bh.PeopleId 
										and ph.RoleId = bh.PrimaryRoleId 
										and ph.HDate >= bh.ActionDate) > 0)
						then (select distinct(concat(p.PeopleName, ', ', rh.RoleDesc)) 
							from people_history ph 
							join people p on p.PeopleId = ph.PeopleId 
							join role rh on rh.RoleId = ph.RoleId
							where ph.PeopleId = bh.PeopleId 
								and ph.RoleId = bh.PrimaryRoleId 
								and ph.HDate >= bh.ActionDate)
						else (select concat(p.PeopleName, ' (', rp.RoleDesc, ')')
							from people p 
							join role rp on rp.RoleId = p.PrimaryRoleId 
							where p.PeopleId = bh.PeopleId 
								and bh.PrimaryRoleId = p.PrimaryRoleId)
						end) as PeopleName
					from berkas_history bh 
					join role r on r.RoleId = bh.PrimaryRoleId
					where bh.BerkasKey = '" . $_SESSION["AppKey"] . "'
						and	bh.BerkasId = '" . $_SESSION["BerkasId"] . "' 
						and bh.ActionType = 'close'
					group by bh.BerkasId";
			//echo $sql;
			$res = mysql_query($sql);
			while($row = mysql_fetch_array($res)){
				$people_closer = $row["PeopleName"];
				$descStatus .= ' oleh ' . $people_closer;
			}
		}

		$origin = "";
		$taskBefore = "";
		$pageBefore = clean($_REQUEST["page"]);
		$roleBefore = clean($_REQUEST["role"]);
		switch($task){
			case "detail":
			default:
				$origin = "MailInbox";
				$taskBefore = $task;
				break;
			case "detailUk":
				$origin = "MailInboxUk";
				$taskBefore = "list";
				break;
			case "outbox":
				$origin = "MailOutbox";
				$taskBefore = "list";
				break;
			case "viewUk":
			case "view":
				$origin = "MailInboxUk";
				$taskBefore = "list";
				break;
			case "viewBerkas":
				$origin = "MailInbox";
				$taskBefore = "viewBerkas&BId=" . $_SESSION["BerkasId"];
				break;
		}
		
		//generate button text
		$sql = "select GROUP_CONCAT(btn_text SEPARATOR '|') as btn_text from master_btn ";
		$res= mysql_query($sql);
		while($row = mysql_fetch_array($res)){
			$allBtn = explode('|',$row[0]);
		}
		mysql_free_result($res);
		
	?>
	
	<table style="width:100%;" cellspacing="0" cellpadding="1">
		<tr>
			<td class="navrightheader" valign="middle" nowrap="nowrap">
				&nbsp;
				<span id="sp_back" class="navIcon" >
					<input title="Kembali Ke Halaman Sebelumnya" type="button" name="btnBack" value="<?php echo $allBtn[6]; ?>" class="btn_back" onclick="getBack('<?php echo $origin; ?>', '<?php echo $taskBefore; ?>', '<?php echo $pageBefore; ?>', '<?php echo $roleBefore; ?>');" />
				</span>
				<span id="sp_forward" class="navIcon" style="display:<?php echo $sp_forward; ?>;" >
					<input title="Teruskan Surat" type="button" name="btnForward" value="<?php echo $allBtn[1]; ?>" class="btn_forward" onclick="openRD1('forward')" />
				</span>
				<span id="sp_reply" class="navIcon" style="display:<?php echo $sp_reply; ?>;" >
					<input title="Kirim Nota Dinas" type="button" name="btnReply" value="<?php echo $allBtn[0]; ?>" class="btn_reply" onclick="openRD1('reply')" />
				</span>
				<span id="sp_usul" class="navIcon" style="display:<?php echo $sp_usul; ?>;" >
					<input title="Kirim Nota Dinas" type="button" name="btnUsul" value="<?php echo $allBtn[3]; ?>" class="btn_reply" onclick="openRD1('usul')" />
				</span>
				<span id="sp_disposisi" class="navIcon" style="display:<?php echo $sp_disposisi; ?>;" >
					<input title="Kirim Disposisi" type="button" name="btnDisposisi" value="<?php echo $allBtn[2]; ?>" class="btn_view" onclick="openRD('disposisi')" />
				</span>
				&nbsp;
				<span id="sp_ubahMeta" class="navIcon" style="display:<?php echo $sp_ubahMeta; ?>;">
					<input title="Ubah Metadata" type="button" name="btnUbah" value="<?php echo $allBtn[4]; ?>" class="btn_edit" onclick="openMetadata('edit', '');" />
				</span>
                &nbsp;
                <span id="sp_prntDisp" class="navIcon" style="display:<?php echo $sp_prntDisp; ?>;">
					<input type="button" name="btnCetak" value=" Cetak Disposisi" class="btn_print" onClick="openRDPrint();" />
				</span>
				&nbsp;
				<span id="sp_tutupBerkas" class="navIcon" style="display:<?php echo $sp_tutupBerkas; ?>;">
					<input title="Tutup Berkas" type="button" name="btn_berkas_close" value="<?php echo $allBtn[7]; ?>" class="btn_berkas_close" onclick="openTutupBerkas();" />
				</span>
			</td>
		</tr>
	</table>
	<br />
	<table style="width:100%;" cellpadding="0" cellspacing="0" >
		<tr>
			<td>
				<ul> 
					<li><a href="#tab1" style="display:<?php echo $tab1; ?>;">Metadata</a></li> 
					<li><a href="#tab3" style="display:<?php echo $tab3; ?>">File Digital dan Jejak Surat</a></li>
					<li><a href="#tab4" style="display:<?php echo $tab4; ?>">Relasi Surat</a></li> 
					<li><a href="#tab5" style="display:<?php echo $tab5; ?>">Hak Akses</a></li>
                    <li><a href="#tab6" style="display:<?php echo $tab6; ?>">Status Pemberkasan</a></li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>
				<div id="tab1" style="background-color:#FFFFFF;">
					<?php 
						 $sql = "select i.Hal, i.Nomor, i.NAgenda,
							 date_format(i.Tgl, '%d/%m/%Y') as Tgl,
							 i.NIsi, i.NJml, NLokasi, NFileDir, NTipe,
							 mj.JenisName, mt.TPName, mu.UrgensiName, ms.SifatName, i.Pengirim, 
							 mk.KatName, ma.APName, mm.MediaName, mb.LangName, mv.VitName, Tesaurus,	
							 (case i.BerkasId when '1' then '' else convert(concat(b.BerkasNumber, ' - ', b.BerkasName, ', Pada Unit Kerja : ', rl.RoleDesc), CHAR(250)) end) as BerkasName,
							 (case i.Pengirim when 'internal' then 'Unit Kerja'
								when 'external' then 'Instansi' end) as Uk,
							 (case i.Pengirim when 'internal' then (select RoleDesc from role where RoleId = i.CreationRoleId )
								when 'external' then InstansiPengirim end) as InstansiSender,
							 (case i.Pengirim when 'internal' then (select PeopleName from people where PeopleId = i.CreatedBy )
								when 'external' then NamaPengirim end) as NamaSender, 
							 (case i.Pengirim when 'internal' then (select PeoplePosition from people where PeopleId = i.CreatedBy )
								when 'external' then JabatanPengirim end) as JabatanSender,
								msu.MeasureUnitName,
								i.BerkasId, b.BerkasStatus 
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
							 left join berkas b on b.BerkasId = i.BerkasId 
							 left join role rl on rl.RoleId = b.RoleId
								  where(i.NKey = '" . $_SESSION["AppKey"] . "')
							 and i.NId = '" . $id . "'  ";
							 //echo $sql;
						 $res = mysql_query($sql);
						 $row = mysql_fetch_array($res);
					?>
					<table cellspacing="2" cellpadding="3" style="width:100%;">

						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>       

						<tr>
							<td style="width:30%;" ><?php echo $row["Uk"]; ?></td>
							<td style="width:70%;" >
								<?php echo $row["InstansiSender"]; ?>
							</td>
						</tr>

						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>       

						<tr style="display:<?php echo $trBerkasDesc; ?>;">
							<td>
								<font color="red"><strong>Sudah diberkaskan di</strong></font>
							</td>
							<td>
								<font color="red"><strong><?php echo $berkasdi=$row["BerkasName"]; ?></strong></font>
							</td>
						</tr>
                        
						<tr style="display:<?php echo $trBerkasStatusClosed; ?>;">
							<td colspan="2" style="text-align:center;"><strong><font color="red"><?php echo $descStatus; ?></font></strong></td>
						</tr>	
                        					
						<tr>
							<td>
								Jenis Surat 
							</td>
							<td>
								<?php echo $row["JenisName"]; ?>
							</td>
						</tr>
                        
						<tr>
							<td>
								Tingkat Perkembangan 
							</td>
							<td>
								<?php echo $row["TPName"]; ?>
							</td>
						</tr>
						<tr>
							<td>
								Tanggal Surat 
							</td>
							<td valign="middle">
								<?php echo $row["Tgl"]; ?>                                            
							</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
                        	<?php
							if ($row["Pengirim"] == "external"){
							?>
                                <td>
                                    Nomor Asal Surat 
                                </td>
                        	<?php
							}else{
							?>
                                <td>
                                    Nomor Surat Unit Kerja
                                </td>
                        	<?php
							}
							?>
                            
							<td>
								<?php echo $row["Nomor"]; ?>
							</td>
						</tr>
						<tr>
							<td>
								Nomor Agenda 
							</td>
							<td>
								<?php echo $row["NAgenda"]; ?>
							</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td>
								Hal 
							</td>
							<td>
								<?php echo $row["Hal"]; ?>
							</td>
						</tr>
						<tr>
							<td>
								Tingkat Urgensi
							</td>
							<td>
								<?php echo $row["UrgensiName"]; ?>
							</td>
						</tr>
						<tr>
							<td>
								Sifat Surat 
							</td>
							<td>
								<?php echo $row["SifatName"]; ?>
							</td>
						</tr>
						<tr>
							<td>
								Kategori Arsip 
							</td>
							<td>
								<?php echo $row["KatName"]; ?>
							</td>
						</tr>
						<tr>
							<td>
								Tingkat Akses Publik 
							</td>
							<td>
								<?php echo $row["APName"]; ?>
							</td>
						</tr>
						<tr>
							<td>
								Media Arsip
							</td>
							<td>
								<?php echo $row["MediaName"]; ?>
							</td>
						</tr>
						<tr>
							<td>
								Bahasa
							</td>
							<td>
								<?php echo $row["LangName"]; ?>
							</td>
						</tr>
						<tr>
							<td valign="top">
								Isi Ringkas 
							</td>
							<td>
								<?php echo $row["NIsi"]; ?>
							</td>
						</tr>
						<tr>
							<td>
								Arsip Vital / Tidak Vital
							</td>
							<td>
								<?php echo $row["VitName"]; ?>
							</td>
						</tr>
						<tr>
							<td>
								Jumlah
							</td>
							<td>
								<?php echo $row["NJml"]; ?>&nbsp;<?php echo $row["MeasureUnitName"];?>
							</td>
						</tr>
					    <tr>
							<td colspan="2" style="padding:10px; text-align:right;">&nbsp;

							</td>
						</tr>
					</table>

				</div>
				<div id="tab3" style=" padding:3px; background-color:#FFFFFF;">
                
					<span id="sp_final" style="display:<?php echo $sp_final; ?>; margin:10px; width:100%;" >
						<input title="Upload File Digital Surat Final" type="button" name="btnFinal" value="<?php echo $allBtn[5]; ?>" class="btn_view_final" onclick="openFinal('new');" />
                        <br /><font color="red">(Dipergunakan untuk mengupload hasil scan surat yang telah ditandatangani pimpinan dan diberikan nomor surat)</font>
						<input type="hidden" name="gid_finale" value="<?php echo $GId_Finale; ?>" />
					</span>
					&nbsp;
                    
					<table class="adminlist" style="width:100%;" cellpadding="2" cellspacing="0">
						<tr style="height:24px;">
							<th style="width:1%;">No</th>
							<th style="width:12%;">Tanggal &amp; Jam</th>
							<th style="width:25%;">Pengirim Surat</th>
							<th style="width:25%;">Tujuan Surat</th>
							<th style="width:13%;">Keterangan</th>
							<th style="width:25%;">Pesan</th>
							<th style="width:1%;">&nbsp;</th>
							<th style="width:1%;">&nbsp;</th>
                            <th style="width:1%;">&nbsp;</th>
						</tr>
						<?php
							$sql = "select ir.NId, ir.GIR_Id, ir.ReceiveDate, date_format(ir.ReceiveDate, '%d/%m/%Y %H:%i') as waktu, ";

// Hidupkan jika fungsi sekretaris tidak ada, dan jika pimpinan langsung yang menindaklanjuti suratnya

//							$sql .= "    (case ir.From_Id when '0' 
//											then (select concat(InstansiPengirim) from inbox i where i.NId = ir.NId ) 
//										       else (case when ((select count(HId) from people_history where PeopleId=ir.From_Id 
//																and RoleId = ir.RoleId_From and HDate >= ir.ReceiveDate) > 0) 
//													then (select distinct(PeoplePosition) 
//															from people_history 
//															where PeopleId=ir.From_Id 
//																and RoleId = ir.RoleId_From 
//																and HDate >= ir.ReceiveDate)															
//													else (select PeoplePosition 
//														from people 
//														where PeopleId = ir.From_Id 
//														and ir.NId = ir.NId)  
//													end) 
//											end) as pengirim, ";

							$sql .= "    (case ir.From_Id when '0' 
											then (select concat(InstansiPengirim) from inbox i where i.NId = ir.NId ) 
										       else (select RoleName 
														from role 
														where RoleId = ir.RoleId_From)  
										  end) as pengirim, ";
							
							if ($_REQUEST["mode"] == "outbox") {
								$sql .= "  (case when (ir.To_Id = p.PeopleId) then p.PeoplePosition else ir.To_Id  end) as penerima, ";
							}else{
							
								$sql .= "    (SELECT (GROUP_CONCAT(rr.RoleName ORDER BY rr.RoleName ASC SEPARATOR ', ')) ";
								$sql .= "        FROM inbox_receiver irr ";
								$sql .= "        join role rr on rr.RoleId = irr.RoleId_To ";
								$sql .= "     where irr.GIR_Id = ir.GIR_Id ";
								$sql .= "        	and irr.ReceiverAs in ('to', 'to_tl', 'to_memo', 'to_notadinas', 'to_konsep', 'cc1', 'to_usul', 'to_reply', 'to_forward') ";
								$sql .= "     GROUP BY irr.GIR_Id ) as penerima, ";
							
							}
							
							$sql .= "    (case ir.ReceiverAs when 'to' then 'Surat Masuk' "; //(select Hal from inbox where NId = ir.NId)
							$sql .= "	    when ('to_memo') then 'Memo' ";
							$sql .= "	    when ('to_notadinas') then 'Nota Dinas' ";
							$sql .= "	    when ('to_konsep') then 'Nota Dinas' ";
							$sql .= "	    when ('cc1') then 'Disposisi' ";
							$sql .= "	    when ('to_forward') then 'Teruskan' ";
							$sql .= "        when ('to_reply') then 'Nota Dinas' ";
							$sql .= "        when ('to_usul') then 'Nota Dinas' ";
							$sql .= "        when ('to_tl') then 'Surat Tanpa Tindaklanjut' ";
							$sql .= "        when 'final' then 'Dokumen Final' end) as tipeRD, ";
							
							$sql .= "    (case ir.ReceiverAs when 'to' then '' ";
							$sql .= "	    when ('to_memo') then 'Memo' ";
							$sql .= "	    when ('to_notadinas') then 'Nota Dinas' ";
							$sql .= "	    when ('to_konsep') then 'Nota Dinas' ";
							$sql .= "	    when ('cc1') then 'Disposisi' ";
							$sql .= "	    when ('to_forward') then 'Teruskan' ";
							$sql .= "       when ('to_reply') then 'Nota Dinas' ";
							$sql .= "        when ('to_usul') then 'Nota Dinas' ";
							$sql .= "        when ('to_tl') then 'Surat Tanpa Tindaklanjut' ";
							$sql .= "		when ('final') then 'final' end) as modeRD, "; // Mode RD tidak dipergunakan, karena fungsi editnya sudah hilang
							
							$sql .= "    (case ir.Msg when '' then (select Hal from inbox i where i.NId = ir.NId) ";
							$sql .= "        else ir.Msg end ) as Msg, ";
				
							$sql .= "    (case (select count(ir2.GIR_Id) from inbox_receiver ir2 
													where ir2.GIR_Id = ir.GIR_Id and ir2.ReceiverAs in ('cc', 'bcc') ) when 0 then 'none' ";
							$sql .= "        else 'inline' end) as show_tembusan, ";
				
							$sql .= "    (SELECT (GROUP_CONCAT(pp.PeoplePosition ORDER BY pp.PeoplePosition ASC SEPARATOR ', ')) ";
							$sql .= "        FROM inbox_receiver ir3 ";
							$sql .= "        join role p2 on p2.RoleId = ir3.RoleId_To 
											 join people pp on pp.PeopleId = ir3.To_Id ";
							$sql .= "        where ir3.GIR_Id = ir.GIR_Id ";
							$sql .= "        and ir3.ReceiverAs in ('cc','bcc') ";
							$sql .= "        GROUP BY ir3.GIR_Id ) as Tembusan, ";
				
							if (($_REQUEST["mode"] == "viewBerkas") || ($_REQUEST["mode"] == "outbox")) {
								$sql .= " 'none' as showEditRD, ";
								$sql .= " 'none' as showDeleteRD ";
							}else{
								if ($_SESSION["PrimaryRoleId"] == "root"){
									$sql .= "    'none' as showEditRD, ";
									$sql .= "    'none' as showDeleteRD ";
								}else{
									if ($_SESSION["BerkasStatus"] == "closed"){
										$sql .= " 'none' as showEditRD, ";
										$sql .= " 'none' as showDeleteRD ";
									}else{
										$sql .= "    (case concat(ir.From_Id, ir.RoleId_From) 
														when '" . $_SESSION["PeopleID"] . $_SESSION["PrimaryRoleId"] . "' 
														then 'inline' else 'none' ";
										$sql .= "     	end) as showEditRD, ";
										$sql .= "    (case concat(ir.From_Id, ir.RoleId_From) 
														when '" . $_SESSION["PeopleID"] . $_SESSION["PrimaryRoleId"] . "' 
														then 'inline' else 'none' ";
										$sql .= "     end) as showDeleteRD ";
									}
								}
							}
							$sql .= " , (case ir.ReceiverAs when 'cc1' then 'inline' else 'none' end) as showPrintRD ";
							$sql .= "from inbox_receiver ir ";
							$sql .= "left join people p on ir.To_Id = p.PeopleId ";
							$sql .= "where ir.NId = '" . $id . "' ";
							$sql .= "    and ir.Msg != 'usul_hapus' ";
							$sql .= "	 and ir.Msg != 'usul_hapus' ";
							$sql .= "	 and ir.ReceiverAs not in ('bcc', 'bcc_HA') ";
							$sql .= "group by ir.GIR_Id ";
							$sql .= "order by ir.ReceiveDate DESC ";
							//echo $sql;
							$res = mysql_query($sql);
							$a=0;
							while($row = mysql_fetch_array($res)){
								$a++;
								if($a % 2) { //this means if there is a remainder
									$bg = '#FFFFFF';
								} else { //if there isn't a remainder we will do the else
									$bg = '#D7E0EA';
								}
								$ssql = "select * from inbox_receiver 
										where NKey='" . $_SESSION["AppKey"] . "'
											and NId = '" . $row["NId"] . "'
											and Msg != 'usul_hapus' 
											and ReceiverAs not in ('bcc', 'bcc_HA')
											and ReceiveDate > '" . $row["ReceiveDate"] . "'";
								//echo $row["GIR_Id"] . $ssql . "<br />";
								$rres = mysql_query($ssql);
								if(mysql_num_rows($rres) > 0){
									$showEditRD = 'none';
									$showDeleteRD = 'none';
								}else{
									$showEditRD = $row["showEditRD"];
									$showDeleteRD = $row["showDeleteRD"];
								}
								
								if (($_REQUEST["task"] == "viewBerkas") || ($_REQUEST["task"] == "outbox")) {
									$showEditRD = 'none';
									$showDeleteRD = 'none';
								}
								 //echo $ssql;
								?>
								<tr style="background-color:<?php echo $bg; ?>">
									<td><?php echo $a; ?></td>
									<td><?php echo $row["waktu"]; ?></td>
									<td><?php echo $row["pengirim"]; ?></td>
                                   	<?php 
                                    if($row["tipeRD"] == 'Upload Dokumen Final') {
										?>
											<td colspan="2"><center><?php echo $row["tipeRD"]; ?></center></td>
										<?php
									}else{
										?>
                                        <td>
											<?php echo $row["penerima"]; ?>
                                            <div style='display:<?php echo $row["show_tembusan"]; ?>; width:100%;'>
                                                <br />
                                                <strong><em>Tembusan </em></strong> :&nbsp;<?php echo $row["Tembusan"]; ?>
                                            </div>
                                        </td>
                                        <td><?php echo $row["tipeRD"]; ?></td>		
                                        <?php
									}?>
																
									
                                    <td>
										<?php 
											echo $row["Msg"]; 
											
                                    		if($row["tipeRD"] == 'Disposisi') {
												$sqlDisp = " select replace(Disposisi, \"|\", \"','\") as idDisp
															from inbox_disposisi d 
															where d.GIR_Id = '" . $row["GIR_Id"] . "'";
												$resDisp = mysql_query($sqlDisp);
												if(mysql_num_rows($resDisp) > 0){
													while($rwDisp = mysql_fetch_array($resDisp)){
														$idDIsps = $rwDisp["idDisp"];
													}
													
													echo "<table style='width:100%;'>";
													echo "	<tr><td colspan='2'>Isi Disposisi :</td></tr>";
													$sqlDescDisp = "select * from master_disposisi where DisposisiId in ('" . $idDIsps . "')";
													$resDescDisp = mysql_query($sqlDescDisp);
													while($rwDescDisp = mysql_fetch_array($resDescDisp)){
														echo "<tr>";
														echo "	<td>-</td>";
														echo "	<td>" . $rwDescDisp["DisposisiName"] . "</td>";
														echo "</tr>";
													}
													echo "</table>";
													mysql_free_result($resDescDisp);
												}
												mysql_free_result($resDisp);
											}
											
											$fileDir = "FilesUploaded";
											//--------------------- for displaying files attachment if any -----------------------------
											$sql_files = "select concat('" . $fileDir . "/',i.NFileDir,'/',infs.FileName_fake) as FileDisk, ";
											$sql_files .= " 	(case infs.FileStatus when 'usul_hapus' then 'none' else 'inline' end) as StatusReceive, ";
											$sql_files .= " 	convert(concat(infs.NId, '|', infs.GIR_Id, '|', infs.FileName_real), char(50)) as IdDel, ";
											$sql_files .= " 	convert(concat(infs.NID, '|', infs.PeopleID, '|', infs.FileName_real, '|', infs.FileName_fake, 
															'|', infs.GIR_Id), char(200)) as FakeFileName, ";
											if ($_SESSION["GroupId"] == "1" ){
												$sql_files .= " 'none' as vsi, ";
												$sql_files .= " (case infs.FileStatus when 'usul_hapus' then 'block' else 'none' end) as vsi_root, ";
												$sql_files .= " 'block' as vsi_download, ";
											}else{
												if ($_SESSION["BerkasStatus"] == "closed") {
													$sql_files .= " 'none' as vsi, ";
											
													if ($_SESSION["GroupId"] == "1") {
														$sql_files .= " 'inline' as vsi_download, ";
													}else{
														$sql_files .= " (case when (r.RetensiValue_InActive >= '" . date('Y-m-d') . "') then  ";
														$sql_files .= "       (case infs.FileStatus when 'available' then 'block'  ";
														$sql_files .= "           else (case infs.PeopleRoleId when '" . $_SESSION["PrimaryRoleId"] . "' then 'block' ";
														$sql_files .= "               else (case when '" . $_SESSION["PrimaryRoleId"] . "' like concat(infs.PeopleRoleId,'%') then 'none' 
																		else 'block' end)  end) ";
														$sql_files .= "        end) ";
														$sql_files .= "  else 'none' end) as vsi_download,  ";
													}
													$sql_files .= " 'none' as vsi_root, ";
												} else{
													if (($_REQUEST["mode"] == "viewBerkas") || ($_REQUEST["mode"] == "outbox")) {
														$sql_files .= " 'none' as vsi, ";
														$sql_files .= " (case infs.FileStatus when 'available' then 'block'  ";
														$sql_files .= "    else 'none' ";
														$sql_files .= "    end) as vsi_download, ";
														$sql_files .= " 'none' as vsi_root, ";
													}else{
														$sql_files .= " (case when infs.FileStatus = 'usul_hapus' then 'none' ";
														$sql_files .= "	when ((select count(NId) from inbox_receiver where GIR_Id > infs.GIR_Id) > 0) then 'none' ";
														$sql_files .= "    else (case when infs.PeopleRoleID='" . $_SESSION["PrimaryRoleId"] . "' then 'block' ";
														$sql_files .= "            else 'none' end ) ";
														$sql_files .= "    end) as vsi, ";
														$sql_files .= " 'none' as vsi_root, ";
														
														$sql_files .= " (case infs.FileStatus when 'available' then 'block'  
																	when 'none' then 'none'
																	else (case infs.PeopleRoleId when '" . $_SESSION["PrimaryRoleId"] . "' then 'block' 
																			else (case when '" . $_SESSION["PrimaryRoleId"] . "' like concat(infs.PeopleRoleId,'%') then 'none' 
																					else 'block' end) 
																			end)
																	 end) as vsi_download, ";
													}
												}
											}
											
											$sql_files .= " (case infs.FileStatus when 'usul_hapus' then '' ";
											$sql_files .= "        else (case (select distinct(ir.Msg) as Msg from inbox_receiver ir where ir.NId=infs.NId and ir.ReceiverAs = 'to' ) when '' then i.Hal ";
											$sql_files .= "            else infs.FileStatus end) ";
											$sql_files .= "    end) as isiPesan,";
											
											$sql_files .= " (case infs.FileStatus when 'usul_hapus' then '-- Diusulkan untuk dihapus --' ";
											$sql_files .= "    else (case when infs.FileName_real = '' then '-- tidak ada file --' else infs.FileName_real end) end) as FileName ";
											
											$sql_files .= "from inbox_files infs ";
											$sql_files .= "join inbox i on i.NId = infs.NId ";
											$sql_files .= "join berkas r on r.BerkasId = i.BerkasId ";
											$sql_files .= "where infs.NId='" . $id . "' and infs.GIR_Id = '" . $row["GIR_Id"] . "' "; 
											$sql_files .= " order by infs.EditedDate DESC";
											
											$res_files = mysql_query($sql_files);
											if(mysql_num_rows($res_files) > 0) {
												echo "<table style='width:100%;'>";
												echo "	<tr><td>Lampiran File Surat :</td></tr>";
												while($row_files = mysql_fetch_array($res_files)){
													echo "<tr>";
													echo "	<td>";
													?>													
													<div style="text-align:left; display:block; margin:5px;">
                                                        <div style='display:<?php echo $row_files["vsi_download"]; ?>; width:3px fixed; margin-right:2px; float:left;'>
                                                            <a href="<?php echo $row_files["FileDisk"]; ?>" 
                                                            	style="display:<?php echo $row_files["StatusReceive"]; ?>;" 
                                                            	target="_blank" >
                                                            <img src="images/attach.png" alt="Unduh Arsip" style="border:none;" title="Download File Digital Surat" /></a>
                                                        </div>
                                                        <div style='float:left; margin-right:5px; '>
                                                            &nbsp;<?php echo $row_files["FileName"]; ?>
                                                        </div> 
                                                    </div>
                                                    <br />
                                                	<?php
													echo "</td>";
												}
												echo " </table>";
											}
											
										?>                                        
                                    </td>
                                    <td>
										<span style="display:<?php echo $row["showPrintRD"]; ?>">
											<a href="#" onclick="openRDPrint('<?php echo $row["NId"]; ?>','<?php echo $row["GIR_Id"]; ?>');">
												<img src="images/print.png" alt="edit" border="0" vspace="0" hspace="0" width="16" height="16" title="Cetak Disposisi"/>
											</a>
										</span>
									</td>
<!--								<td>
										<span style="display:<?php echo $showEditRD; ?>">
											<a href="#" onclick="openRDEdit('<?php echo $row["modeRD"]; ?>','<?php echo $row["GIR_Id"]; ?>');">
												<img src="images/edit.png" alt="edit" border="0" vspace="0" hspace="0" width="16" height="16" />
											</a>
										</span>
									</td>
-->									<td>
										<span style="display:<?php echo $showDeleteRD; ?>">
											<a href="#" onclick="deleteHistory('<?php echo $row["NId"]; ?>','<?php echo $row["GIR_Id"]; ?>');">
												<img src="images/delete.png" alt="edit" border="0" vspace="0" hspace="0" width="16" height="16" title="Batalkan Tindaklanjut Surat" />
											</a>
										</span>
									</td>
								</tr>
								<?php
							}
						?>
					</table>	
				</div>
				<div id="tab4" style=" padding:3px;background-color:#FFFFFF;">
                    <div id="div_ref_list" style="width:100%; display:inline;">
                        <table class="adminlist" style="width:100%;" cellpadding="2" cellspacing="0">
                            <tr>
                                <th style="width:1%;">No</th>
                                <th style="width:5%;">Jenis</th>
                                <th style="width:10%;">Nomor</th>
                                <th style="width:43%;">Hal</th>
                                <th style="width:30%;">Pengirim Surat</th>
                                <th style="width:10%;">Jenis Relasi</th>
                                <th style="width:1%;">&nbsp;</th>
                                <th style="width:1%;">&nbsp;</th>
                            </tr>
							<?php
                                $sql = "select i.NKey, ir.NId, ir.Id_Ref, i.Nomor, i.Hal, 
                                           (case i.Pengirim when 'external' then i.InstansiPengirim  
                                                when 'internal' then (select r.RoleDesc from role r where r.RoleId = i.InstansiPengirim ) end) as InstansiPengirim, 
                                            (case i.Pengirim when 'external' then i.NamaPengirim  
                                                when 'internal' then (select p.PeoplePosition from people p where p.PeopleId = i.NamaPengirim ) end) as NamaPengirim , 
                                            DATE_FORMAT(i.Tgl, '%d/%m/%Y') as Tgl, 
                                            'Surat' as Jenis,
                                            (case ir.Ref_Type when 'reply' then 'Balasan' else 'Referensi' end) as Ref_type 
                                        from inbox_reference ir 
                                        join inbox i on ir.Id_Ref = i.NId 
                                        where ir.Ref_With = 'surat' 
                                            and (ir.NId = '" . $id . "' or ir.Id_Ref = '" . $id . "') 
                                        union
                                        select b.BerkasKey as 'NKey', " . $id . " as 'NId', 
                                            ir.Id_Ref, b.BerkasNumber as 'Nomor', 
                                            b.BerkasName as 'Hal', r.RoleDesc as 'InstansiPengirim',
                                            r.RoleName as 'NamaPengirim',
                                            '' as Tgl,
                                            'Berkas' as Jenis,
                                            (case ir.Ref_Type when 'reply' then 'Balasan' else 'Referensi' end) as Ref_type
                                        from 
                                        inbox_reference ir 
                                        join berkas b on b.BerkasId = ir.Id_Ref 
                                        join role r on r.RoleId = b.RoleId
                                        where ir.Ref_With = 'berkas' 
                                            and ir.NId = '" . $id . "'";
                                $res = mysql_query($sql);
                                $a=0;
                                while($row = mysql_fetch_array($res)){
                                    $a++;
                                    ?>
                                        <tr>
                                            <td><?php echo $a; ?></td>
                                            <td><?php echo $row["Jenis"]; ?></td>
                                            <td><?php echo $row["Nomor"]; ?></td>
                                            <td><?php echo $row["Hal"]; ?></td>
                                            <td><?php echo $row["InstansiPengirim"] . ", " . $row["NamaPengirim"]; ?></td>
                                            <td><?php echo $row["Ref_type"]; ?></td>
                                            <td>
                                                <?php if($row["Jenis"] == "Surat"){ ?>
                                                <a href="#" onclick="openMetadata('detail', '<?php echo $row["Id_Ref"]; ?>')">
                                                    <img src="images/view2.png" />
                                                </a>
                                                <?php }else{ ?>
                                                <a href="index2.php?option=MailInbox&task=viewBerkas&BId=<?php echo $row["Id_Ref"]; ?>" target="_blank" >
                                                    <img src="images/view2.png" />
                                                </a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if($divRef == "inline"){
                                                    ?>
                                                    <a href="#" onclick="delRef('<?php echo $row["NId"]; ?>','<?php echo $row["Id_Ref"]; ?>')">
                                                        <img src="images/delete.png" border="0" />
                                                    </a>
                                                    <?php
                                                    }else {
                                                        echo "&nbsp;";
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                }
                            ?>
                        </table>
                    </div>
					<br />
					<div style="text-align:right; margin:3px;">
						<input type="button" id="btnRef" name="btnRef" style="display:<?php echo $divRef; ?>"
						 	onclick="changeRef('add')" class="art-button" value="Tambah Relasi" />
					</div>
					<div id="div_ref_form" style="width:100%; display:none; float:left;">
						<iframe id="frame_ref" src="window.php?option=MailTL&filetopen=MailTLRef&NId=<?php echo $id; ?>&width=620" 
					 			frameborder="0" scrolling="no" width="100%" height="200"></iframe>
					</div>
				</div>

				<div id="tab5" style=" padding:3px;background-color:#FFFFFF;">
					<iframe id="frmCC" name="frmCC" frameborder="0" scrolling="no" width="100%" style="background-color:#FFFFFF; height:300px; max-height:450px;"
							 src="frame.php?option=MailTL&task=<?php echo $task; ?>&filetopen=MailTLHA&NId=<?php echo $id; ?>&statusBerkas=<?php echo $_SESSION["BerkasStatus"] ?>"></iframe>
					<input type="hidden" name="txtHA" value="<?php echo $HakAkses; ?>" />
					<br />
					<div style="text-align:right; margin:3px;">
						<input type="button" name="btnAddHA" style="display:<?php echo $divRef; ?>"
						 	onclick="openHA('tembusan')" class="art-button" value="Tambah Hak Akses" />&nbsp;
					</div>
				</div>
                
                <div id="tab6" style="padding:3px;background-color:#FFFFFF;">

								<?php
									$getRole = "";
									$sqlRole = "(select
													concat('\'', GROUP_CONCAT(distinct(RoleId_From) ORDER BY RoleId_From ASC SEPARATOR '\', \''), '\'', ','
														'\'', GROUP_CONCAT(distinct(RoleId_To) ORDER BY RoleId_To ASC SEPARATOR '\', \''), '\'') as Role_Id
												from inbox_receiver where NId = '$id') ";

                                    $resB = mysql_query($sqlRole);
									while($rwRow = mysql_fetch_array($resB)){
										$getRole = $rwRow["Role_Id"];
									}
								?>
                
                 	<input type="hidden" id="txtNid" value="<?php echo $id; ?>" />
                	<div id="hal"></div>
                    <br />
                        <input type="button" title="Buat Berkas Baru" value="Buat Berkas Baru" class="art-button" onclick="addBerkas()" />
                    <br />
                    <hr />
                    <div style="font-size:13px; font-style:normal; color:#F00"><strong>Surat sudah diberkaskan di <?php echo $berkasdi; ?></strong></div>
                    <hr />
                    <br />
                    <font color="#990000">Keterangan : <br />- Jika ingin memindahkan berkas, klik pada baris lokasi berkas baru</font>
                    <br />
                    <br />
                        <table class="display" id="example" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="10px">Nomor</th>
                                    <th width="170px">Nomor Berkas</th>
                                    <th width="570px">Nama Berkas</th>
                                    <th width="50px">Retensi Aktif</th>
                                    <th width="50px">Retensi InAktif</th>
                                </tr>
                            </thead>
                    </table>
            	</div>

			</td>
		</tr>
	</table>
</form>
</div>
 <SCRIPT type="text/javascript"> 
  $("#usual ul").idTabs();
</SCRIPT>