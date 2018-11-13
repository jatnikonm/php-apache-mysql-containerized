<?php

	$sql2 = mysql_query("select NAgenda from inbox where CreationRoleId = '" . $_SESSION["PrimaryRoleId"] . "' and NAgenda != '' order by NTglReg desc limit 1");
	$res2 = mysql_fetch_array($sql2);

	if($task == "new"){
		switch($_REQUEST["mode"]){
			case "outbox":
				$title = 'Registrasi Nota Dinas';
				$lookup = "upper";
				break;

			case "outboxmemo":
				$title = 'Registrasi Memo';
				$lookup = "upper";
				break;

			case "outboxnotadinas":
				$title = 'Registrasi Nota Dinas';
				$lookup = "upper";
				break;
				
			case "inbox":
				$title = 'Registrasi Naskah Masuk';
				$lookup = "lower";
				break;

			case "outboxins":
				$title = 'Registrasi Naskah Keluar';
				$lookup = "upper";
				break;
				
			case "inboxuk":
				$title = 'Registrasi Naskah Tanpa Tindaklanjut';
				$lookup = "lower";
				$viewPenerima = "none";
				break;
		}
		$btn = "inline";
		//$viewPenerima = "table-row";
		//$viewPengirim = "";
		$viewFile = "table-row";
		if($_SESSION["data_3"] == ""){
			$_SESSION["data_3"] = strftime('%d/%m/%Y', strtotime(date('Y-m-d')));
		}
		if($_SESSION["data_19"] == ""){
			$_SESSION["data_19"] = $_SESSION["AppKey"] . ".2";
		}
		$target = '_self';
		$btn_val = 'Proses Selanjutnya';
		$urlClose = "location.href='index2.php';";
		
		$tglReg = strftime('%d/%m/%Y', strtotime(date('Y-m-d')));
		$petugas = $_SESSION["PName"];
		
	}
	elseif($task == "step2"){
		$title = 'Registrasi Naskah - (Sisipkan File Digital)';
	}elseif($task == "edit" || $task == "detail" ||$task == "inboxuk" ||$task == "outboxmemo" ||$task == "outboxnotadinas" || $task == "outboxins"){
		$viewPenerima = "none";
		$viewPengirim = "none";
		$berkas = "none";
		$viewFile = "none";
		$viewRef = "none";
		
		switch($task){
			case "edit":
				$title = "Ubah Metadata";
				$btn = "inline";
				break;
			case "detail":
				$title = "Metadata";
				$btn = "none";
		}
		
		$id = $_REQUEST["NId"];		
		$sql = "select NId, JenisId, TPId, 
				DATE_FORMAT(Tgl, '%d/%m/%Y') as Tgl, 				
				Nomor, Hal, UrgensiId, SifatId, KatId, APId, 
				i.NTglReg as Col1, p.PeopleName as Col2, '' as Col3, '' as Col4, '' as Col6, '' as Col7,
				MediaId, LangId, NIsi, VitId, 
				NJml, MeasureId, NLokasi, '' as Col8, '' as Col9, '' as Col10, '' as Col11, '' as Col12, NAgenda
				from inbox i, people p  
				where i.CreatedBy = p.PeopleId
					AND NId = '$id'";
		$res = mysql_query($sql);
		while($row = mysql_fetch_array($res)){
			for($i=1;$i<=mysql_num_fields($res);$i++){
				$_SESSION["data_" . $i] = $row[$i];
			}
		}
		mysql_free_result($res);
		
		$target = 'MyWindowDetail';
		$btn_val = 'Simpan';
		$urlClose = "parent.closeWindow();";
		
		$tglReg = $_SESSION["data_10"];
		$petugas = $_SESSION["data_11"];
	} 
	
	?>
	
	<script type="text/javascript">
		document.getElementById("title").innerHTML = '<?php echo $title; ?>';
	</script>
		 
 <?php if($task == "new"){ ?>
	<form name="form1" id="form1" autocomplete="off" method="post" action="handle.php" enctype="multipart/form-data" target="<?php echo $target; ?>">
    	<table cellspacing="2" cellpadding="2" style="width:100%">
	
            <input type="hidden" name="modeRD" value="disposisi" />
            <input type="hidden" name="lookup" value="<?php echo $lookup; ?>" />   
            
            <tr>
                <td style="width:25%;">
                    Tanggal Registrasi                </td>
                <td style="width:65%;">
                    <?php echo $tglReg; ?>                </td>
            </tr>
            
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            
            <tr>
                <td>
                    Jenis Naskah 
                </td>
                <td>
                    <select name="txt1" class="inputbox">
                        <?php
                            $sql = "select JenisId, JenisName from master_jnaskah ";
                            $sql .= "order by JenisName";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                echo "<option value='" . $row["JenisId"] . "'";
								if($_SESSION["data_1"] == $row["JenisId"]){
									echo " selected ";
								}
								echo ">" . $row["JenisName"] . "</option>";
                            }
							mysql_free_result($result);
                        ?>
                    </select>
               </td>     
					<span id="req1" class="req_field" style="display:none;" title="Jenis Naskah Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
        </tr>

<!--            <tr>
                <td>
                    Tingkat Perkembangan <font color="red">*</font>                </td>
                <td>
-->                     <select name="txt2" class="inputbox" style="visibility:hidden">
                        <?php
                            $sql = "select TPId, TPName from master_tperkembangan ";
                            $sql .= "where TPName = 'Asli' ";
                            $sql .= "order by TPName";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                echo "<option value='" . $row["TPId"] . "'";
								if($_SESSION["data_2"] == $row["TPId"]){
									echo " selected ";
								}
								echo ">" . $row["TPName"] . "</option>";
                            }
							mysql_free_result($result);
                        ?>
                    </select>
