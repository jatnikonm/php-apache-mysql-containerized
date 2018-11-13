<?php
	if($_SESSION["GroupId"] != "1"){
		die("<script>location.href='../../index.php'</script>");
	}
?>
<script type="text/javascript">	
	document.getElementById("title").innerHTML = 'Pengaturan Umum -> Setting Text Tombol';
</script>
<form id="form1" name="form1" method="post" action="handle.php">
<div class="content-main-popup">
	<div id="pnlDetails" style="display:none">
		<table style="width:100%;" class="tb_grid" cellpadding="2" cellspacing="0">
			<tr>
				<td style="width:25%;"> Keterangan </td>
				<td style="width:75%;">
					<input type="text" name="txt0" disabled="disabled" class="inputbox" style="width:80%;">&nbsp;
				</td>
			</tr>
			<tr>
				<td> Text <font color="red">*</font></td>
				<td>
					<input type="text" name="txt1" class="inputbox" maxlength="20" size="30">
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input type="hidden" name="option" value="<?php echo $option; ?>" />
					<input type="hidden" name="task" value="delete" />
					<input type="hidden" name="id" />
					<input type="hidden" name="count" value="1" />
					<input type="button" id="btnSimpan" value=" Simpan " onclick="confirmValidate()" class="art-button">&nbsp;
					<input type="button" id="btnBatal" value=" Batal " onclick="setList()" class="art-button">
				</td>
			</tr>
		</table>
	</div>
	<div id="pnlGrid">
	<?php
		$sql = "select * from master_btn";
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
			<th style="width:1%">&nbsp;</th>
			<th style="width:70%">Keterangan</th>
			<th style="width:28%">Text</th>
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
					<td><a href="#" onclick="setDetails('edit','<?php echo $row["btn_func"] . '|' . $row["btn_desc"] . '|' . $row["btn_text"] ; ?>')"><img src="images/edit.png" border="0" /></a></td>
					<td><?php echo $row["btn_desc"]; ?></td>
					<td><?php echo $row["btn_text"]; ?></td>
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
</form>