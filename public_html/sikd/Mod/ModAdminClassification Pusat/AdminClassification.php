<?php
	if($_SESSION["GroupId"] != "1"){
		die("<script>location.href='../../index.php'</script>");
	}
?>
<script type="text/javascript">
	document.getElementById("title").innerHTML = 'Pengaturan Kasifikasi &amp; Berkas -> Klasifikasi';
</script>
<form name="formClassification" method="post" action="handle.php">
<table id="listDocuments" width="100%" cellspacing="0">
    <tr>
        <td colspan="2" class="navrightheader" valign="middle" nowrap="nowrap">
            &nbsp;
            <span class="navIcon">
                <input type="button" id="btnTambahx" name="btnTambahx" value="Tambah " onclick="setNew()" class="btn_add" />
            </span>
            <span class="navIcon">
                <input type="button" id="btnTambah" name="btnTambah" value="Hapus" class="btn_del" onclick="setDelete()" />
            </span>
        </td>
    </tr>
    <tr>
        <td style="width:420px; vertical-align:top;">
          <div id="treeClassfication">
              <?php
					function showClassification($data,$parent){
					  if(isset($data[$parent])){ // jika ada anak dari menu maka tampilkan
						/* setiap menu ditampilkan dengan tag <ul> dan apabila nilai $parent bukan 0 maka sembunyikan element
						 * karena bukan merupakan menu utama melainkan sub menu */
						$str = '<ul>';
						foreach($data[$parent] as $value){
						  /* variable $child akan bernilai sebuah string apabila ada sub menu dari masing-masing menu utama
						   * dan akan bernilai negatif apabila tidak ada sub menu */
						  $child = showClassification($data,$value->id);
						  $str .= '<li id="' . $value->allData . '" ';
						  /* beri tanda sebuah folder dengan warna yang mencolok apabila terdapat sub menu di bawah menu utama
						   * dan beri juga event javascript untuk membuka sub menu di dalamnya */
						  $str .= ($child) ? 'class="folder"' : '';
						  $str .= ">" . $value->name;
						  if($child) $str .= $child;
						  $str .= "</li>";
						}
						$str .= '</ul>';
						return $str;
					  }else return false;
					}

					 $query = "SELECT ClId as id,
								'0' as parent_id,
								Concat(ClCode, ' - ', ClName) as name,
								Concat('0||',ClId,'|',ClCode,'|',ClName,'|',ClDesc,'|',RetensiThn_Active,'|',RetensiThn_InActive,'|', CIStatus,'|', SusutId,'|',
										(case when (select count(c2.ClCode) from classification c2 where c2.ClParentId like c.ClId ) > 0 then 'true' else 'false' end),'|',
										1) as allData
								FROM classification c
								where ClId='1'
								union
								(SELECT c.ClId as id, c.ClParentId as parent_id, Concat(c.ClCode, ' - ', c.ClName) as name,
									Concat(c.ClParentId,'|',c2.ClCode,'|',c.ClId,'|',c.ClCode,'|',c.ClName,'|',c.ClDesc,'|',c.RetensiThn_Active,'|',c.RetensiThn_InActive,'|', c.CIStatus,'|', c.SusutId,'|',
									(case when (select count(c3.ClCode) from classification c3 where c3.ClParentId like c.ClId ) > 0 then 'true' else 'false' end), '|', c.ClStatusParent ) as allData
									FROM classification c join classification c2 on c.ClParentId = c2.ClId order by c.ClCode)";
					$result = mysql_query($query);
					$data = array();
					while($row = mysql_fetch_object($result)){
					  $data[$row->parent_id][] = $row; // simpan data dari databae ke dalam variable array 3 dimensi di PHP
					}
					echo showClassification($data,'0'); // lakukan looping menu utama
				?>
            </div>
        </td>
        <td style="width:65%; padding:3px; vertical-align:top;">
            	<div class="content-main-popup">
                	
                        <table style="width:100%; " cellspacing="1" cellpadding="3">
                            <tr>
                                <td style="width:20%">Kode <font color="#FF0000">*</font></td>
                                <td style="width:80%; vertical-align:middle;">
                                    <span id="txtParent" style="display:none; font-size:12px;"></span>
                                    <span id="dotParent" style="display:none; font-size:12px;">.</span>                                            
                                    <input type="text" name="txt1" style="width:auto;" disabled="disabled" class="inputbox" />&nbsp;
                                    <span id="req" class="require_field" style="display:none">!</span>                                    </td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top;">Nama <font color="#FF0000">*</font></td>
                                <td>
                                    <input type="text" name="txt2" disabled="disabled" class="inputbox" style="width:90%;" />&nbsp;
                                    <span id="req2" class="require_field" style="display:none">!</span>                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top;">Deskripsi</td>
                                <td>
                                    <textarea name="txt3" rows="4" style="width:90%;" class="inputbox" disabled="disabled"></textarea>                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top;" colspan="2"><hr /></td>
                            </tr>
                            
                            <tr>
                            	<td>Retensi Aktif</td>
                                <td>
                                	<table>
                                    	<tr valign="middle">
											<td valign="middle">
                                                <input type="text" name="txt6" width="5" maxlength="2" value="<?php echo $tgl1_sp[0]; ?>" style="width:15px;" disabled="disabled" />                                            </td>
                                            <td valign="middle">
                                                Tahun											</td>
                                        </tr>
                                    </table>                                </td>
                            </tr>
                            <tr>
                            	<td>Retensi InAktif</td>
                                <td>
                                	<table>
                                    	<tr valign="middle">
											<td valign="middle">
                                                <input type="text" name="txt7" width="5" maxlength="2" value="<?php echo $tgl1_sp[0]; ?>" style="width:15px;" disabled="disabled" />                                            </td>
                                            <td valign="middle">
                                                Tahun											</td>
                                        </tr>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                            	<td>Penyusutan Akhir</td>
                                <td>
                                	<table>
                                    	<tr valign="middle">
											<td valign="middle">
                                                <select name="txt10" disabled="disabled">
								                    <option value="">-</option>
								                        <?php

                        									$sql = "select SusutId, SusutName from master_penyusutan ";
                        									$sql .= "where SusutId like '" . $_SESSION["AppKey"] . "%' ";
                        									$sql .= "order by SusutName";
                        									$result = mysql_query($sql);
                        									while($rows = mysql_fetch_array($result)){
                        										echo "<option value='" . $rows["SusutId"] . "'";
                        										if($row['SusutId'] == $rows["SusutId"]){
                        											echo "selected";
                        										}
                        										echo ">" . $rows["SusutName"] . "</option>";
                        									}
                        								?>
							                    </select>
                                              </td>
                                        </tr>
                                    </table>
                                 </td>
                              </tr>
                            <tr>
                            	<td>Status Aktif</td>
                                <td>
                                	<table>
                                    	<tr valign="middle">
											<td valign="middle">
                                                <input type="checkbox" name="txt8" id="txt8" value="1" disabled="disabled" />                                            </td>
                                            <td valign="middle">
                                                											</td>
                                        </tr>
                                        
                                    </table> 
                                                                   </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                	<input type="hidden" name="option" value="<?php echo $option; ?>" />
                                    <input type="hidden" name="task" value="<?php echo $task; ?>" />
                                    <input type="hidden" name="txt4" />
                                    <input type="hidden" name="txt5" />
                                    <input type="hidden" name="txt9" />
                                    <input type="hidden" name="id" />
                                    <input type="hidden" name="count" value="11" />
                                    <input type="button" name="btnSimpan" value=" Simpan " class="art-button" onclick="setSave()" disabled="disabled" />&nbsp;
                                    <input type="button" name="btnUbah" value=" Ubah " onclick="setEdit()" class="art-button" />&nbsp;
                                    <input type="button" name="btnBatal" value=" Batal " onclick="setReset()" class="art-button" disabled="disabled" />                                </td>
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
