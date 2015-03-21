(function(){
	var $$={};

	$$.set = function(){
		var listUrl = document.getElementsByClassName("listUrl");
		for(var i=0;i<listUrl.length;i++){
			window.$$LIB.eventAdd(listUrl[i],"click",$$.urlClick);
		}

	};

	$$.urlClick = function(){
		var id  = this.getElementsByClassName("id");
		//var url = this.getElementsByClassName("url");
		//alert(url[0].innerHTML);
		var urls = location.href.split("?");
		location.href = urls[0]+"?id="+id[0].innerHTML;
	};


	window.$$LIB.eventAdd(window,"load",$$.set);
	return $$;
})();
