<?php
	if($task == "edit"){
		$sql = "select b.*, cl.ClCode,
				Concat(cl.ClId, '|', cl.ClCode, '|', 
						(case cl.RetensiThn_Active when '0' then '' else cl.RetensiThn_Active end) , '|',
						(case cl.RetensiThn_InActive when '0' then '' else cl.RetensiThn_InActive end)) as allData
				from berkas b 
				join classification cl on cl.ClId = b.ClId
				where b.BerkasKey = '" . $_SESSION["AppKey"] . "' 
						and b.BerkasId = '$id'";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			for($a=0;$a<mysql_num_fields($result);$a++){
				$data[$a] = $row[$a];
			}
		}
	}
	
	if($task == "newFix"){
		$data[2] = $_SESSION["PrimaryRoleId"];
	}
	
   	if(($_SESSION["GroupId"] == "2") || ($_SESSION["GroupId"] == "3") || ($_SESSION["GroupId"] == "4") || ($_SESSION["GroupId"] == "5") || ($_SESSION["GroupId"] == "6") || ($_SESSION["GroupId"] == "7")){
		if($task == "new"){
			$data[2] = $_SESSION["PrimaryRoleId"];
		}
	}

	if($task == "edit"){
		$data[2] = $_SESSION["PrimaryRoleId"];
	}
	
