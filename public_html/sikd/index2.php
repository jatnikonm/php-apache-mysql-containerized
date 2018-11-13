<?php
	session_start();
	if ($_SESSION["PeopleID"] == "" || $_SESSION["GroupId"] == ""){
		die("<script>location.href = 'index.php';</script>");
	}
	require_once("conf.php");
	
	require("include/checkLogin.php");
	require_once("include/functions.php");
	
	$option = clean($_REQUEST["option"]);
	$task = clean($_REQUEST["task"]);
	$id = clean($_REQUEST["id"]);
	
	if(($_SESSION["GroupId"] == "1") || ($_SESSION["GroupId"] == "2")){
		$BerkasBtn = 'inline';
	}else{
		$BerkasBtn = 'none';
	}

	date_default_timezone_set('Asia/Jakarta');

	//fungsi cek waktu session. jika bernilai false atau tidak true

	$idletime=600;//after 10 menit the user gets logged out
	if (time()-$_SESSION['timestamp']>$idletime){
		?><script language="javascript">document.location.href='handle.php?option=Login&task=logout';</script><?php
		exit(0);		
	}else{
		$_SESSION['timestamp']=time();
	}

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>Sistem Informasi Kearsipan Dinamis</title>
<script type="text/javascript" src="script.js"></script>
<script type="text/javascript" src="include/jquery1.5.js"></script>
<script type="text/javascript" src="include/tinybox.js"></script>
<script type="text/javascript" src="include/tinybox_property.js"></script>
<script type="text/javascript" src="include/chat/js/chat.js"></script>
<script type="text/javascript" language="javascript" src="include/jquery.dataTables.js"></script>

	<link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="style/style_add.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="style/tiny.css" type="text/css" media="screen" />
	<link type="text/css" rel="stylesheet" media="all" href="include/chat/css/chat.css" />
	<link type="text/css" rel="stylesheet" media="all" href="include/chat/css/screen.css" />

	<!--[if lte IE 7]><link type="text/css" rel="stylesheet" media="all" href="css/screen_ie.css" /><![endif]-->
    <!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="style.ie7.css" type="text/css" media="screen" /><![endif]-->
 
    
<script type="text/javascript" src="include/jquery.tokeninput.js"></script>
<link rel="stylesheet" type="text/css" href="style/token-input.css" />
<link rel="stylesheet" href="style/token-input-facebook.css" type="text/css" />
	<script type="text/javascript">
	<!--
	
	function getWindow() {
		var getParam = getProperty(arguments[0]);
		var winW, winH, wUrl;
		winW = getParam[0];
		winH = getParam[1];
		wUrl = getParam[2] + '&' + arguments[1];
		
		TINY.box.show({ iframe: wUrl, boxid: window, fixed: false, width: winW, height: winH, opacity: 40 });        
	}
	
	function openWindow(){
		var getParam = getProperty(arguments[0]);
		var winW, winH, wUrl;
		winW = getParam[0];
		winH = getParam[1];
		wUrl = getParam[2] + '&' + arguments[1];
		window.open(wUrl, arguments[0], 'width=' + winW + ', height=' + winH);
	}
	
	function closeWindow(){
		TINY.box.hide();
	}
	
	function doneWindow(){
		TINY.box.hide();
		location.reload(true);
	}
	-->
	</script>
<?php
	if($option != ""){
		$file_js = "Mod/Mod" . $option . "/" . $option . "_validate.js";
		if(file_exists($file_js)){
			include($file_js);
		}
	}else{
		echo '<script type="text/javascript" src="include/notification.js"></script>';
	}
	
	if(($_SESSION["GroupId"] == "1") || ($_SESSION["GroupId"] == "2")){
		$menu = $_REQUEST["menu"];
		if($menu != ""){
			if(($menu == "admin") || ($menu == "user")){
				$_SESSION["menu"] = $menu;
			}
		}
	}
	$width_main = '100%';
?>
	<script type="text/javascript">
		function OpenWinPassword(){
			getWindow('changePass', '');
		}
	</script>
</head>

