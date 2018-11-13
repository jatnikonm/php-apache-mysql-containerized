<?php
session_start();

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */

	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array( 'idmusnah', 'nomor', 'tgl', 'UploadSurat', 'ket' );

	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "idmusnah";

	/* DB table to use */
	$sTable = "permohonan_musnah";

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

    $sWhere = " WHERE ket = 'usul'";
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
			SELECT idmusnah, nomor, tgl, ket, UploadSurat
			FROM   $sTable
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
	   $xml = "Select PermohonanId from berita_acara where PermohonanId = '".$aRow[0]."' and stat = 'm'";
       $temu = mysql_num_rows(mysql_query($xml));

       if($temu!=0){
         $display = 'none';
       }else
       {
        $display = "inline";
       }
		$row = array();

		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
            $row[] = "<div align=right>".$n.".</div>";
            $row[] = $aRow["nomor"];
            $row[] = '<div align="center">'.tgl_indo($aRow["tgl"]).'</div>';
            if($temu!=0) $ket = "Musnah"; else $ket = "Usulan";
            if(!empty($aRow["UploadSurat"])){
            $file = explode("/",$aRow["UploadSurat"]);

            $row[] = "<a target='_blank' href = '".$aRow["UploadSurat"]."'>".$file[2]."</a>";
            }
            else
            $row[] = "-";
            $row[] = $ket;
            $row[] = '<div align="center">
  <i class="btn_edit" onclick=setDetails("edit","'.$aRow[0].'") style="cursor:pointer; display:'.$display.'" title="Ubah Data"></i>
  <i class="btn_del" onclick=setDelete("'.$aRow[0].'") style="cursor:pointer; display:'.$display.'" title="Hapus Data"></i>
  <a target="_blank" href ="Mod/ModUsulMusnah/daftarberkas_web.php?mod=um&ids='.$aRow[0].'" ><i class="btn_print" style="cursor:pointer" title="Cetak Daftar"></i></a>
  </div>';

     }
		$output['aaData'][] = $row;
		$n++;
	}

	echo json_encode( $output );
?>