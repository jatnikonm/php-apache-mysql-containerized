<?php
	session_start();
		
	require_once("../../conf.php");
	require_once("../../include/fungsi_indotgl.php");
	$tgl1 = $_REQUEST["tgl1"];
	$tgl2 = $_REQUEST["tgl2"];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan</title>
<link rel="stylesheet" type="text/css" href="../../style/sipati.css">
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
					<h2><b>LAPORAN REGISTRASI NASKAH MASUK</b></h2>
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
				<th width="4%" height="29" style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">No.</th>
				<th width="8%" style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Tanggal Naskah</th>
				<th width="10%" style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">No Naskah</th>
				<th width="20%" style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Perihal</th>
				<th width="15%" style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Asal Naskah</th>
				<th width="15%" style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Tujuan Naskah</th>
				<th width="8%" style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Tanggal Registrasi</th>
                <th width="15%" style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Keterangan</th>
			</tr>
			<?php
            $sql = "SELECT 
                    inbox.Tgl,
                    inbox.Nomor,
                    inbox.Hal,
                    role.RoleName,
                    inbox.InstansiPengirim,
                    inbox.pengirim,
                    (case inbox_receiver.ReceiverAs
                      when 'to' then 'Surat Masuk Eksternal'
                      when 'cc1' then 'Disposisi' else
                      'Surat Masuk Internal' end) as Ket,
					inbox.NTglReg
                    FROM
                    inbox
                    Inner Join inbox_receiver ON inbox_receiver.NId = inbox.NId
                    Inner Join role ON role.RoleId = inbox_receiver.RoleId_To
                    WHERE CreationRoleId = '$_SESSION[PrimaryRoleId]' and inbox_receiver.ReceiverAs = 'to' and ";

            if(!empty($tgl1) and !empty($tgl2))
            $sql .= "(inbox.NTglReg between '" . mkdate($tgl1) . "' and '" . mkdate($tgl2) . "') ";

            $sql .= ' order by inbox.Tgl DESC ';
			$res = mysql_query($sql);
			$no=1;
            $jml_lap = mysql_num_rows($res);
            if($jml_lap!=0){
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
					<td style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><center><?php echo tgl_indo($row["Tgl"]); ?></center></td>
					<td style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["Nomor"]; ?></td>
					<td style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["Hal"]; ?></td>
					<td style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">
                    <?php
                       if($row['pengirim']=='internal'){
                        $ssl = mysql_query("select rolename from role where roleid = '".$row['InstansiPengirim']."'");
                        $rows = mysql_fetch_array($ssl);
                        echo $rows['rolename'];
                       }
                       else
                        echo $row["InstansiPengirim"];


                    ?></td>
					<td style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["RoleName"]; ?></td>
                    <td style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><center><?php echo tgl_indo($row["NTglReg"]); ?></center></td>
                    <td style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["Ket"]; ?></td>
				</tr>
				<?php $no++; } } else { ?>
                <tr>
					<td colspan="8" align="center" style="padding:0.4em; border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Data tidak ditemukan</td>
				</tr>
            <?php
            }
			mysql_free_result($res);
			?>
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
