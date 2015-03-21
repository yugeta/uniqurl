<?php
/**
 *
 */

class viewData{
	/**
	* csv to talbe-view
	* param @ $csvFilePath : root-path
	* $flg @ [ none:record-only table:add-table-tag ]
	*/
	function viewCsv2Table($csvFilePath="",$flg="none"){
		if(!$csvFilePath){$csvFilePath = "access.csv";}
		if(!is_file($csvFilePath)){return;}

		$records = explode("\n",file_get_contents($csvFilePath));

		//$num = 1;
		$html = "";
		if($flg=="table"){$html.= "<table>";}
		for($i=0;$i<count($records);$i++){
			//空行はスキップする
			if($records[$i]===""){continue;}
			//セル処理
			$split = explode(",",$records[$i]);
			$html.= "<tr class='listUrl'>";
			//$html.= "<th>".$num."</th>";
			$html.= "<td class='id'>".$split[1]."</td>";
			//protocol&port
			$protocol = "http";
			$domain = $split[3];
			if($split[2]){
				if($split[2]=="80"){
					$protocol=="http";
					$domain = $split[3];
				}
				else if($split[2]=="443"){
					$protocol=="https";
					$port = $split[3];
				}
				else{
					$protocol=="http";
					$port = $split[3].":".$split[2];
				}
			}
			$url = $protocol."://".$domain."/".$split[4];
			$html.= "<td class='url'>".$url."</td>";
			//--Access
			//$access = 0;
			//$html.= "<td class='access'>".$access."</td>";

			$html.= "</tr>";
			$html.= "\n";
			//$num++;
		}
		if($flg=="table"){$html.= "</table>";}

		return $html;
	}

}
