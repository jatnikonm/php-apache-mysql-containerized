<?php
session_start();

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	 
	$aColumns = array( 'GIR_Id', 'waktu', 'RoleId_From', 'RoleId_To', 'ReceiverAs', 'Msg', 'tindakan', 'RoleId_From2' );

	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "GIR_Id";
	
	/* DB table to use */
	$sTable = "v_jejak_surat";
	
	/* Database connection information   */
	include "../../conf.php";
	
	
	/* REMOVE THIS LINE (it just includes my SQL connection user/pass) 
	include( $_SERVER['DOCUMENT_ROOT']."/datatables/mysql.php" );  */
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
	 * no need to edit below this line
	 */
	
	/* 
	 * Local functions
	 */
	function fatal_error ( $sErrorMessage = '' )
	{
		header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
		die( $sErrorMessage );
	}

	
	/* 
	 * MySQL connection
	 */
	if ( ! $gaSql['link'] = mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) )
	{
		fatal_error( 'Could not open connection to server' );
	}

	if ( ! mysql_select_db( $gaSql['db'], $gaSql['link'] ) )
	{
		fatal_error( 'Could not select database ' );
	}

	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
			intval( $_GET['iDisplayLength'] );
	}
	
	
	/*
	 * Ordering
	 */
	$sOrder = "";
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= "`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".
					($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$sWhere = "";
	if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" )
			{
				$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
			}
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
		}
	}
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	if ($sWhere=="") {
		/* $sQuery = "
			SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
			FROM   $sTable
			Where NId = $_GET[id] group by GIR_Id
			$sOrder
			$sLimit
		" ;*/
		// Prubahan Query disini pake UNION antara yang pertama (to) dengan sisanya --hanya khususon berdasarkan Session RoleId, atau klo mo ganti pake To_Id jg bisa..
		$sQuery = "select SQL_CALC_FOUND_ROWS * 
					from (
						SELECT GIR_Id, waktu, RoleId_From, RoleId_To, ReceiverAs, Msg, tindakan, RoleId_From2
						FROM   v_jejak_surat
						Where NId = '" . $_GET["id"] . "'
							and ReceiverAs in ('to', 'to_konsep') 
						group by GIR_Id	
						UNION
						SELECT GIR_Id, waktu, RoleId_From, RoleId_To, ReceiverAs, Msg, tindakan, RoleId_From2
						FROM   v_jejak_surat
						Where NId = '" . $_GET["id"] . "'
						and RoleId_To = '" . $_SESSION["PrimaryRoleId"] . "'
						group by GIR_Id	) a
					ORDER BY  `waktu` desc
					LIMIT 0, 10";
	} else {
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
			FROM   $sTable
			$sWhere AND NId = $_GET[id] group by GIR_Id
			$sOrder
			$sLimit
			";
	}
	$rResult = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(`".$sIndexColumn."`)
		FROM   $sTable
	";
	$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	
	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);

    include "../../include/fungsi_indotgl_jam.php";

	$n=1;
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] == 'GIR_Id' )
        	{
            	$GIR_Id= $aRow[ $aColumns[$i] ];
            	$row[] = $n + $_GET['iDisplayStart'];
        	}
            elseif ( $aColumns[$i] == 'waktu' )
            {
            	$waktu1 = $aRow[ $aColumns[$i] ];
            	$waktu = tgl_indo($aRow[ $aColumns[$i] ]);
				$row[] .= ''."$waktu".'';	
			}			
            elseif ( $aColumns[$i] == 'RoleId_From' )
            {
            	$RoleId_From = $aRow[ $aColumns[$i] ];
				$cari212=mysql_query("select NTipe, InstansiPengirim from inbox where NId = $_GET[id]");
				$hasil2222=mysql_fetch_array($cari212);
				
				if($hasil2222[NTipe] == 'inbox' and $RoleId_From == '') {
					$row[] .= ''."$hasil2222[InstansiPengirim]".'';	
				}
				else
				{
					$cari21=mysql_query("select RoleName from role where RoleId = '$RoleId_From'");
					$hasil222=mysql_fetch_array($cari21);
					
					$row[] .= ''."$hasil222[RoleName]".'';	
				}
			}			
			elseif ( $aColumns[$i] == 'RoleId_To' )
        	{
            	$RoleId_To = $aRow[ $aColumns[$i] ];
				if($RoleId_To == '-') {
					$row[] .= ''."<font color=red>Dokumen Final</font>".'';	
				}
				else
				{
					$cari21=mysql_query("SELECT (GROUP_CONCAT(rr.RoleName ORDER BY rr.RoleName ASC SEPARATOR ', ')) as penerima
										FROM inbox_receiver irr 
										join role rr on rr.RoleId = irr.RoleId_To
										where irr.NId = $_GET[id] and irr.GIR_Id = $GIR_Id
										and irr.ReceiverAs in ('to', 'to_tl', 'to_memo', 'to_notadinas', 'to_konsep', 'cc1', 'to_usul', 'to_reply', 'to_forward') 
										GROUP BY irr.GIR_Id");
					$hasil222=mysql_fetch_array($cari21);
					
					$cari212=mysql_query("SELECT (GROUP_CONCAT(rr.RoleName ORDER BY rr.RoleName ASC SEPARATOR ', ')) as tembusan
										FROM inbox_receiver irr 
										join role rr on rr.RoleId = irr.RoleId_To
										where irr.NId = $_GET[id] and irr.GIR_Id = $GIR_Id
										and irr.ReceiverAs in ('cc','bcc') 
										GROUP BY irr.GIR_Id");
					$hasil2221=mysql_fetch_array($cari212);
					if($hasil2221[tembusan] == '') {
						$row[] .= ''."$hasil222[penerima]".'';	
					}
					else
					{
						$row[] .= ''."$hasil222[penerima] <br> <b><i>Tembusan :</i></b> $hasil2221[tembusan]".'';	
					}
				}
        	}
            elseif ( $aColumns[$i] == 'ReceiverAs' )
            {
            	$ReceiverAs = $aRow[ $aColumns[$i] ];
				if($RoleId_To == '-') {
					$row[] .= ''."<font color=red>Dokumen Final</font>".'';	
				}
				else
				{
					$cari212=mysql_query("SELECT irr.ReceiverAs as x
										FROM inbox_receiver irr 
										where irr.NId = $_GET[id] and irr.GIR_Id = $GIR_Id
										and irr.ReceiverAs in ('to', 'to_tl', 'to_memo', 'to_notadinas', 'to_konsep', 'cc1', 'to_usul', 'to_reply', 'to_forward') 
										GROUP BY irr.GIR_Id");
					$hasil2221=mysql_fetch_array($cari212);
					
					switch ($hasil2221[x]) {
						case 'to':
							$ket = "Surat Masuk";
							break;
						case 'to_memo':
							$ket = "Memo";
							break;
						case 'to_notadinas':
							$ket = "Nota";
							break;
						case 'to_konsep':
							$ket = "Nota Dinas";
							break;
						case 'cc1':
							$ket = "Disposisi";
							break;
						case 'to_forward':
							$ket = "Teruskan";
							break;
						case 'to_reply':
							$ket = "Nota Dinas";
							break;
						case 'to_usul':
							$ket = "Nota Dinas";
							break;
						case 'to_tl':
							$ket = "Surat Tanpa Tindaklanjut";
							break;
						default:
							$ket = "<font color=red>Dokumen Final</font>";
							break;
					}				
					$row[] .= ''."$ket". ' ';		
				}
			}	
            elseif ( $aColumns[$i] == 'Msg' )
            {
				$Msg = $aRow[ $aColumns[$i] ];		
				$disp = "";		
				$lamp = "";	
				if($ReceiverAs == 'cc1') {
					$sqlDisp = " select replace(Disposisi, \"|\", \"','\") as idDisp
								from inbox_disposisi d 
								where d.GIR_Id = '$GIR_Id'";
					$resDisp = mysql_query($sqlDisp);
					if(mysql_num_rows($resDisp) > 0){
						while($rwDisp = mysql_fetch_array($resDisp)){
							$idDIsps = $rwDisp["idDisp"];
						}
						
						$disp = "<table style='width:100%;' cellpadding='0' cellspacing='0'>";
						$disp .=  "	<tr><td colspan = 2><b>Isi Disposisi </b></td></tr>";
						$sqlDescDisp = "select * from master_disposisi where DisposisiId in ('" . $idDIsps . "')";
						$resDescDisp = mysql_query($sqlDescDisp);
						while($rwDescDisp = mysql_fetch_array($resDescDisp)){
							$disp .=  "<tr>";
							$disp .=  "<td width='1%' align='left'>-</td>";
							$disp .=  "<td>" . $rwDescDisp["DisposisiName"] . "</td>";
							$disp .=  "</tr>";
						}
						$disp .=  "</table>";
						mysql_free_result($resDescDisp);
					}
					mysql_free_result($resDisp);

				}

				$files_Attc = "";
				//File Attachment
				//--------------------- for displaying files attachment if any -----------------------------
				$sql_files = "select concat('FilesUploaded/',i.NFileDir,'/',infs.FileName_fake) as FileDisk, ";
				$sql_files .= " 	(case infs.FileStatus when 'usul_hapus' then 'none' else 'inline' end) as StatusReceive, ";
				$sql_files .= " 	convert(concat(infs.NId, '|', infs.GIR_Id, '|', infs.FileName_real), char(50)) as IdDel, ";
				$sql_files .= " 	convert(concat(infs.NID, '|', infs.PeopleID, '|', infs.FileName_real, '|', infs.FileName_fake, 
								'|', infs.GIR_Id), char(200)) as FakeFileName, ";
				if ($_SESSION["GroupId"] == "1" ){
					$sql_files .= " 'none' as vsi, ";
					$sql_files .= " (case infs.FileStatus when 'usul_hapus' then 'block' else 'none' end) as vsi_root, ";
					$sql_files .= " 'block' as vsi_download, ";
				}else{
					if ($_SESSION["BerkasStatus"] == "closed") {
						$sql_files .= " 'none' as vsi, ";
				
						if ($_SESSION["GroupId"] == "1") {
							$sql_files .= " 'inline' as vsi_download, ";
						}else{
							$sql_files .= " (case when (r.RetensiValue_InActive >= '" . date('Y-m-d') . "') then  ";
							$sql_files .= "       (case infs.FileStatus when 'available' then 'block'  ";
							$sql_files .= "           else (case infs.PeopleRoleId when '" . $_SESSION["PrimaryRoleId"] . "' then 'block' ";
							$sql_files .= "               else (case when '" . $_SESSION["PrimaryRoleId"] . "' like concat(infs.PeopleRoleId,'%') then 'none' 
											else 'block' end)  end) ";
							$sql_files .= "        end) ";
							$sql_files .= "  else 'none' end) as vsi_download,  ";
						}
						$sql_files .= " 'none' as vsi_root, ";
					} else{
						if (($_REQUEST["mode"] == "viewBerkas") || ($_REQUEST["mode"] == "outbox")) {
							$sql_files .= " 'none' as vsi, ";
							$sql_files .= " (case infs.FileStatus when 'available' then 'block'  ";
							$sql_files .= "    else 'none' ";
							$sql_files .= "    end) as vsi_download, ";
							$sql_files .= " 'none' as vsi_root, ";
						}else{
							$sql_files .= " (case when infs.FileStatus = 'usul_hapus' then 'none' ";
							$sql_files .= "	when ((select count(NId) from inbox_receiver where GIR_Id > infs.GIR_Id) > 0) then 'none' ";
							$sql_files .= "    else (case when infs.PeopleRoleID='" . $_SESSION["PrimaryRoleId"] . "' then 'block' ";
							$sql_files .= "            else 'none' end ) ";
							$sql_files .= "    end) as vsi, ";
							$sql_files .= " 'none' as vsi_root, ";
							
							$sql_files .= " (case infs.FileStatus when 'available' then 'block'  
										when 'none' then 'none'
										else (case infs.PeopleRoleId when '" . $_SESSION["PrimaryRoleId"] . "' then 'block' 
												else (case when '" . $_SESSION["PrimaryRoleId"] . "' like concat(infs.PeopleRoleId,'%') then 'none' 
														else 'block' end) 
												end)
										 end) as vsi_download, ";
						}
					}
				}
				
				$sql_files .= " (case infs.FileStatus when 'usul_hapus' then '' ";
				$sql_files .= "        else (case (select distinct(ir.Msg) as Msg from inbox_receiver ir where ir.NId=infs.NId and ir.ReceiverAs = 'to' ) when '' then i.Hal ";
				$sql_files .= "            else infs.FileStatus end) ";
				$sql_files .= "    end) as isiPesan,";
				
				$sql_files .= " (case infs.FileStatus when 'usul_hapus' then '-- Diusulkan untuk dihapus --' ";
				$sql_files .= "    else (case when infs.FileName_real = '' then '-- tidak ada file --' else infs.FileName_real end) end) as FileName ";
				
				$sql_files .= "from inbox_files infs ";
				$sql_files .= "join inbox i on i.NId = infs.NId ";
				$sql_files .= "join berkas r on r.BerkasId = i.BerkasId ";
				$sql_files .= "where infs.GIR_Id = '$GIR_Id' "; 
				$sql_files .= " order by infs.EditedDate DESC";
				
				$res_files = mysql_query($sql_files);
				if(mysql_num_rows($res_files) > 0) {
					$files_Attc = "<table style='width:100%;' cellpadding='0' cellspacing='0'>";
					$files_Attc .=  "	<tr><td><b>File Surat </b></td></tr>";
					while($row_files = mysql_fetch_array($res_files)){
						$files_Attc .= "<tr>";
						$files_Attc .= "	<td>";																			
						$files_Attc .= "		<div style='text-align:left; display:block; margin:5px;'>
													<div style='display:" . $row_files["vsi_download"] . "; width:3px fixed; margin-right:2px; float:left;'>
														<a href='" . $row_files["FileDisk"] . "' style='display:" . $row_files["StatusReceive"] . "'	target='_blank' >
														<img src='images/attach.png' alt='Unduh Arsip' style='border:none;' title='Download File Digital Surat' /></a>
													</div>
													<div style='float:left; margin-right:5px; '>
														&nbsp;" . $row_files["FileName"] . "
													</div> 
												</div>
												<br />												
											</td>
										</tr>";
					}
					$files_Attc .= "</table>";
				}		
				
				if($Msg == '') {
					$row[] .= ''."$files_Attc".'';
				}
				elseif($ReceiverAs == 'cc1' and $disp == '' and $files_Attc == '') {
					$row[] .= ''."$Msg".'';
				}
				elseif($ReceiverAs == 'cc1' and $disp == '') {
					$row[] .= ''."$Msg <br> $files_Attc".'';
				}
				elseif($ReceiverAs == 'cc1' and $files_Attc == '') {
					$row[] .= ''."$Msg <br> $disp".'';
				}
				elseif($ReceiverAs == 'cc1' and $disp != '' and $files_Attc != '') {
					$row[] .= ''."$Msg <br> $disp <br> $files_Attc".'';
				}
				else {
					$row[] .= ''."$Msg <br> $files_Attc".'';
				}
				
			}		
			elseif ( $aColumns[$i] == 'tindakan' )
            {
            	$tindakan = $aRow[ $aColumns[$i] ];
				if($tindakan == 'cc1') {																										
					$row[] .= ''."<a href='#' onclick=\"window.open('window_flat.php?option=mailTL&filetopen=MailTLDisposisi&NId=$_GET[id]&GIR_Id=$GIR_Id','Cetak Disposisi', 'width=575px, height=500px, center=yes,status=no, scroll=no, resizable=yes, left=350px, top=100px');\"><center><img src=images/print.png title='Cetak Disposisi'></center></a>".' ';
				} else {
					$row[] .= ''."".'';				 
				}
			}			
            elseif ( $aColumns[$i] == 'RoleId_From2' )
            {
            	$RoleId_From2 = $aRow[ $aColumns[$i] ];

				$cari212=mysql_query("SELECT RoleId_From, ReceiveDate FROM inbox_receiver where NId = '$_GET[id]' Order by ReceiveDate DESC LIMIT 1");
				$hasil2221=mysql_fetch_array($cari212);
				
				if(($hasil2221[RoleId_From] == $RoleId_From2) and ($hasil2221[RoleId_From] == $_SESSION[PrimaryRoleId]) and ($hasil2221[ReceiveDate] == $waktu1)) {
					$row[] .= ''."<a href=handle.php?option=MailTL&task=deleteTL&NId=$_GET[id]&GIR_Id=$GIR_Id onclick=\"return confirm('Apakah Akan Membatalkan Pengiriman Surat ??')\"><center><img src=images/delete.png title='Batalkan Pengiriman Surat'></center></a>".' ';
				}
				else
				{
					$row[] .= ''."".'';
				}

			}			
			else if ( $aColumns[$i] != ' ' )
			{
				/* General output */
				$row[] = $aRow[ $aColumns[$i] ];
			}
		}
		$output['aaData'][] = $row;
		$n++;
	}
	
	echo json_encode( $output );
?>