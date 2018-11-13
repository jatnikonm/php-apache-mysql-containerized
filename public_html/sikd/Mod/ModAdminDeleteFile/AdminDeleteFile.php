<script type="text/javascript">	
	document.getElementById("title").innerHTML = 'Notifikasi Hapus ';
</script>
<form id="form1" name="form1" method="post" action="handle.php">
<table id="listDocuments" width="100%" cellspacing="0">
    <tr>
        <td class="navrightheader" valign="middle" nowrap="nowrap">
            &nbsp;
            <span class="navIcon">
            	<input type="button" id="btnHapus" value="Hapus" onclick="setDelete()" class="btn_del" />
            </span>
        </td>
    </tr>
</table>
<?php
	$sql = "select ifs.GIR_Id, r.RoleDesc, p.PeopleName, 
			 date_format(ifs.EditedDate, '%d/%m/%Y %H:%i') as Tgl, ifs.FileName_real, ifs.Keterangan 
			 from inbox_files ifs 
			 join people p on p.PeopleId = ifs.PeopleID 
			 left join role r on r.RoleId = ifs.PeopleRoleID 
			 where ifs.FileKey = '" . $_SESSION["AppKey"] . "'
					and ifs.FileStatus = 'usul_hapus' ";
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
		<th style="width:1%"><input type="checkbox" onClick="changeCheckState(this.checked);"></th>
		<th style="width:25%">Pengirim</th>
		<th style="width:15%">Waktu</th>
		<th style="width:20%">Copy File Digital</th>
		<th style="width:39%">Pesan</th>
	</tr>
	<?php
		$no = $startrec;
		for ($i = $startrec; $i < $reccount; $i++)
		{
			$no++;
			if($no % 2) { //this means if there is a remainder
				$bg = '#Transparent';
			} else { //if there isn't a remainder we will do the else
				$bg = '#FFFFFF';
			}
			$row = mysql_fetch_assoc($result);	
			?>
			<tr style="background-color:<? echo $bg; ?>">
				<td><?php echo $no; ?></td>
				<td><input type="checkbox" name="ids[]" value="<?php echo $row["GIR_Id"]; ?>" /></td>
				<td><?php echo $row["RoleDesc"] . ', ' . $row["PeopleName"]; ?></td>
				<td><?php echo $row["Tgl"]; ?></td>
				<td><?php echo $row["FileName_real"]; ?></td>
				<td><?php echo $row["Keterangan"]; ?></td>
			</tr>
			<?php			
		}					
		
	?>
</table>
<table style="width:100%;" cellpadding="1" cellspacing="1">
	<tr style="background-color:#FFFFFF;"> 
		<td><?php showpagenav('index2.php', $option, $page, $pagecount); ?></td>
	</tr>
</table>
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
    <input type="hidden" name="task" value="delete" />
</form>