<!--					<span id="req2" class="req_field" style="display:none;" title="Tingkat Perkembangan Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>
-->
           <tr>
                <td>
                    Tanggal Naskah <font color="red">*</font>                </td>
                <td valign="middle">
                    <input type="text" name="txt3" id="txt3" maxlength="12" 
						style="width:75px;" value="<?php echo $_SESSION["data_3"]; ?>" class="inputbox" readonly="true" />
					<img src="images/calendar.png" alt="" width="16" height="15" align="absmiddle"  
						id="trigger1" style="cursor: pointer; border: 1px solid #CCCCCC;" title="Date selector" /> 
					<span id="req3" class="req_field" style="display:none;" title="Tanggal Naskah Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>

            <tr>
            
                <?php
                if(($_REQUEST["mode"] == 'inbox') || ($_SESSION["data_23"] == 'inbox')){
				?>
                    <td>
                        Nomor Asal Naskah <font color="red">*</font>                </td>
                    <td>
             	<?php    
				}elseif(($_REQUEST["mode"] == 'inboxuk') || ($_SESSION["data_23"] == 'inboxuk')){
				?>
                    <td>
                        Nomor Naskah <font color="red">*</font>                </td>
                    <td>
             	<?php    
				}else{
				?>	
                    <td>
                        Nomor Naskah Unit Kerja <font color="red">*</font>                </td>
                    <td>
             	<?php    
				}
				?>	

                    <input type="text" name="txt4" value="<?php echo $_SESSION["data_4"]; ?>" style="width:50%;" maxlength="100" class="inputbox" />&nbsp;
					<span id="req4" class="req_field" style="display:none;" title="Nomor Naskah Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>

			<tr>
                <td valign="top">
                    Nomor Agenda                </td>
                <td>
                    <input type="text" name="txt28" value="<?php echo $_SESSION["data_28"]; ?>" style="width:50%;" maxlength="150" class="inputbox" placeholder="Diisi jika menggunakan buku agenda" />&nbsp; 
					<input type="button" style="background: url(images/view2.png) no-repeat; border:0px; width:20px;height:18px;" onclick="openAgenda();" /><br />
					<font color="#FF0000">Nomor Agenda Terakhir adalah :  <?php echo $res2["0"]; ?> </font><br />              
					<small><i>Pengisian No. Agenda harus mencantumkan Tahun, contoh : <strong>001/xx/<?php echo date("Y"); ?></strong></i></small>                </td>
            </tr>

            <tr>
                <td>
                    Hal <font color="red">*</font>                </td>
                <td>
                    <input type="text" name="txt5" value="<?php echo $_SESSION["data_5"]; ?>" style="width:80%" maxlength="250" class="inputbox" />&nbsp;
					<span id="req5" class="req_field" style="display:none;" title="Hal Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>

                <?php
                if(($_REQUEST["mode"] == 'inbox') || ($_SESSION["data_23"] == 'inbox') || ($_REQUEST["mode"] == 'inboxuk') || ($_SESSION["data_23"] == 'inboxuk')){
				?>
						<tr>
							<td>
								Asal Naskah <font color="red">*</font>                </td>
							<td>
								 <input type="text" name="txt10" class="inputbox" style="width:80%" value="<?php echo $data[10]; ?>"	<?php echo $pengirim; ?> maxlength="80" />&nbsp;
									<span id="req10" class="req_field" style="display:none;" title="Asal Naskah Wajib Diisi !">
													<img src="images/Alert.gif" height="12" width="12" />
												  </span>
						   </td>
						</tr>
             	<?php    
				}else if(($_REQUEST["mode"] == 'outboxins') || ($_SESSION["data_23"] == 'outboxins')){
				?>	
						<tr>
							<td>
								Tujuan Naskah Keluar <font color="red">*</font>                </td>
							<td>
								 <input type="text" name="txt10" class="inputbox" style="width:80%" value="<?php echo $data[10]; ?>"	<?php echo $pengirim; ?> maxlength="80" />&nbsp;
									<span id="req10" class="req_field" style="display:none;" title="Asal Naskah Wajib Diisi !">
													<img src="images/Alert.gif" height="12" width="12" />
												  </span>
						   </td>
						</tr>
             	<?php    
				}else{
				?>	
								 <input type="hidden" name="txt10" class="inputbox" style="width:80%" value="-" maxlength="80" />&nbsp;
									<span id="req10" class="req_field" style="display:none;" title="Asal Naskah Wajib Diisi !">
													<img src="images/Alert.gif" height="12" width="12" />
												  </span>
             	<?php           
				}					
				?>

<!--            <tr>
                <td>
                    Tingkat Urgensi <font color="red">*</font>               </td>
                <td>
-->                    <select name="txt6" class="inputbox" style="visibility:hidden">
                        <?php
                            $sql = "select UrgensiId, UrgensiName from master_urgensi ";
                            $sql .= "where UrgensiName = 'Biasa' ";
                            $sql .= "order by UrgensiName desc";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                echo "<option value='" . $row["UrgensiId"] . "'";
								if($_SESSION["data_6"] == $row["UrgensiId"]){
									echo " selected ";
								}
								echo ">" . $row["UrgensiName"] . "</option>";
                            }
							mysql_free_result($result);
                        ?>
                    </select>                <!--</td>
            </tr>-->

<!--            <tr>
                <td>
                    Sifat Naskah <font color="red">*</font>                </td>
                <td>
-->                    <select name="txt7" class="inputbox" style="visibility:hidden">
                        <?php
                            $sql = "select SifatId, SifatName from master_sifat ";
                            $sql .= "where SifatName = 'Biasa' ";
                            $sql .= "order by SifatName";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                echo "<option value='" . $row["SifatId"] . "'";
								if($_SESSION["data_7"] == $row["SifatId"]){
									echo " selected ";
								}
								echo ">" . $row["SifatName"] . "</option>";
                            }
							mysql_free_result($result);
                        ?>
                    </select>
<!--					<span id="req7" class="req_field" style="display:none;" title="Sifat Naskah Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
-->            </tr>

<!--            <tr>
                <td>
                    Kategori Arsip <font color="red">*</font>                </td>
                <td>
