
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
    
    var st_suspend = $("#st_suspend").parent('[class*="icheckbox"]').hasClass("checked");
    var st_drop = $("#st_drop").parent('[class*="icheckbox"]').hasClass("checked");
    var st_repeat = $("#st_repeat").parent('[class*="icheckbox"]').hasClass("checked");

    var oTable = $('#student_filter').dataTable();
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
        
    if(st_drop && st_repeat && st_suspend){
        sql += " AND status='repeat' OR status='dropped' OR status='suspend' ";
    }else if(st_drop && st_repeat){
        sql += " AND status='repeat' OR status='dropped' ";
    }else if(st_drop && st_suspend){
        sql += " AND status='suspend' OR status='dropped' ";
    }else if(st_suspend && st_repeat){
        sql += " AND status='repeat' OR status='suspend' ";
    }
    else if(st_repeat){
        sql += " AND status='repeat' ";
    }else if(st_drop){
        sql += " AND status='dropped' ";
    }else if(st_suspend){
        sql += " AND status='suspend' ";
    }
    
    $.ajax({
        url: 'ajax/student_filter.php?data=get',
        data: 'sql=' + sql,
        dataType: 'json',
        success: function(s){
            console.log(s);
            oTable.fnClearTable();
            for(var i = 0; i < s.length; i++) {
                oTable.fnAddData([ s[i][0], s[i][1], s[i][2], s[i][3], s[i][4],  s[i][5], s[i][6], s[i][7] ]); 
            }
        }, error: function(e){
            oTable.fnClearTable(); 
            console.log(e.responseText); 
        }
    });
    return false;
}

var stu_id,cls_id;
function returnClass(stid,clsid){
    stu_id = stid;
    cls_id = clsid;
}

function getClass(){
    var br = $('#ch_breach').val();
    var sem = $('#ch_semester').val();

    //autoComplate Class
    $.ajax({
        url: 'ajax/payment.php?data=getCls',
        data: 'breach='+ br + '&semester=' + sem,
        dataType: 'json',
        success: function(data){
            $( "#txtclass" ).autocomplete({
                minLength: 0,
                source: data,
                focus: function( event, ui ) {
                   $( "#txtclass" ).val( ui.item.label );
                      return false;
                   },
                select: function( event, ui ) {
                   $( "#txtclass" ).val( ui.item.label );
                   $( "#class_id" ).val( ui.item.value );
                   $( "#cls_des" ).html( ui.item.desc );
                   
                   return false;
                }
             })
             .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                return $( "<li>" )
                .append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
                .appendTo( ul );
             };
        }, error: function(e){ 
            console.log(e.responseText); 
        }
    });
}

// submit on save
$(document).on('submit', '#cls_return', function(e){

    var form_data = $('#cls_change').serialize();

    $.ajax({
        url:          'ajax/class_detail.php?data=save',
        cache:        false,
        data:         form_data + '&class='+cls_id + '&student='+stu_id,
        success: function(e){
            console.log(e);
            noty({text: 'Return Successfully!', layout: 'topCenter', type: 'success'});
        }, error: function(e){
            console.log(e.responseText); 
        }
      });

    return false;
});



