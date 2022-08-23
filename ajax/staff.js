
// validation on insert and edit
var jvalidate = $("#form-staff").validate({
    ignore: [],
    rules: {                                            
            txtname: {
                    required: true,
                    minlength: 5,
                    maxlength: 50
            },
            txtgender: {
                    required: true
            },
            txtphone: {
                    required: true,
                    minlength: 8,
                    maxlength: 20
            },
            txtemail: {
                    email: true
            },
            txtactive: {
                    required: true
            },
            txtposition: {
                    required: true,
                    minlength: 3,
                    maxlength: 60
            },
            txtaddress: {
                    required: true
            }
        }                                        
    });



// on load data
$(document).ready(function() {
    getData();
    
     $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();
 
        // Get the column API object
        var column = table.column( $(this).attr('data-column') );
 
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );
    
} );

var table;

/// clear text on from
function clearFrom(){
    $('#txtname').val('');
    $('#txtgender').val('');
    $('#txtphone').val('');
    $('#txtemail').val('');
    $('#txtactive').val('active');
    $('#txtposition').val('');
    $('#txtaddress').val('');
}


function getData(){
    
    table = $('#staff').DataTable( {
        destroy: true,
        "processing": true,
        "serverSide": true,
        "ajax": "ajax/load_staff.php",
        "columnDefs": [
            {
                "targets": [ 1 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 4 ],
                "visible": false
            },
            {
                "targets": [ 6 ],
                "visible": false
            },
            {
                "targets": [ 7 ],
                "visible": false
            },
            {
                "targets": [ 8 ],
                "visible": false
            }
        ]
    } );
    
}


// Hide iPad keyboard
  function hide_ipad_keyboard(){
    document.activeElement.blur();
    $('input').blur();
  }

function add(){
    clearFrom()
    jvalidate.resetForm();
    $('#btnsubmit').text('Insert');
    $('#form-staff').removeClass('form-edit');
    $('#form-staff').addClass('form-add');
}

var id;
function edit(row){
    $('#btnsubmit').text('Update');
    $('#form-staff').removeClass('form-add');
    $('#form-staff').addClass('form-edit');
    id=row;
    // get data to form
    $.ajax({
        url:        'ajax/staff.php?data=get-at',
        data:       'id=' + row,
        dataType:   'json',
        success: function(s){
            console.log(s);
            $('#txtname').val(s[0][0]);
            $('#txtgender').val(s[0][1]);
            $('#txtposition').val(s[0][2]);
            $('#txtphone').val(s[0][3]);
            $('#txtemail').val(s[0][4]);
            $('#txtactive').val(s[0][5]);
            $('#txtaddress').val(s[0][6]);
        }, error: function(e){ 
            console.log(e.responseText); 
        }
    });
}

// submit on add
$(document).on('submit', '#form-staff.form-add', function(e){
    hide_ipad_keyboard();

    var form_data = $('#form-staff').serialize();

    $.ajax({
        url:          'ajax/staff.php?data=add',
        cache:        false,
        data:         form_data,
        success: function(e){
            console.log(e);
            noty({text: 'Insert Successfully!', layout: 'topCenter', type: 'success'});
            getData();
            clearFrom();
        }, error: function(e){
            console.log(e.responseText); 
        }
      });

    return false;
});

// submit on edit
$(document).on('submit', '#form-staff.form-edit', function(e){
    hide_ipad_keyboard();
    var form_data = $('#form-staff').serialize();

    $.ajax({
        url:          'ajax/staff.php?data=edit',
        cache:        false,
        data:         form_data + '&id='+id,
        success: function(e){
            console.log(e);
            noty({text: 'Update Successfully!', layout: 'topCenter', type: 'success'});
            //getData();
        }, error: function(e){
            console.log(e.responseText); 
        }
      });
    return false;
});


function deleteARow(row){
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
            url:        'ajax/staff.php?data=delete',
            data:       'id=' + row,
            success: function(s){
                console.log(s);
                noty({text: 'Delete Successfully!', layout: 'topCenter', type: 'success'});
            }, error: function(e){ 
                console.log(e.responseText); 
            }
        });

        $("#trow_"+row).parent().parent().hide("slow",function(){
            $(this).remove();
        });
    });
}

setInterval(function() {$.noty.closeAll();}, 8000);


