<?php
	$server = $data[2];
	$user = $data[3];
	$password = $data[4];
	
	if($_REQUEST["chooseConf"] == 'upgrade'){
		$fileOPen = "upgrade.sql";
		$database = $data[5];
		
	}else{
		$genCode = generateKey();
		
		$fileOPen = "install.sql";
		$database = "db_sikd_" . $genCode;
	}
	$con = @mysql_connect($server, $user, $password);
	if(!$con){
		die("<script>
			alert('Sistem Gagal Melakukan Koneksi ke Database. Periksa kembali Konfigurasi Anda !');
			history.go(-1);
			</script>");
		return false;
	}
	
	if(clean($_REQUEST["chooseConf"]) == 'new'){
		mysql_query("CREATE DATABASE `" . $database . "`;");
	}
	mysql_select_db($database, $con);
	
	//if Upgrade, getting GenKey
	if($_REQUEST["chooseConf"] == 'upgrade'){
		$sql = "select tb_key from tb_setting";
		$res = mysql_query($sql);
		while($row = mysql_fetch_array($res)){
			$genCode = $row[0];
		}
		mysql_free_result($res);
	}
	//die();
	//open file SQL
	$fileSQL = fopen($fileOPen, "r");
	while(!feof($fileSQL))
	{	
		$strQuery = str_replace('_GenKey_', $genCode, fgets($fileSQL));
		$strQuery = str_replace('_Nama Instansi_', clean($data[1]), $strQuery);
		$strQuery = str_replace('_Versi_', 'ver2.2-2012', $strQuery);
		mysql_query($strQuery);
	}
	fclose($fileSQL);

	//setting of app. version
	$sql = "update tb_setting set nama_instansi = '$data[1]', versi = 'ver2.2-2012' ";
	mysql_query($sql);
	
	//overwrite file conf.php
	$fileConf = fopen("../conf.php", "w+");
	$strData = "<?php	\n
		$" . server_mysql_local . " = '" . $data[2] . "';\n
		$" . user_mysql_local . " = '" . $data[3] . "';\n
		$" . password_mysql_local . " = '" . $data[4] . "';\n
		$" . database_mysql_local . " = '" . $database . "';\n
		$" . con_mysql_local . " = @mysql_connect($" . server_mysql_local . ", $" . user_mysql_local . ", $" . password_mysql_local . ");\n
		if(!$" . con_mysql_local . "){\n
			if(file_exists('install/index3.php')){
				$" . filename . " = 'index3.php';
			}else{
				$" . filename . " = 'index_install.php';
			}
			header('location:install/' . $" . filename . " . '?option=server_error');\n
		}\n
		mysql_select_db($" . database_mysql_local . " , $" . con_mysql_local . ");\n
		
		$" . 'gaSql[server]' . " = '" . $data[2] . "';\n
		$" . 'gaSql[user]' . " = '" . $data[3] . "';\n
		$" . 'gaSql[password]' . " = '" . $data[4] . "';\n
		$" . 'gaSql[db]' . " = '" . $database . "';\n
		

		?>";
	fwrite($fileConf, $strData);
	fclose($fileConf);
	
	//delete all folder
//	$MainDir = '../FilesUploaded';
//	remove_directory($MainDir);
	
	//create New Folder Default
//	mkdir($MainDir);
	
//	mkdir($MainDir . '/Temp');
//	mkdir($MainDir . '/Konsolidasi');
	
	if(file_exists('index_install.php')){
		rename('index_install.php', 'index3.php');
	}
	//die();
	die("<script>location.href='../index.php';</script>");
	
?>