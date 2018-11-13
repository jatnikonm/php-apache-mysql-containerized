<?php
	$sql = "select f.FileName_fake, f.FileName_real, 
					i.NFileDir, f.NId, f.GIR_Id
			from inbox_files f, inbox i
			where f.NId = i.NId
				and f.NId = '" . $_REQUEST["NId"] . "' 
				and f.GIR_Id = '" . $_REQUEST["GIR_Id"] . "'";
	//echo $sql;
	$res = mysql_query($sql);
	
?>
<table class="adminlist" style="width:100%" cellpadding="2" cellspacing="0" >
	<tr>
		<th style="width:2%;">No</th>
		<th style="width:1%;">#</th>
		<th style="width:96%;">Nama File</th>
		<th style="width:1%;">#</th>
	</tr>
</table>
<div style="background-color:#FFFFFF; height:215px; max-height:215px; overflow:scroll;">
<table class="adminlist" style="width:100%" cellpadding="2" cellspacing="0" >
	<?php
		while($row = mysql_fetch_array($res)){ 
		$a++;
		if($a % 2) { //this means if there is a remainder
			$bg = '#Transparent';
		} else { //if there isn't a remainder we will do the else
			$bg = '#FFFFFF';
		}
	?>
	<tr style="background-color:<?php echo $bg; ?>">
		<td><?php echo $a; ?></td>
		<td><a href="FilesUploaded/<?php echo $row["NFileDir"] . "/" . $row["FileName_fake"]; ?>" target="_blank" title="Download File">
				<img src="images/download_dir.png" alt="Download" width="21" height="18" border="0"></a></td>
		<td><?php echo $row["FileName_real"]; ?></td>
		<td>
		<?php if(($task == "edit") || 
				($task == "editAdd")){ ?>
			<a href="#" onclick="setDelete('<?php echo $row["NId"]; ?>', '<?php echo $row["GIR_Id"]; ?>', '<?php echo $row["FileName_fake"]; ?>')">
				<img src="images/delete.png" width="18" height="18" border="0">
			</a>		
		<?php } ?>
		</td>
	</tr>
	<?php } ?>
</table>
</div>