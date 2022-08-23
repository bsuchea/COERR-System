
// on load data
$(document).ready(function() {

    $("#score").validationEngine();

    // change month
    $('#txtterm').change(function(event) {
        var row = $('#txtrow').val();
        // get data to form
        $.ajax({
            url:        'ajax/score.php?data=get-at',
            data:       'term=' + $('#txtterm').val() + '&class=' + $('#txtclassid').val(),
            dataType:   'json',
            success: function(s){
                if(s=='no_record'){
                    for(var i=0;i<row;i++){
                        $('#asg_'+(i+1)).val(0);
                        $('#read_pro_'+(i+1)).val(0);
                        $('#speak_'+(i+1)).val(0);
                        $('#gram_'+(i+1)).val(0);
                        $('#listen_'+(i+1)).val(0);
                        $('#read_'+(i+1)).val(0);
                        $('#write_'+(i+1)).val(0);
                    }
                    return false;
                }
                for(var i=0;i<row;i++){
                    $('#asg_'+(i+1)).val(s[i][0]);
                    $('#read_pro_'+(i+1)).val(s[i][1]);
                    $('#speak_'+(i+1)).val(s[i][2]);
                    $('#gram_'+(i+1)).val(s[i][3]);
                    $('#listen_'+(i+1)).val(s[i][4]);
                    $('#read_'+(i+1)).val(s[i][5]);
                    $('#write_'+(i+1)).val(s[i][6]);
                }
                console.log('success!');
            }, error: function(e){
                for(var i=0;i<row;i++){
                    $('#asg_'+(i+1)).val(0);
                    $('#read_pro_'+(i+1)).val(0);
                    $('#speak_'+(i+1)).val(0);
                    $('#gram_'+(i+1)).val(0);
                    $('#listen_'+(i+1)).val(0);
                    $('#read_'+(i+1)).val(0);
                    $('#write_'+(i+1)).val(0);
                }
                console.log(e.responseText); 
            }
        });
    });

} );


$('#btnDetail').click(function(event) {
    window.location.href = 'class_detail.php?cls_id='+$('#txtclassid').val();
});
$('#btnAttendent').click(function(event) {
    window.location.href = 'attendent.php?cls_id='+$('#txtclassid').val();
});
$('#btnReport').click(function(event) {
    window.location.href = 'class_report.php?cls_id='+$('#txtclassid').val();
});


// submit on save
$(document).on('submit', '#score', function(e){

    var form_data = $('#score').serialize();

    $.ajax({
        url:          'ajax/score.php?data=save',
        cache:        false,
        data:         form_data,
        success: function(e){
            console.log(e);
            noty({text: 'Save Successfully!', layout: 'topCenter', type: 'success'});
        }, error: function(e){
            console.log(e.responseText); 
        }
      });

    return false;
});


setInterval(function() {$.noty.closeAll();}, 8000);


