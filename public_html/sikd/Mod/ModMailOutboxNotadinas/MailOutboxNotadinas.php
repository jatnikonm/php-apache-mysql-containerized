<?php 

	$title = "";
	$searchCond = "";
	$searchCond4 = "";
	
	switch($task){
		case "search_list":
			if($_REQUEST["txt1"] == '' and $_REQUEST["txt2"] == '' and $_REQUEST["txt3"] == '' and $_REQUEST["txt4"] == '' and $_REQUEST["txt5"] == ''
				and $_REQUEST["txt6"] == '' and $_REQUEST["txt7"] == ''and $_REQUEST["txt8"] == '' and $_REQUEST["txt9"] == '' and $_REQUEST["txt10"] == '') 
			{
				$title = "Log Registrasi Nota Dinas";	
				$searchCond = "";
				break;
			}
			else 
			{
				$title = "Log Registrasi Nota Dinas";	
				$searchCond = " and rr.RoleId_From = '" . $_SESSION["PrimaryRoleId"] . "' and i.NTipe = 'outboxnotadinas' ";
				break;
			}
		case "list":
			if($_REQUEST["txt1"] == '' and $_REQUEST["txt2"] == '' and $_REQUEST["txt3"] == '' and $_REQUEST["txt4"] == '' and $_REQUEST["txt5"] == ''
				and $_REQUEST["txt6"] == '' and $_REQUEST["txt7"] == ''and $_REQUEST["txt8"] == '' and $_REQUEST["txt9"] == '' and $_REQUEST["txt10"] == '') 
			{
				$title = "Log Registrasi Nota Dinas";	
				$searchCond = " and rr.RoleId_From = '" . $_SESSION["PrimaryRoleId"] . "' and i.NTipe = 'outboxnotadinas' ";
				$searchCond4 = " limit 10 ";				
				break;
			}
			else 
			{
				$title = "Log Registrasi Nota Dinas";	
				$searchCond = " and rr.RoleId_From = '" . $_SESSION["PrimaryRoleId"] . "' and i.NTipe = 'outboxnotadinas' ";
				$searchCond4 = " limit 10 ";				
				break;
			}

	}

	$mode = $task;
	$task = str_replace("search_", "", $task);

?>

