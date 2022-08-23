
// on load data
$(document).ready(function() {

    $("#attendent").validationEngine('attach', {focusFirstField : false});

    // $('#atten_his').dataTable( {
    //     destroy: true,
    //     "order": [[ 1, "asc" ]]
    // } );

} );

function getData(){
    // init dataTable
    var oTable = $('#atten_his').dataTable();

    $.ajax({
        url: 'ajax/attendent.php?data=get',
        dataType: 'json',
        data: 'class_id=' + $('#txtclassid').val(),
        success: function(s){
            console.log(s);
            oTable.fnClearTable();
            for(var i = 0; i < s.length; i++) {
                oTable.fnAddData([ s[i][0], s[i][1], s[i][2], s[i][3], s[i][4], s[i][5] ]); 
            }
        }, error: function(e){ 
                console.log(e.responseText); 
        }
    });
}


$('#btnDetail').click(function(event) {
    window.location.href = 'class_detail.php?cls_id='+$('#txtclassid').val();
});

$('#btnScore').click(function(event) {
    window.location.href = 'score.php?cls_id='+$('#txtclassid').val();
});

$('#btnReport').click(function(event) {
    window.location.href = 'class_report.php?cls_id='+$('#txtclassid').val();
});


// submit on save
$(document).on('submit', '#attendent', function(e){

    var form_data = $('#attendent').serialize();

    $.ajax({
        url:          'ajax/attendent.php?data=save',
        cache:        false,
        data:         form_data,
        success: function(e){
            console.log(e);
            noty({text: 'Save Successfully!', layout: 'topCenter', type: 'success'});
        }, error: function(e){
            console.log(e.responseText); 
        }
      });

    return false;
});

function del(row){
    var study_id = row.split('_')[0];
    var date = row.split('_')[1];
    
    playAudio('alert');
    var box = $("#mb-remove-row");
    box.addClass("open");

    var i=0;
    box.find(".mb-control-close").on("click",function(){
        i++;
    });
    
    box.find(".mb-control-yes").on("click", function(){
        box.removeClass("open");

        //protect error loop with old 
        if(i>0){
            return false;
        }

        //proccess delete on ajax
        $.ajax({
            url:        'ajax/attendent.php?data=delete',
            data:       'study_id=' + study_id + '&date=' + date ,
            success: function(s){
                console.log(s);
                noty({text: 'Delete Successfully!', layout: 'topCenter', type: 'success'});

                $("#trow"+row).parent().parent().hide("slow",function(){
                    $(this).remove();
                });
            }, error: function(e){ 
                console.log(e.responseText); 
            }
        });

    });
    return false;
}


setInterval(function() {$.noty.closeAll();}, 6000);


