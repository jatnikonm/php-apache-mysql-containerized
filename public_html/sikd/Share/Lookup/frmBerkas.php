<?php
	$ClId = $_REQUEST["ClId"];
	$txtSearch = clean($_REQUEST["txtSearch"]);
	$sql = "select b.BerkasNumber, b.BerkasName, r.RoleDesc 
			from berkas b 
			join role r on r.RoleId = b.RoleId
			where b.BerkasNumber != '0' 
				and b.ClId = '" . $ClId . "' " ;
	if ($txtSearch != ''){
		$sql .= " and (b.BerkasNumber like '%" . $txtSearch . "%' 
					or b.BerkasName like '%" . $txtSearch . "%' 
					or r.RoleDesc like '%" . $txtSearch . "%' )";
	}				
	$sql .= " ORDER BY b.BerkasNumber DESC";
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);
	if ($count % $showrecs != 0) {
		$pagecount = intval($count / $showrecs) + 1;
	}else {
		$pagecount = intval($count / $showrecs);
	}
	$showrecs = 5;
	$startrec = $showrecs * ($page - 1);
	if ($startrec < $count) { mysql_data_seek($result, $startrec);}
	$reccount = min($showrecs * $page, $count);
?>
<div class="art-content" style="width:610px;">
	<div class="art-Post">
		<div class="art-Post-tl"></div>
		<div class="art-Post-tr"></div>
		<div class="art-Post-bl"></div>
		<div class="art-Post-br"></div>
		<div class="art-Post-tc"></div>
		<div class="art-Post-bc"></div>
		<div class="art-Post-cl"></div>
		<div class="art-Post-cr"></div>
		<div class="art-Post-cc"></div>
		<div class="art-Post-body">
			<div class="art-Post-inner" style="width:585px; max-width:585px;">
				<div class="art-PostMetadataHeader">
					<h2 class="art-PostHeader">
						<img src="images/PostHeaderIcon.png" width="26" height="26" alt="PostHeaderIcon" />
						Data Berkas Yang Sudah Ada
					</h2>
				</div>
				<div class="art-PostContent" style="width:585px; max-width:585px;">
					<p>
						<form id="form1" name="form1" method="get" action="window_lookup.php">
							<table class="adminform" width="100%">
								<tr>
									<td style="width:10%;">Cari Data </td>
									<td style="width:75%;"><input type="text" id="txtSearch" name="txtSearch" style="width:80%;" /></td>
									<td style="width:15%;"><input type="submit" name="btnCari" class="art-button" value=" Cari " /></td>
								</tr>
							</table>
							<input type="hidden" name="option" value="Berkas" />
							<input type="hidden" name="ClId" value="<?php echo $_REQUEST["ClId"]; ?>" />
						</form>			
						<table class="adminlist" width="100%">
							<tr>
								<th style="width:1%;">No</th>
								<th style="width:20%;">Nomor</th>
								<th style="width:39%;">Nama Berkas</th>
								<th style="width:41%;">Unit Kerja</th>
							</tr>
							<?php
								$no = $startrec;
								for ($i = $startrec; $i < $reccount; $i++)
								{
									$no++;
									if($no % 2) { //this means if there is a remainder
										$bg = 'Transparent';
									} else { //if there isn't a remainder we will do the else
										$bg = '#FFFFFF';
									}
									$row = mysql_fetch_assoc($result);
									?>
										<tr style="background-color:<? echo $bg; ?>">
											<td><?php echo $no; ?></td>
											<td><?php echo $row["BerkasNumber"]; ?></td>
											<td><?php echo $row["BerkasName"]; ?></td>
											<td><?php echo $row["RoleDesc"]; ?></td>
										</tr>
									<?php
								}
								mysql_free_result($result);
							?>
						</table>
						<table width="90%;" cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<?php
										$option .= '&ClId=' . $ClId;
										$option .= '&txtSearch=' . $txtSearch;
										showpagenav('window_lookup.php', $option, $page, $pagecount); 
									?>
								</td>
							</tr>
						</table>
						<div style="margin:10px; text-align:right; width:95%">
							<input type="button" name="btnClose" class="art-button" onclick="parent.addBerkas();" value=" Tutup " />
						</div>
					</p>
				</div>
				<div class="cleared"></div>
			</div>                        
		<div class="cleared"></div>
		</div>
	<div class="cleared"></div>
	</div>
</div>
