<?php
session_start();

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */

	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
    if(empty($_REQUEST['roleid']))
    $uk = $_SESSION['PrimaryRoleId'];
    else
    $uk = $_REQUEST['roleid'];

	$aColumns = array( 'BerkasId', 'Klasifikasi', 'BerkasNumber', 'BerkasName', 'RoleId', 'CreationDate', 'RetensiValue_Active', 'BerkasStatus' );

	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "BerkasId";

	/* DB table to use */
	$sTable = "berkas";

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
		if ( $sOrder == "ORDER BY CreationDate Desc" )
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

	$sWhere = " where klasifikasi != '0' and RoleId = '".$uk."' ";

	if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
	{
		$sWhere = "WHERE klasifikasi != '0' and RoleId != 'uk' and (";
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
		//=======================================================================================
        if($aRow['BerkasStatus']=='open')
          $icon1 = "<center><img src='images/briefcase.png' style='cursor: pointer' title='Tutup Berkas' onclick=setClose('".$aRow['BerkasId']."') /></center>";
        else {
        $icon1 = "<center><img src='images/lock.png' style='cursor: pointer' title='Buka Berkas' onclick=openBukaBerkas('".$aRow['BerkasId']."') /></center>";
        }

        $row[] .= '<div align=left>'.$icon1.'</div>';
		//=======================================================================================
        $row[] .= $aRow['Klasifikasi']."/".$aRow['BerkasNumber'];
		//=======================================================================================
        $qw = mysql_query("Select BerkasId from inbox Where BerkasId = '".$aRow['BerkasId']."'");
        $qus = mysql_num_rows($qw);
        $row[] .= $aRow['BerkasName'];
		//=======================================================================================
        $row[] .= '<div align=center>'.$qus.'&nbsp;Item</div>';
		//=======================================================================================
        $qw = mysql_query("Select RoleName from role Where RoleId = '".$aRow['RoleId']."'");
        $qu = mysql_fetch_array($qw);
        $row[] .= $qu[0];
        $inline = 'none';
        if($qus==0)
        $inline = 'inline';
		//=======================================================================================
		
        $row[] .= tgl_indo($aRow['RetensiValue_Active']);
        $x = $aRow['Klasifikasi']."/".$aRow['BerkasNumber']." - ".$aRow['BerkasName'];
		//=======================================================================================

		$cari2=mysql_query("select RoleId from berkas where RoleId = '$_GET[roleid]'");
		$hasil222=mysql_fetch_array($cari2);

		if($hasil222 > 0) 
		{
			$row[] .= '<div align=left><img src="images/view2.png" style="cursor: pointer" onclick="tbl_item('.$aRow['BerkasId'].',\'' . $dat . '\')" />
					   </div>';
		}
		else
		{
        	if($aRow['BerkasStatus']=='closed')
			{
				$row[] .= '<div align=left><img src="images/view2.png" style="cursor: pointer" onclick="tbl_item('.$aRow['BerkasId'].',\'' . $x . '\')" />
						   </div>';					   
			} else {
				$row[] .= '<div align=left><img src="images/view2.png" style="cursor: pointer" onclick="tbl_item('.$aRow['BerkasId'].',\'' . $x . '\')" />
						   <img src="images/edit.png" style="cursor: pointer;" onclick=addBerkas("edit","'.$aRow['BerkasId'].'"); />
						   <img src="images/delete.png" style="cursor: pointer; display: '.$inline.'" onclick=setDelete("'.$aRow['BerkasId'].'"); />
						   </div>';
			}
		}
		$output['aaData'][] = $row;
		$n++;
	}

	echo json_encode( $output );

?>