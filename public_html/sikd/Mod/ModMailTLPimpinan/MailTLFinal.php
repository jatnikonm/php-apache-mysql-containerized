<?php
	if($_SESSION["GroupId"] == "" || 
		$_SESSION["PeopleID"] == ""){
		die("<script>location.href='index.php'</script>");
	}
	
	if($data[1] == ""){
		$data[1] = $_SESSION["to"];
		$data[2] = $_SESSION["cc"];
		$data[4] = $_SESSION["msg"];
	}
	
	$GId = $_REQUEST["GId"];
	$NId = $_REQUEST["NId"];
	
	if ($task == "editfinal"){
		$title = "Dokumen Final";
		$tr_upload = "none";		
		$sql = "select r.Msg from inbox_receiver r 
				where r.NId='$NId' 
					and r.GIR_Id='$GId'";	
		$res = mysql_query($sql);
		while($row = mysql_fetch_array($res)){
			$data[3] = $row[0];
		}
		mysql_free_result($res);
	}else{
		$tr_upload = "table-inline";
		$sql = "select btn_text from master_btn where btn_func = 'final'";	
		$res = mysql_query($sql);
		while($row = mysql_fetch_array($res)){
			$title = $row[0];
		}
		mysql_free_result($res);
	}
?>
<script type="text/javascript">
	document.getElementById("title").innerHTML = '<?php echo $title; ?>';
</script>
<form id="form1" name="form1" method="post" action="handle.php" target="MyWindowDetail">
	<table cellspacing="0" cellpadding="3px" width="100%">
		<tr>
			<td align="right" colspan="2" class="style1">
				<font color="red">*</font> kolom wajib diisi
			</td>
		</tr>
		<tr>
			<td style="width:20%;">Jenis Dokumen</td>
			<td style="width:80%;">-- Dokumen Final --</td>
		</tr>
		<tr>
			<td valign="top">
				Pesan
			</td>
			<td>
				<textarea name="txt4" rows="4" style="width:80%;" ><?php echo $data[3]; ?></textarea>
			</td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td>
				<input type="hidden" name="option" value="<?php echo $option; ?>" />
				<input type="hidden" name="task" value="<?php echo $task; ?>" />
				<input type="hidden" name="NId" value="<?php echo $NId; ?>" />
				<input type="hidden" name="GId" value="<?php echo $GId; ?>" />
				<input type="hidden" name="count" value="4" />
			</td>
		</tr>
	</table>
</form>
<form id="form2" name="form2" enctype="multipart/form-data" 
	method="post" action="handle.php" onsubmit="getMsg();" target="frmFile">
	<table cellspacing="0" cellpadding="3px" width="100%">
		<tr style="display:<?php echo $tr_upload; ?>">
			<td style="width:20%;">Pilih Dokumen</td>
			<td style="width:80%;"><input type="file" name="file" />
				&nbsp;&nbsp;&nbsp;<input type="submit" value=" Upload " class="art-button" />			</td>
		</tr>
			
		<tr>
			<td colspan="2">
				<iframe id="frmFile" name="frmFile" 
					src="frame.php?option=Mail&task=<?php echo $task; ?>&filetopen=Mail_Files&NId=<?php echo $NId; ?>&GIR_Id=<?php echo clean($GId); ?>" 
					 style=" height:200px; max-height:250px; overflow:scroll;"
					 frameborder="0" width="98%"></iframe>			</td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td>
            	<input type="hidden" name="txt3" value="1" />
				<input type="hidden" name="txt4" />
				<input type="hidden" name="option" value="<?php echo $option; ?>" />
				<input type="hidden" name="task" value="finalFile" />
				<input type="hidden" name="count" value="4" />
				<input type="hidden" name="NId" value="<?php echo $NId; ?>" />
				<input type="hidden" name="GId" value="<?php echo $GId; ?>" />			</td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td>
				<input type="button" class="art-button" value=" Kirim " onclick="setSave()" />&nbsp;&nbsp;&nbsp;
				<input type="button" class="art-button" value=" Tutup " onclick="parent.closeWindow();" />			</td>
		</tr>
	</table>
</form>