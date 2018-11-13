<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Laporan';
</script>
<div class="content-main-popup">
	<form name="form1" id="form1" action="">
		<table width="100%" cellpadding="2" id="listDocuments" cellspacing="0">
			<tr>
				<td class="navrightheader" colspan="2" valign="middle" nowrap="nowrap">
					<strong>Pembuatan Laporan</strong>
				</td>
			</tr>
			<tr>
				<td></td>                    
				<td></td>                    
			</tr>
			<tr>
				<td style="width:15%;" class="tabel-upload-label">
					Pilih Jenis Laporan
				</td>
				<td style="width:85%;" class="tabel-upload-content">
					<select name="txt1" class="inputbox">
						<?php 
//							$sql = "select CONVERT(substring(RId, 12), SIGNED) as nmr, RId, RName 
//								from master_report_name 
//								where Mid(RName,9,5) = 'Arsip' or Mid(RName,9,5) = 'Umum'
//								order by nmr ";
							$sql = "select CONVERT(substring(RId, 12), SIGNED) as nmr, RId, RName 
								from master_report_name 
								where RId in ('" . $_SESSION["AppKey"] . ".6','" . $_SESSION["AppKey"] . ".7','" . $_SESSION["AppKey"] . ".13' )
								order by nmr ";
							$result = mysql_query($sql);
							while($row = mysql_fetch_array($result)){
								echo "<option value='" . $row["RId"] . "'>" . $row["RName"] . "</option>";
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="tabel-upload-label">Periode</td>
				<td valign="middle" class="tabel-upload-content">
					<input type="text" name="txt2" id="txt2" class="inputbox" maxlength="10" style="width:70px;">&nbsp;
					<img src="images/calendar.png" alt="" width="16" height="15" align="absmiddle"  
						id="trigger1" style="cursor: pointer; border: 1px solid #CCCCCC;" title="Date selector" /> 
							
					&nbsp;&nbsp;s/d&nbsp;&nbsp;
					
					<input type="text" name="txt3" id="txt3" class="inputbox" maxlength="10" style="width:70px;">&nbsp;
					<img src="images/calendar.png" alt="" width="16" height="15" align="absmiddle"  
						id="trigger2" style="cursor: pointer; border: 1px solid #CCCCCC;" title="Date selector" /> 
				</td>                    
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="button" value="Tampilkan Laporan" class="art-button" onclick="OpenReport()" /></td>
			</tr>
			<tr>
				<td colspan="2"></td>                    
			</tr>
		</table>
		<script language="javascript">
			Calendar.setup(
				{
				  inputField  : "txt2",         // ID of the input field
				  ifFormat    : "%d/%m/%Y",    // the date format
				  button      : "trigger1",       // ID of the button
				  align          :    "Tl",           // alignment (defaults to "Bl")
				  singleClick    :    true
				}
				
			);
			
			Calendar.setup(
				{
				  inputField  : "txt3",         // ID of the input field
				  ifFormat    : "%d/%m/%Y",    // the date format
				  button      : "trigger2",       // ID of the button
				  align          :    "Tl",           // alignment (defaults to "Bl")
				  singleClick    :    true
				}
				
			);
		</script>
	</form>
</div>