-->                    <select name="txt8" class="inputbox" style="visibility:hidden">
                        <?php
                            $sql = "select KatId, KatName from master_kategoriarsip ";
                            $sql .= "where KatName =  'Umum' ";
                            $sql .= "order by KatName desc";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                echo "<option value='" . $row["KatId"] . "'";
								if($_SESSION["data_8"] == $row["KatId"]){
									echo " selected ";
								}
								echo ">" . $row["KatName"] . "</option>";
                            }
							mysql_free_result($result);
                        ?>
                    </select>
<!--					<span id="req8" class="req_field" style="display:none;" title="Kategori Arsip Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>
--> 
<!--           <tr>
                <td>
                    Tingkat Akses Publik <font color="red">*</font></td>
                <td>
-->                     <select name="txt9" class="inputbox" style="visibility:hidden">
                        <?php
                            $sql = "select APId, APName from master_aksespublik ";
                            $sql .= "where APName = 'Terbuka' ";
                            $sql .= "order by APName";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                echo "<option value='" . $row["APId"] . "'";
								if($_SESSION["data_9"] == $row["APId"]){
									echo " selected ";
								}
								echo ">" . $row["APName"] . "</option>";
                            }
							mysql_free_result($result);
                        ?>
                    </select>
<!--					<span id="req9" class="req_field" style="display:none;" title="Tingkat Akses Publik Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>
-->
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>

            <tr>
            	<td colspan="2">
<!--				<div id="pnlRef" style="display:<?php echo $viewRef; ?>;">
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td style="width:25%;">
								Referensi Balasan Naskah							</td>
							<td style="width:65%;"> -->
								<input type="hidden" name="txt24" class="inputbox" style="width:70%" maxlength="80" />&nbsp;
<!--								<input type="button" style="background:url(images/view2.png) no-repeat;border:0px;
													background-position:left; width:20px;" onclick="openRef()" />
-->								<input type="hidden" name="txt25" />
								<input type="hidden" name="txt26" />
								<input type="hidden" name="txt27" />							<!--</td>
						</tr>
					</table>
				</div>-->
                <?php
                	if(($_REQUEST["mode"] == 'inbox') || ($_SESSION["data_23"] == 'inbox')){
						$uk = 'Instansi';
						$pengirim = '';
						$berkas = 'inline';
						if($_SESSION["data_23"] != ""){
							$data[10] = $_SESSION["data_10"];
							$data[11] = $_SESSION["data_11"];
							$data[12] = $_SESSION["data_12"];
						}
					}else if(($_REQUEST["mode"] == 'outbox') || ($_SESSION["data_23"] == 'outbox')){
						$uk = 'Unit Kerja';
						$pengirim = 'readonly="readonly"';
						$berkas = 'inline';
						if($_SESSION["data_23"] == ""){
							$data[10] = $_SESSION["NamaBagian"];
							$data[11] = $_SESSION["PName"];
							$data[12] = $_SESSION["NamaJabatan"];
						}else{
							$data[10] = $_SESSION["data_10"];
							$data[11] = $_SESSION["data_11"];
							$data[12] = $_SESSION["data_12"];
						}		
					}else if(($_REQUEST["mode"] == 'outboxins') || ($_SESSION["data_23"] == 'outboxins')){
						$uk = 'Unit Kerja';
						$pengirim = 'readonly="readonly"';
						$berkas = 'inline';
						if($_SESSION["data_23"] == ""){
							$data[10] = $_SESSION["NamaBagian"];
							$data[11] = $_SESSION["PName"];
							$data[12] = $_SESSION["NamaJabatan"];
						}else{
							$data[10] = $_SESSION["data_10"];
							$data[11] = $_SESSION["data_11"];
							$data[12] = $_SESSION["data_12"];
						}	
					}else if(($_REQUEST["mode"] == 'outboxmemo') || ($_SESSION["data_23"] == 'outboxmemo')){
						$uk = 'Unit Kerja';
						$pengirim = 'readonly="readonly"';
						$berkas = 'inline';
						if($_SESSION["data_23"] == ""){
							$data[10] = $_SESSION["NamaBagian"];
							$data[11] = $_SESSION["PName"];
							$data[12] = $_SESSION["NamaJabatan"];
						}else{
							$data[10] = $_SESSION["data_10"];
							$data[11] = $_SESSION["data_11"];
							$data[12] = $_SESSION["data_12"];
						}		
					}else if(($_REQUEST["mode"] == 'inboxuk') || ($_SESSION["data_23"] == 'inboxuk')){
						$uk = 'Instansi / Unit Kerja';
						$pengirim = '';
						$berkas = 'inline';
						$_SESSION["data_14"] = $_SESSION["PeopleID"] . ",";
					}

				?>
<!--                	<div id="pnlPengirim" style="display:<?php echo $viewPengirim; ?>">
                    	<table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td colspan="2" align="center" valign="middle">
                                    <div style="text-align:center; padding:10px;">Pengirim Naskah</div>                                </td>
                            </tr>
                            <tr>
                                <td style="width:25%;">
                                    <?php echo $uk; ?> Pengirim <font color="red">*</font></td>
                                <td style="width:65%;">
                                 <input type="hidden" name="txt10" class="inputbox" style="width:80%"
                                     value="<?php //echo $data[10]; ?>"	<?php echo $pengirim; ?> maxlength="80" />&nbsp;
<!--									 <span id="req10" class="req_field" style="display:none;" title="<?php echo $uk; ?> Wajib Diisi !">
										<img src="images/Alert.gif" height="12" width="12" />
                                      </span>
                                 </td>
                            </tr>
                            <tr>
                                <td>
                                    Nama Pengirim <font color="red">*</font></td>
                                <td>-->
                                    <input type="hidden" name="txt11" class="inputbox" style="width:80%" 
									 value="<?php echo $data[11]; ?>" <?php echo $pengirim; ?> maxlength="80" />&nbsp;
<!--									 <span id="req11" class="req_field" style="display:none;" title="Nama Pengirim Wajib Diisi !">
										<img src="images/Alert.gif" height="12" width="12" />
                                     </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Jabatan Pengirim</td>
                                <td>
