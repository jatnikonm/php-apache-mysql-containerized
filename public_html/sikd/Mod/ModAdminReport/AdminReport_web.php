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
				<th style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Nomor Berkas</th>
				<th style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Judul Berkas</th>
				<th style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Lokasi Fisik Berkas</th>
				<th style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Nomor Item</th>
				<th style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Isi Ringkas Item</th>
				<th style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;text-align:center">Tgl Arsip</th>
				<th style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;text-align:center">Jml Item</th>
				<th style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Lokasi Fisik Item</th>
				<th style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Nama Kopi Digital / File Elektronik</th>
<!--			<th style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Jabatan Pimpinan Unit Pengolah</th>
				<th style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Kategori Arsip</th>
				<th style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Vital / Tidak Vital</th>
				<th style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Tingkat Akses Publik</th>
-->				<th style="border-bottom: #000000 solid 1px;">Tindakan Penyusutan</th>
			</tr>
			<?php
				$sql = "select i.NId,
							(case BerkasNumber when '0' then '-' else b.BerkasNumber end) as BerkasNumber, 
							(case b.BerkasName when 'General Temp' then ' - ' else b.BerkasName end) as BerkasName, b.BerkasLokasi, 
							i.Nomor, i.Hal, i.NIsi, i.NJml, NLokasi, date_format(i.Tgl, '%d/%m/%Y') as Tgl, 
							r.RoleName, 
							ma.APName, mk.KatName, mv.VitName, mp.SusutName 
						from inbox i 
						JOIN berkas b on b.BerkasId = i.BerkasId 
						join inbox_receiver ir on ir.NId = i.NId
						left join master_aksespublik ma on ma.APId = i.APId 
						left join master_kategoriarsip mk on mk.KatId = i.KatId 
						left join master_vital mv on mv.VitId = i.VitId 
						left join master_penyusutan mp on mp.SusutId = b.SusutId 
						left join berkas_history bh on bh.BerkasId = b.BerkasId
						join role r on r.RoleId = b.RoleId 
						where ir.ReceiverAs = 'to'";
			
            switch($jlap){
                case $_SESSION["AppKey"] . ".2":
                    $sql .= " and i.KatId = '" . $_SESSION["AppKey"] . ".1' ";
					break;
                
				case $_SESSION["AppKey"] . ".3":
                    $sql .= " and i.APId = '" . $_SESSION["AppKey"] . ".2' ";
					break;
                
				case $_SESSION["AppKey"] . ".4":
                    $sql .= " and i.APId = '" . $_SESSION["AppKey"] . ".1' ";
					break;
                
				case $_SESSION["AppKey"] . ".5":
                    $sql .= "  and i.VitId = '" . $_SESSION["AppKey"] . ".1' ";
					break;
                
				case $_SESSION["AppKey"] . ".6":
                    $sql .= " and (b.BerkasStatus = 'open' and ((b.BerkasCountSince = 'created' and b.RetensiValue_Active > '" . date("Y-m-d") . "') or 
								(b.BerkasCountSince = 'closed' and b.RetensiValue_Active < '" . date("Y-m-d") . "'))) ";
					break;
                
				case $_SESSION["AppKey"] . ".7":
                    $sql .= " and (b.BerkasStatus = 'closed' 
                    		  and (b.RetensiValue_Active > '"  . date("Y-m-d") . "' 
                    		  or b.RetensiValue_InActive <= '"  . date("Y-m-d") . "')) ";
					break;
                
				case $_SESSION["AppKey"] . ".8":
                    $sql .= " and (b.BerkasStatus = 'closed' 
                    		and b.RetensiValue_InActive > '"  . date("Y-m-d") .  "') 
                    		and b.SusutId = '" . $_SESSION["AppKey"] . ".1' ";
					break;
                
				case $_SESSION["AppKey"] . ".9":
                    $sql .= "and (b.BerkasStatus = 'closed' 
                    		 and b.RetensiValue_InActive > '" . date("Y-m-d") . "') 
                    		 and b.SusutId = '" . $_SESSION["AppKey"] . ".2' ";
					break;
                
				case $_SESSION["AppKey"] . ".10":
                    $sql .= "and (b.BerkasStatus = 'closed' 
                    		 and b.RetensiValue_InActive > '" . date("Y-m-d") . "') 
                    		 and b.SusutId = '" . $_SESSION["AppKey"] . ".3' ";
					break;
					
				case $_SESSION["AppKey"] . ".11":
                    $sql .= "and b.BerkasStatus = 'susut' 
                    		 and b.SusutId = '" . $_SESSION["AppKey"] . ".1' 
							 and bh.ActionDate between '" . mkdate($tgl1) . "' and '" . mkdate($tgl2) . "' ";
					break;
					
				case $_SESSION["AppKey"] . ".12":
                    $sql .= "and b.BerkasStatus = 'susut' 
                    		 and b.SusutId = '" . $_SESSION["AppKey"] . ".2' 
							 and bh.ActionDate between '" . mkdate($tgl1) . "' and '" . mkdate($tgl2) . "' ";
					break;
            }
			if($tgl1 != '' && $tgl2 != ''){
            	$sql .= " and (i.Tgl between '" . mkdate($tgl1) . "' and '" . mkdate($tgl2) . "') ";
			}
			
			$sql .= ' order by i.NTglReg DESC ';
			//echo $sql;
			$res = mysql_query($sql);
			while($row = mysql_fetch_array($res)){
				?>
				<tr>
					<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["BerkasNumber"]; ?></td>
					<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["BerkasName"]; ?></td>
					<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["BerkasLokasi"]; ?></td>
					<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["Nomor"]; ?></td>
					<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["NIsi"]; ?></td>
					<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["Tgl"]; ?></td>
					<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["NJml"]; ?></td>
					<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["NLokasi"]; ?></td>
					<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">
						<?php 
							$query = "select FileName_real 
										from inbox_files infs 
									   where infs.NId='" . $row["NId"] . "'" ;									  
							$res2 = mysql_query($query);
							while($row2 = mysql_fetch_array($res2)){
								echo $row2[0] . "<br />";
							}
							mysql_free_result($res2);											
						?></td>
<!--				<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["RoleName"]; ?></td>
					<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["KatName"]; ?></td>
					<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["VitName"]; ?></td>
					<td style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><?php echo $row["APName"]; ?></td>
-->					<td style="border-bottom: #000000 solid 1px;"><?php echo $row["SusutName"]; ?></td>
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
