
var sem_id = 0;
var lv_id = 0;
var stu_id = 0;

// on load data
$(document).ready(function() {
    
    
} );

function suspend(study_id){
     study_id
     var box = $("#mb-suspend");
     box.find(".mb-control-yes").on("click",function(){
        box.removeClass("open");

        //proccess suspend on ajax
        $.ajax({
            url:          'ajax/class_detail.php?data=suspend',
            cache:        false,
            data:         'study='+study_id,
            success: function(e){
                console.log(e);
                noty({text: 'Suspend Successfully!', layout: 'topCenter', type: 'success'});
                
            }, error: function(e){
                console.log(e.responseText); 
            }
          });
        
    });
}

$('#choose_breach').change(function(event) {
    comClass(sem_id, lv_id);
});

$('#btnAttendent').click(function(event) {
    window.location.href = 'attendent.php?cls_id='+$('#txtclassid').val();
});

$('#btnScore').click(function(event) {
    window.location.href = 'score.php?cls_id='+$('#txtclassid').val();
});

$('#btnReport').click(function(event) {
    window.location.href = 'class_report.php?cls_id='+$('#txtclassid').val();
});


function changeClass(study_id) {
    stu_id = study_id
    // get breach id by class id
    $.ajax({
        url:        'ajax/class_detail.php?data=getBrId',
        data:       'class=' + $('#txtclassid').val() + "&study=" + study_id,
        dataType:   'json',
        success: function(data){
            console.log(data);
            $('#choose_breach').selectpicker('val', data[0]);
            $('#txtclass').val('');
            $('#class_id').val('');
            $('#cls_des').text('Type in the time of that level.');
            sem_id = data[1];
            lv_id = data[2];
            comClass(data[1], data[2]);

        }, error: function(e){ 
            console.log(e.responseText); 
        }
    });
    
}

function comClass(sem, lv){
    //autoComplate Class
            $.ajax({
                url: 'ajax/class_detail.php?data=getCls',
                data: 'breach='+ $('#choose_breach').val() + '&semester=' + sem +'&lv='+ lv,
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
                        $( "#txtclass" ).autocomplete({
                            minLength: 0,
                            source: [{ value: ' ', label: "No class", desc: "There are no class for this breach."}],
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
                    console.log(e.responseText); 
                }
            });
}

// submit on save
$(document).on('submit', '#cls_change', function(e){

    var form_data = $('#cls_change').serialize();

    $.ajax({
        url:          'ajax/class_detail.php?data=save',
        cache:        false,
        data:         form_data + '&study='+stu_id,
        success: function(e){
            console.log(e);
            noty({text: 'Change Successfully!', layout: 'topCenter', type: 'success'});
            $("#trow_"+stu_id).hide("slow",function(){
                $(this).remove();
            });
        }, error: function(e){
            console.log(e.responseText); 
        }
      });

    return false;
});



setInterval(function() {$.noty.closeAll();}, 8000);


