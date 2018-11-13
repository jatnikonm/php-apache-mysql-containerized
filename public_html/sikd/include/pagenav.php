<?php
	function showpagenav($url, $option, $page, $pagecount){
		global $search;
		global $searchby;
		global $task;
		$url = $url . "?option=$option&task=$task";
		if($search != ""){
			$url = $url . "&search=$search&searchby=$searchby";
		}
		if($_REQUEST["orderby"] != ""){
			$url = $url . "&orderby=" . $_REQUEST["orderby"];
		}
		echo "<table border='0' cellspacing='1' cellpadding='2' class='tb_paging'>";
		echo "	<tr>";
		echo "	<td>&nbsp;</td>";
		
			if ($page > 1) { 
				$prevpage = $page-1;
				echo "<td><a href='$url&page=$prevpage'>&lt;&lt;&nbsp;Prev</a>&nbsp;</td>";
			}
			global $pagerange;
	
			if ($pagecount > 1) {
				if ($pagecount % $pagerange != 0) {
					$rangecount = intval($pagecount / $pagerange) + 1;
				} else {
					$rangecount = intval($pagecount / $pagerange);
				}
				for ($i = 1; $i < $rangecount + 1; $i++) {
					$startpage = (($i - 1) * $pagerange) + 1;
					$count = min($i * $pagerange, $pagecount);
					
					if ((($page >= $startpage) && ($page <= ($i * $pagerange)))) {
						for ($j = $startpage; $j < $count + 1; $j++) {
							if ($j == $page) {
								echo "<td class='pg_active'><strong>$j</strong></td>";
							} else { 
								echo "<td class='pg_inactive'><a href='$url&page=$j'>$j</a></td>";
							} 
						} 
					} else { 
						echo "<td>|<a href='$url&page=$startpage'>$startpage..</a></td>";
					} 
				} 
			}
			if ($page < $pagecount) { 
				$nextpage = $page + 1;
				echo "<td>&nbsp;<a href='$url&page=$nextpage'>Next&nbsp;&gt;&gt;</a>&nbsp;</td>";
			}
			
		echo "</tr>";
		echo "</table>";
	} 

?>