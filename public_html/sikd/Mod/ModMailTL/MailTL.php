<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Detail Naskah';
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
        $tab7 = "none";
		
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
						$sp_forward = "inline";
						$sp_usul = "inline";
						$sp_reply = "none";
					}else{
						$sp_reply = "inline";
						
// Jika Ingin Mengaktifkan Teruskan, Hidupkan fungsi $sp_forward
						$sp_forward = "inline";
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

					if ($_SESSION["GroupId"] == "7") { 
						$sp_forward = "none";
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
						
/*			if ($row["BerkasId"] == "1") {	
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
                $tab7 = "none";
				
				$lblBerkas = 'Diberkaskan di ';
				$lblBerkasBtn = 'Berkaskan';
				$trBerkasDesc = "none";
				$trBerkasStatusClosed = "none";
				$divRef = 'none';
			}else{
*/				$tab1 = "inline";
				$tab2 = "inline";
				$tab3 = "inline";
				$tab4 = "inline";
				$tab5 = "inline";
                $tab6 = "inline";
                $tab7 = "inline";
//			}
			
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
                    $tab7 = "inline";
				}else{
					$tab1 = "inline";
					$tab2 = "none";
					$tab3 = "none";
					$tab4 = "none";
					$tab5 = "none";
                    $tab6 = "none";
                    $tab7 = "none";
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
            $tab7 = "inline";
			
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
			$tab7 = "inline";

			$divRef = 'none';
			$gridRef = "none";			
		}
		
		//update if already open/read
		//Diaktifkan jika sekretaris membuka status surat tetap unread
		$sql = "update inbox_receiver 
				set StatusReceive ='read' 
				where NKey='" . $_SESSION["AppKey"] . "' 
					and NId = '$id' 
					and To_Id = '" . $_SESSION["PeopleID"] . "' 
					and RoleId_To='" . $_SESSION["PrimaryRoleId"] . "'";

//		$sql = "update inbox_receiver 
//				set StatusReceive ='read' 
//				where NKey='" . $_SESSION["AppKey"] . "' 
//					and NId = '$id' 
//					and RoleId_To='" . $_SESSION["PrimaryRoleId"] . "'";
					
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
	
		//$sp_tutupBerkas = "none";
			
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
					<input style="cursor:pointer" title="Kembali Ke Halaman Sebelumnya" type="button" name="btnBack" value="<?php echo $allBtn[6]; ?>" class="btn_back" onclick="history.go(-1);" />
				</span>
				<span id="sp_forward" class="navIcon" style="display:<?php echo $sp_forward; ?>;" >
					<input style="cursor:pointer" title="Teruskan Naskah" type="button" name="btnForward" value="<?php echo $allBtn[1]; ?>" class="btn_forward" onclick="openRD1('forward')" />
				</span>
				<span id="sp_reply" class="navIcon" style="display:<?php echo $sp_reply; ?>;" >
					<input style="cursor:pointer" title="Kirim Nota Dinas" type="button" name="btnReply" value="<?php echo $allBtn[0]; ?>" class="btn_reply" onclick="openRD1('reply')" />
				</span>
				<span id="sp_usul" class="navIcon" style="display:<?php echo $sp_usul; ?>;" >
					<input style="cursor:pointer" title="Kirim Nota Dinas" type="button" name="btnUsul" value="<?php echo $allBtn[3]; ?>" class="btn_reply" onclick="openRD1('usul')" />
				</span>
				<span id="sp_disposisi" class="navIcon" style="display:<?php echo $sp_disposisi; ?>;" >
					<input style="cursor:pointer" title="Kirim Disposisi" type="button" name="btnDisposisi" value="<?php echo $allBtn[2]; ?>" class="btn_view" onclick="openRD('disposisi')" />
				</span>
				&nbsp;
				<span id="sp_ubahMeta" class="navIcon" style="display:<?php echo $sp_ubahMeta; ?>;">
					<input style="cursor:pointer" title="Ubah Metadata" type="button" name="btnUbah" value="<?php echo $allBtn[4]; ?>" class="btn_edit" onclick="openMetadata('edit', '');" />
				</span>
                &nbsp;
                <span id="sp_prntDisp" class="navIcon" style="display:<?php echo $sp_prntDisp; ?>;">
					<input style="cursor:pointer" type="button" name="btnCetak" value=" Cetak Disposisi" class="btn_print" onClick="openRDPrint();" />
				</span>
                
                <?php
				$sql2 = mysql_query("select BerkasId from inbox  
									where NKey = '" . $_SESSION["AppKey"] . "' and NId='" . $id . "'");
				$res2 = mysql_fetch_array($sql2);

				if($res2[BerkasId] == '1'){
				?>
                    &nbsp;
                    <center><div id=blinkingtext><font color="red" size="3"><b>Naskah Belum Diberkaskan</b> </font></div></center>
				<?php			
				}
				?>
			</td>
		</tr>
	</table>
	<br />
	<table style="width:100%;" cellpadding="0" cellspacing="0" >
		<tr>
			<td>
				<ul> 
					<li><a href="#tab7" style="display:<?php echo $tab7; ?>">Tindaklanjut Masuk</a></li>
					<li><a href="#tab3" style="display:<?php echo $tab3; ?>">Histori Naskah</a></li>
					<li><a href="#tab1" style="display:<?php echo $tab1; ?>">Metadata</a></li> 
<!--					<li><a href="#tab4" style="display:<?php echo $tab4; ?>">Relasi Surat</a></li>  
					<li><a href="#tab5" style="display:<?php echo $tab5; ?>">Hak Akses</a></li>-->
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
							 (case i.BerkasId when '1' then '' else convert(concat('Nomor Berkas : ', b.Klasifikasi, '/', b.BerkasNumber, ' - Nama Berkas : ', b.BerkasName, ', Pada Unit Kerja : ', rl.RoleDesc), CHAR(250)) end) as BerkasName,
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
								Jenis Naskah 
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
								Tanggal Naskah 
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
                                    Nomor Asal Naskah 
                                </td>
                        	<?php
							}else{
							?>
                                <td>
                                    Nomor Naskah Unit Kerja
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
								Sifat Naskah 
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
				<div id="tab7" style=" padding:3px; background-color:#FFFFFF;">
                
					<span id="sp_final" style="display:<?php echo $sp_final; ?>; margin:10px; width:100%;" >
						<input style="cursor:pointer" title="Upload File Digital Naskah Final" type="button" name="btnFinal" value="<?php echo $allBtn[5]; ?>" class="btn_view_final" onclick="openFinal('new');" />
                        <br /><font color="red">(Dipergunakan untuk mengupload hasil scan naskah yang telah ditandatangani pimpinan dan diberikan nomor naskah)</font>
						<input type="hidden" name="gid_finale" value="<?php echo $GId_Finale; ?>" />
					</span>
					&nbsp;
                    
					<script type="text/javascript" charset="utf-8">
                        $(document).ready(function() {
                            $('#example212').dataTable({
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "bProcessing": true,
                                "bServerSide": true,
                                "aaSorting": [[1, "desc"]],
                                "sAjaxSource": "Mod/ModMailTL/bantai2.php?id=<?php echo "$_GET[id]"; ?>"
                            });
                    
                        } );
                    </script>

                    <table class="display" id="example212" cellspacing="0">
                        <thead>
                            <tr style="height:24px;">
                                <th style="width:1%;">No</th>
                                <th style="width:10%;">Tanggal &amp; Jam</th>
                                <th style="width:30%;">Asal Naskah</th>
                                <th style="width:30%;">Tujuan Naskah</th>
                                <th style="width:10%;">Keterangan</th>
                                <th style="width:10%;">Pesan</th>
                                <th style="width:1%;"></th>
                                <th style="width:1%;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8" class="dataTables_empty">Loading data from server</td>
                            </tr>
                        </tbody>
                    </table>
				</div>
                
				<div id="tab3" style=" padding:3px; background-color:#FFFFFF;">
 
					<script type="text/javascript" charset="utf-8">
                        $(document).ready(function() {
                            $('#example21').dataTable({
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "bProcessing": true,
                                "bServerSide": true,
                                "aaSorting": [[1, "desc"]],
                                "sAjaxSource": "Mod/ModMailTL/bantai1.php?id=<?php echo "$_GET[id]"; ?>"
                            });
                    
                        } );
                    </script>

                    <table class="display" id="example21" cellspacing="0">
                        <thead>
                            <tr style="height:24px;">
                                <th style="width:1px;">No</th>
                                <th style="width:10px;">Tanggal &amp; Jam</th>
                                <th style="width:250px;">Asal Naskah</th>
                                <th style="width:250px;">Tujuan Naskah</th>
                                <th style="width:10px;">Keterangan</th>
                                <th style="width:100px;">Pesan</th>
                                <th style="width:1px;"></th>
                                <th style="width:1px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8" class="dataTables_empty">Loading data from server</td>
                            </tr>
                        </tbody>
                    </table>
				</div>
                
<!--				<div id="tab4" style=" padding:3px;background-color:#FFFFFF;">
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
-->                
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
                        <input style="cursor:pointer" type="button" title="Buat Berkas Baru" value="Buat Berkas Baru" class="art-button" onclick="addBerkas1()" />
                    <br />
                    <hr />
                    <div style="font-size:13px; font-style:normal; color:#F00"><strong>Naskah sudah diberkaskan di <?php echo $berkasdi; ?></strong></div>
                    <hr />
                    <br />
                    <font color="#990000">Keterangan : <br />- Jika ingin memindahkan berkas, klik pada baris lokasi berkas baru</font>
                    <br />
                    <br />
                        <table class="display" id="example" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="10px">Nomor</th>
                                    <th width="50px">Id Berkas</th>
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