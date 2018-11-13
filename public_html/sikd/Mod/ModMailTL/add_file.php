<?php
session_start();
$NId = $_REQUEST['NId'];
$GIR_Id = $_REQUEST['GIR_Id'];
?>

<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Upload File Surat';
</script>
<br /><br />
<form id="form2" name="form2" enctype="multipart/form-data" method="post" action="handle.php" onsubmit="getMsg();" target="frmFile">
	<table cellspacing="0" cellpadding="3px" width="100%">
		<tr style="display:<?php echo $tr_upload; ?>">
			<td style="width:20%;">Pilih Dokumen</td>
			<td style="width:80%;"><input type="file" name="file" id="file" />
				&nbsp;&nbsp;&nbsp;<input type="submit" value=" Upload " class="art-button" />			</td>
		</tr>

		<tr>
			<td colspan="2">
			 <!--	<iframe id="frmFile" name="frmFile"
					src="frame.php?option=Mail&task=<?php echo $task; ?>&filetopen=Mail_Files&NId=<?php echo $NId; ?>&GIR_Id=<?php echo clean($GId); ?>"
					 style=" height:200px; max-height:250px; overflow:scroll;"
					 frameborder="0" width="98%"></iframe> -->

             <iframe id="frmFile" name="frmFile"
					src="frame.php?option=MailTL&task=<?php echo $task; ?>&filetopen=Mail_Files&NId=<?php echo $NId; ?>&GId=<?php echo clean($GIR_Id); ?>"
					 style=" height:200px; max-height:250px; overflow:scroll;"
					 frameborder="0" width="98%"></iframe>
             </td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td>
                <input type="hidden" name="txt3" value="1" />
                <input type="hidden" name="count" value="3" />
				<input type="hidden" name="option" value="MailTL" />
				<input type="hidden" name= 'task' value="addFile" />
				<input type="hidden" name='NId' value="<?php echo $NId; ?>" />
                <input type="hidden" name='GId' value="<?php echo $GIR_Id; ?>" />
			</td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td align="right">
				<input type="button" class="art-button" value=" Tutup " onclick="parent.doneWindow();" /></td>
		</tr>
	</table>
</form>