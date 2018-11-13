<?php
session_start();

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */

	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
    $BerkasId = $_REQUEST['BerkasId'];

	$aColumns = array( 'NId','Nomor','Tgl','Hal','InstansiPengirim' );

	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "NId";

	/* DB table to use */
	$sTable = "v_inbox";

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
		if ( $sOrder == "ORDER BY " )
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

	$sWhere = " WHERE BerkasId = '".$BerkasId."'";
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
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
			FROM   $sTable
			$sWhere
			$sOrder
			$sLimit
			";
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

    include "../../include/fungsi_indotgl.php";

	$n=1;
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row = array();
	    $row[] .= '<div align="right">'.$n.'.</div>';
	    $row[] .= $aRow['Nomor'];
        $tgls = tgl_indo($aRow['Tgl']);
	    $row[] .= $tgls;

		$cari21=mysql_query("select NTipe from inbox where NId = '".$aRow['NId']."'");
		$hasil2221=mysql_fetch_array($cari21);
		
		if($hasil2221[NTipe]=='outboxnotadinas')
		{
			$query1 = mysql_query("select * from role where RoleId = '".$aRow['InstansiPengirim']."' ");
			$res1 = mysql_fetch_array($query1);
			
			if($res1 > 0)
			{
        		$row[] .= $res1['RoleName'];
			}
		}
		elseif($hasil2221[NTipe]=='outboxmemo')
		{
			$query1 = mysql_query("select * from role where RoleId = '".$aRow['InstansiPengirim']."' ");
			$res1 = mysql_fetch_array($query1);
			
			if($res1 > 0)
			{
        		$row[] .= $res1['RoleName'];
			}
		}
		elseif($hasil2221[NTipe]=='outbox')
		{
			$query1 = mysql_query("select * from role where RoleId = '".$aRow['InstansiPengirim']."' ");
			$res1 = mysql_fetch_array($query1);
			
			if($res1 > 0)
			{
        		$row[] .= $res1['RoleName'];
			}
		}
		else
		{
        	$row[] .= $aRow['InstansiPengirim'];
		}
		
	    $row[] .= $aRow['Hal'];
	    $row[] .= "<div align='center'><img src='images/view2.png' style=cursor:pointer onclick='detail_item(".$aRow['NId'].")' />";

		$output['aaData'][] = $row;
		$n++;
	}

	echo json_encode( $output );

?>