<body>
	<div id="art-page-background-simple-gradient"></div>
	<div id="art-main">
        <div class="art-Sheet">
			<div class="art-Sheet">
				<div class="art-Sheet-tl"></div>
				<div class="art-Sheet-tr"></div>
				<div class="art-Sheet-bl"></div>
				<div class="art-Sheet-br"></div>
				<div class="art-Sheet-tc"></div>
				<div class="art-Sheet-bc"></div>
				<div class="art-Sheet-cl"></div>
				<div class="art-Sheet-cr"></div>
				<div class="art-Sheet-cc"></div>
				<div class="art-Sheet-body">
					<div class="art-Header">
						<div class="art-Header-png"></div>
						<div class="art-Header-jpeg"></div>
						<div class="art-Logo">
							<h1 id="name-text" class="art-Logo-name"><a href="#">Sistem Informasi Kearsipan Dinamis</a></h1>
							<div id="slogan-text" class="art-Logo-text"><?php echo $_SESSION["NamaInstansi"]; ?></div><br />
							<div class="art-Logo-text" style="font-size:12px; font-style:normal;">Selamat Datang <strong><?php echo $_SESSION["PName"]; ?></strong> Anda Login Sebagai <strong><?php echo $_SESSION["GroupName"]; ?></strong> | <a href="#" onClick="OpenWinPassword()">Ubah Kata Sandi</a></div>
						</div>
					</div>
					<div class="art-nav">
						<div class="l"></div>
						<div class="r"></div>
						<div style="width:747px; margin:0px; float:left;">
							<ul class="art-menu">
                            
								  <?php
								  // Jika login sebagai admin, yang muncul hanya menu unit kerja - pengguna, pengaturan umum dan kalisifikasi
								  if(($_SESSION["PeopleUsername"] == "admin")){ 
								  ?>
									<li>
										<a href="index2.php?option=Share&task=UKP" class="{ActiveItem}"><span class="l"></span><span class="t">Unit Kerja &amp; Pengguna</span></a>
										<ul>
											<li><a href="index2.php?option=AdminUnitKerja&task=list">Pengaturan Unit Kerja</a></li>
											<li><a href="index2.php?option=AdminPengguna&task=list">Pengaturan Pengguna</a></li>
										</ul>
									</li>
                                    <li>
                                        <a href="index2.php?option=Share&task=General" class="{ActiveItem}"><span class="l"></span><span class="r"></span><span class="t">Pengaturan Umum</span></a>
                                        <ul>
                                            <li><a href="index2.php?option=SetBahasa&task=list">Pengaturan Bahasa</a></li>
                                            <li><a href="index2.php?option=SetJNaskah&task=list">Pengaturan Jenis Naskah</a></li>
                                            <li><a href="index2.php?option=SetMedia&task=list">Pengaturan Media Arsip</a></li>
                                            <li><a href="index2.php?option=SetSNaskah&task=list">Pengaturan Sifat Naskah</a></li>
                                            <li><a href="index2.php?option=SetTP&task=list">Pengaturan Tingkat Perkembangan</a></li>
                                            <li><a href="index2.php?option=SetUrgensi&task=list">Pengaturan Tingkat Urgensi</a></li>
                                            <li><a href="index2.php?option=SetExtensi&task=list">Pengaturan Jenis Extensi File</a></li>
                                            <li><a href="index2.php?option=SetButton&task=list">Pengaturan Text Tombol</a></li>
                                            <li><a href="index2.php?option=SetSUnit&task=list">Pengaturan Satuan Unit</a></li>
                                            <li><a href="index2.php?option=SetGJabatan&task=list">Pengaturan Grup Jabatan</a></li>
                                            <li><a href="index2.php?option=SetDisposisi&task=list">Pengaturan Isi Disposisi</a></li>
                                            <li><a href="#"><hr /></a></li>
                                            <li><a href="index2.php?option=SetSitus&task=list">Pengaturan Halaman Depan</a></li>
                                            <li><a href="index2.php?option=SetInstansi&task=list">Pengaturan Data Instansi</a></li>
                                            <li><a href="#"><hr /></a></li>
                                            <li><a href="index2.php?option=TemplateDocUp">Upload Template Dokumen</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="index2.php?option=Share&task=CLB" class="{ActiveItem}"><span class="l"></span><span class="r"></span><span class="t"> Klasifikasi</span></a>
                                        <ul>
                                            <li><a href="index2.php?option=AdminClassification&task=list">Pengaturan Klasifikasi</a></li>
                                        </ul>
                                    </li>
                                    
                                  <?php
                                  }else{
								  ?>

									<?php 
									if($_SESSION["menu"]=="user"){
									?>
									<li>
										<a href="index2.php" class="{ActiveItem}"><span class="l"></span><span class="r"></span><span class="t">Halaman Utama</span></a>
									</li>
											<?php if(($_SESSION["GroupId"] == "3")){ ?>
                                            <li>
                                                <a href="#"><span class="l"></span><span class="r"></span><span class="t">Registrasi Naskah</span></a>
                                                <ul>
                                                    <li><a href="index2.php?option=Mail&mode=outboxmemo&task=new">Registrasi Memo</a></li>
                                                    <li><a href="index2.php?option=Mail&mode=outbox&task=new">Registrasi Nota Dinas</a></li>
                                                    <li><a href="index2.php?option=Mail&mode=outboxins&task=new">Registrasi Naskah Keluar</a></li>
                                                    <li><a href="index2.php?option=Mail&mode=inboxuk&task=new">Registrasi Naskah Tanpa Tindaklanjut</a></li>
                                                    <li><a href="#"><hr /></a></li>
                                                    <li><a href="index2.php?option=TemplateDoc">Download Template Dokumen</a></li>
                                                </ul>
                                            </li>    
											<?php } else if(($_SESSION["GroupId"] == "4")){ ?>
                                            <li>
                                                <a href="#"><span class="l"></span><span class="r"></span><span class="t">Registrasi Naskah</span></a>
                                                <ul>
                                                    <!-- <li><a href="index2.php?option=Mail&mode=inbox&task=new">Registrasi Naskah Masuk</a></li>  -->
                                                    <li><a href="index2.php?option=Mail&mode=outboxmemo&task=new">Registrasi Memo</a></li>
                                                    <li><a href="index2.php?option=Mail&mode=outbox&task=new">Registrasi Nota Dinas</a></li>
                                                    <li><a href="index2.php?option=Mail&mode=outboxins&task=new">Registrasi Naskah Keluar</a></li>
                                                    <li><a href="index2.php?option=Mail&mode=inboxuk&task=new">Registrasi Naskah Tanpa Tindaklanjut</a></li>
                                                    <li><a href="#"><hr /></a></li>
                                                    <li><a href="index2.php?option=TemplateDoc">Download Template Dokumen</a></li>
                                                </ul>
                                            </li>    
											<?php } else if(($_SESSION["GroupId"] == "6")){ ?>
                                            <li>
                                                <a href="#"><span class="l"></span><span class="r"></span><span class="t">Registrasi Naskah</span></a>
                                                <ul>
                                                    <li><a href="index2.php?option=Mail&mode=inbox&task=new">Registrasi Naskah Masuk</a></li>
                                                    <li><a href="index2.php?option=Mail&mode=outboxmemo&task=new">Registrasi Memo</a></li>
                                                    <li><a href="index2.php?option=Mail&mode=outbox&task=new">Registrasi Nota Dinas</a></li>
                                                    <li><a href="index2.php?option=Mail&mode=outboxins&task=new">Registrasi Naskah Keluar</a></li>
                                                    <li><a href="index2.php?option=Mail&mode=inboxuk&task=new">Registrasi Naskah Tanpa Tindaklanjut</a></li>
                                                    <li><a href="#"><hr /></a></li>
                                                    <li><a href="index2.php?option=TemplateDoc">Download Template Dokumen</a></li>
                                                </ul>
                                            </li>    
											<?php } else if(($_SESSION["GroupId"] == "7")){ ?>
                                            <li>
                                                <a href="#"><span class="l"></span><span class="r"></span><span class="t">Registrasi Naskah</span></a>
                                                <ul>
                                                    <li><a href="index2.php?option=Mail&mode=outboxins&task=new">Registrasi Naskah Keluar</a></li>
                                                    <li><a href="index2.php?option=Mail&mode=inboxuk&task=new">Registrasi Naskah Tanpa Tindaklanjut</a></li>
                                                    <li><a href="#"><hr /></a></li>
                                                    <li><a href="index2.php?option=TemplateDoc">Download Template Dokumen</a></li>
                                                </ul>
                                            </li>    
											<?php } else if(($_SESSION["GroupId"] == "5")) { ?>
                                            <li>
                                                <a href="#"><span class="l"></span><span class="r"></span><span class="t">Registrasi Naskah</span></a>
                                                <ul>
                                                    <li><a href="index2.php?option=Mail&mode=inbox&task=new">Registrasi Naskah Masuk</a></li>
                                                    <li><a href="index2.php?option=Mail&mode=inboxuk&task=new">Registrasi Naskah Tanpa Tindaklanjut</a></li>
                                                    <li><a href="#"><hr /></a></li>
                                                    <li><a href="index2.php?option=TemplateDoc">Download Template Dokumen</a></li>
                                                </ul>
											</li>
									<?php } ?>	
									<li>
											<?php if(($_SESSION["GroupId"] == "3") || ($_SESSION["GroupId"] == "4") || ($_SESSION["GroupId"] == "7")){ ?>
												<a href="index2.php?option=MailInbox&task=list"><span class="l"></span><span class="r"></span><span class="t">Naskah Masuk</span></a>
											<?php } else if(($_SESSION["GroupId"] == "6")){ ?>
												<a href="index2.php?option=MailInbox&task=list"><span class="l"></span><span class="r"></span><span class="t">Naskah Masuk</span></a>
                                                <ul>
                                                    <li><a href="index2.php?option=MailInbox&task=list">Naskah Masuk</a></li>
                                                    <li><a href="index2.php?option=MailInboxPimpinan&task=list">Naskah Masuk Pimpinan</a></li>
                                                </ul>
											<?php }?>
									</li>
											<?php if(($_SESSION["GroupId"] == "3")){ ?>
                                            <li>
                                                <a href="#"><span class="l"></span><span class="r"></span><span class="t">Log Registrasi</span></a>
                                                <ul>
                                                    <li><a href="index2.php?option=LogMemo&task=list">Log Registrasi Memo</a></li>
                                                    <li><a href="index2.php?option=MailOutbox&task=list">Log Registrasi Nota Dinas</a></li>
                                                    <li><a href="index2.php?option=LogIns&task=list">Log Registrasi Naskah Keluar</a></li>
                                                    <li><a href="index2.php?option=MailInboxUk&task=list">Log Registrasi Naskah Tanpa Tindaklanjut</a></li>
                                                </ul>
											</li>
											<?php } else if(($_SESSION["GroupId"] == "4")){ ?>
                                            <li>
                                                <a href="#"><span class="l"></span><span class="r"></span><span class="t">Log Registrasi</span></a>
                                                <ul>
                                                    <li><a href="index2.php?option=LogMemo&task=list">Log Registrasi Memo</a></li>
                                                    <li><a href="index2.php?option=MailOutbox&task=list">Log Registrasi Nota Dinas</a></li>
                                                    <li><a href="index2.php?option=LogIns&task=list">Log Registrasi Naskah Keluar</a></li>
                                                    <li><a href="index2.php?option=MailInboxUk&task=list">Log Registrasi Naskah Tanpa Tindaklanjut</a></li>
                                                </ul>
											</li>
											<?php } else if(($_SESSION["GroupId"] == "6")){ ?>
                                            <li>
                                                <a href="#"><span class="l"></span><span class="r"></span><span class="t">Log Registrasi</span></a>
                                                <ul>
                                                    <li><a href="index2.php?option=LogSuratMasuk&task=list">Log Registrasi Naskah Masuk</a></li>
                                                    <li><a href="index2.php?option=LogMemo&task=list">Log Registrasi Memo</a></li>
                                                    <li><a href="index2.php?option=MailOutbox&task=list">Log Registrasi Nota Dinas</a></li>
                                                    <li><a href="index2.php?option=LogIns&task=list">Log Registrasi Naskah Keluar</a></li>
                                                    <li><a href="index2.php?option=MailInboxUk&task=list">Log Registrasi Naskah Tanpa Tindaklanjut</a></li>
                                                </ul>
											</li>
											<?php } else if(($_SESSION["GroupId"] == "7")){ ?>
                                            <li>
                                                <a href="#"><span class="l"></span><span class="r"></span><span class="t">Log Registrasi</span></a>
                                                <ul>
                                                    <li><a href="index2.php?option=LogIns&task=list">Log Registrasi Naskah Keluar</a></li>
                                                    <li><a href="index2.php?option=MailInboxUk&task=list">Log Registrasi Naskah Tanpa Tindaklanjut</a></li>
                                                </ul>
											</li>
											<?php } else if(($_SESSION["GroupId"] == "5")) { ?>
                                            <li>
                                                <a href="#"><span class="l"></span><span class="r"></span><span class="t">Log Registrasi</span></a>
                                                <ul>
                                                    <li><a href="index2.php?option=LogSuratMasuk&task=list">Log Registrasi Naskah Masuk</a></li>
                                                    <li><a href="index2.php?option=MailInboxUk&task=list">Log Registrasi Naskah Tanpa Tindaklanjut</a></li>
                                                </ul>
                                            </li>    
											<?php }?>
									<li>
										<a href="#"><span class="l"></span><span class="r"></span><span class="t">Berkas</span></a>
										<ul>
											<li><a href="index2.php?option=AdminBerkas&task=list">Berkas Unit Kerja</a></li>
											<?php if(($_SESSION["GroupId"] == "1") || ($_SESSION["GroupId"] == "2")){ ?>
											<li><a href="index2.php?option=NotifyBerkasAktiveAdm&task=list">Daftar Berkas Yang Melewati Masa Aktif</a></li>
											<?php } else { ?>
											<li><a href="index2.php?option=NotifyBerkasAktive&task=list">Daftar Berkas Yang Melewati Masa Aktif</a></li>
											<li><a href="index2.php?option=PindahBerkas&task=list">Usul Pindah Arsip Inaktif</a></li>
											<?php } ?>
											<?php if(($_SESSION["GroupId"] == "1") || ($_SESSION["GroupId"] == "2")){ ?>
											<li><a href="index2.php?option=NotifyBerkasInAktive&task=list">Daftar Berkas Yang Melewati Masa Inaktif</a></li>
											<?php } ?>
										</ul>
									</li>
                                    <?php if(($_SESSION["GroupId"] == "1") || ($_SESSION["GroupId"] == "2")){ ?>
                                    <li>
                                        <a href="index2.php?option=Share&task=CLB" class="{ActiveItem}"><span class="l"></span><span class="r"></span><span class="t"> Penyusutan Berkas</span></a>
                                        <ul>
                                            <li><a href="index2.php?option=PindahBerkas&task=list">Usul Pindah Arsip Inaktif</a></li>
                                            <li><a href="index2.php?option=UsulMusnah&task=list">Usul Musnah Arsip</a></li>
                                            <li><a href="index2.php?option=Musnah&task=list">Pemusnahan Arsip</a></li>
                                            <li><a href="index2.php?option=UsulSerah&task=list">Usul Serah Arsip Statis</a></li>
                                            <li><a href="index2.php?option=Serah&task=list">Penyerahan Arsip Statis</a></li>
                                        </ul>
                                    </li>
                                    <?php } ?>
									<?php if(($_SESSION["GroupId"] == "3")){ ?>
                                    <li>
                                        <a href="#"><span class="l"></span><span class="r"></span><span class="t">Laporan</span></a>
                                        <ul>
                                            <li><a href="index2.php?option=AdminReportMasuk">Naskah Masuk</a></li>
                                            <li><a href="index2.php?option=AdminReportKeluar">Naskah Keluar</a></li>
                                            <li><a href="index2.php?option=AdminReportBerkas">Daftar Berkas</a></li>
                                        </ul>
                                    </li>
                                    <?php } else if(($_SESSION["GroupId"] == "4")){ ?>
                                    <li>
                                        <a href="#"><span class="l"></span><span class="r"></span><span class="t">Laporan</span></a>
                                        <ul>
                                            <li><a href="index2.php?option=AdminReportMasuk">Naskah Masuk</a></li>
                                            <li><a href="index2.php?option=AdminReportKeluar">Naskah Keluar</a></li>
                                            <li><a href="index2.php?option=AdminReportBerkas">Daftar Berkas</a></li>
                                        </ul>
                                    </li>
                                    <?php } else if(($_SESSION["GroupId"] == "6")){ ?>
                                    <li>
                                        <a href="#"><span class="l"></span><span class="r"></span><span class="t">Laporan</span></a>
                                        <ul>
                                            <li><a href="index2.php?option=AdminReportLogMasuk">Registrasi Naskah Masuk</a></li>
                                            <li><a href="index2.php?option=AdminReportLogTL&task=list">Registrasi Naskah Tanpa Tindaklanjut</a></li>
                                            <li><a href="index2.php?option=AdminReportMasuk">Naskah Masuk</a></li>
                                            <li><a href="index2.php?option=AdminReportKeluar">Naskah Keluar</a></li>
                                            <li><a href="index2.php?option=AdminReportBerkas">Daftar Berkas</a></li>
                                        </ul>
                                    </li>
                                    <?php } else if(($_SESSION["GroupId"] == "7")){ ?>
                                    <li>
                                        <a href="#"><span class="l"></span><span class="r"></span><span class="t">Laporan</span></a>
                                        <ul>
                                            <li><a href="index2.php?option=AdminReportMasuk">Naskah Masuk</a></li>
                                            <li><a href="index2.php?option=AdminReportKeluar">Naskah Keluar</a></li>
                                            <li><a href="index2.php?option=AdminReportBerkas">Daftar Berkas</a></li>
                                        </ul>
                                    </li>
                                    <?php } else if(($_SESSION["GroupId"] == "5")) { ?>
                                    <li>
                                        <a href="#"><span class="l"></span><span class="r"></span><span class="t">Laporan</span></a>
                                        <ul>
                                            <li><a href="index2.php?option=AdminReportLogMasuk">Registrasi Naskah Masuk</a></li>
                                            <li><a href="index2.php?option=AdminReportLogTL&task=list">Registrasi Naskah Tanpa Tindaklanjut</a></li>
                                            <li><a href="index2.php?option=AdminReportBerkas">Daftar Berkas</a></li>
                                        </ul>
                                    </li>    
                                    <?php }?>
                                            
                                            

									<?php
									}if($_SESSION["menu"]=="admin"){
									?>
									<li>
										<a href="index2.php?option=Share&task=UKP" class="{ActiveItem}"><span class="l"></span><span class="t">Unit Kerja &amp; Pengguna</span></a>
										<ul>
											<li><a href="index2.php?option=AdminUnitKerja&task=list">Pengaturan Unit Kerja</a></li>
											<li><a href="index2.php?option=AdminPengguna&task=list">Pengaturan Pengguna</a></li>
										</ul>
									</li>
										<?php	if(($_SESSION["GroupId"] == "1")){	?>
											<li>
												<a href="index2.php?option=Share&task=General" class="{ActiveItem}"><span class="l"></span><span class="r"></span><span class="t">Pengaturan Umum</span></a>
												<ul>
													<li><a href="index2.php?option=SetBahasa&task=list">Pengaturan Bahasa</a></li>
													<li><a href="index2.php?option=SetJNaskah&task=list">Pengaturan Jenis Naskah</a></li>
													<li><a href="index2.php?option=SetMedia&task=list">Pengaturan Media Arsip</a></li>
													<li><a href="index2.php?option=SetSNaskah&task=list">Pengaturan Sifat Naskah</a></li>
													<li><a href="index2.php?option=SetTP&task=list">Pengaturan Tingkat Perkembangan</a></li>
													<li><a href="index2.php?option=SetUrgensi&task=list">Pengaturan Tingkat Urgensi</a></li>
													<li><a href="index2.php?option=SetExtensi&task=list">Pengaturan Jenis Extensi File</a></li>
													<li><a href="index2.php?option=SetButton&task=list">Pengaturan Text Tombol</a></li>
                                                    <li><a href="index2.php?option=SetSUnit&task=list">Pengaturan Satuan Unit</a></li>
                                                    <li><a href="index2.php?option=SetGJabatan&task=list">Pengaturan Grup Jabatan</a></li>
                                                    <li><a href="index2.php?option=SetDisposisi&task=list">Pengaturan Isi Disposisi</a></li>
													<li><a href="#"><hr /></a></li>
                                                    <li><a href="index2.php?option=SetSitus&task=list">Pengaturan Halaman Depan</a></li>
													<li><a href="index2.php?option=SetInstansi&task=list">Pengaturan Data Instansi</a></li>
                                                    <li><a href="#"><hr /></a></li>
													<li><a href="index2.php?option=TemplateDocUp">Upload Template Dokumen</a></li>
												</ul>
											</li>
										<?php } ?>
										<?php	if($_SESSION["GroupId"] == "1") {	?>
											<li>
												<a href="index2.php?option=Share&task=CLB" class="{ActiveItem}"><span class="l"></span><span class="r"></span><span class="t"> Klasifikasi &amp; Berkas</span></a>
												<ul>
													<li><a href="index2.php?option=AdminClassification&task=list">Pengaturan Klasifikasi</a></li>
													<li><a href="index2.php?option=AdminBerkas&task=list">Pengaturan Berkas</a></li>
												</ul>
											</li>
										<?php } ?>
									<?php
									} }
								?>
							</ul>
						</div>
						<div style="width:25%; margin:0px; float:right; text-align:right;">
							  
						  <?php
						  //Jika login menggunakan admin, link menu admin hilang
                          if(($_SESSION["PeopleUsername"] == "admin")){ 
                          ?>
                        
                            <ul class="art-menu" style="float:right;">
								<li><a href="handle.php?option=Login&task=logout"><span class="l"></span><span class="r"></span><span class="t">Keluar</span></a></li>
							</ul>

                        
						  <?php
                          }else{
                          ?>

                            <ul class="art-menu" style="float:right;">
								<?php
									$link="";
									$text="";
									if(($_SESSION["GroupId"] == "1") || ($_SESSION["GroupId"] == "2")){
										if($_SESSION["menu"]=="admin"){
											$link="?menu=user";
											$text="Menu Pengguna";
										}
										if($_SESSION["menu"]=="user") {
											$link="?menu=admin";
											$text="Menu Admin";
										}	
									}
								?>
								<li><a href="<?php echo $link; ?>"><span class="l"></span><span class="r"></span><span class="t"><?php echo $text; ?></span></a></li>
								<li><a href="handle.php?option=Login&task=logout"><span class="l"></span><span class="r"></span><span class="t">Keluar</span></a></li>
							</ul>
                            
						<?php
                         }
                        ?>
                        
						</div>
					</div>
					<div class="art-contentLayout">
						<?php
						
						//Jika login sebagai admin, menu klasifikasi, pilihan berkas di left menu hilang
						if(($_SESSION["PeopleUsername"] == "admin")){ 
						
							if($option != ""){
								if(($option == "SetBahasa") ||
									($option == "SetJNaskah") ||
									($option == "SetMedia") ||
									($option == "SetSNaskah") ||
									($option == "SetTP") ||
									($option == "SetUrgensi")|| 
									($option == "SetExtensi") || 
									($option == "SetColor") || 
									($option == "SetButton") || 
									($option == "SetSUnit") || 
									($option == "SetGJabatan") || 
									($option == "SetDisposisi") || 
									($option == "TemplateDocUp") || 
									($option == "Share" && $task == "General")){
									$file_include = 'Share/MenuLeftGeneral.htm';
								}
								
								else if ($option == "AdminBerkas"){
									$file_include = "Share/MainBerkas.php";
								}
								else if ($option == "MailInboxUk"){
									//$file_include = "Share/MainInboxUk.php";
								}
//								else if($option == "AdminPengguna"){
//									$file_include = "Share/MainBerkas.php";
//								}
//								else if(($option == "AdminUnitKerja") ||
//									($option == "Share" && $task == "UKP")){
//									$file_include = 'Share/MenuLeftAksesSistem.htm';
//								}
								else if($option == "AdminOthersBerkas"){
									$file_include = "Share/MainBerkasOthers.php";
								}
								
							}else {
								$file_include = 'Share/MainAlert.php';
							}
						}
						else
						{
							if($option != ""){
								if(($option == "SetBahasa") ||
									($option == "SetJNaskah") ||
									($option == "SetMedia") ||
									($option == "SetSNaskah") ||
									($option == "SetTP") ||
									($option == "SetUrgensi")|| 
									($option == "SetExtensi") || 
									($option == "SetColor") || 
									($option == "SetButton") || 
									($option == "SetSUnit") || 
									($option == "SetGJabatan") || 
									($option == "SetDisposisi") || 
									($option == "TemplateDocUp") || 
									($option == "Share" && $task == "General")){
									$file_include = 'Share/MenuLeftGeneral.htm';
								}
/*								
								else if(($option == "AdminClassification") ||
									($option == "Share" && $task == "CLB")){
									//$width_main = "990px";
									if($_SESSION["GroupId"] == "1"){
									$file_include = 'Share/MenuLeftDokumentasiAdmin.htm';
									}
								}
								else if ($option == "AdminBerkas"){
									$file_include = "Share/MainBerkas.php";
								}
*/								else if ($option == "MailInboxUk"){
									//$file_include = "Share/MainInboxUk.php";
								}
//								else if($option == "AdminPengguna"){
//									$file_include = "Share/MainBerkas.php";
//								}
/*								else if(($option == "AdminUnitKerja") ||
									($option == "Share" && $task == "UKP")){
									$file_include = 'Share/MenuLeftAksesSistem.htm';
								}
*/								else if($option == "AdminOthersBerkas"){
									$file_include = "Share/MainBerkasOthers.php";
								}
								
							}else {
								$file_include = 'Share/MainAlert.php';
							}
						}
								if(file_exists($file_include)){
									if($width_main == "100%"){
										$width_main = '747px';
									}
							?>
								<div class="art-sidebar1">
									<div class="art-Block" style="max-width:250px;">
										<div class="art-Block-tl"></div>
										<div class="art-Block-tr"></div>
										<div class="art-Block-bl"></div>
										<div class="art-Block-br"></div>
										<div class="art-Block-tc"></div>
										<div class="art-Block-bc"></div>
										<div class="art-Block-cl"></div>
										<div class="art-Block-cr"></div>
										<div class="art-Block-cc"></div>
										<div class="art-Block-body">
											<div class="art-BlockHeader">
												<div class="l"></div>
												<div class="r"></div>
													<div class="art-header-tag-icon">
													<div class="t"><span id="leftTitle" name="leftTitle"></span></div>
												</div>
											</div>
											<div class="art-BlockContent">
												<div class="art-BlockContent-body">
													<?php
														include($file_include);
													?>
													<div class="cleared"></div>
												</div>
											</div>
											<div class="cleared"></div>
										</div>
									</div>
									<div class="art-Block" style="max-width:250px;">
										<div class="art-Block-tl"></div>
										<div class="art-Block-tr"></div>
										<div class="art-Block-bl"></div>
										<div class="art-Block-br"></div>
										<div class="art-Block-tc"></div>
										<div class="art-Block-bc"></div>
										<div class="art-Block-cl"></div>
										<div class="art-Block-cr"></div>
										<div class="art-Block-cc"></div>
										<div class="art-Block-body">
											<div class="art-BlockHeader">
												<div class="l"></div>
												<div class="r"></div>
													<div class="art-header-tag-icon">
													<div class="t">User Online</div>
												</div>
											</div>
											<div class="art-BlockContent">
												<div class="art-BlockContent-body">
													<div id="pnlMain" style="width:100%;">
														<span id="listOnline" name="listOnline"></span>
													</div>
													<div class="cleared"></div>
												</div>
											</div>
											<div class="cleared"></div>
										</div>
									</div>
								</div>
							<?php
							}
						?>
						<div class="art-content" style="width:<?php echo $width_main; ?>;">
							<div class="art-Post">
								<div class="art-Post-tl"></div>
								<div class="art-Post-tr"></div>
								<div class="art-Post-bl"></div>
								<div class="art-Post-br"></div>
								<div class="art-Post-tc"></div>
								<div class="art-Post-bc"></div>
								<div class="art-Post-cl"></div>
								<div class="art-Post-cr"></div>
								<div class="art-Post-cc"></div>
								<div class="art-Post-body">
                        			<div class="art-Post-inner">
                                        <div class="art-PostMetadataHeader">
                                            <h2 class="art-PostHeader">
                                                <img src="images/PostHeaderIcon.png" width="26" height="26" alt="PostHeaderIcon" />
                                                <span id="title"></span>
                                            </h2>
                                        </div>
                                        <div class="art-PostContent">
                                            <p>
												<?php
													if($option != ""){
														if($option == 'Share'){
															$filepath = "Share/Main" . $task . ".htm";
															if(file_exists($filepath)){
																include($filepath);
															}
														}else{
															$filepath = "Mod/Mod" . $option . "/" . $option . ".php";
															if(file_exists($filepath)){
																require_once("include/pagenav.php");
																$showrecs = 25;
																$pagerange = 10;
																$a = @$_GET["a"];
																$recid = @$_GET["recid"];
																$page = @$_GET["page"];
																if (!isset($page)) $page = 1;
																include($filepath);
															}
														}
													}else{
														$filepath = "Share/MainDefault.php";
														if(file_exists($filepath)){
															include($filepath);
														}
													}
											   ?>
											</p>
                                        </div>
                                        <div class="cleared"></div>
                       				</div>                        
                        		<div class="cleared"></div>
                            </div>
							</div>
						</div>
					</div>
					<div class="cleared"></div>
					<div class="art-Footer">
						<div class="art-Footer-inner">
							<div class="art-Footer-text">
								<p>Hak Cipta &copy; 2016 Arsip Nasional Republik Indonesia</p>
							</div>
						</div>
						<div class="art-Footer-background"></div>
					</div>
				</div>
			</div>
			<div class="cleared"></div>
		</div>
	</div>
</body>
</html>
