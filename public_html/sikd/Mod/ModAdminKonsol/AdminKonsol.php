<?php
	if($_SESSION["PeopleID"] != "1"){
		echo "<script>alert('Anda harus login sebagai Administrator Pusat !');</script>";
		die("<script>location.href='index2.php'</script>");
	}
?>
<script type="text/javascript">	
	document.getElementById("title").innerHTML = 'Pengaturan Umum -> Konsolidasi Data';
</script>
<div class="content-main-popup">
	<form name="form1" id="form1" method="post" action="handle.php" >
		<div style="width:95%; margin-top:25px; padding-left:5px; ">
			<p>Modul ini digunakan untuk melakukan Konsolidasi : 
				<ol>
					<li>Ekspor data dari Naskah dan Berkas dengan Tindakan Penyusutan Akhir = <strong>Serah</strong>.</li>
					<li>Output Konsolidasi berupa file <strong>folder </strong>yang tersimpan di lokasi <strong>/FilesUploaded/Konsolidasi/exp-<? echo $_SESSION["AppKey"]; ?></strong>.</li>				
				  <li>Folder <strong>exp-<? echo $_SESSION["AppKey"]; ?></strong> tersebut untuk diserahkan ke pihak <strong>ANRI</strong>.</li>
				</ol>
			</p>
			<p>
				<input type="hidden" name="option" value="AdminKonsol" />
				<input type="hidden" name="task" value="export" />
				<input type="submit" name="btnRestart" class="art-button" value=" Mulai Proses Konsolidasi ">
			</p>
		</div>
	</form>
</div>