?>
<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Entry Berkas';
</script>
<form name="form1" id="form1" method="post" action="handle.php" target="MyWindowDetail">
	<table width="680" cellspacing="0px" border="0" cellpadding="5px" >
		<tr>
			<td align="right" class="indikator">
				<font color="red">*</font> kolom wajib diisi
			</td>
		</tr>
		<tr>
			<td>
				<table cellspacing="2px" cellpadding="3px" width="100%">
					<tr>
						<td style="width:26%;" class="tabel-upload-label" valign="top">
							<br />Unit Kerja <font color="red">*</font>
						</td>
                        <?php
                        if($task == "edit"){
						?>
                            <td style="width:74%;">
                              <!--	<div style="height:120px; width:95%; max-width:420px; overflow:scroll; "> -->
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
                                                  $str .= '<li id="' . $value->id . '" ';
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
                                            
                                           if(($_SESSION["GroupId"] == "2") || ($_SESSION["GroupId"] == "3") || ($_SESSION["GroupId"] == "4") || ($_SESSION["GroupId"] == "5") || ($_SESSION["GroupId"] == "6") || ($_SESSION["GroupId"] == "7")){
                                                $sql = "SELECT RoleParentId 
                                                        FROM role 
                                                        WHERE RoleKey = '" . $_SESSION["AppKey"] . "' 
                                                            and RoleId = '" . $_SESSION["PrimaryRoleId"] . "'";
                                                $result = mysql_query($sql);
                                                while($row = mysql_fetch_array($result)){
                                                    $parent = $row['RoleParentId'];
                                                }
                                                
                                                $sql = "SELECT RoleParentId as parent_id, 
                                                            RoleId as id, RoleDesc as name 
                                                        FROM role 
                                                        WHERE RoleKey = '" . $_SESSION["AppKey"] . "' 
                                                            and RoleId = (select RoleParentId from role r2 where r2.RoleId = '" . $_SESSION["PrimaryRoleId"] . "')
                                                        UNION
                                                        SELECT RoleParentId as parent_id, RoleId as id, RoleDesc as name
                                                          FROM role
                                                         WHERE RoleKey = '" . $_SESSION["AppKey"] . "'
                                                           and RoleId = '" . $_SESSION["PrimaryRoleId"] . "'
                                                        UNION
                                                        SELECT RoleParentId as parent_id, 
                                                            RoleId as id, 
                                                            RoleDesc as name 
                                                        FROM role 
                                                        WHERE RoleKey = '" . $_SESSION["AppKey"] . "'
                                                            and (RoleId = '" . $_SESSION["PrimaryRoleId"] . "')";
                                            }else{
                                                $parent = 'root';
                                                $sql = "SELECT RoleParentId as parent_id, 
                                                            RoleId as id, 
                                                            RoleDesc as name 
                                                        FROM role 
                                                        WHERE RoleKey = '" . $_SESSION["AppKey"] . "'
                                                            and RoleId != 'root'";
                                            }
                                                    
                                            $query = mysql_query($sql);
                                            $dataUK = array();
                                            while($row = mysql_fetch_object($query)){
                                              $dataUK[$row->parent_id][] = $row; // simpan data dari databae ke dalam variable array 3 dimensi di PHP
                                            }
                                            echo showUK($dataUK,$parent); // lakukan looping menu utama
                                        ?>

                                    </div>
                               <!--	</div> -->
                                <span id="req" class="require_field" style="display:none" title="Unit Kerja Harus Dipilih !">
                                    <img src="images/Alert.gif" width="12" height="12" border="0" />
                                </span>
                                <input type="hidden" name="txt1" value="<?php echo $data[2]; ?>" />
                                <input type="hidden" name="txt1_2" value="<?php echo $data[2]; ?>" />
                            </td>
                        <?php
						} else {
						?>	
                            <td style="width:74%;">
                              <!--	<div style="height:120px; width:95%; max-width:420px; overflow:scroll; "> -->
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
                                                  $str .= '<li id="' . $value->id . '" ';
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
                                            
                                           if(($_SESSION["GroupId"] == "2") || ($_SESSION["GroupId"] == "3") || ($_SESSION["GroupId"] == "4") || ($_SESSION["GroupId"] == "5") || ($_SESSION["GroupId"] == "6") || ($_SESSION["GroupId"] == "7")){
                                                $sql = "SELECT RoleParentId 
                                                        FROM role 
                                                        WHERE RoleKey = '" . $_SESSION["AppKey"] . "' 
                                                            and RoleId = '" . $_SESSION["PrimaryRoleId"] . "'";
                                                $result = mysql_query($sql);
                                                while($row = mysql_fetch_array($result)){
                                                    $parent = $row['RoleParentId'];
                                                }
                                                
                                                $sql = "SELECT RoleParentId as parent_id, 
                                                            RoleId as id, RoleDesc as name 
                                                        FROM role 
                                                        WHERE RoleKey = '" . $_SESSION["AppKey"] . "' 
                                                            and RoleId = (select RoleParentId from role r2 where r2.RoleId = '" . $_SESSION["PrimaryRoleId"] . "')
                                                        UNION
                                                        SELECT RoleParentId as parent_id, RoleId as id, RoleDesc as name
                                                          FROM role
                                                         WHERE RoleKey = '" . $_SESSION["AppKey"] . "'
                                                           and RoleId = '" . $_SESSION["PrimaryRoleId"] . "'
                                                        UNION
                                                        SELECT RoleParentId as parent_id, 
                                                            RoleId as id, 
                                                            RoleDesc as name 
                                                        FROM role 
                                                        WHERE RoleKey = '" . $_SESSION["AppKey"] . "'
                                                            and (RoleId = '" . $_SESSION["PrimaryRoleId"] . "')";
                                            }else{
                                                $parent = 'root';
                                                $sql = "SELECT RoleParentId as parent_id, 
                                                            RoleId as id, 
                                                            RoleDesc as name 
                                                        FROM role 
                                                        WHERE RoleKey = '" . $_SESSION["AppKey"] . "'
                                                            and RoleId != 'root'";
                                            }
                                                    
                                            $query = mysql_query($sql);
                                            $dataUK = array();
                                            while($row = mysql_fetch_object($query)){
                                              $dataUK[$row->parent_id][] = $row; // simpan data dari databae ke dalam variable array 3 dimensi di PHP
                                            }
                                            echo showUK($dataUK,$parent); // lakukan looping menu utama
                                        ?>

                                    </div>
                               <!--	</div> -->
                                <span id="req" class="require_field" style="display:none" title="Unit Kerja Harus Dipilih !">
                                    <img src="images/Alert.gif" width="12" height="12" border="0" />
                                </span>
                                <input type="hidden" name="txt1" value="<?php echo $data[2]; ?>" />
                                <input type="hidden" name="txt1_2" value="<?php echo $data[2]; ?>" />
                            </td>
                    	<?php } ?>        
					</tr>
					<tr>
						<td class="tabel-upload-label" valign="top" >
						   <br />	Klasifikasi <font color="red">*</font>
						</td>
						<td>
					   <!--		<div style="height:120px; max-height:120px; width:95%; max-width:420px; overflow:scroll; ">   -->
								<div id="treeCl">
									<?php
										function showCl($dataCl,$parent){
										  if(isset($dataCl[$parent])){ // jika ada anak dari menu maka tampilkan
											/* setiap menu ditampilkan dengan tag <ul> dan apabila nilai $parent bukan 0 maka sembunyikan element
											 * karena bukan merupakan menu utama melainkan sub menu */
											$str = '<ul>'; 
											foreach($dataCl[$parent] as $value){
											  /* variable $child akan bernilai sebuah string apabila ada sub menu dari masing-masing menu utama
											   * dan akan bernilai negatif apabila tidak ada sub menu */
											  $child = showCl($dataCl,$value->id); 
											  $str .= '<li id="' . $value->allData . '" ';
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
										
										$query = mysql_query("SELECT ClId as id,
																	'0' as parent_id,
																	Concat(ClCode, ' - ', ClName) as name,
																	Concat(ClId, '|', ClCode, '|',
																		(case RetensiThn_Active when '0' then '' else RetensiThn_Active end) , '|',
																		(case RetensiThn_InActive when '0' then '' else RetensiThn_InActive end),'|',
                                                                        'SusutId','|',ClParentId) as allData
																FROM classification
																where ClId='1' and  CIStatus='1'
																union
																SELECT c.ClId as id,
																	c.ClParentId as parent_id,
																	Concat(c.ClCode, ' - ', c.ClName) as name,
																	Concat(c.ClId, '|', c.ClCode, '|',
																		(case c.RetensiThn_Active when '0' then '' else c.RetensiThn_Active end) , '|',
																		(case c.RetensiThn_InActive when '0' then '' else c.RetensiThn_InActive end),'|',
                                                                        c.SusutId,'|',c.ClParentId) as allData
															  FROM classification c
															join classification c2 on c.ClParentId = c2.ClId where c.CIStatus = '1'");

                                        $dataCl = array();
										while($row = mysql_fetch_object($query)){
										  $dataCl[$row->parent_id][] = $row; // simpan data dari databae ke dalam variable array 3 dimensi di PHP
										}
										echo showCl($dataCl, '0'); // lakukan looping menu utama
									?>
								</div>
						  <!--	</div>  -->
							<span id="req2" class="require_field" style="display:none" title="Klasifikasi Berkas Harus Dipilih !">
								<img src="images/Alert.gif" width="12" height="12" border="0" />
							</span>
							<input type="hidden" name="txt2" id="txt2" value="<?php echo $data[3]; ?>" />
							<input type="hidden" name="txt2_2" value="<?php echo $data[18]; ?>" />
						</td>
					</tr>
					<tr>
						<td class="tabel-upload-label">
							Nomor Berkas <font color="red">*</font>
						</td>
						<td>
							<input type="text" name="txt3" readonly="readonly" value="<?php echo $data[4]; ?>"
								style="border:0px; min-width:40px; width:15%; " />&nbsp;
							<input type="text" name="txt4" id="txt4" readonly="readonly"
							<?php if($task=="edit") echo "disabled"; ?> value="<?php echo $data[5]; ?>"
								style="border:0px; min-width:40px; width:35%;" maxlength="10" />&nbsp;
							<span id="req3" class="require_field" style="display:none" title="Nomor Berkas Tidak Boleh Kosong !">
								<img src="images/Alert.gif" width="12" height="12" border="0" />
							</span>&nbsp;
						   <!--	<input type="button" id="btnShow"
								 style="background:url(images/view2.png) no-repeat; border:0px; height:18px; width:20px;"
									<?php if($task=="edit") echo "disabled"; ?> onclick="showExisting()" /><br  />
							<small><i>pengisian nomor berkas maksimal 10 digit</i></small> -->
						</td>
					</tr>
					<tr>
						<td class="tabel-upload-label">
							Judul Berkas <font color="red">*</font>
						</td>
						<td>
							<input type="text" name="txt5" value="<?php echo $data[6]; ?>"
								style="border:0px; min-width:40px; width:80%;" maxlength="200" />
							&nbsp;
							<span id="req4" class="require_field" style="display:none" title="Judul Berkas Tidak Boleh Kosong">
								<img src="images/Alert.gif" width="12" height="12" border="0" />
							</span>
						</td>
					</tr>
					<tr>
						<td class="tabel-upload-label">
							Retensi Arsip <font color="red">*</font>
						</td>
						<td style=" vertical-align:middle;">
							<div style="width:90%; float:left;">
								<table width="100%" style="font-size:10px;">
									<tr valign="middle">
										<td valign="middle" colspan="5">Hitung Waktu Retensi Dari : </td>
										<td valign="middle" colspan="7">
											<select name="txt6" onchange="ChooseRetensi(this.value)">
												<?php
													$arrVal = array('created', 'closed');
													$arrTxt = array('Sejak Berkas Dibuat', 'Saat Berkas Ditutup');
													for($a=0;$a<count($arrVal);$a++){
														echo "<option value='$arrVal[$a]'";
														if($data[17] == $arrVal[$a]){
															echo "selected";
														}
														echo ">$arrTxt[$a]</option>";
													}
												?>
											</select>
                                            <span id="req5" class="require_field" style="display:none" title="Harus Dipilih Untuk Penghitungan Awal Waktu Retensi !">
                                                <img src="images/Alert.gif" width="12" height="12" border="0" />
                                            </span>
										</td>
									</tr>
									<tr valign="middle">
										<?php
											if($data[6] == "tgl"){
												$tgl1 = strftime('%d/%m/%Y', strtotime($data[8]));
												$rdTgl1Sp = "";
												$rdTgl1 = 'checked="checked"';
											}else{
												$tgl1_sp = split('/', $data[7]);
												$rdTgl1Sp = 'checked="checked"';
												$rdTgl1 = "";
											}
										?>
										<td valign="middle">
											Aktif
										</td>
										<td valign="middle">
											<input type="radio" name="rentesiAktif" id="rdRetSplit" <?php echo $rdTgl1Sp; ?>
												value="split" onclick="ChooseRadRetensi('active', 'rdRetSplit')" />
										</td>
										<td valign="middle">
											<input type="text" name="thn" width="5" maxlength="2" value="<?php echo $tgl1_sp[0]; ?>" style="width:15px;" />
										</td>
										<td valign="middle">
											Tahun
										</td>
										<td valign="middle">
											<input type="text" name="bln" width="5" maxlength="2" value="<?php echo $tgl1_sp[1]; ?>" style="width:15px;" />
										</td>
										<td valign="middle">
											Bulan
										</td>
										<td valign="middle">
											<input type="text" name="hr" width="5" maxlength="2" value="<?php echo $tgl1_sp[2]; ?>" style="width:15px;" />
										</td>
										<td valign="middle">
											Hari
										</td>
										<td valign="middle">
											&nbsp;/&nbsp;
										</td>
										<td align="right" valign="middle">
											<input type="radio" name="rentesiAktif" id="rdTgl" <?php echo $rdTgl1; ?>
												value="tgl" onclick="ChooseRadRetensi('active', 'tgl')" />
											&nbsp;</td>
										<td valign="middle">
											<input type="text" id="tgl" name="tgl" width="12"
												value="<?php echo $tgl1; ?>"
												maxlength="12" style="width:70px;" readonly="readonly" />
										</td>
										<td valign="middle">&nbsp;
											<img src="images/calendar.png" alt="" width="16" height="15" align="absmiddle"
													id="trigger1" style="cursor: pointer; display:none; border: 1px solid #CCCCCC;" title="Date selector" />
										</td>
									</tr>
									<tr valign="middle">
										<?php
											if($data[8] == "tgl"){
												$tgl2 = strftime('%d/%m/%Y', strtotime($data[10]));
												$rdTgl2Sp = "";
												$rdTgl2 = 'checked="checked"';
											}else{
												$tgl2_sp = split('/', $data[9]);
												$rdTgl2Sp = 'checked="checked"';
												$rdTgl2 = "";
											}
										?>
										<td valign="middle">
											Inaktif
										</td>
									   <td valign="middle">
											<input type="radio" name="rentesiInAktif" id="rdRetSplit2" <?php echo $rdTgl2Sp; ?>
												value="split" onclick="ChooseRadRetensi('inactive', 'rdRetSplit2')" />
										</td>
										<td valign="middle">
											<input type="text" name="thn2" width="5" maxlength="2" value="<?php echo $tgl2_sp[0]; ?>" style="width:15px;" />
										</td>
										<td valign="middle">
											Tahun
										</td>
										<td valign="middle">
											<input type="text" name="bln2" width="5" maxlength="2" value="<?php echo $tgl2_sp[1]; ?>" style="width:15px;" />
										</td>
										<td valign="middle">
											Bulan
										</td>
										<td valign="middle">
											<input type="text" name="hr2" width="5" maxlength="2" value="<?php echo $tgl2_sp[2]; ?>" style="width:15px;" />
										</td>
										<td valign="middle">
											Hari
										</td>
										<td valign="middle">
											&nbsp;/&nbsp;
										</td>
										<td align="right" valign="middle">
											<input type="radio" name="rentesiInAktif" id="rdTgl2" <?php echo $rdTgl2; ?>
											 value="tgl" onclick="ChooseRadRetensi('inactive', 'tgl')" />
											&nbsp;</td>
										<td valign="middle">
											<input type="text" id="tgl2" name="tgl2" width="12" value="<?php echo $tgl2; ?>"
												maxlength="12" style="width:70px;" readonly="readonly" />
										</td>
										<td valign="middle">&nbsp;
											<img src="images/calendar.png" alt="" width="16" height="15" align="absmiddle"  
													id="trigger2" style="cursor: pointer; display:none; border: 1px solid #CCCCCC;" title="Date selector" />
										</td>
									</tr>
								</table>
							</div>
							<div style="width:10%; float:left;">
								<span id="req_number" class="require_field" style="display:none" title="">
									<img src="images/Alert.gif" width="12" height="12" border="0" />
								</span>
							</div>
						</td>
					</tr>
					<tr>
						<td class="tabel-upload-label">
							Tindakan Penyusutan Akhir <font color="red">*</font>
						</td>
						<td>
							<select name="txt7">
								<option value="">-</option>
								<?php
									$sql = "select SusutId, SusutName from master_penyusutan ";
									$sql .= "where SusutId like '" . $_SESSION["AppKey"] . "%' ";
									$sql .= "order by SusutName";
									$result = mysql_query($sql);
									while($row = mysql_fetch_array($result)){
										echo "<option value='" . $row["SusutId"] . "'";
										if($data[11] == $row["SusutId"]){
											echo "selected";
										}
										echo ">" . $row["SusutName"] . "</option>";
									}
								?>
							</select>
							<span id="req6" class="require_field" style="display:none" title="Tindakan Penyusutan Akhir Harus Ditentukan !">
								<img src="images/Alert.gif" width="12" height="12" border="0" />
							</span>
						</td>
					</tr>
					<tr>
						<td class="tabel-upload-label">
							Lokasi Fisik Berkas </td>
						<td>
							<input type="text" name="txt8" value="<?php echo $data[12]; ?>" style="width:80%;" maxlength="250" />
						</td>
					</tr>
					<tr>
						<td class="tabel-upload-label" valign="top">
							Isi Ringkas
						</td>
						<td valign="top">
							<textarea name="txt9" rows="3" style="width:80%"><?php echo $data[13]; ?></textarea>&nbsp;
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
<div style="width:95%;padding:5px; text-align:right;">
	<table cellpadding="0" cellspacing="0" style="width:100%">
		<tr>
			<td style="width:50%;">
				&nbsp;
				<input type="hidden" name="option" value="AdminBerkas" />
				<input type="hidden" name="task" value="<?php echo $task; ?>" />
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<input type="hidden" name="count" value="9" />
			</td>
			<td style="width:50%; text-align:right;">
				<input type="button" name="btnSimpan" value=" Simpan " class="art-button" onclick="setSave();" />&nbsp;&nbsp;
				<input type="button" name="btnKeluar" value=" Tutup " class="art-button" onclick="parent.closeWindow();" />
			</td>
		</tr>
	</table>
</div>
<script language="javascript">
	Calendar.setup(
		{
		  inputField  : "tgl",         // ID of the input field
		  ifFormat    : "%d/%m/%Y",    // the date format
		  button      : "trigger1",       // ID of the button
		  align          :    "Tl",           // alignment (defaults to "Bl")
		  singleClick    :    true
		}
		
	);
	
	Calendar.setup(
		{
		  inputField  : "tgl2",         // ID of the input field
		  ifFormat    : "%d/%m/%Y",    // the date format
		  button      : "trigger2",       // ID of the button
		  align          :    "Tl",           // alignment (defaults to "Bl")
		  singleClick    :    true
		}
		
	);
</script>
</form>