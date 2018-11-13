<script type="text/javascript">
	document.getElementById("leftTitle").innerHTML = 'Unit Kerja';
</script>
<div style="width:100%; height:auto;">
<table width="100%" cellspacing="0px">
	<tr>
		<td>
			<div style="min-height:500px; max-width:250px; overflow:scroll; ">
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
							  $str .= "><a href='#' onclick=\"setLocation('" . $value->tipe . "', '" . $value->id . "')\">" . $value->name . "</a>";
							  if($child) $str .= $child;
							  $str .= "</li>";
							}
							$str .= '</ul>';
							return $str;
						  }else return false;	  
						}
						
						if(($_SESSION["GroupId"] == "2") || ($_SESSION["GroupId"] == "3")){
							$sql = "SELECT RoleParentId 
									FROM role 
									WHERE RoleKey = '" . $_SESSION["AppKey"] . "' 
										and RoleId = '" . $_SESSION["PrimaryRoleId"] . "'";
							$result = mysql_query($sql);
							while($row = mysql_fetch_array($result)){
								$parent = $row['RoleParentId'];
							}	
							mysql_free_result($result);
							
							$sql = "SELECT RoleParentId as parent_id, 
										RoleId as id, 
										'uk' as tipe,
										RoleDesc as name
									FROM role r, people p 
									WHERE r.RoleId = p.PrimaryRoleId
										and RoleKey = '" . $_SESSION["AppKey"] . "'
										and PeopleIsActive = '1'
										and RoleId like '" . $_SESSION["PrimaryRoleId"] . "%'
									UNION
									SELECT PrimaryRoleId as parent_id, 
											PeopleId as id, 
											'people' as tipe,
											PeopleName as name
									  FROM people
									 WHERE PeopleKey = '" . $_SESSION["AppKey"] . "'
										and PeopleIsActive = '1'
										and PrimaryRoleId like '" . $_SESSION["PrimaryRoleId"] . "%'";
										
						}elseif($_SESSION["GroupId"] == "1"){
							$parent = 'root';
							$sql = "SELECT RoleParentId as parent_id, 
										RoleId as id, 
										'uk' as tipe,
										RoleDesc as name 
									FROM role r, people p 
									WHERE r.RoleId = p.PrimaryRoleId
										and RoleKey = '" . $_SESSION["AppKey"] . "'
										and RoleId != 'root'
								    UNION
									SELECT PrimaryRoleId as parent_id, 
											PeopleId as id, 
											'people' as tipe,
											PeopleName as name
									  FROM people
									 WHERE PeopleKey = '" . $_SESSION["AppKey"] . "'
									   and PrimaryRoleId like 'uk%'
									   and PeopleIsActive = '1'";
						}
						
						//echo $parent .  '- ' .  $sql;
						$query = mysql_query($sql);
						$data = array();
						while($row = mysql_fetch_object($query)){
						  $data[$row->parent_id][] = $row; // simpan data dari databae ke dalam variable array 3 dimensi di PHP
						}
						mysql_free_result($query);
						
						echo showUK($data,$parent); // lakukan looping menu utama
					?>
				</div>
			</div>
		</td>
	</tr>
</table>     
</div>                   