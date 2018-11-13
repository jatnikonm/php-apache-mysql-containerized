<?php
	$NId = $_REQUEST["NId"];
	$roleId = $_REQUEST["roleId"];
	if($roleId == ""){
		$roleId = $_SESSION["PrimaryRoleId"];
		if($roleId == 'root'){
			$roleId = 'uk';
		}
	}
?>
<form name="form1" id="form1" method="" >
	<input type="hidden" name="roleId" value="<?php echo $_REQUEST["roleId"]; ?>" />
	<input type="hidden" name="BerkasId" value="" />

<!--	<div class="art-sidebar1">
		<div class="art-Block">
			<div class="art-Block-tl"></div>
			<div class="art-Block-tr"></div>
			<div class="art-Block-bl"></div>
			<div class="art-Block-br"></div>
			<div class="art-Block-tc"></div>
			<div class="art-Block-bc"></div>
			<div class="art-Block-cl"></div>
			<div class="art-Block-cr"></div>
			<div class="art-Block-cc"></div>
			<div class="art-Block-body">
				<div class="art-BlockHeader">
					<div class="l"></div>
					<div class="r"></div>
					<div class="art-header-tag-icon">
						<div class="t">Unit Kerja</div>
					</div>
				</div>
				<div class="art-BlockContent">
					<div class="art-BlockContent-body">
						<div style="width:222px;height:350px; overflow:scroll;">
							<div id="treeUK">
								<?php
									function showUK($data,$parent){
									  if(isset($data[$parent])){ // jika ada anak dari menu maka tampilkan
										/* setiap menu ditampilkan dengan tag <ul> dan apabila nilai $parent bukan 0 maka sembunyikan element 
										 * karena bukan merupakan menu utama melainkan sub menu */
										$str = '<ul>'; 
										foreach($data[$parent] as $value){
										  /* variable $child akan bernilai sebuah string apabila ada sub menu dari masing-masing menu utama
										   * dan akan bernilai negatif apabila tidak ada sub menu */
										  $child = showUK($data,$value->id); 
										  $str .= '<li id="' . $value->id . '" ';
										  /* beri tanda sebuah folder dengan warna yang mencolok apabila terdapat sub menu di bawah menu utama 	  	   
										   * dan beri juga event javascript untuk membuka sub menu di dalamnya */
										  $str .= ($child) ? 'class="folder"' : '';
										  $str .= "><a href='#' onclick=\"setLocation('" . $value->id . "')\">" . $value->name . "</a>";
										  if($child) $str .= $child;
										  $str .= "</li>";
										}
										$str .= '</ul>';
										return $str;
									  }else return false;	  
									}
									
									switch($_SESSION["GroupId"]){
										case "1":
										case "2":
											$parent = "uk";
										case "3":
										case "4":
											$sql = "SELECT RoleParentId 
											FROM role 
											WHERE RoleKey = '" . $_SESSION["AppKey"] . "' 
												and RoleId = '" . $_SESSION["PrimaryRoleId"] . "'";
											$result = mysql_query($sql);
											while($row = mysql_fetch_array($result)){
												$parent = $row['RoleParentId'];
											}
									}
									
									$sql = "SELECT RoleParentId as parent_id, 
												RoleId as id, RoleDesc as name 
											FROM role 
											WHERE RoleKey = '" . $_SESSION["AppKey"] . "' 
												and RoleId = (select RoleParentId from role r2 where r2.RoleId = '" . $_SESSION["PrimaryRoleId"] . "')
											UNION
											SELECT RoleParentId as parent_id, RoleId as id, RoleDesc as name
											  FROM role
											 WHERE RoleKey = '" . $_SESSION["AppKey"] . "'
											   and RoleId = '" . $_SESSION["PrimaryRoleId"] . "'
											UNION
											SELECT RoleParentId as parent_id, 
												RoleId as id, 
												RoleDesc as name 
											FROM role 
											WHERE RoleKey = '" . $_SESSION["AppKey"] . "'
												and (RoleId like '" . $_SESSION["PrimaryRoleId"] . ".%')";
									if($_REQUEST["NId"] != ""){
										$sql .= "	and RoleId in (select RoleId_To from inbox_receiver where NId = '" . $_REQUEST["NId"] . "') ";
									}else{
										$sql .= "	and RoleId = '" . $_SESSION["PrimaryRoleId"] . "'";
									}
									
									$query = mysql_query($sql);
									$data = array();
									while($row = mysql_fetch_object($query)){
									  $data[$row->parent_id][] = $row; // simpan data dari database ke dalam variable array 3 dimensi di PHP
									}
									echo showUK($data,$parent); // lakukan looping menu utama
								?>
							</div>
						</div>                        
					</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
		</div>
		<div class="cleared"></div>
	</div>
