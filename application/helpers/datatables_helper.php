<?php defined('SYSPATH') OR die('No direct access allowed.');

class datatables_helper_Core {
	
	function get_data($sTable, $sIndexColumn, $aColumns, $sTableJoin, $aSearchColumns, $sTableCond, $sButtons, $sCheckbox=FALSE, $sAddCond="", $sGroupBy=""){		
		
		$this->db = new Database;
		
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
					//$sOrder .= "`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".

					// check if column has alias
					$check = strstr($aColumns[ intval( $_GET['iSortCol_'.$i] ) ], ' as ');
					if($check)
					{
						$t = explode(" as ", $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]);
						$sort_col = $t[0];

						$sOrder .= "".$sort_col." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
					}else{
						$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
					}
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
			//$sWhere = "WHERE (";
			$sWhere = $sTableCond ? "AND (" : "WHERE (";
			for ( $i=0 ; $i<count($aSearchColumns) ; $i++ )
			{
				//$sWhere .= "".$aSearchColumns[$i]." LIKE '%".( $_GET['sSearch'] )."%' OR ";
				$sWhere .= "".$aSearchColumns[$i]." LIKE '%".addslashes( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aSearchColumns) ; $i++ )
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
				$sWhere .= "".$aSearchColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
			}
		}
		
		//for custom filtering
		//service calls
		if(isset($_GET['service_calls']) == "YES" && isset($_GET['from_date']))
		{
			if($_GET['from_date'] != "")
			{
				$from_date = strtotime($_GET['from_date']);
				$sWhere .= $sWhere ? " AND date_added >= '".($from_date)."'" : " WHERE date_added >= '".($from_date)."'";
			}
		}
		
		if(isset($_GET['service_calls']) == "YES" && isset($_GET['to_date']))
		{
			if($_GET['to_date'] != "")
			{
				$to_date = strtotime($_GET['to_date']);
				$sWhere .= $sWhere ? " AND date_added <= '".($to_date)."'" : " WHERE date_added <= '".($to_date)."'";
				//$sWhere .= " AND date_added <= '".($to_date)."'";
			}
		}
		
		if($sAddCond == "weekly_meal_list_get_recipes" && $sWhere)
		{
			$temp_sTableCond = str_replace("WHERE ", "",  $sTableCond);
			$temp_sTableCond = "( ".$temp_sTableCond." )";

			$sWhere = str_replace("AND (", "", $sWhere);
			$sWhere = str_replace(" )", " AND ", $sWhere);
			$sTableCond = "WHERE ".$sWhere;

			$sWhere = $temp_sTableCond;
		}
		
		/*
		 * SQL queries
		 * Get data to display
		 */
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
			FROM   $sTable
			$sTableJoin
			$sTableCond
			$sWhere
			$sGroupBy
			$sOrder
			$sLimit
			";
		// echo $sQuery;
		// exit;
		$rResult = $this->db->query($sQuery);
		
		/* Data set length after filtering */
		$sQuery = "
			SELECT FOUND_ROWS() as fr
		";
		$rResultFilterTotal = $this->db->query($sQuery);
		$aResultFilterTotal = $rResultFilterTotal->current();
		$iFilteredTotal = $aResultFilterTotal->fr;
		
		/* Total data set length */
		$sQuery = "
			SELECT COUNT(".$sIndexColumn.") as cnt
			FROM   $sTable
			$sTableJoin
			$sTableCond
			$sWhere
		";
		$rResultTotal = $this->db->query($sQuery);
		$aResultTotal = $rResultTotal->current();
		$iTotal = $aResultTotal->cnt;
		
		
		/*
		 * Output
		 */
		$sEcho = isset($_GET['sEcho']) ? $_GET['sEcho'] : '';
		$output = array(
			"sEcho" => intval($sEcho),
			//"iTotalRecords" => $iTotal,
			"iTotalRecords" => $iFilteredTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach ( $rResult as $aRow )
		{
			$row = array();
			// Add the row ID to the array	
			$row['DT_RowId'] = 'row_'.$aRow->$sIndexColumn;

			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] == "version" )
				{
					/* Special output formatting for 'version' column */
					$row[] = ($aRow->$aColumns[$i]=="0") ? '-' : $aRow->$aColumns[$i];
				}else if($aColumns[$i] == "CONCAT_WS(' ', firstname, lastname) as member_name")
				{
					$t = explode(" as ", $aColumns[$i]);
					$col = $t[1];
					if($sCheckbox == TRUE && $i == 0)
					{
						$row[] = "<span style=\"display: inline-block !important; vertical-align: middle !important; margin-bottom: 12px !important;\"><input type=\"checkbox\" name=\"pid\" value=\"".$aRow->$sIndexColumn."\"></span>&nbsp;&nbsp;<a href=\"javascript:void(0)\" id=\"".$aRow->$sIndexColumn."\" class=\"viewmember\">".$aRow->$col."</a>"; 
					}else{
						$row[] = "<a href=\"javascript:void(0)\" id=\"".$aRow->$sIndexColumn."\" class=\"viewmember\">".$aRow->$col."</a>"; 
					}
				}else if($aColumns[$i] == "status")
				{	
					if($aRow->$aColumns[$i] == 'P')
					{
						$row[] = "Pending";
					}elseif($aRow->$aColumns[$i] == 'D')
					{
						$row[] = "Declined";
					}elseif($aRow->$aColumns[$i] == 'A')
					{
						$row[] = "Approved";
					}else{
						$row[] = $aRow->$aColumns[$i];
					}
				}else if($aColumns[$i] == "user_status")
				{	
					if($aRow->$aColumns[$i] == '0')
					{
						$row[] = "Inactive";
					}elseif($aRow->$aColumns[$i] == '1')
					{
						$row[] = "Active";
					}elseif($aRow->$aColumns[$i] == '2')
					{
						$row[] = "Pending";
					}elseif($aRow->$aColumns[$i] == '3')
					{
						$row[] = "Suspended";
					}
				}else if($aColumns[$i] == $sIndexColumn)
				{
					//this is for the last column, for buttons
					$primary_id = $aRow->$aColumns[$i];
					$Buttons = $sButtons;
					eval("\$Buttons = \"$Buttons\";");
					$row[] = $Buttons;
				}elseif($aColumns[$i] == 'last_modified_date' || $aColumns[$i] == 'from_date' || $aColumns[$i] == 'to_date' || $aColumns[$i] == 'report_date' || $aColumns[$i] == 'date_added' || $aColumns[$i] == 'date_created') //php timestamp value
				{
					$row[] = date('m/d/Y', $aRow->$aColumns[$i]); 
				}
				else if ( $aColumns[$i] != ' ' )
				{
					/* General output */
					if($sCheckbox == TRUE && $i == 0){ 	//has checkbox
						// find str
						$check = strstr($aColumns[$i], ' as ');
						if($check)
						{
							$t = explode(" as ", $aColumns[$i]);
							$col = $t[1];
							$row_val = $aRow->$col;
						}else{
							$row_val= strip_tags($aRow->$aColumns[$i]);
						}

						$row[] = "<span style=\"display: inline-block !important; vertical-align: middle !important; margin-bottom: 12px !important;\"><input type=\"checkbox\" name=\"pid\" value=\"".$aRow->$sIndexColumn."\"></span>&nbsp;&nbsp;".$row_val;
					}else{
						// find str
						$check = strstr($aColumns[$i], ' as ');
						if($check)
						{
							$t = explode(" as ", $aColumns[$i]);
							$col = $t[1];
							
							if($col == "date_added")
							{
								$row[] = date('m/d/Y', $aRow->$col);
							}else{
								$row[] = $aRow->$col;
							}
						}else{
							$row[] = strip_tags($aRow->$aColumns[$i]);
						}
					}
				}
			}
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	
	}
}
?>