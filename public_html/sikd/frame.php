<?php
	session_start();
	require_once("conf.php");
	require_once("include/checkLogin.php");
	require_once("include/functions.php");
	
	$peopleId = $_REQUEST["peopleId"];
	$option = clean($_REQUEST["option"]);
	$task = clean($_REQUEST["task"]);
	$id = clean($_REQUEST["id"]);
	$file_to_include = clean($_REQUEST["filetopen"]);
	$file_js = "Mod/" . $option . ".js";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>SIKD Frame</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="script.js"></script>
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="style/style_add.css" type="text/css" media="screen" />
    <!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="style.ie7.css" type="text/css" media="screen" /><![endif]-->
	<?php
		$file_js = "Mod/Mod" . $option . "/" . $file_to_include . ".js";
		if(file_exists($file_js)){
			include($file_js);
		}
	?>
</head>

<body style="background:none;">
	<div id="art-main" style="background-color:#FFFFFF;">
		<div class="art-Sheet" style="width:90%; background-color:#FFFFFF;">
			<div class="art-Sheet-body">
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
	</div>
</body>
</html>
