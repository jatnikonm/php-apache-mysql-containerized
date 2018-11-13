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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sistem Informasi Kearsipan Dinamis</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="style/style_add.css" type="text/css" media="screen" />
	<script type="text/javascript">
		window.name= 'MyWindowDetail';
	</script>
	<script type="text/javascript" src="script.js"></script>
    <?php
		$file_js = "Mod/Mod" . $option . "/" . $file_to_include . ".js";
		if(file_exists($file_js)){
			include($file_js);
		}
	?>
</head>

<body onload="jInit();">
	<?php
		if($option != ""){
			$filepath = "Mod/Mod" . $option . "/" . $file_to_include . ".php";
			if(file_exists($filepath)){
				include_once($filepath);
			}
		}
	?>
</body>
</html>