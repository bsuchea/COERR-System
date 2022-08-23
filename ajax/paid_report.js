
// on load data
$(document).ready(function() {
    
    $('#breach').click(function(event) {
        if($(this).is(':checked')){
            $('#choose_breach').removeAttr('disabled');
            $('#choose_breach').selectpicker('refresh');
        }else{
            $('#choose_breach').prop('disabled', 'true');
            $('#choose_breach').selectpicker('refresh');
        }
    });

    $('#level').click(function(event) {
        if($(this).is(':checked')){
            $('#choose_level').removeAttr('disabled');
            $('#choose_level').selectpicker('refresh');
        }else{
            $('#choose_level').prop('disabled', 'true');
            $('#choose_level').selectpicker('refresh');
        }
    });

} );


function getData(){

    var oTable = $('#paid_report').dataTable();
    var br = $('#choose_breach').val();
    var sem = $('#choose_semester').val();
    var lv = $('#choose_level').val();
    if(!sem){
        playAudio('fail');
        $("#fail_view").addClass("open");
        return false;
    }

    var sql = "WHERE semester_id="+sem;
    if($('#breach').is(':checked')){
        if(br){
            sql += " AND breach_id=" + br;
        }
    }
    if($('#level').is(':checked')){
        if(lv){
            sql += " AND level_id=" + lv;
        }
    }

    $.ajax({
        url: 'ajax/paid_report.php?data=get',
        data: 'sql=' + sql,
        dataType: 'json',
        success: function(s){
            console.log(s);
            oTable.fnClearTable();
            for(var i = 0; i < s.length; i++) {
                oTable.fnAddData([ s[i][0], s[i][1], s[i][2], s[i][3] ]); 
            }
        }, error: function(e){
            oTable.fnClearTable(); 
            console.log(e.responseText); 
        }
    });
    return false;
}

