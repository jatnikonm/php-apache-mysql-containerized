<?php
	if($task == "new"){
		$checked = 'checked="checked"';
		$data[11] = strftime('%d/%m/%Y', strtotime(date('Y-m-d')));
		$date = date("Y-m-d");
		$newdate = date("d") . "/" . date('m') . "/" . (date("Y") + 30);
		$data[12] = $newdate;
	}
	
	$tabsMenu = 'none';
	$tabsDiv = 'none';
	
	if($task == "edit"){
		$tabsDiv = 'inline';		
		$sql = "select p.PeopleKey, p.PeopleId, p.PeopleName, p.PeoplePosition, p.PeopleUsername, p.PeoplePassword, 
				p.PeopleActiveStartDate,  p.PeopleActiveEndDate, p.PeopleIsActive, p.PrimaryRoleId, p.GroupId, ";
		$sql .= "date_format(p.PeopleActiveStartDate, '%d/%m/%Y') as PeopleActiveStartDate, ";
		$sql .= "date_format(p.PeopleActiveEndDate, '%d/%m/%Y') as PeopleActiveEndDate, ";
		$sql .= "(case p.PeopleIsActive when '1' then 'checked=\"checked\"' else '' end) as PeopleIsActive, r.RoleName, p.RoleAtasan ";
		$sql .= "from people p, role r ";
		$sql .= "where r.RoleId = p.PrimaryRoleId 
				  and p.PeopleKey = '" . $_SESSION["AppKey"] . "' ";
		$sql .= " and p.PeopleId = '$id'";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			for($a=0;$a<mysql_num_fields($result);$a++){
				$data[$a] = $row[$a];
			}
		}
		
		$sql = "select * from inbox_receiver where From_Id = '$id' or To_Id = '$id'";
		$res = mysql_query($sql);
		if(mysql_num_rows($res) > 0){
			$txtName = 'disabled="disabled"';
		}else{
			$txtName = '';
		}
	}
	
