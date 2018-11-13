<?php

	$btnHapus = "none";	
	$btnSusut = 'none';
	if(($_SESSION["GroupId"] == "1") || ($_SESSION["GroupId"] == "2") || ($_SESSION["GroupId"] == "3") || ($_SESSION["GroupId"] == "4")){
		$btnHapus = "inline";
	}
	
	if($_SESSION["GroupId"] == "1"){
		$btnSusut = 'inline';
	}
	
?>
<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Pengaturan Klasifikasi &amp; Berkas >> Berkas';
</script>
<form id="form1" name="form1" method="post" action="handle.php">
	<input type="hidden" name="roleId" value="<?php echo $_REQUEST["roleId"]; ?>" />
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
    <input type="hidden" name="task" value="delete" />
	<input type="hidden" name="groupId" value="<?php echo $_SESSION["GroupId"]; ?>" />
	<input type="hidden" name="cond" />
	<input type="hidden" name="id" />
<table id="listDocuments" width="100%" cellspacing="0">
    <tr>
        <td class="navrightheader" valign="middle" nowrap="nowrap">
            &nbsp;
            <span class="navIcon">
                <input type="button" id="btnTambah" value="Tambah" onclick="addBerkas('new','')" class="btn_add" />
            </span>
            <span class="navIcon" style="display:<?php echo $btnHapus; ?>">
            	<input type="button" id="btnHapus" value="Hapus" onclick="setDelete()" class="btn_del" />
            </span>
			<span class="navIcon" style="display:<?php echo $btnSusut; ?>">
            	<input type="button" id="btnSusut" value="Penyusutan Akhir" onclick="setSusut()" class="btn_berkas_susut" />
            </span>
        </td>
    </tr>
	<tr>
		<td class="tb_grid" >
			Pencarian Data &nbsp;&nbsp;<input type="text" name="txt_search" 
			onkeydown="if(event.which || event.keyCode){if ((event.which == 13) || (event.keyCode == 13)) {getSearch();return false;}} else {return false;};" id="txt_search" class="inputbox" style="width:30%" value="<?php echo clean($_REQUEST["keyword"]); ?>" />
				<span id="req_search" style="display:none;" title="Kata Kunci Pencarian Harus Diisi !">
					<img src="images/Alert.gif" border="0" width="14" height="14" />
				</span>
				&nbsp;&nbsp;
				<input type="button" class="art-button" value=" cari " onclick="getSearch()" />
		</td>
	</tr>
    <tr>
        <td style="padding:4px;">
        	<div class="content-main-popup">
            	<?php
            		$sql = "select r.RoleId, r.BerkasId, r.BerkasNumber, r.BerkasName, BerkasStatus, ";
					$sql .= " (case r.BerkasStatus when 'susut' 
									then concat(r.BerkasDesc, '<br />', 'Penyusutan Akhir = <strong>', 
													(select SusutName from master_penyusutan where SusutId = r.SusutId), '</strong>') 
									else r.BerkasDesc end) as BerkasDesc, ";
					$sql .= "    (case when (select count(NId) from inbox i where i.BerkasId = r.BerkasId and i.APId = '1') >= 1 then 'inline' else 'none' end) as show_AP,  ";
					$sql .= "    (case when (select count(NId) from inbox i where i.BerkasId = r.BerkasId and i.KatId = '1') >= 1 then 'inline' else 'none' end) as show_KA,  ";
					$sql .= "    (case when (select count(NId) from inbox i where i.BerkasId = r.BerkasId and i.VitId = '1') >= 1 then 'inline' else 'none' end) as show_TV, ";
					$sql .= "    (case r.BerkasStatus when 'closed' then 'inline' else 'none' end) as show_Lock, ";
					$sql .= "    (case r.BerkasStatus ";
					$sql .= "        when 'open' then (case r.BerkasCountSince when 'created' then (case when (r.RetensiValue_Active < '" . date('Y-m-d') . "') 
														then 'inline' else 'none' end)
					                        	else 'none' end) 
								     when 'closed' then 'none'
									 else 'none'
									end) as show_Alert, ";
					
					$sql .= "    (case r.BerkasStatus
								    when 'susut' then 'inline' 
						           	else 'none' 
									end) as show_Susut, ";
					
					$sql .= "	(case r.BerkasStatus
									when 'susut' then 'disabled' 
									else ";
					switch($_SESSION["GroupId"]){
						case "1":
							$sql .= "'' ";
							break;
						case "2":
						case "3":
							$sql .= "	(case when r.RoleId like concat('" . $_SESSION["PrimaryRoleId"] . "%') 
											then '' 
											else 'disabled' end) ";
							break;
						case "4":
							$sql .= " 'disabled' ";
							break;
						case "5":
							$sql .= "	(case when r.RoleId like concat('" . $_SESSION["PrimaryRoleId"] . "%') 
											then '' 
											else 'disabled' end) ";
							break;
					}
					$sql .= "end) as chk, ";
					
					//for showing is allow for edit, based on StatusBerkas
					$sql .= "(case r.BerkasStatus 
								when 'closed' then 'none' 
								when 'susut' then 'none'
								else ";
					
						if($_SESSION["GroupId"] == "1"){
							$sql .= " 'inline' ";
						}elseif(($_SESSION["GroupId"] == "2") || ($_SESSION["GroupId"] == "3")){
							$sql .= " (case when r.RoleId like concat('" . $_SESSION["PrimaryRoleId"] . "%')
											then 'inline' 
											else 'none' end) ";
						}else{
							$sql .= " 'none' ";
						}
					
					$sql .= " end) as edit, ";
					//----------------------------------------------------------------
					
					//for showing is Allow for do close Berkas
					$sql .= "(case r.BerkasStatus when 'open' 
									then (case r.RoleId when '" . $_SESSION["PrimaryRoleId"] . "' then 'inline' else 'none' end) 
							 	else 'none' end) as showClose, ";
					//----------------------------------------------------------------
					
					$sql .= "    (case r.BerkasStatus 
									when 'closed' then (case when (r.RetensiValue_Active < '" . date('Y-m-d') . "') then 'inline' else 'none' end) 
									when 'open' then 'none' 
									else 'none' end) as show_Inactive, ";
									
					$sql .= "DATE_FORMAT(r.CreationDate,'%d/%m/%Y') as CreationDate  ";
					$sql .= "from berkas r ";
					$sql .= "where BerkasKey = '" . $_SESSION["AppKey"] . "' ";
					$sql .= "    and BerkasId != '1' ";
					
					//echo $sql;
					if($_REQUEST["keyword"] != ''){
						$sql .= " and ( (BerkasNumber like '%" . clean($_REQUEST["keyword"]) . "%') 
										or (BerkasName like '%" . clean($_REQUEST["keyword"]) . "%')
										or (BerkasLokasi like '%" . clean($_REQUEST["keyword"]) . "%')
										or (BerkasDesc like '%" . clean($_REQUEST["keyword"]) . "%')) ";
					}
					
					if($_REQUEST["roleId"] != ""){
						$RoleId = $_REQUEST["roleId"];
					}else{
						if($_SESSION["GroupId"] == '1'){
							$RoleId = 'uk';
						}else{
							$RoleId = $_SESSION["PrimaryRoleId"];
						}
					}
					
					$sql .= "    and RoleId = '" . $RoleId . "' ";
										
					$result = mysql_query($sql);
					$count = mysql_num_rows($result);
					if ($count % $showrecs != 0) {
						$pagecount = intval($count / $showrecs) + 1;
					}else {
						$pagecount = intval($count / $showrecs);
					}
					$startrec = $showrecs * ($page - 1);
					if ($startrec < $count) { mysql_data_seek($result, $startrec);}
					$reccount = min($showrecs * $page, $count);
					
				?>
            	<script type="text/javascript" src="include/ConfirmDelete.js"></script>
            	<table class="adminlist" style="width:100%" >
                	<tr>
                    	<th style="width:1%">#</th>
                    	<th style="width:1%">No</th>
                        <th style="width:8%">Nmr Berkas</th>
                        <th style="width:12%">&nbsp;</th>
                        <th style="width:24%">Nama Berkas</th>
                        <th style="width:40%">Deskripsi</th>
                        <th style="width:12%">Tgl Pembuatan</th>
                        <th style="width:1%">#</th>
						<th style="width:1%">#</th>
                    </tr>
                    <?php
                    	$no = $startrec;
						for ($i = $startrec; $i < $reccount; $i++)
						{
							$no++;
							if($no % 2) { //this means if there is a remainder
								$bg = '#Transparent';
							} else { //if there isn't a remainder we will do the else
								$bg = '#FFFFFF';
							}
							$row = mysql_fetch_assoc($result);	
													
							?>
							<tr style="background-color:<?php echo $bg; ?>">
                                <td><input type="checkbox" name="ids[]" <?php echo $row["chk"]; ?> value="<?php echo $row["BerkasId"]; ?>" /></td>
                                <td><?php echo $no; ?></td>                                
                                <td><?php echo $row["BerkasNumber"]; ?></td>
                                <td>
									<img style="display:<?php echo $row['show_AP'] ;?>;" src="images/flag_blue.png" alt="Akses Publik" width="12" height="12" />
									<img style="display:<?php echo $row['show_KA'] ;?>;" src="images/flag_yellow.png" alt="Kategori Arsip" width="12" height="12" />
									<img style="display:<?php echo $row['show_TV'] ;?>;" src="images/flag_red.png" alt="Tingkat Vital" width="12" height="12" />
									<img style='display:<?php echo $row['show_Inactive'] ;?>;' src="images/flag_gray.png" alt="Status InActive" width="12" height="12" />
									<img style='display:<?php echo $row['show_Alert'] ;?>;' src="images/Alert.gif" alt="Alert" width="12" height="12" />
									<img style='display:<?php echo $row['show_Susut'] ;?>;' src="images/cabkecil.png" alt="Alert" width="14" height="14" />
									<a href="#" style="display:<?php echo $row['show_Lock'] ; ?>;" onclick="openBukaBerkas('<?php echo $row['BerkasId'] ;?>');">
										<img style="display:<?php echo $row['show_Lock'] ;?>; border:0px;" src="images/lock.png" alt="Status Berkas" width="14" height="14" />
									</a>
									<a href="#" style="display:<?php echo $row['showClose'] ; ?>;" onclick="setClose('<?php echo $row['BerkasId'] ;?>');">
										<img style="display:<?php echo $row['showClose'] ;?>; border:0px;" src="images/briefcase.png" alt="Status Berkas" width="14" height="14" />
									</a>
									&nbsp;
                                </td>
                                <td><?php echo $row["BerkasName"]; ?></td>
                                <td><?php echo $row["BerkasDesc"]; ?></td>
                                <td><?php echo $row["CreationDate"]; ?></td>
                                <td>
									<?php if($row["edit"] == 'inline'){ ?>
										<a style="display:<?php echo $row["edit"]; ?>" href="#" title="Ubah" 
												onclick="addBerkas('edit', '<?php echo $row["BerkasId"]; ?>')">   
											<img alt="Ubah" src="images/edit.png" style="border:0px;" title="Ubah Berkas" />
										</a>
									<?php }else{
										echo "&nbsp;";
										}
									 ?>
                                </td>
								<td>
									<a href="index2.php?option=MailInbox&task=viewBerkas&BId=<?php echo $row["BerkasId"]; ?>" title="Lihat Naskah">   
										<img src="images/view2.png" style="border:0px;" alt="Lihat Naskah" />
									</a>
                                </td>
                            </tr>
							<?php		
						}					
						
					?>
                </table>
				<table style="width:100%" cellpadding="2" cellspacing="0" >
					<tr style="background-color:#FFFFFF;"> 
                        <td colspan="8">
							<?php 
								$option = $option;
								
								if($_REQUEST["roleId"] != ""){
									$option .= "&roleId=" . $RoleId;
								}
								
								if($_REQUEST["keyword"] != ""){
									$option .= "&keyword=" . clean($_REQUEST["keyword"]);
								}
								
								showpagenav('index2.php', $option, $page, $pagecount); 
							?>
						</td>
                    </tr>
				</table>
                <div style="width:95%; margin-top:25px; padding-left:5px; background-color:#FFFFFF">
                    <ul style="list-style:none;">
                        <li><img src="images/flag_blue.png" alt="Akses Publik" width="16" height="16" /> Tingkat Akses Publik = Tertutup</li>
                        <li><img src="images/flag_yellow.png" alt="Kategori Arsip" width="16" height="16" /> Kategori Arsip = Terjaga</li>
                        <li><img src="images/flag_red.png" alt="Tingkat Vital" width="16" height="16" /> Tingkat Vital = Vital</li>
						<li><img src="images/briefcase.png" alt="Tutup Berkas" width="16" height="16" /> Klik untuk Menutup Berkas.</li>
                        <li><img src="images/lock.png" alt="Status Berkas" width="16" height="16" /> Status Berkas <strong>Sudah Tertutup</strong> 
							<?php if($_SESSION["GroupId"] == "1"){?>, Klik pada icon tsb untuk Membuka Berkas Kembali.<?php } ?><br /></li>
                        
                        <li><img src="images/flag_gray.png" alt="Status Berkas" width="16" height="16" /> Status Berkas = <strong>InActive</strong></li>
                        <li><img src="images/Alert.gif" alt="Alert" width="16" height="16" /> Status Berkas = <strong>Terbuka dan Melewati Masa Aktif</strong><br /></li>
						
						<li><img src="images/cabkecil.png" align="absmiddle" width="16" height="16" alt="Susut" /> Status Berkas = <strong>Sudah Diproses Tindakan Akhir Penyusutan</strong><br /></li>
						<li><img src="images/view2.png" alt="Lihat Naskah" width="16" height="16" /> Untuk melihat naskah.<br /></li>
						
						<li>Penghapusan Berkas Hanya Aktif Pada :
							<ol>
								<li><strong>Berkas Milik Anda Sendiri</strong></li>
								<li>Jika Anda Sebagai <strong>Group Administrator</strong></li>
								<li>Untuk <strong>Berkas Belum Memiliki Arsip</strong></li>
							</ol>
						</li>
						
                    </ul>
                </div> 
            </div>
        </td>
    </tr>
</table>
</form>