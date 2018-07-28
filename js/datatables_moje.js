$.extend( $.fn.dataTable.defaults, {
    ordering:  false
} );

$(document).ready( function () {
    $('#nesrece').DataTable({
        "pageLength": 7,
        "dom": 'ftipr',
    });
    $('#uzbune').DataTable({
        "pageLength": 7,
        "dom": 'ftipr',
         
    });
    $('#ustanove').DataTable({
        "pageLength": 7,
        "dom": 'ftipr',
         
    });
} );
