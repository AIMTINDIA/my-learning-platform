<?php
include '../components/connect.php';


if($_GET['type']=="feesearch")
{
$aColumns = array( 's.registration_id','s.name','s.balance','s.fees','b.program','s.contact_no','s.doj');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "s.registration_id";
	
	/* DB table to use */
	$sTable = " users as s,program as b ";
	
	
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		#filter_var($name, FILTER_SANITIZE_STRING);
		$sLimit = "LIMIT ".filter_var($_GET['iDisplayStart'],FILTER_SANITIZE_STRING ).", ".
		filter_var($_GET['iDisplayLength'], FILTER_SANITIZE_STRING);
		#$sLimit = "LIMIT ".mysqli_real_escape_string($conn,$_GET['iDisplayStart'] ).", ".
		#	mysqli_real_escape_string($conn, $_GET['iDisplayLength'] );
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
				$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".filter_var( $_GET['sSortDir_'.$i], FILTER_SANITIZE_STRING) .", ";
					#".mysqli_real_escape_string($conn, $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	$cond = "";
	$condArr = array();
	if(isset($_GET['student']) && $_GET['student']!="")
	{
	$condArr[] = "s.name like '%".filter_var($_GET['student'],FILTER_SANITIZE_STRING)."%'";
	
	}
	
	if(isset($_GET['program']) && $_GET['program']!="")
	{
	$condArr[] = "b.id = '".filter_var($_GET['program'],FILTER_SANITIZE_STRING)."'";
	
	}
	
	
	if(isset($_GET['doj']) && $_GET['doj']!="")
	{
	$Adate= explode(' ',$_GET['doj']);
    $month = $Adate[0];
    $year = $Adate[1];
	$months = array('January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09','October'=>'10','November'=>'11','December'=>'12');
	
	$doj = $months[$month].'-'.$year;	
	$condArr[] = " DATE_FORMAT(s.doj, '%m-%Y') = '".$doj."'";
	
	}
	if(count($condArr)>0)
	{
	$cond = " and ( ".implode(" and ",$condArr)." )";
	}
	 
	$mycount = count($aColumns);
	 
	$sWhere = " WHERE b.program=s.program and s.delete_status in ('0','2') and s.balance>0 ";
	if ( isset($_GET['sSearch'])&& $_GET['sSearch'] != "" )
	{
	    
		$sWhere = $sWhere." and (";
		for ( $i=0 ; $i<$mycount ; $i++ )
		{
		    
			$sWhere .= $aColumns[$i]." LIKE '%".filter_var($_GET['sSearch'],FILTER_SANITIZE_STRING )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering 
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn,$_GET['sSearch_'.$i])."%' ";
		}
	}*/
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT    ".implode(", ", $aColumns)."
		FROM   ".$sTable."	".$sWhere.$cond." ".$sOrder." ".$sLimit;
	
	$rResult = $conn->prepare($sQuery);
    $rResult->execute();
	
	#$rResult = $conn->query($sQuery) or die(mysqli_error($conn));
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT    count(*) as rr
		FROM   ".$sTable."	".$sWhere.$cond." ".$sOrder." ".$sLimit;
	
	$rResultFilterTotal = $conn->prepare($sQuery);
    $rResultFilterTotal->execute();
	#$rResultFilterTotal = $conn->query( $sQuery) or die(mysqli_error($conn));
	$aResultFilterTotal = $rResultFilterTotal->fetch(PDO::FETCH_ASSOC);
	$iFilteredTotal = $aResultFilterTotal['rr'];
	
	/* Total data set length */
	$sQuery = "SELECT COUNT(".$sIndexColumn.") as cc
		FROM   ".$sTable." WHERE b.program=s.program and s.delete_status in ('0','2') and s.balance>0  ";
	$rResultTotal = $conn->prepare($sQuery);
    $rResultTotal->execute();
	#$rResultTotal = $conn->query( $sQuery ) or die(mysqli_error($conn));
	$aResultTotal = $rResultTotal->fetch(PDO::FETCH_ASSOC);
	$iTotal = $aResultTotal['cc'];
	
	
	/*
	 * Output
	 */
	 
	if(isset($_GET['sEcho'])) 
	{
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	}else
	{
	 $output = array(
		
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	}
	
     $row =array();
	while ( $aRow = $rResult->fetch(PDO::FETCH_ASSOC)  )
	{
		
		
		$row = array(
                    html_entity_decode($aRow['name'].'<br/>'.$aRow['contact_no']),
                    $aRow['fees'],
					$aRow['balance'],
                    $aRow['program'],
					date("d M y", strtotime($aRow['doj'])),
                    
					html_entity_decode('<button class="btn-success btn-sm" style="border-radius:0%" onclick="javascript:GetFeeForm('.$aRow['registration_id'].')"><i class="fa fa-money"></i> Collect Fee </button>')
										
                );
		
		$output['aaData'][] =$row;
		
	}
	
	echo json_encode( $output );

}



