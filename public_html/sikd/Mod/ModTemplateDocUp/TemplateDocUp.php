<?php	
	if($_SESSION["GroupId"] != "1"){
		die("<script>location.href='../../index.php'</script>");
	}
?>
<script type="text/javascript">	
	document.getElementById("title").innerHTML = 'Pengaturan Umum -> Upload Template Dokumen';
</script>
<form name="form1" id="form1" action="handle.php">
	<table id="listDocuments" width="100%" cellspacing="0">
		<tr>
			<td class="navrightheader" valign="middle" nowrap="nowrap">
				&nbsp;
				<span class="navIcon">
					<input type="button" id="btnTambah" value="Tambah" onclick="addDoc()" class="btn_add" />
				</span>
				<span class="navIcon">
					<input type="button" id="btnHapus" value="Hapus" onclick="setDelete()" class="btn_del" />
				</span>
			</td>
		</tr>
	</table>
	<div class="content-main-popup">
		<div id="pnlGrid">
			<?php
					$sql = "select * from master_doc_template ";
					$sql .= " order by upload_date";
					
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
					<th style="width:97%">Keterangan</th>
					<th style="width:1%"><img src="images/download_dir.png" width="20" height="20" /></th>
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
					<td><?php  echo $no; ?></td>
					<td><input type="checkbox" name="ids[]" value="<?php  echo $row["doc_id"]; ?>" /></td>
					<td><?php  echo $row["doc_desc"]; ?></td>
					<td><a href="FilesUploaded/TemplateDoc/<?php  echo $row["doc_file"]; ?>" target="_blank" ><img src="images/download_dir.png" width="20" height="20" /></a></td>
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
	<input type="hidden" name="option" value="<?php  echo $option; ?>" />
	<input type="hidden" name="task" value="delete" />
</form>