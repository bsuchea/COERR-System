
// validation on insert and edit
var jvalidate = $("#form-class").validate({
    ignore: [],
    rules: {                                            
            txtbreach: {
                required: true
            },
            txtsemester: {
                required: true
            },
            txtstaff: {
                required: true
            },
            txtlv: {
                required: true
            },
            txtrm: {
                required: true
            },
            txttime: {
                required: true
            }
        }                                        
    });

var classId;

function setId(id){
    classId = id;
    if($('#option').hasClass('hide')){
        $('#option').removeClass('hide');
        $('#option').addClass('show');
    }
}

// on load data
$(document).ready(function() {
    classId = 0;
    $('#class tbody').on('click', 'tr', function () {
        $(this).children('td:first-child').children('input').prop('checked', true);
        var n = $( "input:checked" ).val();
        setId(n);
    } );

} );


$('#btnDetail').click(function(event) {
    window.location.href = 'class_detail.php?cls_id='+classId;
});
$('#btnAttendent').click(function(event) {
    window.location.href = 'attendent.php?cls_id='+classId;
});
$('#btnScore').click(function(event) {
    window.location.href = 'score.php?cls_id='+classId;
});
$('#btnReport').click(function(event) {
    window.location.href = 'class_report.php?cls_id='+classId;
});


/// clear text on from
function clearFrom(){
    $('#txtbreach').selectpicker('val', '');
    $('#txtsemester').selectpicker('val', '');
    $('#txtlv').selectpicker('val', '');
    $('#txtrm').selectpicker('val', '');
    $('#txttime').selectpicker('val', '');
    $('#txtstaff').selectpicker('val', '');
    $('#txtdescription').val('');
}

function getData(){
    // init dataTable
    classId = 0;
    if($('#option').hasClass('show')){
        $('#option').removeClass('show');
        $('#option').addClass('hide');
    }
    var oTable = $('#class').dataTable();
    var br = $('#choose_breach').val();
    var sem = $('#choose_semester').val();

    $.ajax({
        url: 'ajax/class_arrage.php?data=get',
        data: 'breach='+br+'&semester='+sem,
        dataType: 'json',
        success: function(s){
            console.log(s);
            oTable.fnClearTable();
            for(var i = 0; i < s.length; i++) {
                oTable.fnAddData([ s[i][0], s[i][1], s[i][2], s[i][3], s[i][4], s[i][5] ]); 
            }
        }, error: function(e){
            oTable.fnClearTable(); 
            console.log(e.responseText); 
        }
    });
    return false;
}

// Hide iPad keyboard
  function hide_ipad_keyboard(){
    document.activeElement.blur();
    $('input').blur();
  }

function add(){
    clearFrom()
    //jvalidate.resetForm();
    $('#btnsubmit').text('Insert');
    $('#form-class').removeClass('form-edit');
    $('#form-class').addClass('form-add');

}

function edit(){
    $('#btnsubmit').text('Update');
    $('#form-class').removeClass('form-add');
    $('#form-class').addClass('form-edit');

    // get data to form
    $.ajax({
        url:        'ajax/class_arrage.php?data=get-at',
        data:       'id=' + classId,
        dataType:   'json',
        success: function(s){
            console.log(s);
            $('#txtbreach').selectpicker('val', s[0][0]);
            $('#txtsemester').selectpicker('val', s[0][1]);
            $('#txtlv').selectpicker('val', s[0][2]);
            $('#txtrm').selectpicker('val', s[0][3]);
            $('#txttime').selectpicker('val', s[0][4]);
            $('#txtstaff').selectpicker('val', s[0][5]);
            $('#txtdescription').val(s[0][6]);
        }, error: function(e){ 
            console.log(e.responseText); 
        }
    });
}

// submit on add
$(document).on('submit', '#form-class.form-add', function(e){
    hide_ipad_keyboard();

    var form_data = $('#form-class').serialize();

    $.ajax({
        url:          'ajax/class_arrage.php?data=check',
        cache:        false,
        data:         form_data,
        success: function(e){
            console.log(e);
            if(e=='busy'){
                playAudio('fail');
                $("#busy").addClass("open");
                return false;
            }
            $.ajax({
                url:          'ajax/class_arrage.php?data=add',
                cache:        false,
                data:         form_data,
                success: function(e){
                    console.log(e);
                    noty({text: 'Insert Successfully!', layout: 'topCenter', type: 'success'});
                    clearFrom();
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

// submit on edit
$(document).on('submit', '#form-class.form-edit', function(e){
    hide_ipad_keyboard();
    var form_data = $('#form-class').serialize();

    $.ajax({
        url:          'ajax/class_arrage.php?data=check',
        cache:        false,
        data:         form_data,
        success: function(e){
            console.log(e);
            if(e=='busy'){
                playAudio('fail');
                $("#busy").addClass("open");
                return false;
            }
            
            $.ajax({
                url:          'ajax/class_arrage.php?data=edit',
                cache:        false,
                data:         form_data + '&id='+classId,
                success: function(e){
                    console.log(e);
                    noty({text: 'Update Successfully!', layout: 'topCenter', type: 'success'});
                    getData();
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


function deleteARow(){
    playAudio('alert');
    var box = $("#mb-remove-row");
    box.addClass("open");
    
    var i=0;
    box.find(".mb-control-close").on("click",function(){
        i++;
    });
    
    box.find(".mb-control-yes").on("click",function(){
        box.removeClass("open");

        //protect error loop with old 
        if(i>0){
            return false;
        }

        //proccess delete on ajax
        $.ajax({
            url:        'ajax/class_arrage.php?data=delete',
            data:       'id=' + classId,
            success: function(s){
                console.log(s);
                $("#trow_"+ classId).parent().parent().hide("slow",function(){
                    $(this).remove();
                });
                noty({text: 'Delete Successfully!', layout: 'topCenter', type: 'success'});
            }, error: function(e){ 
                console.log(e.responseText);
            }
        });
    });
}

setInterval(function() {$.noty.closeAll();}, 8000);