if($_GET['type']=="report")
{ 
$aColumns = array( 's.registration_id','s.name','s.balance','s.fees','b.program','s.contact_no','s.doj');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "s.registration_id";
	
	/* DB table to use */
	$sTable = " users as s,program as b ";
	
	
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".filter_var($_GET['iDisplayStart'],FILTER_SANITIZE_STRING ).", ".
			filter_var($_GET['iDisplayLength'],FILTER_SANITIZE_STRING );
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
				$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".filter_var($_GET['sSortDir_'.$i],FILTER_SANITIZE_STRING ) .", ";
			}
		}

		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	$cond = "";
	$condArr = array();
	if(isset($_GET['student']) && $_GET['student']!="")
	{
	$condArr[] = "s.name like '%".filter_var($_GET['student'],FILTER_SANITIZE_STRING)."%'";
	
	}
	
	if(isset($_GET['program']) && $_GET['program']!="")
	{
	$condArr[] = "b.id = '".filter_var($_GET['program'],FILTER_SANITIZE_STRING)."'";
	
	}
	
	
	if(isset($_GET['doj']) && $_GET['doj']!="")
	{
	$Adate= explode(' ',$_GET['doj']);
    $month = $Adate[0];
    $year = $Adate[1];
	$months = array('January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09','October'=>'10','November'=>'11','December'=>'12');
	
	$doj = $months[$month].'-'.$year;	
	$condArr[] = " DATE_FORMAT(s.doj, '%m-%Y') = '".$doj."'";
	
	}
	if(count($condArr)>0)
	{
	$cond = " and ( ".implode(" and ",$condArr)." )";
	}
	 
	$mycount = count($aColumns);
	 
	$sWhere = " WHERE b.program=s.program and s.delete_status in ('0','2')  ";
	if ( isset($_GET['sSearch'])&& $_GET['sSearch'] != "" )
	{
	    
		$sWhere = $sWhere." and (";
		for ( $i=0 ; $i<$mycount ; $i++ )
		{
		    
			$sWhere .= $aColumns[$i]." LIKE '%".filter_var($_GET['sSearch'],FILTER_SANITIZE_STRING )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering 
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn,$_GET['sSearch_'.$i])."%' ";
		}
	}*/
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT   ".implode(", ", $aColumns)."
		FROM   ".$sTable."	".$sWhere.$cond." ".$sOrder." ".$sLimit;
	$rResult = $conn->prepare($sQuery);
    $rResult->execute();
	#$rResult = $conn->query($sQuery) or die(mysqli_error($conn));
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT count(*) as rr
	FROM   ".$sTable."	".$sWhere.$cond." ".$sOrder." ".$sLimit;
	
	$rResultFilterTotal = $conn->prepare($sQuery);
    $rResultFilterTotal->execute();
	#$rResultFilterTotal = $conn->query( $sQuery) or die(mysqli_error($conn));
	$aResultFilterTotal = $rResultFilterTotal->fetch(PDO::FETCH_ASSOC);
	$iFilteredTotal = $aResultFilterTotal['rr'];
	
	/* Total data set length */
	$sQuery = "SELECT COUNT(".$sIndexColumn.") as cc
		FROM   ".$sTable." WHERE b.program=s.program and s.delete_status='0'   ";
	$rResultTotal = $conn->prepare($sQuery);
    $rResultTotal->execute();
	#$rResultTotal = $conn->query( $sQuery ) or die(mysqli_error($conn));
	$aResultTotal = $rResultTotal->fetch(PDO::FETCH_ASSOC);
	$iTotal = $aResultTotal['cc'];
	
	
	/*
	 * Output
	 */
	 
	if(isset($_GET['sEcho'])) 
	{
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	}else
	{
	 $output = array(
		
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	}
	
     $row =array();
	while ( $aRow = $rResult->fetch(PDO::FETCH_ASSOC)  )
	{
		
		
		$row = array(
                    html_entity_decode($aRow['name'].'<br/>'.$aRow['contact_no']),
                    $aRow['fees'],
					$aRow['balance'],
                    $aRow['program'],
					date("d M y", strtotime($aRow['doj'])),
                    
					html_entity_decode('<button class="btn-success btn-sm" style="border-radius:0%" onclick="javascript:GetFeeForm('.$aRow['registration_id'].')"> Check Report </button><button class="btn-danger btn-sm" style="border-radius:0%" onclick="javascript:BillPrint('.$aRow['registration_id'].')"> Print Invoice </button>')
										
                );
		
		$output['aaData'][] =$row;
		
	}
	
	echo json_encode( $output );

}

?>

