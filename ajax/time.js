
// validation on insert and edit
var jvalidate = $("#form-time").validate({
    ignore: [],
    rules: {                                            
            txttime: {
                    required: true
            },
            txttimetype: {
                    required: true
            }
        }                                        
    });



// on load data
$(document).ready(function() {
    getTimeData();
} );


/// clear text on from
function clearTime(){
    $('#txttime').val('');
    $('#txttimetype').val('');
    $('#txttimedes').val('');
}

function getTimeData(){
    // init dataTable
    var oTable = $('#time').dataTable();

    $.ajax({
        url: 'ajax/time.php?data=get',
        dataType: 'json',
        success: function(s){
            console.log(s);
            oTable.fnClearTable();
            for(var i = 0; i < s.length; i++) {
                oTable.fnAddData([ s[i][0], s[i][1], s[i][2], s[i][3] ]); 
            }
        }, error: function(e){ 
                console.log(e.responseText); 
        }
    });
}

// Hide iPad keyboard
  function hide_ipad_keyboard(){
    document.activeElement.blur();
    $('input').blur();
  }

function addTime(){
    clearTime()
    jvalidate.resetForm();
    $('#btnsubmit').text('Insert');
    $('#form-time').removeClass('form-edit');
    $('#form-time').addClass('form-add');
}

var timeId;
function editTime(row){
    $('#btnsubmit').text('Update');
    $('#form-time').removeClass('form-add');
    $('#form-time').addClass('form-edit');
    timeId=row;
    // get data to form
    $.ajax({
        url:        'ajax/time.php?data=get-at',
        data:       'id=' + row,
        dataType:   'json',
        success: function(s){
            console.log(s);
            $('#txttime').val(s[0][0]);
            $('#txttimetype').val(s[0][1]);
            $('#txttimedes').val(s[0][2]);
        }, error: function(e){ 
            console.log(e.responseText); 
        }
    });
}

// submit on add
$(document).on('submit', '#form-time.form-add', function(e){
    hide_ipad_keyboard();

    var form_data = $('#form-time').serialize();

    $.ajax({
        url:          'ajax/time.php?data=add',
        cache:        false,
        data:         form_data,
        success: function(e){
            console.log(e);
            noty({text: 'Insert Successfully!', layout: 'topCenter', type: 'success'});
            getTimeData();
            clearTime();
        }, error: function(e){
            console.log(e.responseText); 
        }
      });

    return false;
});

// submit on edit
$(document).on('submit', '#form-time.form-edit', function(e){
    hide_ipad_keyboard();
    var form_data = $('#form-time').serialize();

    $.ajax({
        url:          'ajax/time.php?data=edit',
        cache:        false,
        data:         form_data + '&id='+timeId,
        success: function(e){
            console.log(e);
            noty({text: 'Update Successfully!', layout: 'topCenter', type: 'success'});
            getTimeData();
        }, error: function(e){
            console.log(e.responseText); 
        }
      });
    return false;
});


function deleteTime(row){
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
            url:        'ajax/time.php?data=delete',
            data:       'id=' + row,
            success: function(s){
                console.log(s);
                noty({text: 'Delete Successfully!', layout: 'topCenter', type: 'success'});
            }, error: function(e){ 
                console.log(e.responseText); 
            }
        });


        $("#time_"+row).parent().parent().hide("slow",function(){
            $(this).remove();
        });
    });
}

setInterval(function() {$.noty.closeAll();}, 8000);


