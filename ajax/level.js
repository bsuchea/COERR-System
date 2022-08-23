
// validation on insert and edit
var jvalidate = $("#form-level").validate({
    ignore: [],
    rules: {                                            
            txtlevel: {
                    required: true
            },
            txtlevelprice: {
                    required: true,
                    min: 1
            }
        }                                        
    });

// on load data
$(document).ready(function() {
    getLevelData();
} );


/// clear text on from
function clearLevel(){
    $('#txtlevel').val('');
    $('#txtlevelprice').val('');
    $('#txtleveldes').val('');
}

function getLevelData(){
    // init dataTable
    var oTable = $('#level').dataTable();

    $.ajax({
        url: 'ajax/level.php?data=get',
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

function addLevel(){
    clearLevel()
    jvalidate.resetForm();
    $('#btnsubmitlv').text('Insert');
    $('#form-level').removeClass('form-edit');
    $('#form-level').addClass('form-add');
}

var levelId;
function editLevel(row){
    $('#btnsubmitlv').text('Update');
    $('#form-level').removeClass('form-add');
    $('#form-level').addClass('form-edit');
    levelId=row;
    // get data to form
    $.ajax({
        url:        'ajax/level.php?data=get-at',
        data:       'id=' + row,
        dataType:   'json',
        success: function(s){
            console.log(s);
            $('#txtlevel').val(s[0][0]);
            $('#txtlevelprice').val(s[0][1]);
            $('#txtleveldes').val(s[0][2]);
        }, error: function(e){ 
            console.log(e.responseText); 
        }
    });
}

// submit on add
$(document).on('submit', '#form-level.form-add', function(e){
    hide_ipad_keyboard();

    var form_data = $('#form-level').serialize();

    $.ajax({
        url:          'ajax/level.php?data=add',
        cache:        false,
        data:         form_data,
        success: function(e){
            console.log(e);
            noty({text: 'Insert Successfully!', layout: 'topCenter', type: 'success'});
            getLevelData();
            clearLevel();
        }, error: function(e){
            console.log(e.responseText); 
        }
      });

    return false;
});

// submit on edit
$(document).on('submit', '#form-level.form-edit', function(e){
    hide_ipad_keyboard();
    var form_data = $('#form-level').serialize();

    $.ajax({
        url:          'ajax/level.php?data=edit',
        cache:        false,
        data:         form_data + '&id='+levelId,
        success: function(e){
            console.log(e);
            noty({text: 'Update Successfully!', layout: 'topCenter', type: 'success'});
            getLevelData();
        }, error: function(e){
            console.log(e.responseText); 
        }
      });
    return false;
});


function deletelevel(row){
    playAudio('alert');
    var box = $("#mb-remove-row");
    box.addClass("open");

    var i=0;
    box.find(".mb-control-close").on("click",function(){
        i++;
    });
    
    box.find(".mb-control-yes").on("click", function(){
        box.removeClass("open");

        //protect error loop with old record
        if(i>0){
            return false;
        }

        //proccess delete on ajax
        $.ajax({
            url:        'ajax/level.php?data=delete',
            data:       'id=' + row,
            success: function(s){
                console.log(s);
                noty({text: 'Delete Successfully!', layout: 'topCenter', type: 'success'});
            }, error: function(e){ 
                console.log(e.responseText); 
            }
        });


        $("#level_"+row).parent().parent().hide("slow",function(){
            $(this).remove();
        });
    });
}

