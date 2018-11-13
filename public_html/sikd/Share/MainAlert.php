<script type="text/javascript">
	document.getElementById("leftTitle").innerHTML = 'Halaman Utama';
</script>
<div id="pnlMain" style="width:100%;">
	Selamat Datang <strong><?php echo $_SESSION["PName"]; ?></strong><br />
	<?php echo $_SESSION["NamaJabatan"]; ?><br />
	<a href="#" onclick="OpenWinPassword()">
		<font color="#0066FF">Ubah Kata Sandi</font>
	</a>
</div>
<div id="pnlMail" style="display:none; width:100%; margin-top:5px;">
	<br />
    <img src="images/Alert.gif" style="vertical-align:middle" alt="alert" title="Ada Surat Masuk Baru !" />&nbsp;&nbsp;
	<a href="index2.php?option=MailInboxSuratBaru" title="Ada Surat Masuk Baru !">
		 <?php	
            if($_SESSION["GroupId"] == 4)
			{
         ?>		
            	<font color="#0066FF"><strong>Ada Surat Masuk Baru Milik Pimpinan !</strong></font>
         <?php	
		 	}else{ 
		 ?>
                <font color="#0066FF"><strong>Ada Surat Masuk Baru !</strong></font>
         <?php	
		 	}  
		 ?>
	</a>
</div>
<div id="pnlAlertDelete" style="display:none; width:100%; margin-top:5px;">
	<br />
	<img src="images/Alert.gif" style="vertical-align:middle" alt="alert" />&nbsp;&nbsp;
	<a href="index2.php?option=PindahBerkas&task=list">
		<font color="#0066FF"><strong>Ada Permohonan Pemindahan Arsip !</strong></font>
	</a>
</div>