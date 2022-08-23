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
            
            <?php $parent_page = "report"; ?>
            
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
                    <li class="active">View</li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap" id="page-content-wrap">
                    
                    <div class="col-md-12">

                        <?php $db = DB::getInstance(); ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">To view class : &nbsp;&nbsp;&nbsp; </h3>
                                    <div class="form-inline" role="form">
                                        <div class="input-group">
                                            <span class="input-group-addon">Breach</span>
                                            <select class="form-control select" id="choose_breach" name="choose_breach" onchange="getData()">
                                                <option value="">Choose breach ...</option>
                                                <?php 
                                                    $breach=$db->query('select * from tblbreach');
                                                    foreach($breach->getResults() as $br):
                                                 ?>
                                                <option value="<?= $br->id ?>"><?= $br->name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="input-group" id="show_semester">
                                            <span class="input-group-addon">Semester </span>
                                            <select class="form-control select" name="choose_semester" id="choose_semester" onchange="getData()" data-live-search="true">
                                                <option value="">Choose semester ...</option>
                                                <?php 
                                                    $semester=$db->query('select * from tblsemester');
                                                    foreach($semester->getResults() as $sem):
                                                 ?>
                                                <option value="<?= $sem->id ?>"><?= $sem->semester ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <button type="submit" id="view_class" onClick="getData()" class="btn btn-info">View Class</button>
                                    </div>
                                </div>                             
                            </div>
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Class Information </h3>

                                    <div class="pull-right">
                                        <ul class="panel-controls panel-collapse panel-refresh panel-hidden-controls">
                                            <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                                        </ul>  
                                    </div>                                      
                                </div>
                                <div class="panel-body">
                                    <table id="class" class="display table table-hover datatable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Teacher</th>
                                                <th>Level</th>
                                                <th>Room</th>
                                                <th>Time</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                    </table>                                    
                                </div>
                            </div>
                            <!-- END DATATABLE EXPORT --> 
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

        <script type="text/javascript" src="ajax/view_class.js"></script>
    </body>
</html>

