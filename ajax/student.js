
// validation on insert and edit
var jvalidate = $("#form-student").validate({
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
            txtdob: {
                    required: true
            },
	    txtprovince: {
	    	    required: true,
		    minlength: 8
	    }
        }                                        
    });

var table;
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

function getData(){
    
    table = $('#student').DataTable( {
        destroy: true,
        "processing": true,
        "serverSide": true,
        "ajax": "ajax/load_student.php",
        "columnDefs": [
            {
                "targets": [ 1 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 2 ],
                "visible": false
            },
            {
                "targets": [ 6 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 7 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 8 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 9 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 10 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 11 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 12 ],
                "visible": false
            }
        ]
    } );
}


/// clear text on from
function clearFrom(){
    $('#id').val('');
    $('#txtname').val('');
    $('#txtgender').val('');
    $('#txtphone').val('');
    $('#txtdob').val('2000-07-07');
    $('#txtjob').val('');
    $('#txtstatus').val('new');
    $('#txthouse').val('');
    $('#txtgroup').val('');
    $('#txtvillage').val('');
    $('#txtcommune').val('');
    $('#txtdistrict').val('');
    $('#txtprovince').val('');
}


function add(){
    clearFrom()
    jvalidate.resetForm();
    $('#btnsubmit').text('Insert');
    $('#form-student').removeClass('form-edit');
    $('#form-student').addClass('form-add');
}

var id;
function edit(row){
    $('#btnsubmit').text('Update');
    $('#form-student').removeClass('form-add');
    $('#form-student').addClass('form-edit');

    id=row;
    // get data to form
    $.ajax({
        url:        'ajax/student.php?data=get-at',
        data:       'id=' + row,
        dataType:   'json',
        success: function(s){
            console.log(s);
            $('#txtname').val(s[0][0]);
            $('#txtgender').val(s[0][1]);
            $('#txtjob').val(s[0][2]);
            $('#txtphone').val(s[0][3]);
            $('#txtdob').val(s[0][4]);
            $('#txtstatus').val(s[0][5]);
            $('#txthouse').val(s[0][6]);
            $('#txtgroup').val(s[0][7]);
            $('#txtvillage').val(s[0][8]);
            $('#txtcommune').val(s[0][9]);
            $('#txtdistrict').val(s[0][10]);
            $('#txtprovince').val(s[0][11]);
        }, error: function(e){ 
            console.log(e.responseText); 
        }
    });
}


// submit on add
$(document).on('submit', '#form-student.form-add', function(e){

    var form_data = $('#form-student').serialize();

    $.ajax({
        url:          'ajax/student.php?data=add',
        cache:        false,
        data:         form_data,
        success: function(s){
            console.log(s);
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
$(document).on('submit', '#form-student.form-edit', function(e){

    var form_data = $('#form-student').serialize();

    $.ajax({
        url:          'ajax/student.php?data=edit',
        cache:        false,
        data:         form_data + '&id='+id,
        success: function(s){
            console.log(s);
            noty({text: 'Update Successfully!', layout: 'topCenter', type: 'success'});
            getData();
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
            url:        'ajax/student.php?data=delete',
            cache:      false,
            data:       'id=' + row,
            success: function(s){
                console.log(s);
                noty({text: 'Delete Successfully!', layout: 'topCenter', type: 'success'});
                $("#trow_"+row).parent().parent().hide("slow",function(){
                    $(this).remove();
                });
            }, error: function(e){ 
                console.log(e.responseText); 
            }
        });
        
    });
}

setInterval(function() {$.noty.closeAll();}, 8000);


