<?php

/**
 *
 */

class getId{
	//cookie-id
	function getId(){
		require_once "plugins/library/php.module/libBase.php";
		$libBase = new LibBase();
		list($usec, $sec) = explode (' ', microtime());

		$addmsec = (int)($usec * 1000);
		$mtime = ((float)$usec + (float)$sec);
		$basetime = strtotime("2015/1/1 0:0:0");

		$date = (int)(($sec-$basetime)).$addmsec;

		$id = $libBase->encode($date,64);

		return $id;
	}
}
