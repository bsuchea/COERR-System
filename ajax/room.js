
// validation on insert and edit
var jvalidate = $("#form-room").validate({
    ignore: [],
    rules: {                                            
            txtroom: {
                    required: true
            }
        }                                        
    });



// on load data
$(document).ready(function() {
    getRoomData();
} );


/// clear text on from
function clearRoom(){
    $('#txtroom').val('');
    $('#txtroomdes').val('');
}

function getRoomData(){
    // init dataTable
    var oTable = $('#room').dataTable();

    $.ajax({
        url: 'ajax/room.php?data=get',
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

function addRoom(){
    clearRoom()
    jvalidate.resetForm();
    $('#btnsubmitr').text('Insert');
    $('#form-room').removeClass('form-edit');
    $('#form-room').addClass('form-add');
}

var roomId;
function editRoom(row){
    $('#btnsubmitr').text('Update');
    $('#form-room').removeClass('form-add');
    $('#form-room').addClass('form-edit');
    roomId=row;
    // get data to form
    $.ajax({
        url:        'ajax/room.php?data=get-at',
        data:       'id=' + row,
        dataType:   'json',
        success: function(s){
            console.log(s);
            $('#txtroom').val(s[0][0]);
            $('#txtroomdes').val(s[0][2]);
        }, error: function(e){ 
            console.log(e.responseText); 
        }
    });
}

// submit on add
$(document).on('submit', '#form-room.form-add', function(e){
    hide_ipad_keyboard();

    var form_data = $('#form-room').serialize();

    $.ajax({
        url:          'ajax/room.php?data=add',
        cache:        false,
        data:         form_data,
        success: function(e){
            console.log(e);
            noty({text: 'Insert Successfully!', layout: 'topCenter', type: 'success'});
            getRoomData();
            clearRoom();
        }, error: function(e){
            console.log(e.responseText); 
        }
      });

    return false;
});

// submit on edit
$(document).on('submit', '#form-room.form-edit', function(e){
    hide_ipad_keyboard();
    var form_data = $('#form-room').serialize();

    $.ajax({
        url:          'ajax/room.php?data=edit',
        cache:        false,
        data:         form_data + '&id='+roomId,
        success: function(e){
            console.log(e);
            noty({text: 'Update Successfully!', layout: 'topCenter', type: 'success'});
            getRoomData();
        }, error: function(e){
            console.log(e.responseText); 
        }
      });
    return false;
});


function deleteRoom(row){
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
            url:        'ajax/room.php?data=delete',
            data:       'id=' + row,
            success: function(s){
                console.log(s);
                noty({text: 'Delete Successfully!', layout: 'topCenter', type: 'success'});
            }, error: function(e){ 
                console.log(e.responseText); 
            }
        });


        $("#room_"+row).parent().parent().hide("slow",function(){
            $(this).remove();
        });
    });
}

