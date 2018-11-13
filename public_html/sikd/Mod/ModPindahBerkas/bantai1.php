<?php
session_start();

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */

	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array( 'PermohonanId', 'NoSurat', 'TglSurat', 'Priode', 'ket', 'RoleId', 'PermohonanId' );

	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "PermohonanId";

	/* DB table to use */
	$sTable = "permohonanusul";

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
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
    $verifikasi = "false";
    if($_SESSION["GroupId"]==1 or $_SESSION["GroupId"]==2 ){
      $verifikasi = "true";
      $sWhere = " WHERE permohonanusul.status = 'up'";
    }else{
    $roleid = $_SESSION["PrimaryRoleId"];
	$sWhere = " WHERE permohonanusul.RoleId = '$roleid'";
    }

    $sOrder = " Order by permohonanusul.TglSurat Desc ";
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


		$sQuery = "
			SELECT permohonanusul.PermohonanId, permohonanusul.NoSurat, permohonanusul.TglSurat, permohonanusul.Priode, permohonanusul.ket, role.RoleName
			FROM   $sTable
            Inner Join role ON role.RoleId = permohonanusul.RoleId
			$sWhere
			$sOrder
			$sLimit
			";

	$rResult = mysql_query($sQuery) or fatal_error( 'MySQL Error: ' . mysql_errno() );

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

    include "../../include/fungsi_indotgl.php";

	$n=1;
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{

        $xml = "Select PermohonanId from berita_acara where PermohonanId = '".$aRow[0]."' and stat = 'p'";
        $temu = mysql_num_rows(mysql_query($xml));
        if($temu!=0)
         $display = 'none';
        else
        $display = "inline";
		$row = array();
        //$display = "inline";
        $display1 = "inline";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
            $row[] = "<div align=right>".$n.".</div>";
            $row[] = $aRow["NoSurat"];
            $row[] = '<div align="center">'.tgl_indo($aRow["TglSurat"]).'</div>';
            $row[] = '<div align="center">'.$aRow["Priode"].'</div>';
            $row[] = $aRow["RoleName"];
            if($aRow["ket"]==''){
            $row[] = "Proses";
            }else {
            $qerty = "select UploadSurat from berita_acara where PermohonanId = '".$aRow[0]."'";
            $resty = mysql_fetch_array(mysql_query($qerty));
            $field = explode("/",$resty[0]);
            $row[] = "Pemindahan Berkas telah disetujui dengan Berita Acara : <a target=_blank href='".$resty[0]."'>".$field[2]."</a>";
//            $display = "none";
            $display1 = "inline";
            }
            if($verifikasi=="false"){
            $row[] = '<div align="center">
  <i class="btn_edit" onclick=setDetails("edit","'.$aRow[0].'") style="cursor:pointer;display:'.$display.'" title="Ubah Data"></i>
  <i class="btn_del" onclick=setDelete("'.$aRow[0].'") style="cursor:pointer;display:'.$display.'" title="Hapus Data"></i>
  <a target="_blank" href ="Mod/ModPindahBerkas/daftarberkas_web.php?mod=up&ids='.$aRow[0].'" ><img src="images/print.png" style="border:0px;cursor:pointer;display:'.$display1.'" alt="Lihat Data" title="Daftar Berkas" /></a>
  </div>';
           } elseif($aRow["ket"]!='OK'){
           $row[] =  '<div align="center">
  <img src="images/forward.png" style="border:0px;cursor:pointer" onclick=load_BA("'.$aRow[0].'") alt="List Berkas" title="Buat Berita Acara" />
  <a target="_blank" href ="Mod/ModPindahBerkas/daftarberkas_web.php?mod=up&ids='.$aRow[0].'" ><img src="images/print.png" style="border:0px;cursor:pointer;display:'.$display1.'" alt="Lihat Data" title="Daftar Berkas" /></a>
  </div>';
           } else {
            $rowing = '<div align="center">
  <a target="_blank" href ="Mod/ModPindahBerkas/daftarberkas_web.php?mod=up&ids='.$aRow[0].'" ><img src="images/print.png" style="border:0px;cursor:pointer;display:'.$display1.'" alt="Lihat Data" title="Daftar Berkas" /></a>';

            if($_SESSION['PrimaryRoleId']=="uk"){
                 $rowing .= '&nbsp;<img src="images/edit.png" style="border:0px;cursor:pointer; display:'.$display.'" onclick=editBA("'.$aRow[0].'")  title="Ubah Berita Acara" />';
                 $rowing .= '&nbsp;<img src="images/delete.png" style="border:0px;cursor:pointer; display:'.$display.'" onclick=hapusBA("'.$aRow[0].'") title="Hapus Berita Acara" />';
             }
                 $rowing .= '</div>';
                 $row[] = $rowing;
         }


     }
		$output['aaData'][] = $row;
		$n++;
	}

	echo json_encode( $output );
?>