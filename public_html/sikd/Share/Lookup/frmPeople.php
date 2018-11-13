<?php
	$methodLookup = clean($_REQUEST["lookup"]);
	$methodTo = clean($_REQUEST["modeTo"]);
?>
<form name="form1" id="form1" method="get" target="_self" >
	<input type="hidden" name="roleId" value="<?php echo $_REQUEST["roleId"]; ?>" />
	<input type="hidden" name="lookup" value="<?php echo $_REQUEST["lookup"]; ?>" />
	<input type="hidden" name="modeTo" value="<?php echo $_REQUEST["modeTo"]; ?>" />
<div class="art-sidebar2" >
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
				<div class="art-BlockContent-body" style="width:278px; max-width:278px; height:280px; overflow:auto;">
					<div id="treeUK">
					<?php
						
						function showUK($data,$parent){
						  if(isset($data[$parent])){ 
							// jika ada anak dari menu maka tampilkan
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
						
						if($methodLookup == "lower"){
							//get Parent
							$sql = "SELECT RoleParentId 
							FROM role 
							WHERE RoleKey = '" . $_SESSION["AppKey"] . "' 
								and RoleId = '" . $_SESSION["PrimaryRoleId"] . "'";
							$result = mysql_query($sql);
							while($row = mysql_fetch_array($result)){
								$parent = $row['RoleParentId'];
							}
							
							if($_SESSION["GroupId"] == "4"){
							
								$sql = "SELECT RoleParentId as parent_id, 
											RoleId as id, RoleDesc as name 
										FROM role 
										WHERE RoleKey = '" . $_SESSION["AppKey"] . "' 
											and RoleId = (select RoleParentId from role r2 where r2.RoleId = '" . $_SESSION["PrimaryRoleId"] . "')
										UNION
										SELECT RoleParentId as parent_id, 
											RoleId as id, 
											RoleDesc as name 
										FROM role 
										WHERE RoleKey = '" . $_SESSION["AppKey"] . "'
											and RoleId like '" . $_SESSION["PrimaryRoleId"] . "' ";
											
							}elseif(($_SESSION["GroupId"] == "2") || ($_SESSION["GroupId"] == "3")){
								
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
											and RoleId like '" . $_SESSION["PrimaryRoleId"] . ".%' ";
											
							}elseif($_SESSION["GroupId"] == "1"){
								$parent = 'root';
								$sql = "SELECT RoleParentId as parent_id, 
											RoleId as id, 
											RoleDesc as name 
										FROM role 
										WHERE RoleKey = '" . $_SESSION["AppKey"] . "'
											and RoleId != 'root'";
							}
						}else{
							if($methodTo == "tembusan"){
								$parent = 'root';
							}else{
								$parent = '';
							}
							
							$parent = 'root';								
							
							$sql = "SELECT RoleParentId as parent_id, 
										RoleId as id, RoleDesc as name 
									FROM role 
									WHERE RoleKey = '" . $_SESSION["AppKey"] . "'";								
						}
						
						//echo $sql;							
						$query = mysql_query($sql);
						$data = array();
						while($row = mysql_fetch_object($query)){
						  $data[$row->parent_id][] = $row; // simpan data dari databae ke dalam variable array 3 dimensi di PHP
						}
						
						echo showUK($data, $parent); // lakukan looping menu utama
					?>
					</div>  
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
		</div>
		<div class="cleared"></div>
	</div>
</div>
<div class="art-content2" style="width:650px; float:left;">
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
			<div class="art-Post-inner">
				<div class="art-PostMetadataHeader">
					<h2 class="art-PostHeader">
						<img src="images/PostHeaderIcon.png" width="26" height="26" alt="PostHeaderIcon" />
						Pilih Pengguna
					</h2>
				</div>
				<div class="art-PostContent">
					<p>
						<div id="people_form" style="width:100%; float:left; margin:5px;">
							<table class="tb_grid" width="100%">
								<tr>
									<td style="width:10%;">Cari : </td>
									<td style="width:90%;"><input type="text" name="txt_nama" id="txt_nama" style="width:60%;" /> 
										<input type="button" class="art-button" value=" cari " onclick="setLocation('<?php echo $_REQUEST["roleId"]; ?>');" />
									</td>
								</tr>
							</table>
						</div>
						<div id="people_list" style="width:100%; float:left; max-height:245px; overflow:scroll; ">						
                        	<table class="adminlist" cellpadding="1" cellspacing="0" width="100%">
                                <tr>
                                    <th style="width:1%;">No</th>
                                    <th style="width:1%;"><input id="changeCheckStateId" 
                                    		onclick="changeCheckState(this.checked);" type="checkbox"  /></th>
                                    <th style="width:40%;">Nama</th>
                                    <th style="width:58%;">Jabatan</th>
                                </tr>
                                <?php 
									$RoleId = $_REQUEST["roleId"];
									if($RoleId == ""){
										$RoleId = $_SESSION["PrimaryRoleId"];
										if($RoleId == 'root'){
											$RoleId = 'uk';
										}
									}
                                    $sql = "select p.PeopleId, r.RoleName, p.PeopleName, p.PeoplePosition 
											 from people p 
											 join role r on r.RoleId = p.PrimaryRoleId 
											 where p.PrimaryRoleId like '" . $RoleId . "%' 
											 		and p.PeopleisActive = '1' 
													and p.PeopleId != '" . $_SESSION["PeopleID"] . "' ";
									if(clean($_REQUEST["txtSearch"]) != ""){
										$sql .= " and (RoleName like '%" . clean($_REQUEST["txtSearch"]) . "%' 
													or PeopleName like '%" . clean($_REQUEST["txtSearch"]) . "%')";
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
                                                <td><input type="checkbox" name="ids[]" 
                                                	onclick="setName('<?php echo $row["PeopleName"]; ?>, <?php echo $row["RoleName"]; ?>')"
                                                	value="<?php echo $row["PeopleId"]; ?>" /></td>
                                                <td><?php echo $row["PeopleName"]; ?></td>
                                                <td><?php echo $row["PeoplePosition"]; ?></td>
                                            </tr>
                                        <?php }
									mysql_free_result($result);
                                ?>
                            </table>
                        </div>
						<div style="text-align:left; float:left; width:auto; padding-right:3px;">
							<table width="90%;" cellpadding="0" cellspacing="0">
								<tr>
									<td>
										<?php 
											$option .= "&modeRD=" . $_REQUEST["modeRD"] . "&modeTo=" . $_REQUEST["modeTo"] . "&roleId=" . $RoleId;
											showpagenav('window_lookup.php', $option, $page, $pagecount); 
										?>
									</td>
								</tr>
							</table>
							<br />
							<input type="hidden" name="mode" />
							<input type="hidden" name="PeopleId" />
							<input type="hidden" name="PeopleName" />
							<input type="button" class="art-button" value=" Pilih " onclick="confDone();" />&nbsp;&nbsp;
							<input type="button" id="btnTutup" value=" Tutup " onclick="tutup();" class="art-button" />
						</div>
					</p>
				</div>
				<div class="cleared"></div>
			</div>                        
		<div class="cleared"></div>
	</div>
	</div>
</div>
</form>