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
	
	$width = clean($_REQUEST["width"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistem Informasi Kearsipan Dinamis</title>
	<script type="text/javascript">
		window.name= 'MyWindowDetail';
	</script>
	<base target="_self" />
	<script type="text/javascript" src="script.js"></script>

    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="style/style_add.css" type="text/css" media="screen" />
    <!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="style.ie7.css" type="text/css" media="screen" /><![endif]-->
<?php
	$file_js = "Share/Lookup/frm" . $option . ".js";
	if(file_exists($file_js)){
		include($file_js);
	}
?>
</head>

<body>
	<div id="art-page-background-simple-gradient"></div>
	<div id="art-main">
		<div class="art-Sheet">
			<div class="art-Sheet-body">
				<div class="art-contentLayout">
					<?php
						if($option != ""){
							$filepath = "Share/Lookup/frm" . $option . ".php";
							if(file_exists($filepath)){
								require_once("include/pagenav.php");
								$showrecs = 8;
								$pagerange = 10;
								$a = @$_GET["a"];
								$recid = @$_GET["recid"];
								$page = @$_GET["page"];
								if (!isset($page)) $page = 1;
								
								include_once($filepath);
							}
						}
					?>
				</div>
				<div class="cleared"></div>
			</div>
			<div class="cleared"></div>
		</div>
	</div>
</body>
</html>
