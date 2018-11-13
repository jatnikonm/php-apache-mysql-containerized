<?php
	session_start();
		
	require_once("../../conf.php");
	require_once("../../include/fungsi_indotgl.php");

    $mod = $_REQUEST['mod'];
    $ids = $_REQUEST['ids'];

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistem Informasi Kearsipan Dinamis</title>
<link rel="shortcut icon" href="../../favicon.ico">
<style>
	.content-main-report
	{
		width:100%;
		height: auto;
		margin-right: 5px;
		background-color:#FFFFFF;
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:8pt;
		line-height:10pt;
	}
</style>
</head>

<body onload="window.print();">
	<div class="content-main-report">
		<table width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td style="text-align:center;">
					<h2><b>DAFTAR ARSIP STATIS YANG DISERAHKAN</b></h2>
				</td>
			</tr>
			<tr>
				<td style="text-align:center;">
					<?php
						if($tgl1 != '' && $tgl2 != ''){
							echo "<strong>" . $tgl1 . "</strong>&nbsp; s/d &nbsp;<strong>" . $tgl2 . "</strong>";
						}
					?>
				</td>
			</tr>
		</table>
		<br />
		<br />
		<table width="100%" class="tb_report" cellspacing="0" style="border:#000000 1px solid;">
			<tr>
				<th width="1%" height="29" style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">No.</th>
				<th width="8%" style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Nomor Berkas</th>
				<th width="27%" style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Nama Berkas</th>
				<th width="3%" style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Tanggal Berkas</th>
				<th width="15%" style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Unit Kerja</th>
			</tr>
			<?php

            $sql = "SELECT berkasid FROM permohonan_serah where idserah='$ids'";
			$res = mysql_query($sql);
            $row = mysql_fetch_array($res);
            $idberkas = explode("#",$row[0]);
            $jml_array =  count($idberkas);
            for($i=1;$i<$jml_array;$i++){
            $sql = "SELECT
                        berkas.Klasifikasi,
                        berkas.BerkasNumber,
                        berkas.BerkasName,
                        berkas.CreationDate,
                        role.RoleName
                        FROM
                        berkas
                        Inner Join role ON role.RoleId = berkas.RoleId
                        WHERE berkas.BerkasId =  '".$idberkas[$i]."'
                        GROUP BY
                        berkas.BerkasId";

            $res = mysql_query($sql);
            $no=1;
            //$jml_lap = mysql_num_rows($res);
            //if($jml_lap!=0){
			while($row = mysql_fetch_array($res)){
				if($no%2!=0)
				{
					echo "<tr style='background-color:#99CCFF;color:#000000;'>";
				}
				else
				{
					echo "<tr style='background-color:#FFFFFF;color:#000000;'>";
				}
			  ?>
					<td align="right" style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $no; ?>.</td>
					<td style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row[0]."/".$row[1]; ?></td>
					<td style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row[2]; ?></td>
					<td style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo tgl_indo($row[3]); ?></td>
                    <td style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row[4]; ?></td>
				</tr>
               <?php } }mysql_free_result($res);?>
		</table>
	</div>
</body>
</html>
<?php
	function mkdate($str){
		$arrDate = split('/', $str);
		return ($arrDate[2] . '-' . $arrDate[1] . '-' . $arrDate[0]);
	}
?>
