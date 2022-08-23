<?php
 require_once 'core/init.php'; 
 
$user = new User();

if(!$user->isLoggedIn()) {
    Redirect::to('login.php');
}

if($user->hasPermission('user')){
    Session::set('prev_page', $_SERVER['HTTP_REFERER']);
    Redirect::to('403.php');
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
    <style>
        .input-group .form-control {  z-index: initial;}
        textarea{min-width:100%;}
        .modal {z-index:100;}
    </style>
    
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
                    <li class="active">Student paid</li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap" id="page-content-wrap">
                    <?php $db = DB::getInstance() ?>
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Student Paid</strong> List</h3>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                                    </ul>
                                    <div class="pull-right">
                                        <div class="btn-group">
                                            <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                            <ul class="dropdown-menu">
                                                <li><a href="#" onClick ="$('#student_paid').tableExport({type:'csv',escape:'false'});"><img src='img/icons/csv.png' width="24"/> CSV</a></li>
                                                <li><a href="#" onClick ="$('#student_paid').tableExport({type:'txt',escape:'false'});"><img src='img/icons/txt.png' width="24"/> TXT</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#" onClick ="$('#student_paid').tableExport({type:'excel',escape:'false'});"><img src='img/icons/xls.png' width="24"/> XLS</a></li>
                                                <li><a href="#" onClick ="$('#student_paid').tableExport({type:'doc',escape:'false'});"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                                <li><a href="#" onClick ="$('#student_paid').tableExport({type:'powerpoint',escape:'false'});"><img src='img/icons/ppt.png' width="24"/> PowerPoint</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#" onClick ="$('#student_paid').tableExport({type:'png',escape:'false'});"><img src='img/icons/png.png' width="24"/> PNG</a></li>
                                                <li><a href="#" onClick ="$('#student_paid').tableExport({type:'pdf',escape:'false'});"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
                                            </ul>
                                        </div> 
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Semester</span>
                                                    <select class="form-control select" name="choose_semester" id="choose_semester" data-live-search="true">
                                                        <option value="">Choose semester ...</option>
                                                        <?php 
                                                            $semester=$db->query('select * from tblsemester');
                                                            foreach($semester->getResults() as $sem):
                                                         ?>
                                                        <option value="<?= $sem->id ?>"><?= $sem->semester ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input type="checkbox" id="breach">
                                                    </span>
                                                    <select class="form-control select" id="choose_breach" name="choose_breach" disabled>
                                                        <option value="">Choose breach ...</option>
                                                        <?php 
                                                            $breach=$db->query('select * from tblbreach');
                                                            foreach($breach->getResults() as $br):
                                                         ?>
                                                        <option value="<?= $br->id ?>"><?= $br->name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input type="checkbox" id="level">
                                                    </span>
                                                    <select class="form-control select" id="choose_level" name="choose_level"  data-live-search="true" disabled>
                                                        <option value="">Choose level ...</option>
                                                        <?php 
                                                            $level=$db->query('select * from tbllevel');
                                                            foreach($level->getResults() as $lv):
                                                         ?>
                                                        <option value="<?= $lv->id ?>"><?= $lv->lv ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-primary" onclick="getData()"> View Report </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- end panel body -->
                                <div class="panel-body">                                
                                    <table id="student_paid" class="display table table-bordered datatable">
                                        <thead>
                                            <tr>
                                                <th>Pay date</th>
                                                <th>Student name</th>
                                                <th>Gender</th>
                                                <th>Phone</th>
                                                <th>DOB</th>
                                                <th>Payment ID</th>
                                            </tr>
                                        </thead>
                                    </table>                                
                                </div>
                                <!-- end panel body -->
                            </div>
                            <!-- end panel -->
                        </div>
                        <!-- end col 12 -->
                    </div>         
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        <!-- MESSAGE BOX-->
            <?php require 'includes/messagebox.php'; ?>

            <div class="message-box message-box-danger animated fadeIn" data-sound="fail" id="fail_view">
                <div class="mb-container">
                    <div class="mb-middle">
                        <div class="mb-title"><span class="fa fa-times"></span> Failure View!</div>
                        <div class="mb-content">
                            <h4 style="color: #fff">Please choose semester !</h4>                  
                        </div>
                        <div class="mb-footer">
                            <button class="btn btn-default btn-lg pull-right mb-control-close">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        <!-- END MESSAGE BOX-->
        
        <?php require 'includes/footer.php'; ?>

        <script src="ajax/student_paid.js" type="text/javascript"></script>

    </body>
</html>