-->                                    <input type="hidden" name="txt12" class="inputbox" style="width:80%"
									 value="<?php echo $data[12]; ?>" <?php echo $pengirim; ?> maxlength="150" />&nbsp;                                </td>
<!--                            </tr>
                        </table>
                    </div>
-->                   <div id="pnlBerkas" style="display:<?php echo $berkas; ?>;">
                    	<table width="100%" cellpadding="0" cellspacing="0">
                             <tr>
                                <?php
                					if($_REQUEST["mode"] == 'inbox'){
								?>
                                    <td style="width:25%;">
                                        Berkaskan                                 
                                    </td>
                                <?php
									}else{
								?>
                                    <td style="width:25%;">
                                        Berkaskan <font color="red">*</font>                                
                                    </td>
                                <?php
									}
								?>
                                <td style="width:65%;">
                                    <input type="hidden" id="txt13" name="txt13" value="<?php echo $_SESSION["data_13"]; ?>" />
                                    <input type="text" value="<?php echo $_SESSION["txt_berkas"]; ?>" class="inputbox" style="width:40%;" id="txt_berkas" name="txt_berkas" />
                                    <input type="button" id="btnBerkas" 
									 style="background-image:url(images/view2.png); background-repeat:no-repeat; background-color:Transparent; width:20px; border:0px;"
									 onclick="openBerkas();" />&nbsp;
									 <input title="Buat Berkas Baru" type="button" style="background:url(images/createcontent-1.gif) no-repeat;border:0px; background-position:left; width:20px; display:<?php echo $add_berkas; ?>" onclick="addBerkas()" />
									 <span id="req13" class="req_field" style="display:none;" title="Berkas Pertinggal Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                                </td>
                            </tr>
                        </table>
                    </div>
                 </td>
            </tr>
		</tr>

    	<table cellspacing="2" cellpadding="2" style="width:100%">
            <tr style="display:<?php echo $viewPenerima; ?>">
                <td colspan="2" align="center" valign="middle">
                    <?php switch($_REQUEST["mode"]){
                        case "outbox": ?>
                    		<div style="text-align:center; padding:10px;">Tujuan Nota Dinas</div>
                        <?php    break;
            
                        case "outboxmemo": ?>
                    		<div style="text-align:center; padding:10px;">Tujuan Memo</div>
                        <?php    break;
            
                        case "outboxnotadinas": ?>
                    		<div style="text-align:center; padding:10px;">Tujuan Nota Dinas</div>
                        <?php    break;
                            
                        case "inbox": ?>
                    		<div style="text-align:center; padding:10px;">Tujuan Naskah</div>
                        <?php    break;
                            
                    }
					?>
                </td>
            </tr>

            <tr style="display:<?php echo $viewPenerima; ?>">
                <td valign="top" style="width:25%;">Kepada <font color="red">*</font></td>
                <td style="width:65%;">
                    <input type="hidden" name="txt14" value="<?php echo $_SESSION["data_14"]; ?>" />
                    <input type="text" name="txt_kepada" id="txt_kepada" class="inputbox" value="<?php echo $_SESSION["txt_kepada"]; ?>" />
					 <span id="req14" class="req_field" style="display:none;" title="Kepada Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>
            
            <tr id="trTembusan" style="display:<?php echo $viewPenerima; ?>">
                <td valign="top">
                    Tembusan</td>
                <td><input type="text" id="txt_CC" name="txt_CC" class="inputbox" style="width:80%;" />
					<br /><br />
					&nbsp;

                    <input type="hidden" name="txt15" value="<?php echo $_SESSION["data_15"]; ?>" />             </td>
            </tr>

            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            
<!--            <tr>
                <td>
                    Media Arsip <font color="red">*</font>               </td>
                <td>
-->                    <select name="txt16" class="inputbox" style="visibility:hidden">
                        <?php
                            $sql = "select MediaId, MediaName from master_media ";
                            $sql .= "where MediaName = 'Kertas' ";
                            $sql .= "order by MediaName";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                echo "<option value='" . $row["MediaId"] . "'";
								if($_SESSION["data_16"] == $row["MediaId"]){
									echo " selected ";
								}
								echo ">" . $row["MediaName"] . "</option>";
                            }
							mysql_free_result($result);
                        ?>
                    </select>              <!--   </td>
            </tr>

           <tr>
                <td>
                    Bahasa <font color="red">*</font>               </td>
                <td> -->
                    <select name="txt17" class="inputbox" style="visibility:hidden">
                        <?php
                            $sql = "select LangId, LangName from master_bahasa ";
                            $sql .= "where LangName = 'Indonesia' ";
                            $sql .= "order by LangName";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                echo "<option value='" . $row["LangId"] . "'";
								if($_SESSION["data_17"] == $row["LangId"]){
									echo " selected ";
								}
								echo ">" . $row["LangName"] . "</option>";
                            }
							mysql_free_result($result);
                        ?>
                    </select>              <!--  </td>
            </tr>
 
           <tr>
                <td valign="top">
                    Isi Ringkas <font color="red">*</font>                </td>
                <td> -->
                    <input type="hidden" name="txt18" class="inputbox" /><?php echo $_SESSION["data_18"]; ?>
<!--					 <span id="req18" class="req_field" style="display:none;" title="Isian Ringkas Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>
-->
                	<input type="hidden" name="txt29" id="txt29" style="width:80%;" maxlength="150" value="<?php echo $_SESSION["data_18"]; ?>" class="inputbox" />

<!--            <tr>
                <td>
                    Arsip Vital / Tidak Vital <font color="red">*</font>                </td>
                <td>-->
                    <select name="txt19" class="inputbox" style="visibility:hidden">
                        <?php
                            $sql = "select VitId, VitName from master_vital ";
                            $sql .= "where VitName = 'Tidak Vital' ";
                            $sql .= "order by VitId asc";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                echo "<option value='" . $row["VitId"] . "'";
								if($_SESSION["data_19"] == $row["VitId"]){
									echo " selected ";
								}
								echo ">" . $row["VitName"] . "</option>";
                            }
							mysql_free_result($result);
                        ?>
                    </select>&nbsp;
