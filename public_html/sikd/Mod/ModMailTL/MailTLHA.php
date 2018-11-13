<?php
	$id = $_REQUEST["NId"];
	$statusBerkas = $_REQUEST["statusBerkas"];
?>
<script type="text/javascript">
	function setDelete(nid, peopleId, roleId){
		location.href= 'handle.php?NId=' + nid + '&option=MailTL&task=delHA&roleId=' + roleId + '&peopleId=' + peopleId;
	}
</script>
<table style="width:100%" cellpadding="1" cellspacing="0" class="adminlist">
	<tr>
		<th>No</th>
		<th>Pemberi Akses</th>
		<th>Penerima Akses</th>
		<th>&nbsp;</th>
	</tr>
</table>
<div style="background-color:#FFFFFF; background:none; width:100%; margin:0px; height:400px; max-height:400px; overflow:scroll;">
<form name="formCC" id="formCC">
	<input type="hidden" name="from" id="from" value="<?php echo $_REQUEST["from"]; ?>" />
	<input type="hidden" name="peopleId" value="<?php echo $peopleId; ?>" />
	<table style="width:100%" cellpadding="1" cellspacing="0" class="adminlist">
		<?php			
			$sql = "select ir.NId, r.RoleId, 
						
						(case when ( (select count(PeopleId) 
										from people_history 
										where PeopleId=ir.To_Id 
												and r2.RoleId=ir.RoleId_From 
												and HDate >= ir.ReceiveDate ) > 0)
							then (select concat(p.PeopleName, ', ', rh.RoleDesc)
										from people_history ph
										join people p on ph.PeopleId = p.PeopleId 
										join role rh on rh.RoleId = ph.RoleId
										where ph.PeopleId=ir.From_Id 
												and rh.RoleId=ir.RoleId_To 
												and HDate >= ir.ReceiveDate )
							else (select concat(p.PeopleName, ', ', rp.RoleDesc)  
									from people p 
									join role rp on p.PrimaryRoleId = rp.RoleId
									where PrimaryRoleId = r2.RoleId 
										and ir.From_Id = p.PeopleId )
						 end) as Sender, 
						
						(case when ( (select count(PeopleId) 
										from people_history 
										where PeopleId=ir.To_Id 
												and r.RoleId=ir.RoleId_To 
												and HDate >= ir.ReceiveDate ) > 0)
							then (select concat(p.PeopleName, ', ', rh.RoleDesc)
										from people_history ph
										join people p on ph.PeopleId = p.PeopleId 
										join role rh on rh.RoleId = ph.RoleId
										where ph.PeopleId=ir.To_Id 
												and rh.RoleId=ir.RoleId_To 
												and HDate >= ir.ReceiveDate )
							else (select concat(p.PeopleName, ', ', rp.RoleDesc)  
									from people p 
									join role rp on p.PrimaryRoleId = rp.RoleId
									where PrimaryRoleId = r.RoleId 
										and p.PeopleId = ir.To_Id)
						 end) as Receiver, 
						 
						 ir.To_Id as PeopleId, ";
			if($statusBerkas == "closed"){
				$sql .= " 'none' as allow_del ";
			}else{
				if(($task == "view") || ($task == "viewBerkas")){
					$sql .= " '' as allow_del ";			
				}else{			 
					$sql .= " (case ir.RoleId_From when '" . $_SESSION["PrimaryRoleId"] . "' 
								then (case when (ir.To_Id = '" . $_SESSION["PeopleID"] . "' and ir.ReceiverAs = 'bcc_HA') 
										then 'none'
										else 'inline'
												end)
								else 'none'
							 end) as allow_del ";
				 }
			 }
			$sql .= " from inbox_receiver ir
					join role r on ir.RoleId_To = r.RoleId 
					join role r2 on ir.RoleId_From = r2.RoleId 
					where NKey = '" . $_SESSION["AppKey"] . "'
							and ir.NId = '" . $_REQUEST["NId"] . "' 
							and ir.REceiverAs = 'bcc_HA'";
			//echo $sql;
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				$no++;
				?>
					<tr>
						<td style="width:1%; text-align:right;"><?php echo $no; ?>.</td>
						<td style="width:45%; padding-left:10px;"><?php echo $row["Sender"]; ?></td>
						<td style="width:54%;"><?php echo $row["Receiver"]; ?></td>
						<td style="width:1%;">
							<?php
								if($row["allow_del"] == 'inline'){
								?>
								<a href="#" onclick="setDelete('<?php echo $row["NId"]; ?>', '<?php echo $row["PeopleId"]; ?>', '<?php echo $row["RoleId"]; ?>')">
									<img src="images/delete.png" border="0" width="15" height="15" vspace="0" hspace="0" />
								</a>
								<?php
								}else{ echo '&nbsp;'; }
							?>
						</td>
					</tr>
				<?php
			}
		?>
	</table>
</form>
</div>
