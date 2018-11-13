<?php

	/*concat(p.PeopleName, ' (', r.RoleName, ')') as kepada_name,
    $sql .= "	   p2.PeopleId as tembusan_id,
				   concat(p2.PeopleName, ' (', r2.RoleName, ')') as tembusan,		   */

	$sql = "select i.Nomor, i.Hal, 
					p.PeopleId as kepada_id, ";			
	
	$sql .= "    (SELECT (GROUP_CONCAT(rr.RoleName ORDER BY rr.RoleName ASC SEPARATOR '<br /> ')) ";
	$sql .= "        FROM inbox_receiver irr ";
	$sql .= "        join role rr on rr.RoleId = irr.RoleId_To ";
	$sql .= "     where irr.GIR_Id = ir.GIR_Id ";
	$sql .= "        	and irr.ReceiverAs in ('to', 'cc1', 'to_usul', 'to_reply') ";
	$sql .= "     GROUP BY irr.GIR_Id ) as kepada_name, ";				   

//	$sql .= "    (case ir.From_Id when '0' 
//					then (select concat(InstansiPengirim,', ', NamaPengirim, ' (', JabatanPengirim, ')') from inbox i where i.NId = ir.NId ) 
//					   else (case when ((select count(HId) from people_history where PeopleId=ir.From_Id 
//										and RoleId = ir.RoleId_From and HDate >= ir.ReceiveDate) > 0) 
//							then (select distinct(PeoplePosition) 
//									from people_history 
//									where PeopleId=ir.From_Id 
//										and RoleId = ir.RoleId_From 
//										and HDate >= ir.ReceiveDate)															
//							else (select PeoplePosition 
//								from people 
//								where PeopleId = ir.From_Id 
//								and ir.NId = ir.NId)  
//							end) 
//					end) as asal, ";				   

	$sql .= "    (case ir.From_Id when '0' 
					then (select concat(InstansiPengirim) from inbox i where i.NId = ir.NId ) 
					   else (select RoleName 
								from role 
								where RoleId = ir.RoleId_From)  
				  end) as asal, ";
	
	$sql .= "    (SELECT (GROUP_CONCAT(pp.PeoplePosition ORDER BY pp.PeoplePosition ASC SEPARATOR '<br /> ')) ";
	$sql .= "        FROM inbox_receiver ir3 ";
	$sql .= "        join role p2 on p2.RoleId = ir3.RoleId_To 
					 join people pp on pp.PeopleId = ir3.To_Id ";
	$sql .= "        where ir3.GIR_Id = ir.GIR_Id ";
	$sql .= "        and ir3.ReceiverAs in ('cc','bcc') ";
	$sql .= "        GROUP BY ir3.GIR_Id ) as tembusan_name, ";
	
	$sql .= "        ir.Msg, i.NAgenda, date_format(i.Tgl, '%d/%m/%Y') as waktu, i.InstansiPengirim, date_format(ir.ReceiveDate, '%d/%m/%Y') as tgldispo
			 from inbox_receiver ir
			 join inbox i on i.NId = ir.NId
			 join role r on r.RoleId = ir.RoleId_To and ir.ReceiverAs in ('cc1')
			 join people p on p.PrimaryRoleId = r.RoleId
			 left join role r2 on r2.RoleId = ir.RoleId_To and ir.ReceiverAs in ('bcc')
			 left join people p2 on p2.PrimaryRoleId = r2.RoleId
			where ir.NKey='" . $_SESSION["AppKey"] . "'
				and ir.GIR_Id = '" . $_REQUEST["GIR_Id"] . "'
				and ir.NId='" . $_REQUEST["NId"] . "'
			group by ir.GIR_Id";
	$res = mysql_query($sql);
	$data[1] = "|";
	$data[2] = "|";
	while($row = mysql_fetch_array($res)){
		$data[1] .= ", " . $row["kepada_name"] ;			
		$data[2] .= ", " . $row["tembusan_name"] ;
		$data[3] = $row["Msg"];
		$data[7] = $row["Nomor"];
		$data[8] = $row["Hal"];
		$data[9] = $row["NAgenda"];
		$data[10] = $row["waktu"];
		$data[11] = $row["InstansiPengirim"];
		$data[12] = $row["asal"];
		$data[13] = $row["tgldispo"];
		
	}
	mysql_free_result($res);
	
	$data[1] = str_replace("|,", "", $data[1]);
	$data[2] = str_replace("|,", "", $data[2]);
	
	// get from disposisi
	$sql = "select * from inbox_disposisi 
			where NId='" . $_REQUEST["NId"] . "' 
			  and GIR_Id='" . $_REQUEST["GIR_Id"] . "'";
	$res = mysql_query($sql);
	while($row = mysql_fetch_array($res)){
		$data[4] = $row["NoIndex"];
		$data[5] = $row["Sifat"];
		$data[6] = $row["Disposisi"];
	}
	mysql_free_result($res);		