?>
<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Pengaturan Pengguna';
</script>
<form name="form1" id="form1" method="post" action="handle.php" target="MyWindowDetail">			
	<table width="670px" cellpadding="0" cellspacing="0" >
		<tr>
			<td>
				<div id="tab1" style="float:left; width:100%;">
					<div style="margin:3px; padding:3px; border-bottom:#666666 1px solid;">
						<span style="color:#000000;">Entry Data Pengguna</span>
						<a href="#" style="display:<?php echo $tabsDiv; ?>; " onclick="openTab('history')" >&nbsp;|&nbsp;Riwayat Pengguna</a>
					</div>
					<table cellspacing="0" cellpadding="3px" width="100%">
						<tr>
							<td align="right" colspan="2" class="indikator">
								<font color="red">*</font> kolom wajib diisi
							</td>
						</tr>
						<tr>
							<td valign="top">
								Unit Kerja <font color="red">*</font>
							</td>
							<td>
								<input type="hidden" name="txt1" value="<?php echo $data[9]; ?>" />
								<input type="hidden" name="txt2" value="<?php echo $data[9]; ?>" />
									<div id="treeUK">
										<?php
											function showUK($dataUK,$parent){
											  if(isset($dataUK[$parent])){ // jika ada anak dari menu maka tampilkan
												/* setiap menu ditampilkan dengan tag <ul> dan apabila nilai $parent bukan 0 maka sembunyikan element 
												 * karena bukan merupakan menu utama melainkan sub menu */
												$str = '<ul>'; 
												foreach($dataUK[$parent] as $value){
												  /* variable $child akan bernilai sebuah string apabila ada sub menu dari masing-masing menu utama
												   * dan akan bernilai negatif apabila tidak ada sub menu */
												  $child = showUK($dataUK,$value->id); 
												  $str .= '<li id="' . $value->AllData . '" ';
												  /* beri tanda sebuah folder dengan warna yang mencolok apabila terdapat sub menu di bawah menu utama 	  	   
												   * dan beri juga event javascript untuk membuka sub menu di dalamnya */
												  $str .= ($child) ? 'class="folder"' : '';
												  $str .= ">" . $value->name;
												  if($child) $str .= $child;
												  $str .= "</li>";
												}
												$str .= '</ul>';
												return $str;
											  }else return false;	  
											}
											
											if($_SESSION["GroupId"] == "1"){
												$parent = 'root';
												$query = "SELECT RoleParentId as parent_id, 
																RoleId as id, 
																RoleDesc as name,
																concat(RoleId, '|', RoleName) as AllData
															  FROM role 
															WHERE RoleId != 'root'
															ORDER BY RoleId,RoleParentId ";
											}else{
												
												$sql = "SELECT RoleParentId 
														FROM role 
														WHERE RoleKey = '" . $_SESSION["AppKey"] . "' 
															and RoleId = '" . $_SESSION["PrimaryRoleId"] . "'";
												$result = mysql_query($sql);
												while($row = mysql_fetch_array($result)){
													$parent = $row['RoleParentId'];
												}
												
												$query = "SELECT RoleParentId as parent_id, 
														RoleId as id, RoleDesc as name,
														concat(RoleId, '|', RoleName) as AllData 
													FROM role 
													WHERE RoleKey = '" . $_SESSION["AppKey"] . "' 
														and RoleId = (select RoleParentId from role r2 where r2.RoleId = '" . $_SESSION["PrimaryRoleId"] . "')
													UNION
													SELECT RoleParentId as parent_id, 
														RoleId as id, 
														RoleDesc as name,
														concat(RoleId, '|', RoleName) as AllData 
													FROM role 
													WHERE RoleKey = '" . $_SESSION["AppKey"] . "'
														and RoleId like '" . $_SESSION["PrimaryRoleId"] . "%' ";
											}
											//echo $query;
											$res = mysql_query($query);
											$dataUK = array();
											while($row = mysql_fetch_object($res)){
											  $dataUK[$row->parent_id][] = $row; // simpan data dari databae ke dalam variable array 3 dimensi di PHP
											}
											echo showUK($dataUK,$parent); // lakukan looping menu utama
										?>
									</div>
								<span id="req1" style="display:none">
									<img src="images/Alert.gif" />
								</span>
							</td>
						</tr>
						<tr>
							<td valign="top">
								Tipe Pengguna <font color="red">*</font>
							</td>
							<td>
								<select name="txt3">
									<option value="">-</option>
									<?php $sql = "select GroupId, GroupName 
												from groups 
												where GroupKey = '" . $_SESSION["AppKey"] . "' ";
										if($_SESSION["GroupId"] != "1"){
											$sql .= "and GroupId > 1";
										}
										$result = mysql_query($sql);
										while($row = mysql_fetch_array($result)){
											echo "<option value='" . $row["GroupId"] . "'";
											if($data[10] == $row["GroupId"]){
												echo "selected";
											}
											echo ">" . $row["GroupName"] . "</option>";
										}
									?>
								</select>
								<span id="req2" style="display:none">
									<img src="images/Alert.gif" />
								</span>
							</td>
						</tr>
                        <tr> 
                            <td valign="top">
                                Jabatan Atasan Langsung<font color="red">*</font>
                            </td>
                            <td>
                                <select name="txt14" style="width:95%;" class="chosen-select form-control">
                                    <option value="">-</option>
                                    <?php 
                                        $sql1 = "select RoleId, RoleParentId, RoleName from role where RoleId not in ('root','uk') and RoleStatus = 1 and gjabatanId != ''";
                                        $sql1 .= " order by gjabatanId ASC";
                                        $result1 = mysql_query($sql1);
                                        while($row1 = mysql_fetch_array($result1)){
                                            echo "<option value='" . $row1["RoleId"] . "'";
                                            if($data[15] == $row1["RoleId"]){
                                                echo "selected";
                                            }
                                            echo ">" . $row1["RoleName"] . "</option>";
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
						<tr>
							<td>
								Nama Lengkap <font color="red">*</font>
							</td>
							<td>
								<input type="text" name="txt4" <?php echo $txtName; ?> value="<?php echo $data[2]; ?>" style="width:80%" />
								<span id="req3" style="display:none">
									<img src="images/Alert.gif" />
								</span>
							</td>
						</tr>
						<tr>
							<td valign="top">
								Nama Jabatan <font color="red">*</font>
							</td>
							<td>
								<input type="text" name="txt5" 
									value="<?php echo $data[3]; ?>" style="width:80%" />
								<span id="req7" style="display:none">
									<img src="images/Alert.gif" />
								</span>
							</td>
						</tr>
						<tr>
							<td valign="top">
								Tanggal Mulai Aktif
							</td>
							<td>
								<input type="text" name="txt6" id="txt6" width="12" 
									value="<?php echo $data[11]; ?>" 
									maxlength="12" style="width:75px;" readonly="readonly" />&nbsp;
								<img src="images/calendar.png" alt="" width="16" height="15" align="absmiddle"  
										id="trigger1" style="cursor: pointer; border: 1px solid #CCCCCC;" title="Date selector" />
							</td>
						</tr>
						<tr>
							<td valign="top">
								Tanggal Akhir Aktif
							</td>
							<td>
							   <input type="text" name="txt7" id="txt7" width="12" 
									value="<?php echo $data[12]; ?>" 
									maxlength="12" style="width:75px;" readonly="readonly" />&nbsp;
								<img src="images/calendar.png" alt="" width="16" height="15" align="absmiddle"  
										id="trigger2" style="cursor: pointer; border: 1px solid #CCCCCC;" title="Date selector" />
							</td>
						</tr>
						<tr>
							<td valign="top">
								Status Aktif</td>
							<td>
								<input type="checkbox" name="txt8" value="1" 
									<?php echo $checked; ?> <?php echo $data[13]; ?> />    
							</td>
						</tr>
						<tr>
							<td colspan="2" valign="top">&nbsp;
								</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:center; vertical-align:middle">
								Digunakan Untuk Login Aplikasi</td>
						</tr>
						<tr>
							<td>
								Login Pengguna <font color="red">*</font>
							</td>
							<td>
								<input type="text" name="txt9" value="<?php echo $data[4]; ?>" style="width:80%" maxlength="35" />
								<input type="hidden" name="txt10" value="<?php echo $data[4]; ?>" />
								<span id="req4" style="display:none">
									<img src="images/Alert.gif" />
								</span>
							</td>
						</tr>
						<tr>
							<td valign="top">
								Kata Sandi <font color="red">*</font>
							</td>
							<td>
								<input type="password" name="txt11" style="width:80%" maxlength="30" />
								<span id="req5" style="display:none" title="Kata Sandi Wajib Diisi !">
									<img src="images/Alert.gif" />
								</span>
							</td>
						</tr>
						<tr>
							<td valign="top">
								Konfirmasi Kata Sandi <font color="red">*</font>
							</td>
							<td>
								<input type="password" name="txt12" style="width:80%" maxlength="30" />
								<span id="req6" style="display:none">
									<img src="images/Alert.gif" />
								</span>
							</td>
						</tr>
						<tr>
							<td colspan="2" valign="top">&nbsp;
								<input type="hidden" name="option" value="AdminPengguna" />
								<input type="hidden" name="task" value="<?php echo $task; ?>" />
								<input type="hidden" name="id" value="<?php echo $id; ?>" />
								<input type="hidden" name="txt13" value="<?php echo $data[14]; ?>" />
								<input type="hidden" name="count" value="15" />
							</td>
						</tr>
						<tr>
							<td valign="top">&nbsp;
								</td>
							<td style="text-align:right;">
								<input type="button" name="btnSimpan" value=" Simpan " onclick="setSave();" class="art-button" /> &nbsp;&nbsp;
								<input type="button" name="btnCancel" value=" Tutup " onclick="parent.respDetails();" class="art-button" />
							</td>
						</tr>
					</table>
				</div>
				<div id="tab2" style="float:left; width:100%; display:<?php echo $tabsMenu; ?>;">
					<div style="margin:3px; padding:3px; border-bottom:#666666 1px solid;">
						<a href="#" onclick="openTab('detail')" style="display:<?php echo $tab1; ?>;">Entry Data Pengguna&nbsp;|&nbsp;</a><span style="color:#000000;">Riwayat Pengguna</span> 
				</div>
					<table class="adminlist" width="100%" cellpadding="3" cellspacing="1">
						<tr>
							<th style="width:1%;">No</th>
							<th style="width:36%;">Jabatan</th>
							<th style="width:38%;">Unit Kerja</th>
							<th style="width:26%;" colspan="2">Periode</th>
						</tr>	
						<?php $a=0;
							$sql = "(select r.RoleId, r.RoleName, r.RoleDesc, 'current' as StartDate, 'current' as EndDate
									  from people p
									  join role r on r.RoleId = p.PrimaryRoleId
									 where PeopleId = '$id')
									 union
									(select r.RoleId, r.RoleName, r.RoleDesc, '' as StartDate, 
										ph.HDate as EndDate
									   from people_history ph
									   join role r on r.RoleId = ph.RoleId
									  where PeopleId = '$id')
									order by EndDate ASC";
									//echo $sql;
							$res = mysql_query($sql);
							while($row = mysql_fetch_array($res)){
								$a++;
								?>
								<tr>
									<td><?php echo $a; ?></td>
									<td><?php echo $row["RoleName"]; ?></td>
									<td><?php echo $row["RoleDesc"]; ?></td>
                                    <td align="center">
									<?php 
										$startDate = "";
										
										if($row["StartDate"] == ''){
											$sqlStart = "select (case when max(HDate) is null then '' else max(HDate) end) as StartDate
														from people_history hh 
														where hh.PeopleId='$id' 
															and hh.HDate < '" . $row["EndDate"] . "'";
											$rsStart = mysql_query($sqlStart);
											while($rw = mysql_fetch_array($rsStart)){
												$startDate = $rw[0];
											}
											mysql_free_result($rsStart);
											
											//---------- if still enpty, then look for at people start
											if($startDate == ""){
												$sqlStart = "select p.PeopleActiveStartDate from people p where p.PeopleId ='$id'";
												$rsStart = mysql_query($sqlStart);
												while($rw = mysql_fetch_array($rsStart)){
													$startDate = $rw[0];
												}
												mysql_free_result($rsStart);
											}											
										}
										
										if($row["StartDate"] == 'current'){
											$sqlStart = "select (case when max(HDate) IS NULL
															 then p.PeopleActiveStartDate
															 else max(HDate) end) as StartDate
														from people p 
														left join people_history hh on p.PeopleId = hh.PeopleId
														where p.PeopleId='$id';";
											$rsStart = mysql_query($sqlStart);
											while($rw = mysql_fetch_array($rsStart)){
												$startDate = $rw[0];
											}
											mysql_free_result($rsStart);
										}
										//echo $sql . "<br />";			
										echo strftime('%d/%m/%Y', strtotime($startDate)); 
									?>
                                    </td>
									<td align="center">
										<?php 
											if($row["EndDate"] != "current"){
												echo strftime('%d/%m/%Y', strtotime($row["EndDate"])); 
											}
											
											if($data[9] == $row["RoleId"]){
												echo "Saat Ini";
											}
										?>
                                     </td>
								</tr>
								<?php 
								}
							mysql_free_result($res);
						?>							
					</table>						
				</div>
			</td>
		</tr>
	</table>
	
	<script language="javascript">
		Calendar.setup(
			{
			  inputField  : "txt6",         // ID of the input field
			  ifFormat    : "%d/%m/%Y",    // the date format
			  button      : "trigger1",       // ID of the button
			  align          :    "Tl",           // alignment (defaults to "Bl")
			  singleClick    :    true
			}
			
		);
		
		Calendar.setup(
			{
			  inputField  : "txt7",         // ID of the input field
			  ifFormat    : "%d/%m/%Y",    // the date format
			  button      : "trigger2",       // ID of the button
			  align          :    "Tl",           // alignment (defaults to "Bl")
			  singleClick    :    true
			}
			
		);
	</script>			
</form>
