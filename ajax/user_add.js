 // validation on update
var jvalidate = $("#form_user_add").validate({
    ignore: [],
    rules: {                                            
            txtusername: {
                    required: true,
                    minlength: 6,
                    maxlength: 32
            },
            txtgroup: {
            		required: true
            },
            password: {
            		required: true,
                    minlength: 6,
                    maxlength: 32
            },
            txtstaff: {
            		required: true
            }
        }                                        
    });
var jvalidate = $("#form_user_edit").validate({
    ignore: [],
    rules: {                                            
            txtusername: {
                    required: true,
                    minlength: 6,
                    maxlength: 32
            },
            txtgroup: {
            		required: true
            },
            password: {
            		required: true,
                    minlength: 6,
                    maxlength: 32
            },
            txtstaff: {
            		required: true
            }
        }                                        
    });

	// $('#btnpass').click(function() {
	//   $( "p" ).toggle();
	// });

	$('#btnpass').click(function(event) {
		$('#password').attr('type', 'text');
	});
	

    // submit on add
    $(document).on('submit', '#form_user_add', function(e){

        var form_data = $('#form_user_add').serialize();

        $.ajax({
            url:          'ajax/user_add.php?data=add',
            cache:        false,
            data:         form_data ,
            success: function(e){
            	console.log(e);
                noty({text: e, layout: 'topCenter', type: 'success'});
                $('txtusername').val('');
                $('txtstaff').selectpicker('val', '');
                $('txtgroup').selectpicker('val', '');
                $('isactive').val('1');
                $('password').val('');
                $('password').attr('type', 'password');
            }, error: function(e){
                console.log(e.responseText); 
            }
          });
        return false;
    });

	// submit on edit
    $(document).on('submit', '#form_user_edit', function(e){

        var form_data = $('#form_user_edit').serialize();

        $.ajax({
            url:          'ajax/user_add.php?data=edit',
            cache:        false,
            data:         form_data ,
            success: function(e){
            	console.log(e);
                noty({text: e, layout: 'topCenter', type: 'success'});
                $('password').val('');
                $('password').attr('type', 'password');
            }, error: function(e){
                console.log(e.responseText); 
            }
          });
        return false;
    });

