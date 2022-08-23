
var dis;

// on load data
$(document).ready(function() {
    dis = parseInt( $('#txtdiscount').val() );
    
    $('input').on('ifChecked ifUnchecked', function(event){ 
        if(event.type =='ifChecked'){
            //process to change price
            $.ajax({
                url: 'ajax/payment.php?data=getPrice',
                data: 'class='+ $('#class_id').val(),
                dataType: 'json',
                success: function(data){
                    $('#txtprice').val( data - ( dis * data/100 ) +5);
                }, error: function(e){ 
                    console.log(e.responseText); 
                }
            });
        }else{
            //process to change price
            $.ajax({
                url: 'ajax/payment.php?data=getPrice',
                data: 'class='+ $('#class_id').val(),
                dataType: 'json',
                success: function(data){
                    $('#txtprice').val(data - ( dis * data/100 ));
                }, error: function(e){ 
                    console.log(e.responseText); 
                }
            });
        }
    });


    //autoComplate student
    $.ajax({
        url: 'ajax/payment.php?data=getSt',
        dataType: 'json',
        success: function(data){
            $( "#student" ).autocomplete({
                minLength: 3,
                source: data,
                focus: function( event, ui ) {
                   $( "#student" ).val( ui.item.label );
                      return false;
                   },
                select: function( event, ui ) {
                   $( "#student" ).val( ui.item.label );
                   $( "#student_id" ).val( ui.item.value );
                   $( "#student_des" ).html( ui.item.desc );
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

    $('#btnprint').on('click', function() {
        //Print printing with default options
        $.print("#printing");
    });

} );

$('#txtdiscount').change(function(){
    
    dis = parseInt( $('#txtdiscount').val() );
    
    //process to change price
    $.ajax({
        url: 'ajax/payment.php?data=getPrice',
        data: 'class='+ $('#class_id').val(),
        dataType: 'json',
        success: function(data){
            var checked = $("#newstudent").parent('[class*="icheckbox"]').hasClass("checked");

            if(checked) {
                $('#txtprice').val(data - ( dis * data/100 ) +5);
            }else{
                $('#txtprice').val(data - ( dis * data/100 ) );
            }

        }, error: function(e){ 
            console.log(e.responseText); 
        }
    });
});

function getClass(){
    var br = $('#choose_breach').val();
    var sem = $('#choose_semester').val();

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
                   //process to change price
                    $.ajax({
                        url: 'ajax/payment.php?data=getPrice',
                        data: 'class='+ ui.item.value,
                        dataType: 'json',
                        success: function(data){
                            var checked = $("#newstudent").parent('[class*="icheckbox"]').hasClass("checked");

                            if(checked) {
                                $('#txtprice').val(data - ( dis * data/100 ) +5);
                            }else{
                                $('#txtprice').val(data - ( dis * data/100 ) );
                            }
                            
                        }, error: function(e){ 
                            console.log(e.responseText); 
                        }
                    });
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


function viewHistory(){
    // init dataTable
    var oTable = $('#pay_his').dataTable();
    var br = $('#choose_breach').val();
    var sem = $('#choose_semester').val();

    $.ajax({
        url: 'ajax/payment.php?data=get',
        data: 'breach='+br+'&semester='+sem,
        dataType: 'json',
        success: function(s){
            console.log(s);
            oTable.fnClearTable();
            for(var i = 0; i < s.length; i++) {
                oTable.fnAddData([ s[i][0], s[i][1], s[i][2], s[i][3], s[i][4], s[i][5], s[i][6] ]);
            }
        }, error: function(e){
            oTable.fnClearTable(); 
            console.log(e.responseText); 
        }
    });
    return false;
}


// submit save and print
$(document).on('submit', '#payment', function(e){

    if($('#class_id').val()=='' || $('#student_id').val()==''){
        playAudio('fail');
        $("#fail_pay").addClass("open");
        return false;
    }

    var form_data = $('#payment').serialize();

    $.ajax({
        url:          'ajax/payment.php?data=check',
        cache:        false,
        data:         'choose_semester='+$('#choose_semester').val() +'&student_id='+$('#student_id').val(),
        success: function(e){
            console.log(e);
            if(e=='busy'){
                playAudio('fail');
                $("#busy").addClass("open");
                return false;
            }
            $.ajax({
                url:          'ajax/payment.php?data=add',
                cache:        false,
                data:         form_data,
                success: function(e){
                    console.log(e);
                    $( "#student" ).val( '' );
                    $( "#student_id" ).val( '' );
                    $( "#student_des" ).html( 'Type in and choose the correct student' );
                    print(e);
                }, error: function(e){
                    console.log(e.responseText); 
                }
            });
        }, error: function(e){
            console.log(e.responseText); 
        }
    });

    return false;
});

$('#btnClear').click(function(event) {
    $( "#class_id" ).val( '' );
    $('#cls_des').html('Type level name in and choose the correct class');
    $( "#student_id" ).val( '' );
    $( "#student_des" ).html( 'Type in and choose the correct student' );
    $("#newstudent").parent('[class*="icheckbox"]').removeClass("checked");
});

function del(row){
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
            url:        'ajax/payment.php?data=delete',
            data:       'id=' + row ,
            success: function(s){
                console.log(s);
                $("#trow"+row).parent().parent().hide("slow",function(){
                    $(this).remove();
                });
                noty({text: 'Delete Successfully!', layout: 'topCenter', type: 'success'});
            }, error: function(e){ 
                console.log(e.responseText); 
            }
        });

    });
    return false;
}



function print(row){

    //proccess print on ajax
    $.ajax({
        url:        'ajax/payment.php?data=print',
        data:       'id=' + row ,
        dataType:   'json',
        success: function(s){
            console.log(s[0]);
            $('#inv_id').html('No :<b style="color: red;"> '+s[0]+'</b>')
            $('#date').html('<b>Date : '+ s[1] + '</b>');
            $('#cls_lv').text('Study in class : '+ s[2] );
            $('#from').text('Received From : '+ s[3] );
            $('#amount').text('The Amount : $'+ s[4] );
            $('#recipient').text( s[5] );
            $("#printing").print({
                title: "COERR Invoice",
                globalStyles: true,
                mediaPrint: false,
                stylesheet: null,
                noPrintSelector: ".no-print",
                iframe: true,
                append: null,
                prepend: null,
                manuallyCopyFormValues: false,
                deferred: $.Deferred(),
                timeout: 250,
                title: null,
                doctype: '<!doctype html>'
            });
        }, error: function(e){ 
            console.log(e.responseText); 
        }
    });

    return false;
}

setInterval(function() {$.noty.closeAll();}, 6000);

