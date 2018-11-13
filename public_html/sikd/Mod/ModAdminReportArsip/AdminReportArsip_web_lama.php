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
		<?php
				$sql = "Select * FROM inbox i
				        Inner Join berkas b ON i.BerkasId = b.BerkasId 
						Inner Join master_satuanunit ma ON  ma.MeasureUnitId = i.MeasureId
				        Inner Join master_tperkembangan tp ON i.TPId = tp.TPId
						Inner Join role r ON b.RoleId = r.RoleId
				  		WHERE b.BerkasNumber <> '0' and " ;

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
			
			$sql .= ' order by i.Tgl, b.BerkasNumber DESC ';
			$no=1;
			$res = mysql_query($sql);		
			?>

		<br />
		&nbsp;
		&nbsp;
		<table width="100%" height="52" cellspacing="0" class="tb_report" style="border:#000000 1px solid;">
			<tr>
				<th width="2%" height="29" style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">No.</th>
				<th width="16%" style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Nomor Naskah </th>
				<th width="10%" style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Tgl. Naskah </th>
				<th width="21%" style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Isi Naskah </th>
				<th width="6%" style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Jumlah</th>
				<th width="15%" style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Nomor/Nama Berkas</th>
				<th width="10%" style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"> Unit Pengolah </th>
				<th  width="9%" style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Tingkat Perkembangan</th>
				<th  width="11%" style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;">Lokasi</th>
			</tr>
			<?php while($row = mysql_fetch_array($res)){ ?>
			<tr>
					<td height="21"  align="right" valign="top" style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><? echo $no.". "; ?></td>
					<td valign="top" style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px; padding-left:5px; padding-right:5px"><? echo $row["Nomor"];?></td>
					<td align="center" valign="top"   style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px; padding-left:5px"><? echo date('d-M-Y',strtotime($row["Tgl"])); ?></td>
					<td align="left" valign="top"   style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px; padding-left:5px; padding-right:5px"><? echo $row["NIsi"];?></td>
					<td align="center" valign="top"   style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><? echo $row['NJml']." ".$row["MeasureUnitName"]; ?></td>
					<td align="left" valign="top"   style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px; padding-left:5px"><? echo $row["BerkasNumber"]." ".$row["BerkasName"]; ?></td>
					<td align="left" valign="top"   style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px; padding-left:5px"><? echo $row["RoleName"]; ?></td>
					<td align="center" valign="top"   style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><? echo $row["TPName"];?></td>
					<td align="center" valign="top"   style="border-right: #000000 solid 1px;border-bottom: #000000 solid 1px;"><? echo $row["BerkasLokasi"];?></td>
		  </tr>
				
								
				<?php $no++;
			}
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
