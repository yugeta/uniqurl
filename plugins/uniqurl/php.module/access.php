<?php

class ACCESS{
	function getCount($id=""){
		if(!$id){return 0;}

		$log = "log/";
		if(!is_dir($log)){return 0;}

		unset($res);

		$cmd = "";
		$cmd.= "awk -F, '";
			$cmd.= "BEGIB{cnt=0}";

			$cmd.= "{";
				$cmd.= "if($2==\"".$id."\"){cnt++;}";
			$cmd.= "}";

			$cmd.= "END{print cnt}";
		$cmd.= "' ".$log."*.log";

		exec($cmd,$res);

		$cnt = 0;
		if(count($res) && $res[0]){
			$cnt = $res[0];
		}
		return $cnt;

	}
}