<!--  					<span id="req19" class="req_field" style="display:none;" title="Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>

          <tr>
                <td>
                    Jumlah                </td>
                <td> -->
                    <input type="hidden" name="txt20" class="inputbox" value="1" style="width:40px;" maxlength="4" />
<!--					<span id="req20" class="req_field" style="display:none;" title="Wajib Diisi Angka !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>
                    &nbsp;
-->                    <select name="txt21" class="inputbox" style="visibility:hidden">
                        <?php
                            $sql = "select MeasureUnitId, MeasureUnitName from master_satuanunit ";
                            $sql .= "where MeasureUnitName = 'Lembar' ";
                            $sql .= "order by MeasureUnitName";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                echo "<option value='" . $row["MeasureUnitId"] . "'";
								if($_SESSION["data_21"] == $row["MeasureUnitId"]){
									echo " selected ";
								}
								echo ">" . $row["MeasureUnitName"] . "</option>";
                            }
							mysql_free_result($result);
                        ?>
                    </select>              <!--  </td>
            </tr>

           <tr>
                <td valign="top">
                    Lokasi Fisik                </td>
                <td> --> 
                    <input type="hidden" name="txt22" class="inputbox" value="<?php echo $_SESSION["data_22"]; ?>" style="width:80%" />                </td>
