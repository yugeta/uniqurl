(function(){
	var $$={}

	//$$.eventAdd(window,"load",$$.set);
	$$.eventAdd=function(t, m, f){

		//other Browser
		if (t.addEventListener){
			t.addEventListener(m, f, false);
		}

		//IE
		else{
			if(m=='load'){
				var d = document.body;
				if(typeof(d)!='undefined'){d = window;}

				if((typeof(onload)!='undefined' && typeof(d.onload)!='undefined' && onload == d.onload) || typeof(eval(onload))=='object'){
					t.attachEvent('on' + m, function() { f.call(t , window.event); });
				}
				else{
					f.call(t, window.event);
				}
			}
			else{
				t.attachEvent('on' + m, function() { f.call(t , window.event); });
			}
		}
	};

	$$.rlProperty=function(url){
		if(!url){return ""}
		var res = {};
		var urls = url.split("?");
		res.url = urls[0];
		res.domain = urls[0].split("/")[2];
		res.querys={};
		if(urls[1]){
			var querys = urls[1].split("&");
			for(var i=0;i<querys.length;i++){
				var keyValue = querys[i].split("=");
				if(keyValue.length!=2||keyValue[0]===""){continue}
				res.querys[keyValue[0]] = keyValue[1];
			}
		}
		return res;
	};

	$$.ajax = {
		//データ送信;
		post:function(fm){

			if(typeof(fm)=='undefined' || !fm){return}

			$$.ajax.httpoj = $$.ajax.createHttpRequest();
			if(!$$.ajax.httpoj){return;}

			//open メソッド
			$$.ajax.httpoj.open('post', "test.php" , true );
			$$.ajax.httpoj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

			//受信時に起動するイベント;
			$NC.$ajax.httpoj.onreadystatechange = function(){
				//readyState値は4で受信完了
				if ($NC.$ajax.httpoj.readyState==4){
					//コールバック
					var val = $$.ajax.httpoj.responseText;
					alert(val);
				}
			};
			var data=[];
			for(var i=0;i<fm.length;i++){
				data[data.length] = fm[i].name+"="+encodeURIComponent(fm[i].value);
			}

			//send メソッド;
			$$.ajax.httpoj.send(data.join("&"));
		},

		xmlObj:function(f){
			var r=null;
			try{
				r=new XMLHttpRequest();
			}
			catch(e){
				try{
					r=new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e){
					try{
						r=new ActiveXObject("Microsoft.XMLHTTP");
					}
					catch(e){
						return null;
					}
				}
			}
			return r;
		},

		//XMLHttpRequestオブジェクト生成;
		set:function( data , method , fileName , async ){
			$$.ajax.httpoj = $$.ajax.createHttpRequest();
			if(!$$.ajax.httpoj){return;}
			//open メソッド;
			$$.ajax.httpoj.open( method , fileName , async );
			$$.ajax.httpoj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			//受信時に起動するイベント;
			$$.ajax.httpoj.onreadystatechange = function(){
				//readyState値は4で受信完了;
				if ($$.ajax.httpoj.readyState==4){
					//コールバック
					var val = $$.ajax.on_loaded($$.ajax.httpoj);
				}
			};
			//send メソッド
			$$.ajax.httpoj.send( data );
		},

		createHttpRequest:function(){
			//Win ie用
			if(window.ActiveXObject){
				try {
					//MSXML2以降用;
					return new ActiveXObject("Msxml2.XMLHTTP")
				}
				catch(e){
					try {
						//旧MSXML用;
						return new ActiveXObject("Microsoft.XMLHTTP")
					}
					catch(e2){
						return null
					}
				}
			}
			//Win ie以外のXMLHttpRequestオブジェクト実装ブラウザ用;
			else if(window.XMLHttpRequest){
				return new XMLHttpRequest()
			}
			else{
				return null
			}
		},
		//コールバック関数 ( 受信時に実行されます );
		on_loaded:function(oj){
			//レスポンスを取得;
			var res = oj.responseText;alert(res);
			//ダイアログで表示;
			if(res && res.match(/^[a-z|$]/)){
				eval(res);
			}
		}
	};

	window.$$LIB = $$;
	return $$;
})();
