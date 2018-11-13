<?php 
	session_start(); 
	$_SESSION["PeopleID"] = "1";
	$_SESSION["GroupId"] = "1";
	$_SESSION["masuk"] = "on";
	$option = $_REQUEST["option"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<title>Sistem Informasi Kearsipan Dinamis</title>
	<script type="text/javascript" src="../script.js"></script>
	<link rel="stylesheet" href="../style.css" type="text/css" media="screen" />
   	<link rel="shortcut icon" href="../favicon.ico">

    <!--[if IE 6]><link rel="stylesheet" href="../style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="../style.ie7.css" type="text/css" media="screen" /><![endif]-->

<?php
	$file_js = "ModAdminRestart/AdminRestart.js";
	if(file_exists($file_js)){
		include($file_js);
	}		
?>

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
							<h1 id="name-text" class="art-Logo-name">Sistem Informasi Kearsipan Dinamis</h1>
						</div>
					</div>
					<div class="art-contentLayout">
						<div class="art-content" style="width:100%;">
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
												<img src="../images/PostHeaderIcon.png" width="26" height="26" alt="PostHeaderIcon" />&nbsp;
												 Instalasi &amp Konfigurasi Sistem Informasi Kearsipan Dinamis
											</h2>
                                        </div>
                                        <div class="art-PostContent">
                                            <p>
												<?php 
													if($option == ''){
														$file = 'ModAdminRestart/AdminRestart.php';
													}else{
														$file = 'reset_conf.php';
													}
													include($file);
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
								<p>Hak Cipta &copy; 2011 Arsip Nasional Republik Indonesia</p>
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
