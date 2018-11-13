
<?php
	if($_SESSION["GroupId"] == "" || 
		$_SESSION["PeopleID"] == ""){
		die("<script>location.href='index.php'</script>");
	}
	
	$modeRD = $_REQUEST["modeRD"];
	switch($modeRD){
		case "reply":
		case "newreply":
			$title = "Nota Dinas";
			$tr_final = "none";
			$lookup = 'upper';
			$to = 'to_reply';
			$txt_btn = "Proses Selanjutnya";
			break;
		case "disposisi":
		case "newdisposisi":
			$title = "Disposisi";
			$trFile = "none";
			$trFileDesc = "none";
			$tr_final = "none";
			$lookup = 'lower';
			$to = 'cc1';
			$txt_btn = "Proses Selanjutnya";
			break;
		case "forward":
		case "newforward":
			$title = "Teruskan";
			$lookup = 'upper';
			$tr_final = "none";
			$to = 'to_forward';
			$txt_btn = "Proses Selanjutnya";
			break;
		case "usul":
		case "newusul":
			$title = "Nota Dinas";
			$lookup = 'upper';
			$to = 'to_usul';
			$tr_final = "none";
			$txt_btn = "Proses Selanjutnya";
			break;
		case "editdisposisi":
			$to = 'cc1';
			break;
		case "editforward":
			$to = 'to_forward';
			break;
		case "editreply":
			$to = 'to_reply';
			break;
		case "editusul":
			$to = 'to_usul';
			break;
	}
	
	if($data[1] == ""){
		if(isset($_SESSION["to"])){
			$data[1] = $_SESSION["to"];
		}else{
			$data[1] = clean($_REQUEST["peopleIDKepada"]);
		}
		
		if(isset($_SESSION["cc"])){
			$data[2] = $_SESSION["cc"];
		}else{
			$data[2] = clean($_REQUEST["peopleIDCC"]);
		}
		
		$data[4] = $_SESSION["msg"];
	}else{
		if($_REQUEST["peopleIDKepada"] != ''){
			$data[1] .= ',' . clean($_REQUEST["peopleIDKepada"]);
		}
		
		if($_REQUEST["peopleIDCC"] != ''){
			$data[2] .= ',' . clean($_REQUEST["peopleIDCC"]);
		}
	}
	
	if(($task == "editdisposisi") ||
		($task == "editforward") || 
		($task == "editreply") || 
		($task == "editusul")){
		
		$sql = "select p.PeopleId as kepada_id,
					   concat(p.PeopleName, ' (', r.RoleName, ')') as kepada_name,
					   p2.PeopleId as tembusan_id,
					   concat(p2.PeopleName, ' (', r2.RoleName, ')') as tembusan_name,
					   ir.Msg, ir.ReceiverAs
				 from inbox_receiver ir
				 left join role r on r.RoleId = ir.RoleId_To and ir.ReceiverAs in ('$to')
				 left join people p on p.PrimaryRoleId = r.RoleId
				 left join role r2 on r2.RoleId = ir.RoleId_To and ir.ReceiverAs in ('bcc')
				 left join people p2 on p2.PrimaryRoleId = r2.RoleId
				where ir.NKey='" . $_SESSION["AppKey"] . "'
					and ir.GIR_Id = '" . $_REQUEST["GIR_Id"] . "'
					and ir.NId='" . $_REQUEST["NId"] . "' ";
		$res = mysql_query($sql);
		//echo $sql;
		$data[1] = "|";
		$data[2] = "|";
		while($row = mysql_fetch_array($res)){
			if($row["ReceiverAs"] == $to){
				$data[1] .= ', {id:' . $row["kepada_id"] . ", name: '" . $row["kepada_name"] . "', 'readonly':true}";	
			}
			if($row["ReceiverAs"] == "bcc"){		
				$data[2] .= ', {id:' . $row["tembusan_id"] . ", name:'" . $row["tembusan_name"] . "', 'readonly':true}";
				//echo "ada" . $data[2] ."<br />";
			}
			$data[3] = $row["Msg"];
		}
		mysql_free_result($res);
		
		$data[1] = str_replace("|,", "", $data[1]);
		$data[1] = str_replace("|", "", $data[1]);
		$data[2] = str_replace("|,", "", $data[2]);
		$data[2] = str_replace("|", "", $data[2]);
		
		// get from disposisi
		$sql = "select * from inbox_disposisi
				where NId='" . $_REQUEST["NId"] . "' 
				  and GIR_Id='" . $_REQUEST["GIR_Id"] . "'";
		$res = mysql_query($sql);
		while($row = mysql_fetch_array($res)){
			$data[4] = $row["NoIndex"];
			$data[5] = $row["Sifat"];
			$data[6] = $row["Disposisi"];
		}
		mysql_free_result($res);		
	}
		