?>
&nbsp; <br clear="all" />
<table border="1" align="center" cellpadding="2" cellspacing="0" class="adminlist">

  <tr>
    <td colspan="3" width="50%"><p align="center"><b>LEMBAR DISPOSISI <br /> <?php echo $data[12]; ?></b></p></td>
  </tr>

  <tr>
    <td width="3%" valign="top"><center><font size="2">A.</font></center></td>
    <td><font size="2">Nomor Indeks : <?php echo $data[4]; ?></font></td>
    <td><font size="2">Tanggal Disposisi : <?php echo $data[13]; ?></font></td></td>
  </tr>

   <tr>
    <td>&nbsp;</td>
    <td><font size="2">Nomor Surat : <?php echo $data[7]; ?></font></td>
    <td><font size="2">Tanggal Surat : <?php echo $data[10]; ?></font></td>
  </tr>

  <tr>
    <td valign="top"><center><font size="2">B.</font></center></td>
    <td><font size="2">DITERUSKAN KEPADA</font></td>
    <td><font size="2">ISI DISPOSISI</font></td>
  </tr>

  <tr>
    <td rowspan="2">&nbsp;</td>
    <td valign="top"><font size="2"><?php echo $data[1]; ?></font></td>
	<td valign="top">
    
        <table width="100%" border="0" style="margin:5px;">
        <?php
            
			$isiDisp = explode("|", $data[6]);
			$jumData = count($isiDisp);
			
			for($i=0;$i<$jumData;$i++) {
    
            $sql = "select DisposisiId, DisposisiName from master_disposisi ";
            $sql .= "where DisposisiId = '" . $isiDisp[$i] . "' ";
            $sql .= "order by DisposisiName";
            $result = mysql_query($sql);

            while($d=mysql_fetch_array($result)){
                $isCheck = "";
                for	($a=0; $a < count($isiDisp); $a++){
                    if($d["DisposisiId"] == $isiDisp[$i]){
                        $img = "FormDisposisi_check.png";
                        break;
                    }else{
                        $img = "FormDisposisi_clip.png";
                    }
                }
            ?>
            <tr>
              <td valign="top"><img src="images/<?php echo $img; ?>" width="15" height="15" align="middle" /><font size="2"> <?php echo $d["DisposisiName"];?></font></td>
            </tr>
            <?php 
            }
		}
        ?>       
        </table></td>
  </tr>

  <tr>
    <td colspan="2"><font size="2">SIFAT : </font>&nbsp;&nbsp;<img src="images/FormDisposisi_check.png" width="15" height="15" align="middle" /><font size="2"> <?php echo $data[5]; ?></font></td>
  </tr>
 
  <tr>
    <td valign="top"><center><font size="2">C.</font></center></td>
    <td colspan="2">
    	<font size="2">CATATAN LAIN: <br /> <?php echo $data[3]; ?></font><br /><br /><br /><br /><br /><br />
    </td>
  </tr>


</table>
