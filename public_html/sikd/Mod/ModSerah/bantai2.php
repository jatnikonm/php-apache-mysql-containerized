<?php
session_start();


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */

	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array( 'BerkasId', 'Klasifikasi', 'BerkasNumber', 'BerkasName', 'Role.RoleDesc');

	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "BerkasId";

	/* DB table to use */
	$sTable = "berkas";

    $Nos = $_REQUEST['Nos'];
//    $thnB = $_REQUEST['thnB'];
    $task = $_REQUEST['task'];
    $id = $_REQUEST['id'];

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


        $susutId = $_SESSION["AppKey"].".2";
	    $sWhere = " WHERE berkas.Klasifikasi <> '0' ";
        $sWhere .= " and berkas.RetensiValue_InActive < curdate() and berkas.SusutId = '".$susutId."' and berkas.BerkasStatus='closed'";
        $sJoin = " Inner Join role ON role.RoleId = berkas.RoleId ";

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
			SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
			FROM   $sTable
            $sJoin
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
    if($task=='edit')
    $ddr = "select berkasid from permohonan_serah where idserah = '$id'";
    else
    $ddr = "select berkasid from permohonan_serah where idserah='$Nos'";

    $idb = mysql_fetch_array(mysql_query($ddr));
    $bids = explode("#",$idb[0]);

    while ( $aRow = mysql_fetch_array( $rResult ))
	{
		    $row = array();
            $list=0;

         if($task=='edit'){
            for($i=0;$i<count($bids);$i++){
               $checked = "";
               if($bids[$i]==$aRow[0]){
               $checked = "checked=checked";

            $row[] = '<div align=right>'.$n.".".'</div>';
            $item_check = '<input type="checkbox" name="ch[]" '.$checked.' '.$disabled.'  value="'.$aRow[0].'">';
            $row[] = $aRow["Klasifikasi"]."/".$aRow["BerkasNumber"];
            $row[] = $aRow["BerkasName"];
            $row[] = $aRow["RoleDesc"];
            $output['aaData'][] = $row;$n++;
            }
          }
         }

         if($task=="new"){
            for($i=0;$i<count($bids);$i++){
               $checked = "";
            if($bids[$i]==$aRow[0]){
            $checked = "checked=checked";
            $row[] = '<div align=right>'.$n.".".'</div>';
            $item_check = '<input type="checkbox" name="ch[]" '.$checked.'  value="'.$aRow[0].'">';
            $row[] = $aRow["Klasifikasi"]."/".$aRow["BerkasNumber"];
            $row[] = $aRow["BerkasName"];
            $row[] = $aRow["RoleDesc"];
            $n++;
            $output['aaData'][] = $row;}
             }
         }

  }

	echo json_encode( $output );
?>