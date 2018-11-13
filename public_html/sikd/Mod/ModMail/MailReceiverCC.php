<?php
if($peopleId != ""){
	?>
	<form name="formCC" id="formCC">
		<input type="hidden" name="from" id="from" value="<?php echo $_REQUEST["from"]; ?>" />
		<input type="hidden" name="peopleId" value="<?php echo $peopleId; ?>" />
		<table style="width:100%" cellpadding="2" cellspacing="0" class="gridCC">
			<?php
				$sql = "select p.PeopleId, p.PeopleName, p.PeoplePosition ";
				$sql .= " from people p ";
				$sql .= "	where p.PeopleId in (" . $peopleId . ")";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result)){
					?>
						<tr>
							<td><?php echo $row["PeopleName"]; ?></td>
							<td><?php echo $row["PeoplePosition"]; ?></td>
							<td><a href="#" onclick="setDelete('<?php echo $row["PeopleId"]; ?>')">
									<img src="images/delete.png" border="0" />
								</a>
							</td>
						</tr>
					<?php
				}
			?>
		</table>
	</form>
	<?php
}
?>
					