<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Log Registrasi Nota Dinas';
</script>
<form name="form1" id="form1" method="post" action="handle.php">
	<table style="width:100%;" cellpadding="2" cellspacing="0">
		<tr>
			<td style="width:49%">
				<table id="listDocuments" width="100%" cellspacing="0">
					<tr>
						<td style="width:35%;">
							Hal
						</td>
						<td>
							<input type="text" name="txt1" class="inputbox" style="width:80%;" value="<?php echo clean($_REQUEST["txt1"]); ?>">
						</td>
					</tr>
					<tr>
						<td>
							Nomor Naskah Unit Kerja
						</td>
						<td>
							<input type="text" name="txt2" class="inputbox" style="width:80%;" value="<?php echo clean($_REQUEST["txt2"]); ?>">
						</td>
					</tr>
						<input type="hidden" name="txt3" class="inputbox" style="width:80%;" value="<?php echo clean($_REQUEST["txt3"]); ?>">
					<tr>
						<td>
							Tgl Naskah
						</td>
						<td>
							<input type="text" name="txt4" id="txt4" class="inputbox" maxlength="10" style="width:70px;"
									 value="<?php echo clean($_REQUEST["txt4"]); ?>">&nbsp;
							<img src="images/calendar.png" alt="" width="16" height="15" align="absmiddle"  
								id="trigger1" style="cursor: pointer; border: 1px solid #CCCCCC;" title="Date selector" /> 
						</td>
					</tr>

				</table>
			</td>
			<td style="width:2%"></td>
			<td style="width:49%">
				<table id="listDocuments" width="100%" cellspacing="0">
					<tr>
						<td>
							Jenis Naskah
						</td>
						<td style="width:50%;">
							<select name="txt5" class="inputbox">
							<?php
								$sql = "(select '' as JenisId, '-' as JenisName from dual) union ";
								$sql .= "(select JenisId, JenisName from master_jnaskah ";
								$sql .= "where JenisId like '" . $_SESSION["AppKey"] . "%' ";
								$sql .= "order by JenisName)";
								$result = mysql_query($sql);
								while($row = mysql_fetch_array($result)){
									echo "<option value='" . $row["JenisId"] . "'";
									if($_REQUEST["txt5"] == $row["JenisId"]){
										echo " selected ";
									}
									echo ">" . $row["JenisName"] . "</option>";
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							Kategori Arsip
						</td>
						<td style="width:50%;">
							<select name="txt6" class="inputbox">
							 <?php
								$sql = "(select '' as KatId, '-' as KatName from dual) union ";
								$sql .= "(select KatId, KatName from master_kategoriarsip ";
								$sql .= "where KatId like '" . $_SESSION["AppKey"] . "%' ";
								$sql .= "order by KatName)";
								$result = mysql_query($sql);
								while($row = mysql_fetch_array($result)){
									echo "<option value='" . $row["KatId"] . "'";
									if($_REQUEST["txt6"] == $row["KatId"]){
										echo " selected ";
									}
									echo ">" . $row["KatName"] . "</option>";
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							Tingkat Akses Publik
						</td>
						<td style="width:50%;">
							<select name="txt7" class="inputbox">
							 <?php
								$sql = "(select '' as APId, '-' as APName from dual) union ";
								$sql .= "(select APId, APName from master_aksespublik ";
								$sql .= "where APId like '" . $_SESSION["AppKey"] . "%' ";
								$sql .= "order by APName)";
								$result = mysql_query($sql);
								while($row = mysql_fetch_array($result)){
									echo "<option value='" . $row["APId"] . "'";
									if($_REQUEST["txt7"] == $row["APId"]){
										echo " selected ";
									}
									echo ">" . $row["APName"] . "</option>";
								}
							?>
							</select>
						</td>
					</tr>	
							<input type="hidden" name="txt8" class="inputbox" style="width:80%;" value="<?php echo clean($_REQUEST["txt8"]); ?>">
					<tr>
					  <td>Periode</td>
					  <td><input type="text" name="txt9" id="txt9" maxlength="10" style="width:70px;" value="<?php echo clean($_REQUEST["txt9"]); ?>"/>&nbsp;
							<img src="images/calendar.png" alt="" width="16" height="15" align="absmiddle"  
								id="trigger2" style="cursor: pointer; border: 1px solid #CCCCCC;" title="Date selector" />	
					    s/d
				        <input type="text" name="txt10" id="txt10" maxlength="10" style="width:70px;" value="<?php echo clean($_REQUEST["txt10"]); ?>" />&nbsp;
							<img src="images/calendar.png" alt="" width="16" height="15" align="absmiddle"  
								id="trigger3" style="cursor: pointer; border: 1px solid #CCCCCC;" title="Date selector" />	</td>
				  	</tr>

				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;
            	 
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<input type="button" class="art-button" value=" Cari Data " onclick="setSearch();">
			</td>
		</tr>
	</table>
    
	<?php  
	
		if($searchCond!=''){
			$sql = "select i.NKey, i.NId, i.Nomor, i.Hal, i.CreationRoleId, i.NTipe,
					i.BerkasId, b.BerkasName, 
					DATE_FORMAT(i.Tgl, '%d/%m/%Y') as Tgl, 
					
					(case ir.To_Id 
						when (p.PeopleId) then p.PeoplePosition 
						else ir.To_Id
					end) as Penerima, 
					
					'" . $_SESSION["SessionID"] . "' as SessionID, 
					'outboxnotadinas' as modeView, 
					i.NIsi, 
					
					(case i.APId when '" . $_SESSION["AppKey"] . ".1' then 'inline' else 'none' end) as show_AP, 
					(case i.KatId when '" . $_SESSION["AppKey"] . ".1' then 'inline' else 'none' end) as show_KA, 
					(case i.VitId when '" . $_SESSION["AppKey"] . ".2' then 'inline' else 'none' end) as show_TV, 
					(case u.UrgensiName
							when 'Segera' then 'inline'
							else 'none'
							end
						) as show_TU,
					
					(case b.BerkasStatus
						  when 'open' then
						   'none'
						  else
						   'inline'
						end) as show_BS, 
					
					(case when (rr.jml > 1) 
							then 'disabled' else '' end) as chk 
			from inbox i 
				left join berkas b on i.BerkasId = b.BerkasId 
				join master_urgensi u on u.UrgensiId = i.UrgensiId
				join (select NId, count(NId) as Jml 
						from inbox_receiver 
						where (RoleId_From = '" .  $_SESSION["PrimaryRoleId"] . "') 
						group by NId) rr on rr.NId = i.NId
				left join (select min(ReceiveDate) as ReceiveDate, 
						To_Id, RoleId_To,
						NId, StatusReceive
						  from inbox_receiver
						 where GIR_Id is not null
						   and RoleId_From = '" .  $_SESSION["PrimaryRoleId"] . "'
						 group by NId) ir on ir.NId = i.NId
				left join people p on p.PeopleId = ir.To_Id 
			where i.NId is not null 
				  and i.NTipe = 'outboxnotadinas' ";
			
		if ($_SESSION["GroupId"] == '1'){
			$sql .= "and (i.CreatedBy in (select PeopleId from people where GroupId = '1') ) ";
		}else{
			$sql .= "and ( NTipe='outboxnotadinas' or i.CreatedBy = '" . $_SESSION["PeopleID"] . "' ) ";
		}
		
		if (($_REQUEST["mode"] == "viewBerkas") && ($_REQUEST["BId"] != "")) {
			$sql .= "and i.BerkasId = '" . $_REQUEST["BId"] . "' ";
		}

		if(clean($_REQUEST["txt9"]) != '' || clean($_REQUEST["txt10"]) != '')
		{			
			$date1=$_REQUEST["txt9"];
			$date2=$_REQUEST["txt10"];
			$sql .= " and i.Tgl between '" . mkdate($date1) . "' and '" . mkdate($date2) . "'";
			
		}
		
		//using for searching if filled
		if(clean($_REQUEST["txt1"]) != ''){
			$sql .= " and i.Hal like '%" . clean($_REQUEST["txt1"]) . "%' ";
		}
		
		if(clean($_REQUEST["txt2"]) != ''){
			$sql .= " and i.Nomor like '%" . clean($_REQUEST["txt2"]) . "%' ";
		}
		
		if(clean($_REQUEST["txt3"]) != ''){
			$sql .= " and (i.NamaPengirim like '%" . clean($_REQUEST["txt3"]) . "%' or ir.From_Id like '%" . clean($_REQUEST["txt3"]) . "%' ) ";
		}
		
		if(clean($_REQUEST["txt4"]) != ''){
			$sql .= " and i.Tgl = '" . mkdate(clean($_REQUEST["txt4"])) . "' ";
		}
		
		if(clean($_REQUEST["txt5"]) != ''){
			$sql .= " and i.JenisId = '" . clean($_REQUEST["txt5"]) . "' ";
		}
		
		if(clean($_REQUEST["txt6"]) != ''){
			$sql .= " and i.KatId = '" . clean($_REQUEST["txt6"]) . "' ";
		}
		
		if(clean($_REQUEST["txt7"]) != ''){
			$sql .= " and i.APId = '" . clean($_REQUEST["txt7"]) . "' ";
		}
		
		if(clean($_REQUEST["txt8"]) != ''){
			$sql .= " and i.NIsi like '%" . clean($_REQUEST["txt8"]) . "%' ";
		}
		
		$sql .= "Group By i.NId";
		$sql .= " order by i.NTglReg DESC ";
	//echo $sql;
	//die($sql);
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
		
		if($_REQUEST["mode"] == "viewBerkas"){
			$btnHapus = 'none;';
			$check = 'disabled';
		}else{
			$btnHapus = ';';
			$check = '';
		}
?>
	<table id="listDocuments" width="100%" cellspacing="0">
		<tr>
			<td class="navrightheader" valign="middle" nowrap="nowrap">
				&nbsp;
				<span class="navIcon" style="display:<?php echo $btnHapus; ?>">
					<input type="button" id="btnHapus" value="Hapus" onclick="setDelete()" class="btn_del" />
				</span>
			</td>
		</tr>
	</table>
	<table class="adminlist" style="width:100%" cellpadding="2" cellspacing="0" >
		<tr>
			<th style="width:1%">No</th>
			<th style="width:1%"><input type="checkbox" <?php echo $check; ?> onClick="changeCheckState(this.checked);"></th>
			<th style="width:22%">Tujuan Naskah</th>
			<th style="width:7%">&nbsp;</th>
			<th style="width:20%">Hal</th>
			<th style="width:10%">Tanggal</th>
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
				<tr style="background-color:<?php echo $bg; ?>;">
					<td><?php echo $no; ?></td>
					<td><input type="checkbox" name="ids[]" <?php echo $row["chk"]; ?> value="<?php echo $row["NId"]; ?>" /></td>
					<td>
						<a href="#" onclick="setDetails('outboxnotadinas','<?php echo $page; ?>','<?php echo $row["NId"]; ?>')">
							<?php echo $row["Penerima"]; ?> 
						</a>
					</td>
					<td>
						<img style="display:<?php echo $row["show_AP"]; ?>;" src="images/flag_blue.png" alt="Akses Publik" width="12" height="12" />
						<img style="display:<?php echo $row["show_KA"]; ?>;" src="images/flag_yellow.png" alt="Kategori Arsip" width="12" height="12" />
						<img style="display:<?php echo $row["show_TU"]; ?>;" src="images/flag_orange.png" alt="Kategori Arsip" width="12" height="12" />
						<img style="display:<?php echo $row["show_TV"]; ?>;" src="images/flag_red.png" alt="Tingkat Vital" width="12" height="12" />
						<img style="display:<?php echo $row["show_BS"]; ?>;" src="images/lock.png" alt="Status Berkas" width="14" height="14" />&nbsp;
					</td>
					<td>
						<a href="#" onclick="setDetails('outboxnotadinas','<?php echo $page; ?>','<?php echo $row["NId"]; ?>')">
							<?php echo $row["Hal"]; ?>
						</a>
					</td>
					<td align="center">
						<a href="#" onclick="setDetails('outboxnotadinas','<?php echo $page; ?>','<?php echo $row["NId"]; ?>')">
							<?php echo $row["Tgl"]; ?>
						</a>
					</td>
				</tr>
				<?php				
			}
		?>
	</table>
	<table style="width:100%" cellpadding="2" cellspacing="0">
		<tr style="background-color:#FFFFFF;"> 
			<td><?php showpagenav('index2.php', $option, $page, $pagecount); ?></td>
		</tr>
	</table>
    <?php 
	}
	?>
    <input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task"value="search_<?php echo $task; ?>" />
	<input type="hidden" name="task2" value="delete" />
	<input type="hidden" name="mode" value="<?php echo $_REQUEST["mode"]; ?>" />
	<div style="width:95%; margin-top:25px; padding-left:5px; background-color:#FFFFFF">
		<ul style="list-style:none;">
			<li><img src="images/flag_blue.png" alt="Akses Publik" width="16" height="16" /> Tingkat Akses Publik = Tertutup</li>
			<li><img src="images/flag_yellow.png" alt="Kategori Arsip" width="16" height="16" /> Kategori Arsip = Terjaga</li>
			<li><img src="images/flag_orange.png" alt="Tingkat Urgensi" width="16" height="16" /> Tingkat Urgensi = Segera</li>
			<li><img src="images/flag_red.png" alt="Tingkat Vital" width="16" height="16" /> Tingkat Vital = Vital</li>
			<li><img src="images/lock.png" alt="Status Berkas" width="16" height="16" /> Status Berkas <strong>Sudah Tertutup</strong></li>
		</ul>		
		<strong>Untuk Penghapusan Naskah</strong>, Hanya untuk Naskah Yang BELUM Memiliki Disposisi atau Balasan. 
		<br />
		<br />
	</div>
	<script language="javascript">
		Calendar.setup(
			{
			  inputField  : "txt4",         // ID of the input field
			  ifFormat    : "%d/%m/%Y",    // the date format
			  button      : "trigger1",       // ID of the button
			  align          :    "Tl",           // alignment (defaults to "Bl")
			  singleClick    :    true
			}
			
		);
		Calendar.setup(
			{
			  inputField  : "txt9",         // ID of the input field
			  ifFormat    : "%d/%m/%Y",    // the date format
			  button      : "trigger2",       // ID of the button
			  align          :    "Tl",           // alignment (defaults to "Bl")
			  singleClick    :    true
			}
			
		);
		Calendar.setup(
			{
			  inputField  : "txt10",         // ID of the input field
			  ifFormat    : "%d/%m/%Y",    // the date format
			  button      : "trigger3",       // ID of the button
			  align          :    "Tl",           // alignment (defaults to "Bl")
			  singleClick    :    true
			}
			
		);
	</script>
</form>
<?php
	function mkdate($str){
		$arrDate = split('/', $str);
		return ($arrDate[2] . '-' . $arrDate[1] . '-' . $arrDate[0]);
	}
?>