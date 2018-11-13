<div class="art-content" style="width:510px;">
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
			<div class="art-Post-inner" style="width:485px;">
				<div class="art-PostMetadataHeader">
					<h2 class="art-PostHeader">
						<img src="images/PostHeaderIcon.png" width="26" height="26" alt="PostHeaderIcon" />
						Data Nomor Agenda Yang Sudah Ada
					</h2>
				</div>
				<div class="art-PostContent" style="width:485px; margin:15px;">
					<form name="form1" id="form1" class="adminForm" method="get" action="window_lookup.php">
						Pencarian Data : <input type="text" name="txt1" style="width:150px;" maxlength="15" value="<?php echo $_REQUEST["txt1"]; ?>" />&nbsp; 
						Tahun : <select name="txt2">
								<?php
									for($a=2009;$a<=date("Y");$a++){
										echo "<option value='$a'";
										if($_REQUEST["txt2"] != ''){
											if($_REQUEST["txt2"] == $a){
												echo " selected ";
											}
										}else{
											if(date("Y") == $a){
												echo " selected ";
											}
										}
										echo ">$a</option>";
									}
								?>
								</select> 
							<input type="submit" class="art-button" value="cari" /> 
							<input type="hidden" name="search" value="true" />
							<input type="hidden" name="Ntipe" value="<?php echo clean($_REQUEST["Ntipe"]); ?>" />
							<input type="hidden" name="option" value="<?php echo $option; ?>" />
					</form>
					
				</div>
				<div class="art-PostContent" style="width:485px;">
					<table class="adminlist" cellspacing="0" width="100%">
						<tr>
							<th style="width:1%;">No</th>
							<th style="width:19%;">Tgl Dibuat</th>
							<th style="width:80%;">Nmr Agenda</th>
						</tr>
					</table>
					<div style=" height:310px; max-height:310px; overflow:scroll">
					<?php
						if($_REQUEST["search"] != ''){
							$sql = "select date_format(NTglReg, '%d/%m/%Y') as NTglReg, NAgenda 
									from inbox 
									where NAgenda is not null 
										and NAgenda != ''
										and NTipe = '" . clean($_REQUEST["Ntipe"]) . "'";
							//echo $sql;
							if(clean($_REQUEST["txt1"]) != ''){
								$sql .= " and NAgenda like '%" . clean($_REQUEST["txt1"]) . "%'";
							}
							if(clean($_REQUEST["txt2"]) != ''){
								$sql .= " and (NAgenda like '%" . clean($_REQUEST["txt2"]) . "%'  or year(NTglReg) = '" . clean($_REQUEST["txt2"]) . "')";
							}else{
								$sql .= " and (NAgenda like '%" . date("Y") . "%' or year(NTglReg) = '" . date("Y") . "')";
							}
						
							$sql .= "	ORDER BY NAgenda, NTglReg DESC";
							$showrecs = 25;
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
					<table class="adminlist" cellspacing="0" width="100%">
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
									<tr style="background-color:<?php echo $bg; ?>">
										<td style="width:1%;"><?php echo $no; ?></td>
										<td style="width:19%; text-align:center;"><?php echo $row["NTglReg"]; ?></td>
										<td style="width:80%;"><?php echo $row["NAgenda"]; ?></td>
									</tr>
								<?php
							}
							mysql_free_result($result);
						}
						?>
					</table></div>
					<div style="width:490px; max-width:490px; overflow:scroll;">
					<table width="100%;" cellpadding="0" cellspacing="0">
						<tr>
							<td>
								<?php 
									$option .= '&search=true&Ntipe=' . $_REQUEST["Ntipe"] . '&txt1=' . clean($_REQUEST["txt1"]) . '&txt2=' . clean($_REQUEST["txt2"]);
									showpagenav('window_lookup.php', $option, $page, $pagecount); 
								?>
							</td>
						</tr>
					</table>
					</div>
					<div style="margin:5px; text-align:right; width:95%">
						<input type="button" name="btnClose" class="art-button" onclick="parent.TINY.box.hide()" value=" Tutup " />
					</div>
				</div>
				<div class="cleared"></div>
			</div>                        
		<div class="cleared"></div>
		</div>
	<div class="cleared"></div>
	</div>
</div>
