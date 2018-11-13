<script type="text/javascript">
	document.getElementById("leftTitle").innerHTML = 'Instansi Lain';
</script>
<div style="width:100%; height:auto;">
	<table width="100%" cellspacing="0px">
		<tr>
			<td>
				<div style="min-height:500px; max-width:300px; overflow:scroll; ">
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
							
							$parent = 'root';
							$sql = "SELECT '0' as parent_id, 
										'root' as id, 
										'Daftar Instansi' as name 
									FROM others_setting ot
									union
									SELECT 'root' as parent_id, 
										ot.tb_key as id, 
										ot.nama_instansi as name 
									FROM others_setting ot";
							//echo $sql;
							$query = mysql_query($sql);
							$data = array();
							while($row = mysql_fetch_object($query)){
							  $data[$row->parent_id][] = $row; // simpan data dari databae ke dalam variable array 3 dimensi di PHP
							}
							echo showUK($data,'0'); // lakukan looping menu utama
						?>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>