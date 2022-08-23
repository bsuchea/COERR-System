<?php
 require_once 'core/init.php'; 
 
$user = new User();

if(!$user->isLoggedIn()) {
    Redirect::to('login.php');
}
if(!$user->hasPermission('admin') and !$user->hasPermission('moderator')){
    Session::set('prev_page', $_SERVER['HTTP_REFERER']);
    Redirect::to('403.php');
}

$log = new Log;

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
            
            <?php $parent_page = ""; ?>
            
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
                    <li class="active">User Activities</li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap" id="page-content-wrap">
                    
                    <div class="col-md-12">

                        <div class="panel panel-default">
                            <div class="panel-heading ui-draggable-handle">
                                <h3 class="panel-title"><strong>User 's Activities </strong></h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="tbl_log" class="display table table-bordered table-striped datatable">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>User's Name</th>
                                                <th>Position</th>
                                                <th>Action</th>
                                                <th>Other</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end col-12  -->
                                     
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
            $('#tbl_log').DataTable( {
                destroy: true,
                "order": [[ 0, "desc" ]],
                "processing": true,
                "serverSide": true,
                "ajax": "ajax/load_log.php"
            } );

        </script>

    </body>
</html>

