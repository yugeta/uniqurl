<?php

date_default_timezone_set('Asia/Tokyo');

new uniqurl_index();

class uniqurl_index extends fw_define{

	public $dataFile = "access.csv";


	function __construct(){
		//if(!isset($_REQUEST['mode'])){return;}
		/*
		if(isset($_REQUEST['id']) && $_REQUEST['id']){
			echo "aaa";
		}
		*/
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="regist"){

			//data-check
			unset($res);
			$cmd = "awk -F, '{";
				$cmd.= "if(!$1 && $4 && $5){";
					$cmd.= "if(!$3){";
						$cmd.= "url = \"http://\"$4\"/\"$5";
					$cmd.= "}";
					$cmd.= "else{";
						$cmd.= "url = \"https://\"$4\"/\"$5";
					$cmd.= "}";
					//$cmd.= "print url;";
					$cmd.= "if(url==\"".$_REQUEST['url']."\"){print}";
				$cmd.= "}";
			$cmd.= "}' ".$this->dataFile;
			exec($cmd,$res);
			//print_r($res);

			//data-set
			if(!count($res)){
				$data = $this->url2data($_REQUEST['url']);
				file_put_contents($this->dataFile,$data."\n",FILE_APPEND);
			}

			//redirect
			$url = new libUrl();
			$url->setUrl($url->getUrl());
		}

	}



	function url2data($url){
		$getId = new getId();
		$dataUrl = $this->decodeUrl($url);
		$data = ",".$getId->getId().",".$dataUrl[0].",".$dataUrl[1].",".$dataUrl[2].",".date("YmdHis");
		return $data;
	}
/*
	function getId(){
		$libBase = new LibBase();
		list($usec, $sec) = explode (' ', microtime());

		$addmsec = (int)($usec * 1000);
		$mtime = ((float)$usec + (float)$sec);
		$basetime = strtotime("2015/1/1 0:0:0");

		$date = (int)(($sec-$basetime)).$addmsec;

		$id = $libBase->encode($date,64);

		return $id;
	}
*/
	function decodeUrl($url){
		$splitUrl = explode("/",$url);
		$arr = array();

		//port
		if(preg_match("/.*:([0-9]*)$/",$splitUrl[2],$res)){
			$arr[0] = $res[1];
		}
		else if($splitUrl[0]=="http:"){
			$arr[0] = "";
		}
		else if($splitUrl[0]=="https:"){
			$arr[0] = "s";
		}

		else{
			$arr[0] = "-";
		}

		//domain
		$arr[1] = explode(":",$splitUrl[2])[0];

		$arr[2] = join("/",array_slice($splitUrl,3));

		return $arr;
	}

}
