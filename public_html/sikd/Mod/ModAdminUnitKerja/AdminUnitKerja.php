<?php
	if(($_SESSION["GroupId"] != "1") && ($_SESSION["GroupId"] != "2")){
		die("<script>location.href='index.php'</script>");
	}
?>
<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Pengaturan Unit Kerja &amp; Pengguna -> Unit Kerja';
</script>
<form name="formUK" method="post" action="handle.php">
	<table id="listDocuments" width="100%" cellspacing="0">
		<tr>
			<td colspan="2" class="navrightheader" valign="middle" nowrap="nowrap">
				&nbsp;
				<span class="navIcon">
					<input type="button" id="btnTambah" name="btnTambah" value="Tambah" onclick="setNew()" class="btn_add" />
				</span>
				<span class="navIcon">
					<input type="button" id="btnHapus" name="btnHapus" value="Hapus" class="btn_del" onclick="setDelete()" />
				</span>
			</td>
		</tr>
		<tr>
			<td style="width:100px; vertical-align:top;">
				<div id="treeUK">
				<!-- <div id="treeUK" style="width:380px; max-height:350px; margin-left:0px; overflow:scroll;"> -->
					<?php
						function showUK($data,$parent){
						  if(isset($data[$parent])){ 
							$str = '<ul>'; 
							foreach($data[$parent] as $value){
							  $child = showUK($data,$value->id); 
							  $str .= '<li id="' . $value->allData . '" ';
							  $str .= ($child) ? 'class="folder"' : '';
							  $str .= ">" . $value->name;
							  if($child) $str .= $child;
							  $str .= "</li>";
							}
							$str .= '</ul>';
							return $str;
						  }else return false;	  
						}
						
						if($_SESSION["GroupId"] == "1"){
							$parent = 'root';
							$query = "SELECT RoleParentId as parent_id, 
												RoleId as id, 
												RoleDesc as name, 
												Concat(RoleParentId,'|',RoleId,'|',RoleName,'|',RoleDesc,'|',RoleStatus,'|',gjabatanId) as allData
											  FROM role 
											WHERE RoleId != 'root'
											ORDER BY RoleId,RoleParentId ";
						}else{
							$sql = "SELECT RoleParentId 
									FROM role 
									WHERE RoleKey = '" . $_SESSION["AppKey"] . "' 
										and RoleId = '" . $_SESSION["PrimaryRoleId"] . "'";
							$result = mysql_query($sql);
							while($row = mysql_fetch_array($result)){
								$parent = $row['RoleParentId'];
							}
							
							$query = "SELECT RoleParentId as parent_id, 
									RoleId as id, RoleDesc as name,
									Concat(RoleParentId,'|',RoleId,'|',RoleName,'|',RoleDesc,'|',RoleStatus,'|',gjabatanId) as allData 
								FROM role 
								WHERE RoleKey = '" . $_SESSION["AppKey"] . "' 
									and RoleId = (select RoleParentId from role r2 where r2.RoleId = '" . $_SESSION["PrimaryRoleId"] . "')
								UNION
								SELECT RoleParentId as parent_id, 
									RoleId as id, 
									RoleDesc as name,
									Concat(RoleParentId,'|',RoleId,'|',RoleName,'|',RoleDesc,'|',RoleStatus,'|',gjabatanId) as allData
								FROM role 
								WHERE RoleKey = '" . $_SESSION["AppKey"] . "'
									and RoleId like '" . $_SESSION["PrimaryRoleId"] . "%' ";
						}

						$res = mysql_query($query);
						$data = array();
						while($row = mysql_fetch_object($res)){
						  $data[$row->parent_id][] = $row; // simpan data dari databae ke dalam variable array 3 dimensi di PHP
						}
						echo showUK($data,$parent); // lakukan looping menu utama
					?>
				</div>                        
			</td>
			<td style="width:45%; padding:3px; vertical-align:top;">
            	<div class="content-main-popup">
                        <table style="width:100%; " cellspacing="1" cellpadding="3">
                            <tr>
                                <td style="width:30%">Jabatan <font color="#FF0000">*</font></td>
                                <td style="width:70%; vertical-align:middle;">
                                    <input type="hidden" name="txt1" />
                                    <input type="hidden" name="txt2" />                                           
                                    <input type="text" name="txt3" style="width:80%;" class="inputbox" disabled="disabled" />
                                    <span id="req" class="require_field" style="display:none">!</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top;">Unit Kerja <font color="#FF0000">*</font></td>
                                <td>
                                    <input type="text" name="txt4" style="width:80%;" class="inputbox" disabled="disabled" />&nbsp;
                                    <span id="req2" class="require_field" style="display:none">!</span>
                                </td>
                            </tr>
                            <tr> 
                                <td valign="top">
                                    Grup Jabatan<font color="red">*</font>
                                </td>
                                <td>
                                    <select name="txt6" class="inputbox" disabled="disabled">
                                        <option value="">-</option>
                                        <?php 
                                            $sql1 = "select gjabatanId, gjabatanName from master_gjabatan ";
                                            $sql1 .= "order by gjabatanName";
                                            $result1 = mysql_query($sql1);
                                            while($row1 = mysql_fetch_array($result1)){
                                                echo "<option value='" . $row1["gjabatanId"] . "'";
                                                if($data[6] == $row1["gjabatanId"]){
                                                    echo "selected";
                                                }
                                                echo ">" . $row1["gjabatanName"] . "</option>";
                                            }
                                            mysql_free_result($result1);
                                        ?>
                                    </select>
                                    <span id="req3" style="display:none">
                                        <img src="images/Alert.gif" />
                                    </span>
                                </td>
                            </tr>
							<tr>
                                <td style="vertical-align:top;">Status Aktif <font color="#FF0000">*</font></td>
                                <td>
                                    <input type="checkbox" name="txt5" id="txt5" value="1" disabled="disabled" /> &nbsp;
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                	<input type="hidden" name="option" value="<?php echo $option; ?>" />
                                    <input type="hidden" name="task" value="<?php echo $task; ?>" />
                                    <input type="hidden" name="id" />
                                    <input type="hidden" name="count" value="6" />
                                    <input type="button" name="btnSimpan" value=" Simpan " onclick="getSave()" class="art-button" disabled="disabled" />&nbsp;
                                    <input type="button" name="btnUbah" value=" Ubah " onclick="setEdit()" class="art-button" />&nbsp;
                                    <input type="button" name="btnBatal" value=" Batal " onclick="setReset()" class="art-button" disabled="disabled" />
                                </td>
                            </tr>
                        </table>
					</div>                     
			</td>
		</tr>
		<tr>
			<td colspan="2" style="padding:4px;">
				
			</td>
		</tr>
	</table>
 </form>