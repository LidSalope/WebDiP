
function pocetna(){
	var mojCookie = procitajCookie("put");

	if(mojCookie == null){
		kreirajCookie("put","prvi_dolazak",2);
		alert("Ova stranica sprema kolačiće");
	}
	else{
		return;
	}
}

function procitajCookie(ime){
	var imeEQ = ime + '=';
	var ca = document.cookie.split(';');
	for(var i=0; i < ca.length; i++){
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if(c.indexOf(imeEQ) == 0) return c.substring(imeEQ.length,c.length);
	}
	return null;
}

function kreirajCookie(ime,vrijednost,vrijeme){
        if(vrijeme){
            var datum = new Date();
            datum.setTime(datum.getTime()+(vrijeme*24*60*60*1000));
            var expires = "; expires="+datum.toGMTString();
                    console.log(vrijeme);
                    console.log(expires);
        }
        else var istice = "";
	document.cookie = ime + "=" + vrijednost+";"+expires + ";;";
}
    