-->
<div class="art-content" style="width:660px;">
	<div class="art-Post">
		<div class="art-Post-tl"></div>
		<div class="art-Post-tr"></div>
		<div class="art-Post-bl"></div>
		<div class="art-Post-br"></div>
		<div class="art-Post-tc"></div>
		<div class="art-Post-bc"></div>
		<div class="art-Post-cl"></div>
		<div class="art-Post-cr"></div>
		<div class="art-Post-cc"></div>
		<div class="art-Post-body">
			<div class="art-Post-inner" style="width:635px;">
				<div class="art-PostMetadataHeader">
					<h2 class="art-PostHeader">
						<img src="images/PostHeaderIcon.png" width="26" height="26" alt="PostHeaderIcon" />
						Pilih Data Berkas
					</h2>
				</div>
				<div class="art-PostContent" style="width:635px;">
                	<div style="float:left; width:100%; display:block; padding:5px; margin:5px;">
                    	<input type="text" id="txt_cari" name="txt_dari" width="200" />&nbsp;
                        <input type="button" class="art-button" value=" cari " onclick="getSearch(document.forms[0].txt_cari.value);" />&nbsp;
                        <input type="button" class="art-button" value=" tampilkan semua " onclick="getSearch('%');" />
                    </div>
					<div id="people_list" style="width:100%; height:350px; overflow:scroll; float:left; ">						
						<table class="adminlist" width="100%" cellpadding="2" cellspacing="0">
							<tr>
								<th style="width:1%;">No</th>
								<th style="width:1%;">#</th>
								<th style="width:35%;">Klasifikasi</th>
								<th style="width:64%;">Berkas</th>
							</tr>
							<?php
								$sql = "select c.ClCode, c.ClName, b.BerkasId, 
												b.BerkasNumber, b.BerkasName 
										from berkas b 
										join classification c on b.ClId = c.ClId 
										where b.BerkasNumber != '0' 
											and BerkasStatus = 'open'
											and b.RoleId = '" . $roleId . "'";
								if(clean($_REQUEST["search"]) != ""){
									$sql .= " and (BerkasNumber like '%" . clean($_REQUEST["search"]) . "%'
												 or BerkasName like '%" . clean($_REQUEST["search"]) . "%')";
								}
								
								$result = mysql_query($sql);
								$count = mysql_num_rows($result);
								if ($count % $showrecs != 0) {
									$pagecount = intval($count / $showrecs) + 1;
								}else {
									$pagecount = intval($count / $showrecs);
								}
								$startrec = $showrecs * ($page - 1);
								if ($startrec < $count) { mysql_data_seek($result, $startrec);}
								$reccount = min($showrecs * $page, $count);
								$no = $startrec;
								for ($i = $startrec; $i < $reccount; $i++)
									{
										$no++;
										if($no % 2) { //this means if there is a remainder
											$bg = '#Transparent';
										} else { //if there isn't a remainder we will do the else
											$bg = '#FFFFFF';
										}
										$row = mysql_fetch_assoc($result);
									?>
										<tr style="background-color:<?php echo $bg; ?>">
											<td><?php echo $no; ?></td>
											<td style="text-align:center;"><input type="radio" name="ids[]" 
												onclick="setId('<?php echo $row["BerkasId"]; ?>')"
												value="<?php echo $row["BerkasId"]; ?>" /></td>
											<td><?php echo $row["ClCode"] . ' - ' . $row["ClName"]; ?></td>
											<td><?php echo $row["ClCode"] . '/' . $row["BerkasNumber"] . ' - ' . $row["BerkasName"]; ?></td>
										</tr>
									<?php
								}
								mysql_free_result($result);
							?>
						</table><br /><br />
                        <table width="90%;" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <?php 
                                        showpagenav('window_lookup.php', $option, $page, $pagecount); 
                                    ?>
                                </td>
                            </tr>
                        </table>
					</div>
					<div style=" text-align:right; float:right; width:auto; padding-right:3px;">
						<input type="hidden" name="BerkasIdpil" id="BerkasIdpil" />
						<input type="button" class="art-button" value=" Pilih " onclick="confDone();" />&nbsp;&nbsp;
						<input type="button" id="btnTutup" value=" Tutup " onclick="tutup();" class="art-button" />
					</div>
				</div>
				<div class="cleared"></div>
			</div>                        
		<div class="cleared"></div>
	</div>
	</div>
</div>
</form>
