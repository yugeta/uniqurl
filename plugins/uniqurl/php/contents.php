<?php

new CONTENTS();

class CONTENTS extends fw_define{
	function __construct(){
		$fw_define = new fw_define();
		$libView   = new libView();
		if(isset($_REQUEST['id']) && $_REQUEST['id']){
			$file = $fw_define->define_plugins."/".$_REQUEST['plugins']."/html/url.html";
		}
		else{
			$file = $fw_define->define_plugins."/".$_REQUEST['plugins']."/html/contents.html";
		}

		echo $libView->file2HTML($file);
	}
}
