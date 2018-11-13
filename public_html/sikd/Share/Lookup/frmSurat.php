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
<form name="form1" id="form1">
	<input type="hidden" name="NId" id="NId" />
	<input type="hidden" name="NHal" id="NHal" />
	<input type="hidden" name="BId" id="BId" />
	<input type="hidden" name="TipeRef" id="TipeRef" />
	
	<div class="art-sidebar2">
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
						<div class="t">Klasifikasi</div>
					</div>
				</div>
				<div class="art-BlockContent">
					<div class="art-BlockContent-body" style="width:278px; max-width:278px; height:280px; overflow:auto;">
							<div id="treeCl">
								<?php
									function showCl($dataCl,$parent){
									  if(isset($dataCl[$parent])){ // jika ada anak dari menu maka tampilkan
										/* setiap menu ditampilkan dengan tag <ul> dan apabila nilai $parent bukan 0 maka sembunyikan element 
										 * karena bukan merupakan menu utama melainkan sub menu */
										$str = '<ul>'; 
										foreach($dataCl[$parent] as $value){
										  /* variable $child akan bernilai sebuah string apabila ada sub menu dari masing-masing menu utama
										   * dan akan bernilai negatif apabila tidak ada sub menu */
										  $child = showCl($dataCl,$value->id); 
										  $str .= '<li id="' . $value->id . '" ';
										  /* beri tanda sebuah folder dengan warna yang mencolok apabila terdapat sub menu di bawah menu utama 	  	   
										   * dan beri juga event javascript untuk membuka sub menu di dalamnya */
										  $str .= ($child) ? 'class="folder"' : '';
										  $str .= "><a href='#' onclick=\"setLocationCl('" . $value->id . "')\">" . $value->name . "</a>";
										  if($child) $str .= $child;
										  $str .= "</li>";
										}
										$str .= '</ul>';
										return $str;
									  }else return false;	  
									}
									
									$query = "SELECT ClId as id, 
													'0' as parent_id, 
													Concat(ClCode, ' - ', ClName) as name
												FROM classification 
												where ClId='1'
												union
												SELECT c.ClId as id, 
												c.ClParentId as parent_id, 
												Concat(c.ClCode, ' - ', c.ClName) as name 
											  FROM classification c
											join classification c2 on c.ClParentId = c2.ClId ";
									$result = mysql_query($query);
									$dataCl = array();
									while($row = mysql_fetch_object($result)){
									  $dataCl[$row->parent_id][] = $row; // simpan data dari databae ke dalam variable array 3 dimensi di PHP
									}
									echo showCl($dataCl, '0'); // lakukan looping menu utama
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
	<div class="art-content2" style="width:650px; float:left;" >
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
							<img src="style/temp_deptan/images/PostHeaderIcon.png" width="26" height="26" alt="PostHeaderIcon" />
							Pilih Berkas
						</h2>
					</div>
					<div class="art-PostContent">
						<div style="width:100%; float:left; max-height:120px; margin:5px; overflow:scroll;">
							<table class="adminlist" style="width:100%" cellpadding="2" cellspacing="0" >
								<tr>
									<th style="width:1%">No</th>
									<th style="width:1%">#</th>
									<th style="width:29%">Nomor - Nama Berkas</th>
									<th style="width:39%">Deskripsi</th>
									<th style="width:30%">Unit Kerja</th>
								</tr>
								<?php
									if (clean($_REQUEST["ClId"]) != ''){
										$sql = "select b.BerkasId, b.RoleId, b.BerkasNumber, 
													b.BerkasName, b.BerkasDesc, r.RoleDesc 
												from berkas b
												join role r on b.RoleId = r.RoleId
												where b.BerkasKey='" . $_SESSION["AppKey"] . "' 
													and BerkasId != '1' 
													and b.ClId='" . clean($_REQUEST["ClId"]) . "' 
													and b.RoleId like '" . $_SESSION["PrimaryRoleId"] . "%'
												order by BerkasNumber";
										$res = mysql_query($sql);
										$a = 0;
										while($row= mysql_fetch_array($res)){
											$a++;
											?>
												<tr>
													<td><?php echo $a; ?></td>
													<td><input type="radio" name="rad" value="<? echo $row["BerkasId"]; ?>" 
														onclick="setName('<? echo $row["BerkasId"]; ?>','<? echo $row["BerkasName"]; ?>',
																		'<? echo $row["BerkasId"]; ?>', 'berkas')" />
													</td>
													<td><a href="#" onclick="setLocationBr('<?php echo $row["BerkasId"]; ?>');"><?php echo $row["BerkasNumber"] . " - " . $row["BerkasName"]; ?></a></td>
													<td><?php echo $row["BerkasDesc"]; ?></td>
													<td><?php echo $row["RoleDesc"]; ?></td>
												</tr>
											<?php
										}
									}
								?>
							</table>
						</div>    		
						<div class="cleared"></div>
					</div>
					<div class="cleared"></div>
				</div>
				<div class="cleared"></div>
			</div>
			<div class="cleared"></div>
		</div>
		<div class="cleared"></div>
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
							Pilih Surat
						</h2>
					</div>
					<div class="art-PostContent">
						<div style="width:100%; max-height:150px; overflow:scroll;">
						<br />
							<table class="adminlist" style="width:100%" cellpadding="2" cellspacing="0" >
								<tr>
									<th style="width:1%">No</th>
									<th style="width:1%">&nbsp;</th>
									<th style="width:10%">Nomor</th>
									<th style="width:48%">Perihal</th>
									<th style="width:52%">Pengirim</th>
								</tr>
								<?php
									if (clean($_REQUEST["BerkasId"]) != ''){
										$sql = "select i.NKey, i.NId, i.Nomor, i.Hal, i.BerkasId, i.Tgl, 
												(case i.Pengirim when 'external' then i.InstansiPengirim  
													when 'internal' then (select r.RoleDesc from role r where r.RoleId = i.InstansiPengirim ) end) as InstansiPengirim, 
												(case i.Pengirim when 'external' then i.NamaPengirim  
													when 'internal' then (select p.Peoplename from people p where p.PeopleId = i.NamaPengirim ) end) as NamaPengirim , 
												DATE_FORMAT(i.Tgl, '%d/%m/%Y') as Tgl 
											from inbox i 
											where i.NKey='" . $_SESSION["AppKey"] . "'";
										
										if (clean($_REQUEST["BerkasId"]) != ''){
											$sql .= "	and i.BerkasId='" . clean($_REQUEST["BerkasId"]) . "' 
														and NId != '" . $_REQUEST["NId"] . "' 
													 	and NId not in (select Id_Ref from inbox_reference where NId = '" . $_REQUEST["NId"] . "')";
										}
										$sql .= " order by i.Tgl DESC ";
										
										$res = mysql_query($sql);
										$a = 0;
										while($row= mysql_fetch_array($res)){
											$a++;
											?>
												<tr>
													<td><?php echo $a; ?></td>
													<td><input type="radio" name="rad"
														id="rad_<?php echo $row["NId"]; ?>"
														value="<?php echo $row["NId"]; ?>" 
														onclick="setName('<?php echo $row["NId"]; ?>','<?php echo $row["Hal"]; ?>',
																		'<?php echo $row["BerkasId"]; ?>','surat')" /></td>
													<td><?php echo $row["Nomor"]; ?></a></td>
													<td><?php echo $row["Hal"]; ?></td>
													<td><?php echo $row["NamaPengirim"] . ", " . $row["InstansiPengirim"]; ?></td>
												</tr>
											<?php
										}
									}
								?>
							</table>
						</div>		
						<div class="cleared"></div>
					</div>
					<div class="cleared"></div>
				</div>
				<div class="cleared"></div>
			</div>
			<div class="cleared"></div>
		</div>
		<input type="hidden" name="ClId" />
		<input type="hidden" name="RoleId" />	
		<input type="hidden" name="id" value="<?php echo $_REQUEST["NId"]; ?>" />
		<input type="button" id="btnPilih" value=" Pilih " class="art-button" onclick="done();" />&nbsp;
		<input type="button" id="btnTutup" value=" Tutup " onclick="parent.closeWindow();" class="art-button" />			
	</div>
</form>
