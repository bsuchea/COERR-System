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
    <style>
        .input-group .form-control {  z-index: initial;}
        textarea{min-width:100%;}
    </style>
    
    </head>
    <body>

        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            
            <?php $parent_page = "transaction"; ?>
            
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
                    <li><a href="index.php">Home</a></li>                    
                    <li><a href="#">Transation</a></li>                    
                    <li class="active">Attendent</li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap" id="page-content-wrap">
                    
                    <div class="col-md-12">

                        <?php $db = DB::getInstance(); ?>
                            <?php 
                                $class = $db->query('SELECT tblclass.id, tblstaff.`name` staff_name, tbllevel.lv, tblroom.room, tbltime.time, tbltime.type, tblsemester.semester, tblsemester.year, tblbreach.`name` breach_name FROM tblclass INNER JOIN tblroom ON tblclass.room_id = tblroom.id INNER JOIN tbllevel ON tblclass.level_id = tbllevel.id INNER JOIN tblsemester ON tblclass.semester_id = tblsemester.id INNER JOIN tbltime ON tblclass.time_id = tbltime.id INNER JOIN tblbreach ON tblclass.breach_id = tblbreach.id INNER JOIN tblstaff ON tblclass.staff_id = tblstaff.id WHERE tblclass.id='.Input::get("cls_id"));
                                if($class->count()){
                                    $cls = $class->first();
                                }
                             ?>
                             <div class="page-title">  
                                <div id="class_detail" style="font-size: 16px; font-style: bold;">
                                    <span class="fa fa-arrow-circle-o-left" style="font-size: 22px; font-style: bold;"></span>
                                    Student Attendent on: 
                                    <?php echo  $cls->lv." by ".$cls->staff_name." at ". $cls->room. " on ". $cls->time .' ('. $cls->type.') - '. $cls->breach_name ?>, semester: <?= $cls->semester ?>, year: <?= $cls->year ?> 
                                </div>
                            </div>
                            
                            <!-- START Payment form -->
                            <form class="form-horizontal" id="attendent" name="attendent" action="">
                                <div class="panel panel-default">
                                    <div class="panel-heading ui-draggable-handle">
                                        <div id="option" class="pull-right" style="margin-right: 10px;">
                                            <div class="form-group">
                                                <?php if(!$user->hasPermission('user')): ?>
                                                <a id="btnScore" class="btn btn-primary btn-rounded">Score</a>
                                                <?php endif; ?>
                                                <a id="btnDetail" class="btn btn-info btn-rounded">Class List</a>
                                                <a id="btnReport" class="btn btn-success btn-rounded">Class Report</a>
                                                <a id="btnHistory" onClick="getData()" data-toggle="modal" data-target="#history" class="btn btn-danger btn-rounded">All Attendent</a>
                                            </div>
                                        </div>
                                        <div class="pull-left">
                                            <div class="form-inline">
                                                <div class="input-group">
                                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                                    <input type="text" id="txtdate" name="txtdate" class="form-control datepicker" value="<?= date('Y-m-d') ?>" id="dp-4" data-date="<?= date('Y-m-d') ?>" data-date-format="yyyy-mm-dd" data-date-viewmode="months">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body panel-body-table">

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-actions">
                                                <thead>
                                                    <tr>
                                                        <th width="25">#</th>
                                                        <th>Student Name</th>
                                                        <th width="200">Attendant</th>
                                                        <th width="200">L /E time (mn)</th>
                                                        <th width="250">Reason</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $aps = $db->query('SELECT id, name FROM v_study_detail where class_id='.Input::get('cls_id'));
                                                        $i=0;
                                                        foreach($aps->getResults() as $ap):
                                                     ?>                                   
                                                    <tr>
                                                        <td>
                                                            <strong><?= ++$i  ?></strong>
                                                            <input type="hidden"  id="study_<?= $i ?>" name="study_<?= $i ?>" value="<?= $ap->id  ?>">
                                                        </td>
                                                        <td><strong><?= $ap->name  ?></strong></td>
                                                        <td>
                                                            <select  id="status_<?= $i ?>" name="status_<?= $i ?>" class="form-control">
                                                                    <option value="">Normal</option>
                                                                    <option value="1">Absent</option>
                                                                    <option value="2">Permission</option>
                                                                    <option value="3">Late/Early Leave</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input id="letime_<?= $i ?>" name="letime_<?= $i ?>" type="text"  class="validate[custom[integer],min[5],max[25]] form-control">
                                                        </td>
                                                        <td>
                                                            <input id="reason_<?= $i ?>" name="reason_<?= $i ?>" type="text" class="form-control">
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                            <input type="hidden" id="txtrow" name="txtrow" value="<?= $i ?>">
                                            <input type="hidden" id="txtclassid" name="txtclassid" value="<?= Input::get('cls_id') ?>">
                                        </div>                                

                                    </div>
                                    <div class="panel-footer">
                                        <button type="reset" id="btnReset" class="btn btn-default">Reset All</button>                                    
                                        <button type="submit" id="btnSave" class="btn btn-primary pull-right">Save</button>
                                    </div>
                                </div>
                                </form>
                            <!-- END Payment form --> 
                    </div>
                    <!-- end col-12  -->
                                     
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        <!-- MODALS -->        
        <div class="modal" id="history" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">                      
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="defModalHead">Attendant List</h4>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="atten_his" class="display table table-bordered table-striped datatable">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th width="150">Attendent</th>
                                        <th width="150">L /E time</th>
                                        <th width="150">Date</th>
                                        <th width="200">Reason</th>
                                        <th width="100">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MESSAGE BOX-->
            <?php require 'includes/messagebox.php'; ?>
        <!-- END MESSAGE BOX-->
        
        <?php require 'includes/footer.php'; ?>

        <script type="text/javascript" src="ajax/attendent.js"></script>
        
    </body>
</html>

