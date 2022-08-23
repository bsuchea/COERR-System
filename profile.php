<?php 

require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
    Redirect::to('login.php');
}

 ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- META SECTION -->
        <title>COERR</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="includes/css/theme-default.css"/>
        <!-- EOF CSS INCLUDE -->

    </head>
    <body>

        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            
            <?php $parent_page = "setting"; ?>
            
            <!-- START PAGE SIDEBAR -->
            <?php include 'includes/sidebar.php'; ?>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                    
                <!-- START X-NAVIGATION VERTICAL -->
                <?php include 'includes/x_navigation.php'; ?>
                <!-- END X-NAVIGATION VERTICAL -->                     

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>                    
                    <li><a href="#">Transation</a></li>                    
                    <li class="active">User profile</li>
                </ul>
                <!-- END BREADCRUMB --> 

                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap" id="page-content-wrap">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            
                            <div class="panel panel-default">
                                <div class="panel-body profile" style="background: url('includes/assets/images/ocean.jpg') center center no-repeat; background-size: 100%;">
                                    <div class="profile-image">
                                        <img src="includes/assets/images/users/avatar.jpg" alt="Nadia Ali"/>
                                    </div>
                                    <div class="profile-data">
                                        <div class="profile-data-name"><?php echo escape($user->getData()->name); ?></div>
                                        <div class="profile-data-title" style="color: #FFF;"><?php echo escape($user->getData()->function); ?></div>
                                    </div>
                                    <div class="profile-controls">
                                        <a href="#" class="profile-control-left twitter"><span class="fa fa-twitter"></span></a>
                                        <a href="#" class="profile-control-right facebook"><span class="fa fa-facebook"></span></a>
                                    </div>                                    
                                </div>                                
                                <div class="panel-body">                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-danger btn-rounded btn-block"><span class="fa fa-times"></span> Remove image</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-primary btn-rounded btn-block"><span class="fa fa-plus"></span> add image</button>
                                        </div>
                                    </div>
                                </div>
                                <ul class="panel-body list-group border-bottom">
                                    <a href="#" class="list-group-item active"><span class="fa fa-share-square"></span> Detail Info</a>
                                    <li class="list-group-item">
                                        <span class="fa fa-tag"></span>
                                        Username: <?php echo escape($user->getData()->username); ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="fa fa-tags"></span>
                                        Group: <?php echo escape($user->getData()->group); ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="fa fa-calendar-check-o"></span>
                                        Joined: <?php echo date_format(date_create($user->getData()->joined), 'F jS, Y') ?>
                                    </li>
                                </ul>
                                <div class="panel-body">
                                    <h4 class="text-title">Update</h4>
                                    <div class="row">
                                        <!-- START DEFAULT FORM ELEMENTS -->
                                        <form id="form_user" class="form-horizontal" method="post" role="form">                                    
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Name</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="txtname" id="txtname" class="form-control" value="<?php echo escape($user->getData()->name); ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Phone</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="txtphone" id="txtphone" class="form-control" value="<?php echo escape($user->getData()->phone); ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Email</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="txtemail" id="txtemail" class="form-control" value="<?php echo escape($user->getData()->email); ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Current password</label>
                                                <div class="col-sm-7">
                                                    <input type="password" name="password_current" id="password_current" class="form-control" value="" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">New password</label>
                                                <div class="col-sm-7">
                                                    <input type="password" name="password_new" id="password_new" class="form-control" value="" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Confirm password</label>
                                                <div class="col-sm-7">
                                                    <input type="password" name="password_new_again" id="password_new_again" class="form-control" value="" />
                                                </div>
                                            </div>   
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"></label>
                                                <div class="col-sm-7">
                                                    <button type="reset" class="btn btn-default" data-dismiss="modal">Cencel</button>
                                                    <button type="submit" id="btnsubmit" class="btn btn-primary">Update</button> 
                                                </div>
                                            </div>                       
                                        </form>
                                        <!-- END DEFAULT FORM ELEMENTS -->
                                    </div>
                                    <!-- end row -->
                                </div>
                                <!-- end panel body -->
                            </div>  
                            <!-- end panel                           -->
                        </div>
                    </div>                                   
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        <!-- MESSAGE BOX-->
            <?php require 'includes/messagebox.php'; ?>
        <!-- END MESSAGE BOX-->
        
        <?php require 'includes/footer.php'; ?>

        <script>
            // validation on update
var jvalidate = $("#form_user").validate({
    ignore: [],
    rules: {     
            txtphone: {
                    required: true,
                    minlength: 8,
                    maxlength: 15
            },                            
            txtemail: {
                    required: true,
                    email: true
            },                                
            password_current: {
                    required: true,
                    minlength: 5,
                    maxlength: 32
            },
            password_new: {
                    minlength: 6,
                    maxlength: 32
            },
            password_new_again: {
                    minlength: 6,
                    maxlength: 32,
                    equalTo: "#password_new"
            }
        }                                        
    });

    // submit on edit
    $(document).on('submit', '#form_user', function(e){

        var form_data = $('#form_user').serialize();

        if($('#password_new').val()!=''){
            // submit on edit
            $.ajax({
                url:          'changepassword.php?data=pass',
                cache:        false,
                data:         form_data ,
                success: function(e){
                    console.log(e);
                    noty({text: e, layout: 'topCenter', type: 'success'});
                }, error: function(e){
                    console.log(e.responseText); 
                }
              });
            return false;
        }

        $.ajax({
            url:          'changepassword.php?data=info',
            cache:        false,
            data:         form_data ,
            success: function(e){
                noty({text: e, layout: 'topCenter', type: 'success'});
                
            }, error: function(e){
                console.log(e.responseText); 
            }
          });
        return false;
    });

    setInterval(function() {$.noty.closeAll();}, 8000);

    </script>

    </body>
</html>

