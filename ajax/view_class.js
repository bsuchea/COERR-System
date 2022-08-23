
// on load data
$(document).ready(function() {
    var table = $('#class').DataTable();
 
    $('#class tbody').on( 'click', 'tr', function () {
        window.location.href = 'class_report.php?cls_id='+ table.row( this ).data()[0];
    } );

} );


function getData(){

    var oTable = $('#class').dataTable();
    var br = $('#choose_breach').val();
    var sem = $('#choose_semester').val();

    $.ajax({
        url: 'ajax/view_class.php?data=get',
        data: 'breach='+br+'&semester='+sem,
        dataType: 'json',
        success: function(s){
            console.log(s);
            oTable.fnClearTable();
            for(var i = 0; i < s.length; i++) {
                oTable.fnAddData([ s[i][0], s[i][1], s[i][2], s[i][3], s[i][4], s[i][5] ]); 
            }
        }, error: function(e){
            oTable.fnClearTable(); 
            console.log(e.responseText); 
        }
    });
    return false;
}

