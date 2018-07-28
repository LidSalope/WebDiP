jQuery(document).ready(function() {
	$("#email").on('keyup', function(event) {
		console.log(provjeraStringa(event.target.value)); 
	});

	function provjeraStringa(testString){
		console.log(testString);
		if (testString != null && testString.length > 10 && testString.length < 30){
  			var r = new RegExp(/^[a-zA-Z0-9]+\.*[a-zA-Z0-9]*@[[a-zA-Z0-9]*\.[[a-zA-Z0-9]{2,}$/, 'i');
                        console.log("tu je došlo");
                        $("#email").css("background-color", "#067306");
  			return r.test(testString);
                        
		}
		else
                        $("#email").css("background-color", "#ff6666");
  			return false;
	}
        
        
    });
