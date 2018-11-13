<?php
	
	session_start(); 
	
	if(file_exists('install/index_install.php')){
		header('location:install/index_install.php');
		die();
	}
	
	unset($_SESSION["userid"]);
	unset($_SESSION["username"]);
	unset($_SESSION["user_level"]);
	$_SESSION["masuk"] = "on";
	require_once("conf.php");
	require_once("include/functions.php");

	$location = "install/index3.php";
	$sql = "select * from tb_setting";
	$res = @mysql_query($sql);
	if(@mysql_num_rows($res) > 0){
		while($row = @mysql_fetch_array($res)){
			if($row["tb_key"] === NULL){
				die("<script>" . $location . "</script>");
			}
			
			if($row["tb_key"] == ""){
				die("<script>" . $location . "</script>");
			}
			
			$_SESSION["AppKey"] = $row[0];
			$_SESSION["NamaInstansi"] = $row[1];
		}
	}else{
		header("location:" . $location);
	}	
	
	function loadFrontpage($param){
		$sql = "select $param from master_front";
		$result = mysql_query($sql);
		if (mysql_num_rows($result) > 0){
			while($row = mysql_fetch_array($result)){
				echo $row[0];
			}
		}
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>Sistem Informasi Kearsipan Dinamis</title>
<script type="text/javascript" src="script.js"></script>

	<link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="style/style_add.css" type="text/css" media="screen" />
    <!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="style.ie7.css" type="text/css" media="screen" /><![endif]-->
	<script type="text/javascript">
		function init(){
			document.forms.form1.txt1.focus();
		}
	</script>
</head>

<body onload="init()">
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
							<div id="slogan-text" class="art-Logo-text"><? echo $_SESSION["NamaInstansi"]; ?></div>
						</div>
					</div>
					<div class="art-contentLayout">
						<div class="art-sidebar1">
							<div class="art-Block">
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
											<div class="t">Login Sistem</div>
										</div>
									</div>
									<div class="art-BlockContent">
										<div class="art-BlockContent-body" >
											<form action="handle.php" id="form1" name="form1" method="post">
												<table width="100%" border="0" cellspacing="3">
													<tr>
														<td>Pengguna</td>
														<td><input type="text" id="txt1" name="txt1" maxlength="35" width="80%" placeholder="Nama Pengguna"></td>
													</tr>
													<tr>
														<td>Kata Sandi</td>
														<td><input type="password" id="txt2" name="txt2" maxlength="30" width="80%" placeholder="Kata Sandi"></td>
													</tr>
													<tr>
														<td>&nbsp;</td>
														<td>&nbsp;</td>
													</tr>
<!--                                                    <tr>
														<td>&nbsp;</td>
														<td><img id="siimage" style="border: 1px solid #000; margin-right: 15px" src="include/securimage_show.php?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="left"><a tabindex="-1" style="border-style: none;" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = 'include/securimage_show.php?sid=' + Math.random(); this.blur(); return false"><img src="images/refresh.png" alt="Reload Image" width="20" height="20" onclick="this.blur()" align="bottom" border="0"></a>
                                                        </td>
													</tr>
                                                    <tr>
														<td>Kode</td>
														<td><input type="text" id="txt3" name="txt3" maxlength="6" width="80%"></td>
													</tr>
-->													<tr>
														<td>
															<input type="hidden" id="option" name="option" value="Login" />
															<input type="hidden" id="task" name="task" value="login" />
															<input type="hidden" id="count" name="count" value="3" />
														</td>
														<td>
															<input type="submit" class="art-button" value="Masuk" />
														</td>
													</tr>
												</table>
											</form>
											<div class="cleared"></div>
										</div>
									</div>
									<div class="cleared"></div>
								</div>
							</div>
							<div class="art-Block">
								<img width="240" height="255" id="imgfront" src="<?php echo loadFrontpage('FrontImage'); ?>" />
								<div class="cleared"></div>
								<div class="cleared"></div>
							</div>
						</div>
						<div class="art-content" style="width:75%;">
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
                                                <?php 
													echo loadFrontpage('FrontTitle');
											    ?>
                                            </h2>
                                        </div>
                                        <div class="art-PostContent">
                                            <p>
												<?php 
													echo loadFrontpage('FrontLabel');
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
