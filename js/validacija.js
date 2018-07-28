//provjera da polja nisu prazna
function provjera(){
	var neispunjeno = "";
	if ((document.forms['form2'].ime.value==="")|| 
            (document.forms['form2'].prez.value==="")||
            (document.forms['form2'].korisme.value==="")||
            (document.forms['form2'].email.value==="") ){
	 	neispunjeno += "Polja: ime, prezime, korisničko ime i email ne smiju biti prazna!";
	}
	if(neispunjeno !== "") {
		alert(neispunjeno);
		return false;
	}
	else
		return true;
}

//provjera da nisu uneseni nedozvoljeni znakovi
function nz(e){
    var keynum;

    if(window.event) { // IE                    
      keynum = e.key;
    } else if(e.which){ // Netscape/Firefox/Opera                   
      keynum = e.key;
    }
    
    if (keynum == "'" || keynum == '!'|| keynum == '?' || keynum == '#'){
    	alert("nedozvoljen znak");
    	    	
        var rijec = e.srcElement.value;
        document.getElementById(e.srcElement.id).value = rijec.substring(0, rijec.length-1);
    }
    
}

//provjera za brojanje znakova kod korisničkog imena i lozinke
function broji(text){
	var brojac = 0 + document.getElementById("korisme").value.length;
        
	var rezultati = false;
	if (brojac <= 5 ) {
		rezultati = false;
                alert("Korisničko ime ne smije imati manje od 6 znakova!");
	}else rezultati = true;
	return rezultati;
}

function brojiloz(text){
	var brojac = 0 + document.getElementById("lozinka1").value.length;
        
	var rezultati = false;
	if (brojac <= 5 ) {
		rezultati = false;
	}else rezultati = true;
	return rezultati;
}

//provjera da su lozinke jednake
function lozinke(e){
	var lozinka1 = document.getElementById("lozinka1");
        var lozinka2 = document.getElementById("lozinka2");
        
        var crvena = '#ff6666';
        var zelena = '#067306';
        
        if(lozinka1.value === lozinka2.value){
            lozinka2.style.backgroundColor = zelena;
        }else{
            lozinka2.style.backgroundColor = crvena;
        }
}