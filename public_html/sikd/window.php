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
	$file_to_include = clean($_REQUEST["filetopen"]);
	$file_js = "Mod/" . $option . ".js";
	$width = clean($_REQUEST["width"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Aplikasi Otomasi Kearsipan</title>
	<script type="text/javascript">
		window.name= 'MyWindowDetail';
	</script>
	<script type="text/javascript" src="script.js"></script>

    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="style/style_add.css" type="text/css" media="screen" />
	<script type="text/javascript" src="include/jquery.js"></script>
    <!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="style.ie7.css" type="text/css" media="screen" /><![endif]-->
<?php
	$file_js = "Mod/Mod" . $option . "/" . $file_to_include . ".js";
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
				<div class="art-Sheet-body">
					<div class="art-contentLayout">
						<div class="art-content" style="width:<? echo $width; ?>px; overflow:hidden;">
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
											<?php
												if($option != ""){
													$filepath = "Mod/Mod" . $option . "/" . $file_to_include . ".php";
													if(file_exists($filepath)){
														include_once($filepath);
													}
												}
											?>
										<div class="cleared"></div>
										</div>
                                        <div class="cleared"></div>
									</div>
									<div class="cleared"></div>
								</div>
								<div class="cleared"></div>
							</div>
							<div class="cleared"></div>
						</div>
						<div class="cleared"></div>
					</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
		</div>
	</div>
</body>
</html>
