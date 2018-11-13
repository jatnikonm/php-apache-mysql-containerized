<?php
session_start();

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array( 'BerkasId', 'BerkasStatus', 'BerkasNumber', 'BerkasName', 'RetensiValue_Active', 'RoleDesc' );
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "BerkasId";
	
	/* DB table to use */
	$sTable = "v_berkas_aktif";
	
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
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
			FROM   $sTable
			Where BerkasId != '1'
			$sOrder
			$sLimit
		";
	} else {
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
			FROM   $sTable
			$sWhere BerkasId != '1'  
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

    include "../../include/fungsi_indotgl.php";

	$n=1;
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] == 'BerkasId' )
        	{
            	$BerkasId = $aRow[ $aColumns[$i] ];
            	$x = $n + $_GET['iDisplayStart'];
            	//$row[] = $n + $_GET['iDisplayStart'];
				$row[] .= ''."<a href=index2.php?option=MailBerkas&id=$BerkasId style='text-decoration:none'>$x</a>".'';				 
        	}
            elseif ( $aColumns[$i] == 'BerkasStatus' )
            {
            	$BerkasStatus = $aRow[ $aColumns[$i] ];
				if ($BerkasStatus == 'open')
				{
					$row[] .= ''."<a href=index2.php?option=MailBerkas&id=$BerkasId style='text-decoration:none'><img src=images/opened_folder.png width=16 height=16 title='Berkas Belum Ditutup' /><font color=#FF0000> Berkas terbuka</font></a>".'';				 
				}
				else
				{
					$row[] .= ''."<a href=index2.php?option=MailBerkas&id=$BerkasId style='text-decoration:none'><img src=images/ok.png width=16 height=16 title='Berkas Telah Ditutup'/> Berkas tertutup</a>".'';				 
				}
			}			
            elseif ( $aColumns[$i] == 'BerkasNumber' )
            {
            	$BerkasNumber = $aRow[ $aColumns[$i] ];
				$row[] .= ''."<a href=index2.php?option=MailBerkas&id=$BerkasId style='text-decoration:none'>$BerkasNumber</a>".'';				 
			}			
            elseif ( $aColumns[$i] == 'BerkasName' )
            {
				
				$sql = "select count(*) as jmlP from inbox where BerkasId = $BerkasId";
				$res = mysql_query($sql);
				while($row12 = mysql_fetch_array($res)){
					$jmlP = $row12[0];
				}
				
				if($jmlP > 0){
					$c = $jmlP;
					$c1 = '<font color=brown>( terdapat ' . $c . ' item surat )</font>';
				}else {
					$c = $jmlP;
					$c1 = '';
				}

            	$BerkasName = $aRow[ $aColumns[$i] ];
				$row[] .= ''."<a href=index2.php?option=MailBerkas&id=$BerkasId style='text-decoration:none'>$BerkasName $c1</a>".'';				 
			}			
            elseif ( $aColumns[$i] == 'RetensiValue_Active' )
            {
            	$RetensiValue_Active = tgl_indo($aRow[ $aColumns[$i] ]);
				$row[] .= ''."<a href=index2.php?option=MailBerkas&id=$BerkasId style='text-decoration:none'>$RetensiValue_Active</a>".'';				 
			}		
            elseif ( $aColumns[$i] == 'RoleDesc' )
            {
            	$RoleDesc = $aRow[ $aColumns[$i] ];
				$row[] .= ''."<a href=index2.php?option=MailBerkas&id=$BerkasId style='text-decoration:none'>$RoleDesc</a>".'';				 
			}			
			elseif ( $aColumns[$i] != ' ' )
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