var ecwcjs=function (a, b) {

		//a.sort(sortFunction);
		function sortFunction(a, b) {
			return a[2] > b[2];
		}
		//console.log(a);
        setInterval(function(){
			var tx=""; var elm;
			if(jQuery("#content_ifr").length > 0) var v=true;
			if(v) {
				elm=jQuery("#content_ifr").contents().find("body");
				tx = elm.html();
			}
			else {
				elm=jQuery("#content");
				tx=elm.val();
			}
			
			tx = tx.replace(/(\r\n|\n|\r|\n\r)/g," ");
			tx = tx.replace( /<[a-zA-Z\/][^<>]*>/g, " " ).replace( /&nbsp;|&#160;/gi, " " );
			tx = tx.replace( /[0-9.(),;:!?%#jQuery¿\'"_+=\\/-]+/g, "" );

			var wordscount=tx.match(/\S\s+/g).length;
			
			//elm.css("backgroundColor","inherit");
			
			for(var color in a){
				if(color==0 ){
					if(wordscount<=a[color].count)elm.css({transition: "background-color 1s ease-in-out","background-color":'"'+a[color].bg+'"'});
				}
				else { 
					var prevc=color-1;
					var nextc=color+1;
					
					if(!(nextc in a) && wordscount>a[color].count)elm.css({transition: "background-color 1s ease-in-out","background-color":'"'+a[color].bg+'"'});
					else{
						if(wordscount>a[prevc].count && wordscount<=a[color].count)elm.css({transition: "background-color 1s ease-in-out","background-color":'"'+a[color].bg+'"'});
					}
				}
			}
			
			//jQuery("#wordcount").text(wordscount);
        }, 2000, a);
	}