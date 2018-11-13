<?php
	session_start();
		
	require_once("../../conf.php");
	
	$jlap = $_REQUEST["jlap"];
	$tgl1 = $_REQUEST["tgl1"];
	$tgl2 = $_REQUEST["tgl2"];
	
	//getting Nama Laporan
	$sql = "select RName from master_report_name where RId like '" . $jlap . "'";
	$res = mysql_query($sql);
	while($row = mysql_fetch_array($res)){
		$jnsLap = $row["RName"];
	}
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
					<h2><?php echo $jnsLap; ?></h2>
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
				<th width="2%" height="29" style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">No.</th>
				<th width="16%" style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Nomor Surat</th>
				<th width="21%" style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Hal</th>
				<th width="10%" style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Tgl Surat</th>
				<th width="6%" style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Jumlah</th>
				<th width="15%" style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Nomor/Nama Berkas</th>
				<th width="10%" style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"> Unit Pengolah </th>
				<th  width="9%" style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Tingkat Perkembangan</th>

			</tr>
			<?php
				$sql = "select i.NId,
							(case BerkasNumber when '0' then '-' else b.BerkasNumber end) as BerkasNumber, 
							(case b.BerkasName when 'General Temp' then ' - ' else b.BerkasName end) as BerkasName, b.BerkasLokasi, 
							i.Nomor, i.Hal, i.NIsi, i.NJml, NLokasi, date_format(i.Tgl, '%d/%m/%Y') as Tgl, 
							r.RoleName, 
							ma.APName, mk.KatName, mv.VitName, mp.SusutName, ms.MeasureUnitName , tp.TPName, r.RoleDesc
						from inbox i 
						JOIN berkas b on b.BerkasId = i.BerkasId 
						join inbox_receiver ir on ir.NId = i.NId
						left join master_aksespublik ma on ma.APId = i.APId 
						left join master_kategoriarsip mk on mk.KatId = i.KatId 
						left join master_vital mv on mv.VitId = i.VitId 
						left join master_penyusutan mp on mp.SusutId = b.SusutId 
						left join berkas_history bh on bh.BerkasId = b.BerkasId
						left join master_satuanunit ms on ms.MeasureUnitId = i.MeasureId
						left join master_tperkembangan tp on tp.TPId = i.TPId
						join role r on r.RoleId = b.RoleId 
						where r.RoleId = '" . $_SESSION["PrimaryRoleId"] . "'";
			
            switch($jlap){
				case $_SESSION["AppKey"] . ".6":
                    $sql .= " and (b.RetensiValue_Active < '" . date("Y-m-d") . "') ";
					break;
                
				case $_SESSION["AppKey"] . ".7":
                    $sql .= " and (b.RetensiValue_InActive < '"  . date("Y-m-d") . "') ";
					break;
                				
            }
			if($tgl1 != '' && $tgl2 != ''){
            	$sql .= " and (i.Tgl between '" . mkdate($tgl1) . "' and '" . mkdate($tgl2) . "') ";
			}
			
			$sql .= ' order by i.NTglReg DESC ';
			//echo $sql;
			$res = mysql_query($sql);
			$no=1;

			while($row = mysql_fetch_array($res)){
				?>
				<tr>
					<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $no; ?></td>
					<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["Nomor"]; ?></td>
					<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["Hal"]; ?></td>
					<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["Tgl"]; ?></td>
					<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["NJml"]; echo ' '; echo $row["MeasureUnitName"]; ?></td>
					<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["BerkasNumber"]; echo ' '; echo $row["BerkasName"]; ?></td>
					<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["RoleDesc"]; ?></td>
					<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["TPName"]; ?></td>
				</tr>
				<?php $no++; 
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