?>
<script type="text/javascript">
	document.getElementById("title").innerHTML = '<?php echo $title; ?>';
</script>
 
<script type="text/javascript">
	$(document).ready(function() {
		$("#txt_kepada").tokenInput("Share/Lookup/listPeople.php?role=<?php echo $_SESSION["PrimaryRoleId"]; ?>", {
				theme: "facebook",
				preventDuplicates: true,
				hintText: "<?php echo $title;?> Surat dikirim kepada ?",
				noResultsText: "Data tidak ditemukan",
				prePopulate: [
					<?php echo $data[1]; ?>
				],
				searchingText: "Mencari...",
				animateDropdown: false });
		
		$("#txt_CC").tokenInput("Share/Lookup/listPeople.php", {
					theme: "facebook",
					preventDuplicates: true,
					hintText: "Tembusan dikirim kepada ?",
					noResultsText: "Data tidak ditemukan",
					prePopulate: [
						<?php echo $data[2]; ?>
					],
					searchingText: "Mencari...",
					animateDropdown: false });
	});
					
</script>
<?php 
	if(($task == 'newdisposisi') ||
			($task == 'newforward') || 
			($task == 'newreply') || 
			($task == 'newusul') ||
			($task == 'newfinal') ||
			($task == "editforward") || 
			($task == "editdisposisi") ||
			($task == "editreply") || 
			($task == "editusul")){ ?>
           
	
<div id='info' align='center'></div>
<form id="form1" name="form1" method="post" action="handle.php" target="MyWindowDetail">
	<input type="hidden" name="lookup" value="<?php echo $lookup; ?>" />
		<table cellspacing="0" cellpadding="3px" width="550">
		<tr>
			<td colspan="2" class="style1">
				<font color="red">*</font> kolom wajib diisi
			</td>
		</tr>
		<tr>
			<td colspan="2" class="style1">&nbsp;</td>
		</tr>
		<tr style="display:<?php echo $tr_final; ?>">
			<td>Jenis Dokumen</td>
			<td>-- Dokumen Final --</td>
		</tr>
        
        <?php if(($task=="newdisposisi") || ($task == "editdisposisi")){ ?>
        
            <tr>
                <td valign="top">
                    No Indeks</td>
                <td> <input type="text" id="txt4" name="txt4" style="width:30%;" value="<?php echo $data[4]; ?>" /></td>
            </tr>
            <tr>
                <td valign="top">Sifat <font color="red">*</font></td>
                <td><select name="txt5" class="inputbox">
                        <?php
                            $arr = array("Biasa", "Segera", "Sangat Segera", "Rahasia", "Sangat Rahasia");
                            for($x=0; $x<count($arr); $x++){
                                echo "<option value='" . $arr[$x] . "'";
                                if($data[5] == $arr[$x]){
                                    echo " selected ";
                                }
                                echo ">" . $arr[$x] . "</option>";
                            }
                        ?>
                    </select>
                </td>
             </tr> 
             <tr>
                <td valign="top">
                    Isi Disposisi</td>
                <td>
                    <div style="width:90%; height:140px; max-height:140px; overflow:scroll; border:none;">
                        <ul class="dolorsit">
                            <?php 
                                $isiDisp = explode("|", $data[6]);
                                $sqlIsi = "select DisposisiId, DisposisiName
                                            from master_disposisi
                                            where gjabatanId = '" . $_SESSION["gjabatanId"] . "' and DisposisiId like '" . $_SESSION["AppKey"] . "%'
                                            order by DisposisiName";
                                $resIsi = mysql_query($sqlIsi);
                                $no = 1;
                                while($rwIsi = mysql_fetch_array($resIsi)){ 
                                    $isCheck = "";
                                    for	($a=0; $a < count($isiDisp); $a++){
                                        if($rwIsi["DisposisiId"] == $isiDisp[$a]){
                                            $isCheck = "checked = 'checked'";
                                            break;
                                        }else{
                                            $isCheck = "";
                                        }
                                    }
                                    ?>
                                    <li> <input name="txt_cekDis_<?php echo $no;?>" type="checkbox" 
                                            id="txt_cekDis_<?php echo $no;?>" value="<?php echo $rwIsi["DisposisiId"];?>"
                                            <?php echo $isCheck; ?> />
                                         <?php echo $rwIsi["DisposisiName"];?>
                                    </li><?php
                                    $no++;								
                                }
                                mysql_free_result($resIsi);
                            ?>
                        </ul>
                    </div>    
                    <input type="hidden" name="jumDisposisi" value="<?php echo $no; ?>" />
                    <span id="req2" class="require_field" style="display:none;">
                        <img src="images/Alert.gif" />
                    </span>
                </td>
            </tr>
        <?php }?>        
		<tr>
			<td colspan="2" class="style1">&nbsp;</td>
		</tr>

        <?php if(($task=="newdisposisi") || ($task == "editdisposisi")){ ?>

		<tr>
			<td style="width:30%;" valign="top">
				Tujuan Disposisi <font color="red">*</font>
			</td>

			<!-- Fungsi ini dapat dimatikan jika sestama tidak dapat disposisi kepada eselon 2 dibawah pimpinan tertinggi -->
        	<?php if($_SESSION["PrimaryRoleId"] =="uk.1.1"){ ?>

                <td>
                    <div style="width:90%; height:140px; max-height:140px; overflow:scroll; border:none;">
                        <ul class="dolorsit">
                        
                        <?php 
							$sqlIsitujuan = "SELECT people.PeopleId, people.PeopleName, people.PeoplePosition, role.gjabatanId from people join role on role.RoleId = people.PrimaryRoleId WHERE people.RoleAtasan in('" . $_SESSION["PrimaryRoleId"] . "','uk.1')  and people.PeopleIsActive='1' and people.PeopleId != '" . $_SESSION["PeopleID"] . "' 
											and role.gjabatanId = 'XxJyPn38Yh.3' ORDER BY role.gjabatanId ASC, people.PeoplePosition desc";
                            $resIsiTujuan = mysql_query($sqlIsitujuan);
                            									
                            while($hasil = mysql_fetch_array($resIsiTujuan)){ 
                            ?>
                                                                                            
                              <li>  
                                    <input type="checkbox" name="txt_kepada[]" id="txt_kepada[]" value="<?php echo $hasil['PeopleId']?>"><?php echo $hasil['PeoplePosition']?>         
                              </li>                      
                               
                            <?php
                            }
                        ?>
                        </ul>
                   </div>     
                </td>
                
           <?php  } else  { ?>

            <td>
                <div style="width:90%; height:170px; max-height:170px; overflow:scroll; border:none;">
                    <ul class="dolorsit">
                    
                    <?php 
                        $sqlIsitujuan = "SELECT people.PeopleId, people.PeopleName, people.PeoplePosition, role.gjabatanId from people join role on role.RoleId = people.PrimaryRoleId WHERE people.RoleAtasan = '" . $_SESSION["PrimaryRoleId"] . "' and people.PeopleIsActive='1' and people.PeopleId != '" . $_SESSION["PeopleID"] . "' 
                                        ORDER BY role.gjabatanId ASC, people.PeoplePosition desc";
                        $resIsiTujuan = mysql_query($sqlIsitujuan);
                        
                        while($hasil = mysql_fetch_array($resIsiTujuan)){ 
                        ?>
                        																
                          <li>  
                          		<input type="checkbox" name="txt_kepada[]" id="txt_kepada[]" value="<?php echo $hasil['PeopleId']?>"><?php echo $hasil['PeoplePosition']?>         
                          </li>                      
                           
                        <?php
                        }
                    ?>
                    </ul>
               </div>     
            </td>
            <?php } ?>
		</tr>

        <?php }        

		if(($task == 'newforward') || 
				($task == 'newreply') || 
				($task == 'newusul') ||
				($task == 'newfinal') ||
				($task == "editforward") || 
				($task == "editreply") || 
				($task == "editusul")){ ?>

		<tr>
			<td style="width:30%;" valign="top">
				Tujuan Surat <font color="red">*</font>
			</td>
			<td>
               <div style="max-height:95px; overflow:scroll;">
				<input type="text" id="txt_kepada" name="txt_kepada"  class="inputbox" style="width:80%;" />&nbsp;               
					<span id="req1" class="require_field" style="display:none;" title="Wajib Diisi">
						<img src="images/Alert.gif" />
					</span>
				<input type="hidden" name="txt1" id="txt1" value="<?php echo $data[1]; ?>" />
               </div>
			</td>
		</tr>

		<tr>
			<td valign="top">
				Tembusan 
			</td>
			<td>
               <div style="max-height:95px; overflow:scroll;">
	            <input type="text" id="txt_CC" name="txt_CC" class="input" style="width:80%" />&nbsp;
    		 	<input type="hidden" name="txt2" id="txt2" value="<?php echo $data[2]; ?>" />
               </div>
			</td>
		</tr>
        
        <?php }        ?>
		
		<tr>
			<td valign="top">
				Pesan
			</td>
			<td>
				<textarea name="txt3" style="width:80%;" rows="4" ><?php echo $data[3]; ?></textarea>
			</td>
		</tr>
		<tr>
			<td valign="top">
            	<input type="hidden" name="option" value="<?php echo $option; ?>" />
				<input type="hidden" name="task" value="<?php echo $task; ?>" />
				<input type="hidden" name="GIR_Id" value="<?php echo $_REQUEST["GIR_Id"]; ?>" />
				<input type="hidden" name="NId" value="<?php echo $_REQUEST["NId"]; ?>" />
				<input type="hidden" name="count" value="7" />
            </td>
			<td>
				<input type="button" class="art-button" value=" <?php echo $txt_btn; ?> " onclick="setSave()" />&nbsp;&nbsp;&nbsp;
				<input type="button" class="art-button" value=" Tutup " onclick="parent.closeWindow();" />
			</td>
		</tr>
	</table>
<?php
	if(($task == "editdisposisi") ||
		($task == "editforward") || 
		($task == "editreply") || 
		($task == "editusul")){
		echo "<script>relocate('kepadaRD', '$data[1]');</script>";
		echo "<script>relocate('ccRD', '$data[2]');</script>";
	}
?>
</form>
<?php
}

