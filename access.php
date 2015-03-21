<?php

date_default_timezone_set('Asia/Tokyo');

new ACCESS();

class ACCESS{
	/**
	 * Access関連処理
	 * d : unique-id
	 */
	function __construct(){



		//data-query-check
		if(isset($_REQUEST['d']) && $_REQUEST['d']){
			$this->setRedirect($_REQUEST['d']);
		}
		else{
			if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="regist"){
				$this->setRegist();
			}
			else if($_SERVER['QUERY_STRING']){
				$this->setRedirect($_SERVER['QUERY_STRING']);
			}
			else{
				$this->viewRegist();
			}
		}




	}

	function setRedirect($id){

		//データファイル
		$dataFile = "access.csv";

		if(!is_file($dataFile)){$this->viewError(2);}

		//クエリ情報分析（データファイル内にIDが存在するかどうか）
		$cmd = "awk -F, '{if($4 && !id && $2==\"".$id."\"){id=$2;print;}}' ".$dataFile;
		//$cmd = "awk -F, '{if(!id && $1=='".$_REQUEST['d']."'){id=$1;print;}}' ".$dataFile;
		unset($res);
		exec($cmd,$res);

		//IDが登録されていない場合
		if(!count($res)){$this->viewError(3);}

		//URL整形
		$sp = explode(",",$res[0]);
		$protocol = "http";
		$domain = explode(":",$sp[3])[0];

		//httpの場合
		if($sp[2]=="80"||$sp[2]==""){
			$protocol = "http";
		}
		//httpsの場合
		else if($sp[2]=="443"||$sp[2]=="s"){
			$protocol = "https";
		}
		else if($sp[2]){
			$domain .= ":".$sp[2];
		}
		$uri = str_replace("&#44;",",",$sp[4]);

		$url = $protocol."://".$domain."/".$uri;

		//log-data-write
		$this->setLog($id);

		//IDの値にリダイレクトする
		header("Location: ".$url);
		//echo $url;
	}

	function viewRegist(){
		//echo "viewRegist";
		header("Location: index.php");
	}
	function setRegist(){
		echo "setRegist";
	}


	function viewError($errorType){
		if(!isset($_REQUEST['d']) || !$_REQUEST['d']){$_REQUEST['d'] = "--";}
		die("<h1>Not found data. (".$errorType.")</h1>");
		//die("<h1>Not found data [ID:".$_REQUEST['d']."]</h1>");
	}

	function setLog($id){
		if(!$id){return;}

		$dir = "log/";
		if(!is_dir($dir)){mkdir($dir,0777,true);}

		$logData = date("HisO").",".$id.",".$this->getCookie().",".$_SERVER["REMOTE_ADDR"].",".$_SERVER['HTTP_USER_AGENT'];

		file_put_contents($dir.date("Ymd").".log" , $logData."\n" , FILE_APPEND);

	}

	public $cookieId = "uniqurl";

	function getCookie(){
		//登録済み
		if(isset($_COOKIE[$this->cookieId]) && $_COOKIE[$this->cookieId]){
			return $_COOKIE[$this->cookieId];
		}
		//未登録
		else{
			require_once "plugins/uniqurl/php.module/getId.php";
			$getId = new getId();
			$id = $getId->getId();
			setcookie($this->cookieId, $id, time()+(365*24*60*60));//１年間有効
			return $id;
		}
	}


	/**
	 * libUrl
	 */

	//port + domain [http://hoge.com:8800/]
	//現在のポートの取得（80 , 443 , その他）
	function getSite(){
		//通常のhttp処理
		if($_SERVER['SERVER_PORT']==80){
			$site = 'http://'.$_SERVER['SERVER_NAME'];
		}
		//httpsページ処理
		else if($_SERVER['SERVER_PORT']==443){
			$site = 'https://'.$_SERVER['SERVER_NAME'];
		}
		//その他ペート処理
		else{
			$site = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];
		}

		return $site;
	}
	//現在のクエリ無しパスを返す
	function getUrl(){
		$uri = $this->getSite();
		$req = explode('?',$_SERVER['REQUEST_URI']);
		$uri.= $req[0];
		return $uri;
	}

	//フルパスを返す
	function getUri(){
		$uri = $this->getSite();
		if($_SERVER['REQUEST_URI']){
			$uri.= $_SERVER['REQUEST_URI'];
		}
		else{
			$uri = $this->getUrl.(($_SERVER['QUERY_STRING'])?"?".$_SERVER['QUERY_STRING']:"");
		}
		return $uri;
	}


}
