
// validation on insert and edit
var jvalidate = $("#form-semester").validate({
    ignore: [],
    rules: {                                            
            txtsemester: {
                    required: true
            },
            txtyear: {
                    required: true,
                    min: 1975,
                    max: 2050
            }
        }                                        
    });



// on load data
$(document).ready(function() {
    getsemesterData();
} );


/// clear text on from
function clearsemester(){
    $('#txtsemester').val('');
    $('#txtyear').val('');
    $('#txtsemesterdes').val('');
}

function getsemesterData(){
    // init dataTable
    var oTable = $('#semester').dataTable();

    $.ajax({
        url: 'ajax/semester.php?data=get',
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

function addsemester(){
    clearsemester()
    jvalidate.resetForm();
    $('#btnsubmitsm').text('Insert');
    $('#form-semester').removeClass('form-edit');
    $('#form-semester').addClass('form-add');
}

var semesterId;
function editsemester(row){
    $('#btnsubmitsm').text('Update');
    $('#form-semester').removeClass('form-add');
    $('#form-semester').addClass('form-edit');
    semesterId=row;
    // get data to form
    $.ajax({
        url:        'ajax/semester.php?data=get-at',
        data:       'id=' + row,
        dataType:   'json',
        success: function(s){
            console.log(s);
            $('#txtsemester').val(s[0][0]);
            $('#txtyear').val(s[0][1]);
            $('#txtsemesterdes').val(s[0][2]);
        }, error: function(e){ 
            console.log(e.responseText); 
        }
    });
}

// submit on add
$(document).on('submit', '#form-semester.form-add', function(e){
    hide_ipad_keyboard();

    var form_data = $('#form-semester').serialize();

    $.ajax({
        url:          'ajax/semester.php?data=add',
        cache:        false,
        data:         form_data,
        success: function(e){
            console.log(e);
            noty({text: 'Insert Successfully!', layout: 'topCenter', type: 'success'});
            getsemesterData();
            clearsemester();
        }, error: function(e){
            console.log(e.responseText); 
        }
      });

    return false;
});

// submit on edit
$(document).on('submit', '#form-semester.form-edit', function(e){
    hide_ipad_keyboard();
    var form_data = $('#form-semester').serialize();

    $.ajax({
        url:          'ajax/semester.php?data=edit',
        cache:        false,
        data:         form_data + '&id='+semesterId,
        success: function(e){
            console.log(e);
            noty({text: 'Update Successfully!', layout: 'topCenter', type: 'success'});
            getsemesterData();
        }, error: function(e){
            console.log(e.responseText); 
        }
      });
    return false;
});


function deletesemester(row){
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
            url:        'ajax/semester.php?data=delete',
            data:       'id=' + row,
            success: function(s){
                console.log(s);
                noty({text: 'Delete Successfully!', layout: 'topCenter', type: 'success'});
            }, error: function(e){ 
                console.log(e.responseText); 
            }
        });


        $("#semester_"+row).parent().parent().hide("slow",function(){
            $(this).remove();
        });
    });
}



