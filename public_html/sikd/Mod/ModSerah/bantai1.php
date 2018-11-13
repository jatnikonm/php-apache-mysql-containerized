<?php
session_start();

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */

	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array( 'BeritaId', 'Tgl', 'UploadSurat', 'Priode');

	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "BeritaId";

	/* DB table to use */
	$sTable = "berita_acara";

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

	$sWhere = "where berita_acara.stat='s'";

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
			SELECT berita_acara.BeritaId, berita_acara.Tgl, berita_acara.UploadSurat, permohonan_serah.nomor, permohonan_serah.tgl, permohonan_serah.UploadSurat, berita_acara.Nomor,
            permohonan_serah.idserah
            FROM
            berita_acara
            Inner Join permohonan_serah ON berita_acara.PermohonanId = permohonan_serah.idserah
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
		$row = array();
        $display = "inline";
        $display1 = "none";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
            $row[] = "<div align=right>".$n.".</div>";
            $row[] = $aRow["Nomor"];
            $row[] = '<div align="center">'.tgl_indo($aRow[1]).'</div>';
            $file_b = explode("/",$aRow[2]);
            $file_u = explode("/",$aRow[5]);
            $row[] = "<b><a target=_blank href='".$aRow[2]."'>".$file_b[2]."</a></b>";
            $row[] = "Sesuai dengan Surat Permohonan Nomor : ".$aRow[3]." Tanggal : ".tgl_indo($aRow[4])."<br><u><a target=_blank href='".$aRow[5]."'>".$file_u[2]."</a></u>";
            $row[] = "Serah";
            $row[] = '<div align="center">
  <i class="btn_edit" onclick=setDetails("edit","'.$aRow[0].'") style="cursor:pointer;display:'.$display.'" title="Ubah Data"></i>
  <a target="_blank" href ="Mod/ModSerah/daftarberkas_web.php?ids='.$aRow[7].'" ><i class="btn_print" style="cursor:pointer;display:'.$display.'" title="Cetak Berkas"></i></a>
  </div>';


     }
		$output['aaData'][] = $row;
		$n++;
	}

	echo json_encode( $output );
?>