if($task == "step2"){
		?>
	<script type="text/javascript">
        document.getElementById("title").innerHTML = 'Upload File Digital';
    </script>
	<form name="form2" id="form2" method="post" enctype="multipart/form-data" action="handle.php" target="frmFile">
		<table cellspacing="2" cellpadding="2" style="width:550px;">
			<tr>
				<td style="width:15%;">Pilih File</td>
				<td style="width:85%;"><input type="file" name="file" />
					&nbsp;&nbsp;&nbsp;<input type="submit" value=" Upload " class="art-button" />
				</td>
			</tr>
			<tr style="display:<?php echo $trFileDesc; ?>">
				<td>&nbsp;</td>
				<td>
					<?php echo $lblUploaded; ?>
					<br />
                    <?php if(clean($_REQUEST["modeRD"]) == "newdisposisi") {
						?>
							<input type="hidden" name="txt3" id="txt3" value="1" />
						<?php 
						}else{ ?>
					<input type="checkbox" checked="checked" name="txt3" id="txt3" value="1" <?php echo $check; ?> 
						title="Memberikan ijin file untuk diakses oleh Pejabat bawahan langsung" />
						<label for="txt3" style="font-size:10px;">Memberikan ijin file untuk diakses oleh Pejabat bawahan langsung</label>
                    <?php } ?>
				</td>
			</tr>
			<tr>
				<td><input type="hidden" name="option" value="<?php echo $option; ?>" />
					<input type="hidden" name="task" value="addFile" />
				</td>
				<td>
					<input type="hidden" name="id" value="<?php echo $id; ?>" />
                    <input type="hidden" name="NId" value="<?php echo clean($_REQUEST["NId"]); ?>" />
					<input type="hidden" name="GId" value="<?php echo clean($_REQUEST["GIR_Id"]); ?>" />
                    <input type="hidden" name="count" value="3" />
				</td>
			</tr>		
			<tr>
				<td colspan="2">
					<iframe id="frmFile" name="frmFile" 
                    	src="frame.php?option=Mail&task=edit&filetopen=Mail_Files&NId=<?php echo $id; ?>&GIR_Id=<?php echo clean($_REQUEST["GIR_Id"]); ?>" 
						 style=" height:250px; max-height:250px; overflow:scroll;"
						 frameborder="0" width="98%"></iframe>
				</td>
			</tr>
		</table>
        <div style="text-align:right; margin:5px;">
        	<input type="button" value=" Kirim &amp; Tutup " class="art-button" onclick="parent.doneRD();" />
        </div>
		</form>
		<?php
	}
?>
