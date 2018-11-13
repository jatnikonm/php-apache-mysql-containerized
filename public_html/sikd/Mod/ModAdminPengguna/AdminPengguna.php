<?php
	if(($_SESSION["GroupId"] != "1") && ($_SESSION["GroupId"] != "2")){
		die("<script>location.href='index.php'</script>");
	}
?>
<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Pengaturan Unit Kerja &amp; Pengguna -> Pengguna';
</script>

	<form id="form1" name="form1" method="post" action="handle.php">
		<input type="hidden" name="roleId" value="<?php echo $_REQUEST["roleId"]; ?>" />
		<table width="100%" cellpadding="2">
			<tr>
				<td align="right">
					Pencarian Pengguna : <input type="text" name="txt1" value="<?php echo $_REQUEST["txt1"]; ?>" id="txt1" class="inputbox"  />&nbsp;
					Tipe Pengguna : <select name="txt2">
										<option value="">-</option>
										<?php
											$sql = "select GroupId, GroupName 
													from groups 
													where GroupKey = '" . $_SESSION["AppKey"] . "' ";
											if($_SESSION["GroupId"] != "1"){
												$sql .= "and GroupId > 1";
											}
											$result = mysql_query($sql);
											while($row = mysql_fetch_array($result)){
												echo "<option value='" . $row["GroupId"] . "'";
												if($_REQUEST["txt2"] == $row["GroupId"]){
													echo "selected";
												}
												echo ">" . $row["GroupName"] . "</option>";
											}
										?>
									</select>			
				</td>
			</tr>
			<tr>
				<td style="text-align:right;">
					<input type="button" class="art-button" value="cari" onclick="setSearch();" />
					<input type="button" class="art-button" value="tampilkan semua" onclick="getAll();" />
					<input type="hidden" name="option" value="<?php echo $option; ?>" />
					<input type="hidden" name="task" value="<?php echo $task; ?>" />	
				</td>
			</tr>
		</table> <br /><br />
    <table id="listDocuments" width="100%" cellspacing="0">
        <tr>
            <td class="navrightheader" valign="middle" nowrap="nowrap" style="padding:0.3em">
                &nbsp;
                <span class="navIcon">
                    <input type="button" id="btnTambah" value="Tambah" onclick="openDetails('new','')" class="btn_add" />
                </span>
                <span class="navIcon">
                    <input type="button" id="btnHapus" value="Hapus" onclick="setDelete()" class="btn_del" />
                </span>
                <span><font color="#000000">Unit Kerja :</font>
					<select class="chosen-select form-control" name="pil_uk" id="pil_uk" data-placeholder="Pilih Unit Kerja" onchange="piluk();" >
                          <?php
                              $sql = "SELECT RoleId, RoleDesc FROM role WHERE RoleId !='uk' and RoleId != 'root'";
                              $role = mysql_query($sql);
                              while($fetch=mysql_fetch_array($role)){
                               echo "<option value='" . $fetch["RoleId"] . "'";
								if($_REQUEST['roleId'] == $fetch["RoleId"]){
									echo " selected ";
								}
								echo ">" . $fetch["RoleDesc"] . "</option>";
                                //mysql_free_result($role);
                              }
                           ?>
                    </select>
                </span>
            </td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
	</table>
	<?php
		$sql = "select p.PeopleId, p.PeopleName, r.RoleDesc, p.PeoplePosition, ";
		$sql .= " (CASE p.PeopleIsActive WHEN '1' THEN 'Aktif' ";
		$sql .= " 		WHEN '0' THEN 'Non-Aktif' END) as PeopleIsAktive, p.PeopleUsername ";
		$sql .= "from people p ";
		$sql .= "join role r on r.RoleId = p.PrimaryRoleId ";
		$sql .= "where PeopleKey='" . $_SESSION["AppKey"] . "' and PeopleId > 1 ";
		
		if($_SESSION["GroupId"] > '1'){
			$sql .= " and PrimaryRoleId like '" . $_SESSION["PrimaryRoleId"] . "%' ";
		}
		
		if(clean($_REQUEST["txt1"]) != ''){
			$sql .= " and (PeopleName like '%" . clean($_REQUEST["txt1"]) . "%') ";
		}
		
		if(clean($_REQUEST["txt2"]) != ''){
			$sql .= " and (GroupId like '" . clean($_REQUEST["txt2"]) . "') ";
		}
		
		if(clean($_REQUEST["roleId"] != '')){
			$sql .= " and PrimaryRoleId like '" . $_REQUEST["roleId"] . "%' ";
		}
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
	<table class="adminlist" style="width:100%" cellpadding="2" cellspacing="0" >
		<tr>
			<th style="width:1%">No</th>
			<th style="width:1%"><input type="checkbox" onClick="changeCheckState(this.checked);"></th>
			<th style="width:25%">Nama Lengkap</th>
			<th style="width:20%">Unit Kerja</th>
			<th style="width:25%">Jabatan</th>
			<th style="width:10%">Status</th>	
			<th style="width:10%">Username</th>	
			<th style="width:20%">#</th>
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
				<tr style="background-color:<? echo $bg; ?>">
					<td><?php echo $no; ?></td>
					<td><input type="checkbox" name="ids[]" value="<?php echo $row["PeopleId"]; ?>" /></td>
					<td><?php echo $row["PeopleName"]; ?></td>
					<td><?php echo $row["RoleDesc"]; ?></td>
					<td><?php echo $row["PeoplePosition"]; ?></td>
					<td align="center"><?php echo $row["PeopleIsAktive"]; ?></td>
					<td><?php echo $row["PeopleUsername"]; ?></td>
					<td>
                    	<?php echo "<a href=handle.php?option=AdminPengguna&task=resetpasswd&Pid=$row[PeopleId] onclick=\"return confirm('Apakah Akan Mereset Password Akun Ini ??')\"><img src='images/undo.png' border='0' width='18px' height='18px' title='Reset Password' /></a>"; ?>
                    	<a href="#" onclick="openDetails('edit','<?php echo $row["PeopleId"]; ?>')"><img src="images/edit.png" border="0" title="Ubah Data Pengguna" /></a></td>
				</tr>
				<?php						
			}					
			
		?>
	</table> 
    
	<table style="width:100%" cellpadding="2" cellspacing="0">
		<tr style="background-color:#FFFFFF;"> 
			<td>
				<?php 
					for($i=1;$i<=2;$i++){
						if(clean($_REQUEST["txt" . $i]) != ''){
							$option .= '&txt' . $i . '=' . clean($_REQUEST["txt" . $i]);
						}
					}
					showpagenav('index2.php', $option, $page, $pagecount); 
				?>
			</td>
		</tr>
	</table>

		
	<div style="width:95%; margin-top:25px; padding-left:5px; background-color:#FFFFFF">
		<strong>Keterangan :</strong><br />
		<ul>Penghapusan Data Pengguna tidak dapat dilakukan pada pengguna yang mempunyai riwayat :
			<li>Perubahan Unit Kerja</li>
			<li>Pengguna Pernah Mengirimkan Surat</li>
			<li>Pengguna Pernah Mendapatkan Surat</li>
		</ul>
	</div>
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="delete" />
</form>