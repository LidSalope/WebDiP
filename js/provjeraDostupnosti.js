function provjeriDostupnost() {
jQuery.ajax({
    url: "pomphp/provjeraDostupnosti.php",
    data:'korisme='+$("#korisme").val(),
    type: "POST",
    success:function(data){
    $("#status").html(data);
},
error:function (){}
});
}
