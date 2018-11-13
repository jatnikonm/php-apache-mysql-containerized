<?php
	if($_SESSION["GroupId"] != "1"){
		die("<script>location.href='../../index.php'</script>");
	}
?>
<script type="text/javascript">	
	document.getElementById("title").innerHTML = 'Pengaturan Umum -> Setting Instansi';
</script>
<form id="form1" name="form1" method="post" action="handle.php">
<table id="listDocuments" width="100%" cellspacing="0">
    <tr>
        <td class="navrightheader" valign="middle" nowrap="nowrap">
            &nbsp;
            <span class="navIcon">
                <input type="button" id="btnTambah" value="Tambah" onclick="setDetails('new','')" class="btn_add" />
            </span>
            <span class="navIcon">
            	<input type="button" id="btnHapus" value="Hapus" onclick="setDelete()" class="btn_del" />
            </span>
        </td>
    </tr>
</table>

<div class="content-main-popup">
	<div id="pnlDetails" style="display:none">
		<table style="width:100%;" class="tb_grid" cellpadding="2" cellspacing="0">
			<tr>
				<td style="width:20%;"> Kode Instansi <font color="red">*</font></td>
				<td style="width:80%;">
					<input type="text" name="txt1" class="inputbox" maxlength="35" style="width:50%;">&nbsp;
					<span id="req" class="require_field" style="display:none">
						<img src="images/Alert.gif" />
					</span>
				</td>
			</tr>
            <tr>
				<td > Nama Instansi <font color="red">*</font></td>
				<td >
					<input type="text" name="txt2" class="inputbox" maxlength="250" style="width:80%;" value="<?php echo $_SESSION["NamaInstansi"]; ?>">&nbsp;
					<span id="req2" class="require_field" style="display:none">
						<img src="images/Alert.gif" />
					</span>
				</td>
			</tr>
            <tr>
				<td > Nama Resmi Lainnya </td>
				<td >
					<input type="text" name="txt3" class="inputbox" maxlength="250" style="width:80%;">&nbsp;
				</td>
			</tr>
            <tr>
				<td > Tipe Instansi </td>
				<td >
					<input type="text" name="txt4" class="inputbox" maxlength="250" style="width:80%;">&nbsp;
				</td>
			</tr>
            <tr>
				<td > Tanggal Keberadaan Instansi<font color="red">*</font></td>
				<td >
					<input type="text" name="txt5" id="txt5" class="inputbox" maxlength="10" style="width:80px;">&nbsp;
					<img src="images/calendar.png" alt="" width="16" height="15" align="absmiddle"  
										id="trigger1" style="cursor: pointer; border: 1px solid #CCCCCC;" title="Date selector" />
					<span id="req3" class="require_field" style="display:none">
						<img src="images/Alert.gif" />
					</span>
				</td>
			</tr>
            <tr>
				<td > Fungsi, Jabatan dan Kegiatan <font color="red">*</font></td>
				<td >
					<textarea name="txt6" class="inputbox" rows="5" style="width:80%;"></textarea>&nbsp;
					<span id="req4" class="require_field" style="display:none">
						<img src="images/Alert.gif" />
					</span>
				</td>
			</tr>
            <tr>
				<td > Mandat / Sumber Kewenangan<font color="red">*</font></td>
				<td >
					<input type="text" name="txt7" class="inputbox" maxlength="250" style="width:80%;">&nbsp;
					<span id="req5" class="require_field" style="display:none">
						<img src="images/Alert.gif" />
					</span>
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
				<td>&nbsp;</td>
				<td>
					<input type="hidden" name="option" value="<?php echo $option; ?>" />
					<input type="hidden" name="task" value="delete" />
					<input type="hidden" name="id" />
					<input type="hidden" name="count" value="8" />
					<input type="button" id="btnSimpan" value=" Simpan " onclick="confirmValidate()" class="art-button">&nbsp;
					<input type="button" id="btnBatal" value=" Kembali " onclick="setList()" class="art-button">
				</td>
			</tr>
		</table>
	</div>
	<div id="pnlGrid">
	<?php
		$sql = "select id, 
						(case i.created_date when ii.created_date then '' else 'disabled' end) as checked,
						kode_instansi, 
						nama_instansi, 
						date_format(i.created_date, '%d/%m/%Y') created_date,
						(case status_instansi when 1 then 'Aktif' else 'Non-Aktif' end) as status ,
						concat(kode_instansi, '|', nama_instansi, '|', nama_resmi, 
							'|', tipe_instansi, '|', date_format(tgl, '%d/%m/%Y'), '|', fungsi, '|', mandat, '|', status_instansi) as data
				from master_instansi i
				left join (select max(created_date) as created_date from master_instansi) ii on ii.created_date = i.created_date
				order by tgl desc ";
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
	<table class="adminlist" style="width:100%" cellpadding="2" cellspacing="0" >
		<tr>
			<th style="width:1%">No</th>
			<th style="width:1%">#</th>
			<th style="width:1%">&nbsp;</th>
			<th style="width:51%">Nama Instansi</th>
            <th style="width:25%">Status</th>
            <th style="width:23%">Tgl Perubahan Setting</th>
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
				<tr style="background-color:<?php echo $bg; ?>">
					<td><?php echo $no; ?></td>
					<td><input type="radio" <?php echo $row["checked"]; ?> id="rad_<?php echo $row["id"]; ?>" name="radio" onclick="getId('<?php echo $row["id"]; ?>')" value="<?php echo $row["id"]; ?>" /></td>
					<td><a href="#" onclick="setDetails('view','<?php echo $row["data"]; ?>')"><img src="images/edit.png" border="0" /></a></td>
					<td><label for="rad_<?php echo $row["id"]; ?>"><?php echo $row["nama_instansi"]; ?></label></td>
                    <td style="text-align:center;"><?php echo $row["status"]; ?></td>
                    <td style="text-align:center;"><?php echo $row["created_date"]; ?></td>
				</tr>
				<?php							
			}					
			mysql_free_result($result);
		?>
	</table>                
	<table style="width:100%;" cellpadding="2" cellspacing="0">
		<tr style="background-color:#FFFFFF;"> 
			<td><?php showpagenav('index2.php', $option, $page, $pagecount); ?></td>
		</tr>
	</table>
	</div>
</div>
	<script language="javascript">
		Calendar.setup(
			{
			  inputField  : "txt5",         // ID of the input field
			  ifFormat    : "%d/%m/%Y",    // the date format
			  button      : "trigger1",       // ID of the button
			  align          :    "Tl",           // alignment (defaults to "Bl")
			  singleClick    :    true
			}
			
		);
	</script>			
</form>