<!--             </tr>
           <tr> -->
                <td colspan="2" style="padding:10px; text-align:right;">
					<div style="display:<?php echo $btn; ?>">
						<input type="hidden" name="option" value="<?php echo $option; ?>" />
						<input type="hidden" name="task" value="<?php echo $task; ?>" />
						<input type="hidden" name="id" value="<?php echo $id; ?>" />
						<input type="hidden" name="txt23" value="<?php echo $_REQUEST["mode"]; ?>" />
						<input type="hidden" name="count" value="29" />
						<input type="button" name="btnSimpan" value=" <?php echo $btn_val; ?> " class="art-button" onclick="getSave();" />&nbsp;
						<input type="button" name="btnClose" value=" Tutup " class="art-button" onclick="<?php echo $urlClose; ?>" />
					</div>                
				</td>
            </tr>
        </table>
		<script language="javascript">
			Calendar.setup(
				{
				  inputField  : "txt3",         // ID of the input field
				  ifFormat    : "%d/%m/%Y",    // the date format
				  button      : "trigger1",       // ID of the button
				  align          :    "Tl",           // alignment (defaults to "Bl")
				  singleClick    :    true
				}
				
			);
		</script>
	</form>
	<?php
		for($a=1;$a<24;$a++){
			unset($_SESSION["data_" . $a]);
		}
	}
	if($task == "step2"){
		?>
		<form name="form2" id="form2" method="post" enctype="multipart/form-data" action="handle.php" target="frmFile">
        
		<table cellspacing="2" cellpadding="3" style="width:100%">
			<tr>
				<td style="width:20%;">Pilih File Digital</td>
				<td style="width:80%;"><input type="file" name="file" />
					&nbsp;&nbsp;&nbsp;<input type="submit" value=" Upload " class="art-button" />
				</td>
			</tr>
			<tr>
				<td><input type="hidden" name="option" value="<?php echo $option; ?>" />
					<input type="hidden" name="task" value="addFile" />
				</td>
				<td>
					<input type="hidden" name="id" value="<?php echo $id; ?>" />
					<input type="hidden" name="GIR_Id" value="<?php echo clean($_REQUEST["GIR_Id"]); ?>" />
				</td>
			</tr>		
			<tr>
				<td colspan="2">
					<iframe id="frmFile" name="frmFile" src="frame.php?option=Mail&task=edit&filetopen=Mail_Files&NId=<?php echo $id; ?>&GIR_Id=<?php echo clean($_REQUEST["GIR_Id"]); ?>" 
						 style=" height:250px; max-height:250px;" scrolling="no"
						 frameborder="0" width="98%"></iframe>
				</td>
			</tr>
		</table>
		</form>
		<form name="form3" id="form3" method="post" action="handle.php">
        
        <?php
			$sql3 = mysql_query("select NTipe from inbox where NId = '" . $_REQUEST["GIR_Id"] . "'");
			$res3 = mysql_fetch_array($sql3);
		?>
        
			<table width="100%">
				<tr>
					<td colspan="2" style="padding:10px; text-align:right;">
						<input type="hidden" name="option" value="<?php echo $option; ?>" />
                        <?php
						switch($res3["0"]){
							case "outbox": ?>
								<input type="hidden" name="task" value="sendoutbox" />
								<?php break;
							case "outboxmemo": ?>
								<input type="hidden" name="task" value="sendoutboxmemo" />
								<?php break;
							case "outboxins": ?>
								<input type="hidden" name="task" value="sendoutboxins" />
								<?php break;
							case "outboxnotadinas": ?>
								<input type="hidden" name="task" value="sendoutboxnotadinas" />
								<?php break;
							case "inbox": ?>
								<input type="hidden" name="task" value="sendinbox" />
								<?php break;
							case "inboxuk": ?>
								<input type="hidden" name="task" value="sendinboxuk" />
								<?php break;
								break;
						}
						?>
						<input type="submit" name="btnSimpan" value=" Kirim " class="art-button" />
					</td>
				</tr>
			</table>
		</form>
		<?php
	}
	
 else if($task == "edit" || $task == "detail"){ ?>
	<form name="form1" id="form1" autocomplete="off" method="post" action="handle.php" enctype="multipart/form-data" target="<?php echo $target; ?>">
    	<table cellspacing="2" cellpadding="2" style="width:100%">
            <tr>
                <td style="width:25%;">&nbsp;                </td>
                <td style="width:65%;">
					<input type="hidden" name="modeRD" value="disposisi" />
					<input type="hidden" name="lookup" value="<?php echo $lookup; ?>" />                </td>
            </tr>
            <tr>
                <td>
                    Tanggal Registrasi                </td>
                <td>
                    <?php echo $tglReg; ?>                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td>
                    Jenis Naskah <font color="red">*</font>                </td>
                <td>
                    <select name="txt1" class="inputbox">
                        <?php
                            $sql = "select JenisId, JenisName from master_jnaskah ";
                            $sql .= "where JenisId like '" . $_SESSION["AppKey"] . "%' ";
                            $sql .= "order by JenisName";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                echo "<option value='" . $row["JenisId"] . "'";
								if($_SESSION["data_1"] == $row["JenisId"]){
									echo " selected ";
								}
								echo ">" . $row["JenisName"] . "</option>";
                            }
							mysql_free_result($result);
                        ?>
                    </select>
					<span id="req1" class="req_field" style="display:none;" title="Jenis Naskah Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>
            <tr>
                <td>
                    Tingkat Perkembangan <font color="red">*</font>                </td>
                <td>
                    <select name="txt2" class="inputbox">
                        <?php
                            $sql = "select TPId, TPName from master_tperkembangan ";
                            $sql .= "where TPId like '" . $_SESSION["AppKey"] . "%' ";
                            $sql .= "order by TPName";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                echo "<option value='" . $row["TPId"] . "'";
								if($_SESSION["data_2"] == $row["TPId"]){
									echo " selected ";
								}
								echo ">" . $row["TPName"] . "</option>";
                            }
							mysql_free_result($result);
                        ?>
                    </select>
					<span id="req2" class="req_field" style="display:none;" title="Tingkat Perkembangan Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>
            <tr>
                <td>
                    Tanggal Naskah <font color="red">*</font>                </td>
                <td valign="middle">
                    <input type="text" name="txt3" id="txt3" maxlength="12" 
						style="width:75px;" value="<?php echo $_SESSION["data_3"]; ?>" class="inputbox" readonly="true" />
					<img src="images/calendar.png" alt="" width="16" height="15" align="absmiddle"  
						id="trigger1" style="cursor: pointer; border: 1px solid #CCCCCC;" title="Date selector" /> 
					<span id="req3" class="req_field" style="display:none;" title="Tanggal Naskah Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
            <tr>
                <td>
                    Nomor Asal Naskah <font color="red">*</font>                </td>
                <td>
                    <input type="text" name="txt4" value="<?php echo $_SESSION["data_4"]; ?>" style="width:50%;" maxlength="100" class="inputbox" />&nbsp;
					<span id="req4" class="req_field" style="display:none;" title="Nomor Naskah Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>
			<tr>
                <td valign="top">
                    Nomor Agenda                </td>
                <td>
                    <input type="text" name="txt28" value="<?php echo $_SESSION["data_28"]; ?>" style="width:50%;" maxlength="150" class="inputbox" />&nbsp; 
					<input type="button" style="background: url(images/view2.png) no-repeat; border:0px; width:20px;height:18px;" onclick="openAgenda();" /><br />
					<font color="#FF0000">Nomor Agenda Terakhir adalah :  <?php echo $res2["0"]; ?> </font><br />              
					<small><i>Pengisian No. Agenda harus mencantumkan Tahun, contoh : <strong>001/xx/<?php echo date("Y"); ?></strong></i></small>                </td>
            </tr>
			<tr>	
				<td colspan="2">&nbsp;</td>
			</tr>
            <tr>
                <td>
                    Hal <font color="red">*</font>                </td>
                <td>
                    <input type="text" name="txt5" value="<?php echo $_SESSION["data_5"]; ?>" style="width:80%" maxlength="250" class="inputbox" />&nbsp;
					<span id="req5" class="req_field" style="display:none;" title="Hal Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>
            <tr>
                <td>
                    Tingkat Urgensi <font color="red">*</font>               </td>
                <td>
                    <select name="txt6" class="inputbox">
                        <?php
                            $sql = "select UrgensiId, UrgensiName from master_urgensi ";
                            $sql .= "where UrgensiId like '" . $_SESSION["AppKey"] . "%' ";
                            $sql .= "order by UrgensiName desc";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                echo "<option value='" . $row["UrgensiId"] . "'";
								if($_SESSION["data_6"] == $row["UrgensiId"]){
									echo " selected ";
								}
								echo ">" . $row["UrgensiName"] . "</option>";
                            }
							mysql_free_result($result);
                        ?>
                    </select>                </td>
            </tr>
            <tr>
                <td>
                    Sifat Naskah <font color="red">*</font>                </td>
                <td>
                    <select name="txt7" class="inputbox">
                        <?php
                            $sql = "select SifatId, SifatName from master_sifat ";
                            $sql .= "where SifatId like '" . $_SESSION["AppKey"] . "%' ";
                            $sql .= "order by SifatName";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                echo "<option value='" . $row["SifatId"] . "'";
								if($_SESSION["data_7"] == $row["SifatId"]){
									echo " selected ";
								}
								echo ">" . $row["SifatName"] . "</option>";
                            }
							mysql_free_result($result);
                        ?>
                    </select>
					<span id="req7" class="req_field" style="display:none;" title="Sifat Naskah Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>
            <tr>
                <td>
                    Kategori Arsip <font color="red">*</font>                </td>
                <td>
                    <select name="txt8" class="inputbox">
                        <?php
                            $sql = "select KatId, KatName from master_kategoriarsip ";
                            $sql .= "where KatId like '" . $_SESSION["AppKey"] . "%' ";
                            $sql .= "order by KatName desc";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                echo "<option value='" . $row["KatId"] . "'";
								if($_SESSION["data_8"] == $row["KatId"]){
									echo " selected ";
								}
								echo ">" . $row["KatName"] . "</option>";
                            }
							mysql_free_result($result);
                        ?>
                    </select>
					<span id="req8" class="req_field" style="display:none;" title="Kategori Arsip Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>
            <tr>
                <td>
                    Tingkat Akses Publik <font color="red">*</font></td>
                <td>
                    <select name="txt9" class="inputbox">
                        <?php
                            $sql = "select APId, APName from master_aksespublik ";
                            $sql .= "where APId like '" . $_SESSION["AppKey"] . "%' ";
                            $sql .= "order by APName";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                echo "<option value='" . $row["APId"] . "'";
								if($_SESSION["data_9"] == $row["APId"]){
									echo " selected ";
								}
								echo ">" . $row["APName"] . "</option>";
                            }
							mysql_free_result($result);
                        ?>
                    </select>
					<span id="req9" class="req_field" style="display:none;" title="Tingkat Akses Publik Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>
            <tr>
            	<td colspan="2">
				<div id="pnlRef" style="display:<?php echo $viewRef; ?>;">
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td style="width:25%;">
								Referensi Balasan Naskah							</td>
							<td style="width:65%;">
								<input type="text" name="txt24" class="inputbox" style="width:70%" maxlength="80" />&nbsp;
								<input type="button" style="background:url(images/view2.png) no-repeat;border:0px; 
													background-position:left; width:20px;" onclick="openRef()" />
								<input type="hidden" name="txt25" />
								<input type="hidden" name="txt26" />
								<input type="hidden" name="txt27" />							</td>
						</tr>
					</table>
				</div>
                <?php
                	if(($_REQUEST["mode"] == 'inbox') || ($_SESSION["data_23"] == 'inbox')){
						$uk = 'Instansi';
						$pengirim = '';
						$berkas = 'inline';
						if($_SESSION["data_23"] != ""){
							$data[10] = $_SESSION["data_10"];
							$data[11] = $_SESSION["data_11"];
							$data[12] = $_SESSION["data_12"];
						}
					}else if(($_REQUEST["mode"] == 'outbox') || ($_SESSION["data_23"] == 'outbox')){
						$uk = 'Unit Kerja';
						$pengirim = 'readonly="readonly"';
						$berkas = 'inline';
						if($_SESSION["data_23"] == ""){
							$data[10] = $_SESSION["NamaBagian"];
							$data[11] = $_SESSION["PName"];
							$data[12] = $_SESSION["NamaJabatan"];
						}else{
							$data[10] = $_SESSION["data_10"];
							$data[11] = $_SESSION["data_11"];
							$data[12] = $_SESSION["data_12"];
						}		
					}else if(($_REQUEST["mode"] == 'inboxuk') || ($_SESSION["data_23"] == 'inboxuk')){
						$uk = 'Instansi / Unit Kerja';
						$pengirim = '';
						$berkas = 'inline';
						$_SESSION["data_14"] = $_SESSION["PeopleID"] . ",";
					}
					
				?>
                	<div id="pnlPengirim" style="display:<?php echo $viewPengirim; ?>">
                    	<table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td colspan="2" align="center" valign="middle">
                                    <div style="text-align:center; padding:10px;">Pengirim Naskah</div>                                </td>
                            </tr>
                            <tr>
                                <td style="width:25%;">
                                    <?php echo $uk; ?> Pengirim <font color="red">*</font></td>
                                <td style="width:65%;">
                                    <input type="text" name="txt10" class="inputbox" style="width:80%"
                                     value="<?php echo $data[10]; ?>"	<?php echo $pengirim; ?> maxlength="80" />&nbsp;
									 <span id="req10" class="req_field" style="display:none;" title="<?php echo $uk; ?> Wajib Diisi !">
										<img src="images/Alert.gif" height="12" width="12" />
                                      </span>
                                 </td>
                            </tr>
                            <tr>
                                <td>
                                    Nama Pengirim <font color="red">*</font></td>
                                <td>
                                    <input type="text" name="txt11" class="inputbox" style="width:80%" 
									 value="<?php echo $data[11]; ?>" <?php echo $pengirim; ?> maxlength="80" />&nbsp;
									 <span id="req11" class="req_field" style="display:none;" title="Nama Pengirim Wajib Diisi !">
										<img src="images/Alert.gif" height="12" width="12" />
                                     </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Jabatan Pengirim</td>
                                <td>
                                    <input type="text" name="txt12" class="inputbox" style="width:80%" 
									 value="<?php echo $data[12]; ?>" <?php echo $pengirim; ?> maxlength="150" />&nbsp;                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id="pnlBerkas" style="display:<?php echo $berkas; ?>;">
                    	<table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="width:25%;">
                                    Berkas pertinggal <font color="red">*</font>                                </td>
                                <td style="width:65%;">
                                   	<select name="txt13" class="inputbox">
										<?php
											
											$sql = "select '' as BerkasId, '-' as BerkasName from dual
												union
												(select BerkasId, concat(BerkasNumber, ' - ', BerkasName) as BerkasName from berkas 
													where BerkasKey = '" . $_SESSION["AppKey"] . "' 
													and RoleId = '" . $_SESSION["PrimaryRoleId"] . "' 
													and BerkasStatus = 'open' 
												order by CreationDate desc) ";
											$result = mysql_query($sql);
											while($row = mysql_fetch_array($result)){
												echo "<option value='" . $row["BerkasId"] . "'";
												if($_SESSION["data_13"] == $row["BerkasId"]){
													echo " selected ";
												}
												echo ">" . $row["BerkasName"] . "</option>";
											}
											mysql_free_result($result);
										?>                                    
									</select>&nbsp;
                                    <input type="button" id="btnBerkas" 
									 style="background-image:url(images/view2.png); background-repeat:no-repeat; background-color:Transparent; width:20px; border:0px;"
									 onclick="openBerkas();" />&nbsp;
									 <input type="button" style="background:url(images/createcontent-1.gif) no-repeat;border:0px; background-position:left; width:20px; display:<?php echo $add_berkas; ?>" onclick="addBerkas()" />
									 <span id="req13" class="req_field" style="display:none;" title="Berkas Pertinggal Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                                </td>
                            </tr>
                        </table>
                    </div>                
                 </td>
            </tr>
            <tr style="display:<?php echo $viewPenerima; ?>">
                <td colspan="2" align="center" valign="middle">
                    <div style="text-align:center; padding:10px;">Tujuan Naskah</div>
                </td>
            </tr>
            <tr style="display:<?php echo $viewPenerima; ?>">
                <td valign="top">Kepada <font color="red">*</font></td>
                <td>
                    <input type="hidden" name="txt14" value="<?php echo $_SESSION["data_14"]; ?>" />                   
                    <input type="text" name="txt_kepada" id="txt_kepada" class="inputbox" value="<?php echo $_SESSION["txt_kepada"]; ?>" />
					 <span id="req14" class="req_field" style="display:none;" title="Kepada Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>
            <tr id="trTembusan" style="display:<?php echo $viewPenerima; ?>">
                <td valign="top">
                    Tembusan</td>
                <td><input type="text" id="txt_CC" name="txt_CC" class="inputbox" style="width:80%;" />
					<br /><br />
					&nbsp;
                   
                    <input type="hidden" name="txt15" value="<?php echo $_SESSION["data_15"]; ?>" />             </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            
            <tr>
                <td>
                    Media Arsip <font color="red">*</font>               </td>
                <td>
                    <select name="txt16" class="inputbox">
                        <?php
                            $sql = "select MediaId, MediaName from master_media ";
                            $sql .= "where MediaId like '" . $_SESSION["AppKey"] . "%' ";
                            $sql .= "order by MediaName";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                echo "<option value='" . $row["MediaId"] . "'";
								if($_SESSION["data_16"] == $row["MediaId"]){
									echo " selected ";
								}
								echo ">" . $row["MediaName"] . "</option>";
                            }
							mysql_free_result($result);
                        ?>
                    </select>                </td>
            </tr>
            <tr>
                <td>
                    Bahasa <font color="red">*</font>               </td>
                <td>
                    <select name="txt17" class="inputbox">
                        <?php
                            $sql = "select LangId, LangName from master_bahasa ";
                            $sql .= "where LangId like '" . $_SESSION["AppKey"] . "%' ";
                            $sql .= "order by LangName";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                echo "<option value='" . $row["LangId"] . "'";
								if($_SESSION["data_17"] == $row["LangId"]){
									echo " selected ";
								}
								echo ">" . $row["LangName"] . "</option>";
                            }
							mysql_free_result($result);
                        ?>
                    </select>                </td>
            </tr>
            <tr>
                <td valign="top">
                    Isi Ringkas                 </td>
                <td>
                    <textarea name="txt18" class="inputbox" rows="5" style="width:80%"><?php echo $_SESSION["data_18"]; ?></textarea>
					 <span id="req18" class="req_field" style="display:none;" title="Isian Ringkas Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>

                	<input type="hidden" name="txt29" id="txt29" style="width:80%;" maxlength="150" value="<?php echo $_SESSION["data_18"]; ?>" class="inputbox" />

            <tr>
                <td>
                    Arsip Vital / Tidak Vital <font color="red">*</font>                </td>
                <td>
                    <select name="txt19" class="inputbox">
                        <?php
                            $sql = "select VitId, VitName from master_vital ";
                            $sql .= "where VitId like '" . $_SESSION["AppKey"] . "%' ";
                            $sql .= "order by VitId asc";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                echo "<option value='" . $row["VitId"] . "'";
								if($_SESSION["data_19"] == $row["VitId"]){
									echo " selected ";
								}
								echo ">" . $row["VitName"] . "</option>";
                            }
							mysql_free_result($result);
                        ?>
                    </select>&nbsp;
					<span id="req19" class="req_field" style="display:none;" title="Wajib Diisi !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>                </td>
            </tr>
            <tr>
                <td>
                    Jumlah                </td>
                <td>
                    <input type="text" name="txt20" class="inputbox" value="<?php echo $_SESSION["data_20"]; ?>" style="width:40px;" maxlength="4" />
					<span id="req20" class="req_field" style="display:none;" title="Wajib Diisi Angka !">
						<img src="images/Alert.gif" height="12" width="12" />					</span>
                    &nbsp;
                    <select name="txt21" class="inputbox">
                        <?php
                            $sql = "select MeasureUnitId, MeasureUnitName from master_satuanunit ";
                            $sql .= "where MeasureUnitId like '" . $_SESSION["AppKey"] . "%' ";
                            $sql .= "order by MeasureUnitName";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                echo "<option value='" . $row["MeasureUnitId"] . "'";
								if($_SESSION["data_21"] == $row["MeasureUnitId"]){
									echo " selected ";
								}
								echo ">" . $row["MeasureUnitName"] . "</option>";
                            }
							mysql_free_result($result);
                        ?>
                    </select>                </td>
            </tr>
            <tr>
                <td valign="top">
                    Lokasi Fisik                </td>
                <td>
                    <input type="text" name="txt22" class="inputbox" value="<?php echo $_SESSION["data_22"]; ?>" style="width:80%" />                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding:10px; text-align:right;">
					<div style="display:<?php echo $btn; ?>">
						<input type="hidden" name="option" value="<?php echo $option; ?>" />
						<input type="hidden" name="task" value="<?php echo $task; ?>" />
						<input type="hidden" name="id" value="<?php echo $id; ?>" />
						<input type="hidden" name="txt23" value="<?php echo $_REQUEST["mode"]; ?>" />
						<input type="hidden" name="count" value="29" />
						<input type="button" name="btnSimpan" value=" <?php echo $btn_val; ?> " class="art-button" onclick="getSave();" />&nbsp;
						<input type="button" name="btnClose" value=" Tutup " class="art-button" onclick="<?php echo $urlClose; ?>" />
					</div>                
				</td>
            </tr>
        </table>
		<script language="javascript">
			Calendar.setup(
				{
				  inputField  : "txt3",         // ID of the input field
				  ifFormat    : "%d/%m/%Y",    // the date format
				  button      : "trigger1",       // ID of the button
				  align          :    "Tl",           // alignment (defaults to "Bl")
				  singleClick    :    true
				}
				
			);
		</script>
	</form>
	<?php
		for($a=1;$a<24;$a++){
			unset($_SESSION["data_" . $a]);
		}
	}

?>	