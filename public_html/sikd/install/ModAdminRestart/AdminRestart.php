<form name="form1" id="form1" method="post" action="handle_install.php" >
	<div style="width:95%; margin-top:25px; padding-left:5px;">
		<p>
		<table style="width:100%;" width="100%" cellpadding="2">
			<tr>
			  	<td style="width:25%">Nama Instansi <font color="red">*</font></td>
				<td style="width:75%">
					<input type="text" name="txt1" id="txt1" style="width:40%;" maxlength="250" />
					<span id="req1" class="require_field" style="display:none" title="Masukkan Nama Instansi Baru !">
						<img src="../images/Alert.gif" width="12" height="12" border="0" />					</span>				</td>
			</tr>
			<tr> 
				<td>Alamat Server Database <font color="red">*</font></td>
				<td>
					<input type="text" name="txt2" id="txt2" style="width:40%;" value="localhost" maxlength="250" />
					<span id="req2" class="require_field" style="display:none" title="Masukkan Alamat Server Database !">
						<img src="../images/Alert.gif" width="12" height="12" border="0" />					</span><br /> 
					<em>Server MySQL Anda, biasanya diisi dengan 'localhost'.</em>				</td>
			</tr>
			<tr> 
				<td>Username Database <font color="red">*</font></td>
				<td>
					<input type="text" name="txt3" id="txt3" style="width:40%;" value="root" maxlength="250" />
					<span id="req3" class="require_field" style="display:none" title="Masukkan Username Database !">
						<img src="../images/Alert.gif" width="12" height="12" border="0" />					</span><br />
					<em>User yang diberikan akses ke Database, biasanya diisi dengan 'root'</em>				</td>
			</tr>
			<tr> 
				<td>Password User Database <font color="red">*</font></td>
				<td>
					<input type="password" name="txt4" id="txt4" style="width:40%;" maxlength="250" />
					<span id="req4" class="require_field" style="display:none" title="Masukkan Password User Database !">
						<img src="../images/Alert.gif" width="12" height="12" border="0" />					</span><br />
					<em>Password dari User Database, biasanya masih '' (kosong).</em>				</td>
			</tr>
		</table>
		
		<h2>Pilih Metode Instalasi </h2>
		<table cellspacing="2px" cellpadding="3px" width="100%">
			<tr>
			  <td align="left" class="indikator"><input type="radio" id="rad1" name="chooseConf" onclick="setInstall('new')" value="new" /> <label for="rad1">Instalasi Baru</label>	
				</td>
			</tr>	
			<tr>
				<td><hr /></td>
			</tr>
			<tr>
			  <td><input type="radio" id="rad2" name="chooseConf" onclick="setInstall('upgrade')" value="upgrade" /> <label for="rad2">Upgrade Aplikasi</label></td>
			</tr>
			<tr>
				<td>
					<div id="tbl_upgrade" style="display:none;">
						<table width="100%" cellpadding="2">
							<tr>
							  <td style="width:25%">&nbsp;</td>
								<td style="width:25%">Gunakan Database Sebelumnya <font color="red">*</font></td>
								<td style="width:50%">
									<input type="text" name="txt5" id="txt5" style="width:40%;" maxlength="250" />
									<span id="req5" class="require_field" style="display:none" title="Masukkan Nama Database !">
										<img src="../images/Alert.gif" width="12" height="12" border="0" />					</span><br />
									<em>Masukkan Nama Database.</em>				</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		   <tr>
				<td><hr /></td>
			</tr>
			<tr>
				  <td><em><font color="red">*</font> Kolom wajib diisi !</em></td>
			</tr>
			<tr>
				<td>
					<strong>Catatan : </strong>
					Untuk Konfigurasi pada server Linux
					<ul>
						<li>Pastikan pada file conf.php mendapatkan akses read &amp; write .</li>
						<li>Pastikan pada folder FilesUploaded mendapatkan akses read &amp; write .</li>
					</ul>
				</td>
			</tr>
			<tr>
				<td style="text-align:right"><input type="button" name="btnRestart" class="art-button" 
						value=" Mulai Proses Konfigurasi Aplikasi " onclick="subRestart()"></td>
			</tr>
		</table>				
		<input type="hidden" name="option" value="AdminRestart" />
		<input type="hidden" name="task" value="restart" />
		<input type="hidden" name="count" value="7" />
	</div>
</form>