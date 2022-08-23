
// validation on insert and edit
var jvalidate = $("#form-breach").validate({
    ignore: [],
    rules: {                                            
            txtbreach: {
                    required: true
            }
        }                                        
    });



// on load data
$(document).ready(function() {
    getbreachData();
} );


/// clear text on from
function clearbreach(){
    $('#txtbreach').val('');
    $('#txtbreachtype').val('');
    $('#txtbreachdes').val('');
}

function getbreachData(){
    // init dataTable
    var oTable = $('#breach').dataTable();

    $.ajax({
        url: 'ajax/breach.php?data=get',
        dataType: 'json',
        success: function(s){
            console.log(s);
            oTable.fnClearTable();
            for(var i = 0; i < s.length; i++) {
                oTable.fnAddData([ s[i][0], s[i][1], s[i][2] ]); 
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

function addBreach(){
    clearbreach()
    jvalidate.resetForm();
    $('#btnsubmit').text('Insert');
    $('#form-breach').removeClass('form-edit');
    $('#form-breach').addClass('form-add');
}

var breachId;
function editbreach(row){
    $('#btnsubmit').text('Update');
    $('#form-breach').removeClass('form-add');
    $('#form-breach').addClass('form-edit');
    breachId=row;
    // get data to form
    $.ajax({
        url:        'ajax/breach.php?data=get-at',
        data:       'id=' + row,
        dataType:   'json',
        success: function(s){
            console.log(s);
            $('#txtbreach').val(s[0][0]);
            $('#txtbreachdes').val(s[0][1]);
        }, error: function(e){ 
            console.log(e.responseText); 
        }
    });
}

// submit on add
$(document).on('submit', '#form-breach.form-add', function(e){
    hide_ipad_keyboard();

    var form_data = $('#form-breach').serialize();

    $.ajax({
        url:          'ajax/breach.php?data=add',
        cache:        false,
        data:         form_data,
        success: function(e){
            console.log(e);
            noty({text: 'Insert Successfully!', layout: 'topCenter', type: 'success'});
            getbreachData();
            clearbreach();
        }, error: function(e){
            console.log(e.responseText); 
        }
      });

    return false;
});

// submit on edit
$(document).on('submit', '#form-breach.form-edit', function(e){
    hide_ipad_keyboard();
    var form_data = $('#form-breach').serialize();

    $.ajax({
        url:          'ajax/breach.php?data=edit',
        cache:        false,
        data:         form_data + '&id='+breachId,
        success: function(e){
            console.log(e);
            noty({text: 'Update Successfully!', layout: 'topCenter', type: 'success'});
            getbreachData();
        }, error: function(e){
            console.log(e.responseText); 
        }
      });
    return false;
});


function deletebreach(row){
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
            url:        'ajax/breach.php?data=delete',
            data:       'id=' + row,
            success: function(s){
                console.log(s);
                noty({text: 'Delete Successfully!', layout: 'topCenter', type: 'success'});
            }, error: function(e){ 
                console.log(e.responseText); 
            }
        });


        $("#breach_"+row).parent().parent().hide("slow",function(){
            $(this).remove();
        });
    });
}

setInterval(function() {$.noty.closeAll();}, 10000);


