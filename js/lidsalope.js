$(document).ready(function(){
    $('td:nth-child(4)').hide();
    $('td:nth-child(3)').click(function(){
        $('td:nth-child(4)').show();
    });
});