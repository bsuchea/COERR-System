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
        .modal {z-index:100;}
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
                    <li><a href="#">Home</a></li>                    
                    <li><a href="#">Transation</a></li>                    
                    <li class="active">Class List</li>
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
                                    Student List on: 
                                    <?php echo  $cls->lv." by ".$cls->staff_name." at ". $cls->room. " on ". $cls->time .' ('. $cls->type.') - '. $cls->breach_name ?>, semester: <?= $cls->semester ?>, year: <?= $cls->year ?> 
                                </div>
                            </div>
                            
                            <!-- START Payment form -->
                            <form class="form-horizontal" id="payment" name="payment">
                                <div class="panel panel-default">
                                    <div class="panel-heading ui-draggable-handle">
                                        <h3 class="panel-title"><strong>Student detail in class </strong></h3>
                                        <div class="pull-right">
                                            <div class="btn-group">
                                                <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#" onClick ="$('#class_list').tableExport({type:'csv',escape:'false'});"><img src='img/icons/csv.png' width="24"/> CSV</a></li>
                                                    <li><a href="#" onClick ="$('#class_list').tableExport({type:'txt',escape:'false'});"><img src='img/icons/txt.png' width="24"/> TXT</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="#" onClick ="$('#class_list').tableExport({type:'excel',escape:'false'});"><img src='img/icons/xls.png' width="24"/> XLS</a></li>
                                                    <li><a href="#" onClick ="$('#class_list').tableExport({type:'doc',escape:'false'});"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                                    <li><a href="#" onClick ="$('#class_list').tableExport({type:'powerpoint',escape:'false'});"><img src='img/icons/ppt.png' width="24"/> PowerPoint</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="#" onClick ="$('#class_list').tableExport({type:'png',escape:'false'});"><img src='img/icons/png.png' width="24"/> PNG</a></li>
                                                    <li><a href="#" onClick ="$('#class_list').tableExport({type:'pdf',escape:'false'});"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
                                                </ul>
                                            </div> 
                                        </div>
                                        <div id="option" class="pull-right" style="margin-right: 30px;">
                                            <div class="form-group">
                                                <a id="btnAttendent" class="btn btn-default btn-rounded">Attendent</a>
                                                <?php if(!$user->hasPermission('user')): ?>
                                                <a id="btnScore" class="btn btn-primary btn-rounded">Score</a>
                                                <?php endif; ?>
                                                <a id="btnReport" class="btn btn-success btn-rounded">Class Report</a>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="panel-body panel-body-table">

                                        <div class="table-responsive">
                                            <table id="class_list" class="table table-bordered table-striped table-actions">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Student Name</th>
                                                        <th width="100">Gender</th>
                                                        <th width="150">Occupation</th>
                                                        <th width="150">Phone</th>
                                                        <th width="150">Status</th>
                                                        <th width="100">actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $sts = $db->query('SELECT * FROM v_study_detail where class_id='.Input::get('cls_id'));
                                                        $i=0;
                                                        foreach($sts->getResults() as $st):
                                                     ?>                                   
                                                    <tr id="trow_<?= $st->id ?>">
                                                        <td><strong><?= ++$i  ?></strong></td>
                                                        <td><strong><?= $st->name  ?></strong></td>
                                                        <td><?= $st->gender  ?></td>
                                                        <td><?= $st->job  ?></td>
                                                        <td><?= $st->phone  ?></td>
                                                        <td><?= $st->status  ?></td>
                                                        <td>
                                                        <?php if(!$user->hasPermission('user')): ?>
                                                           
                                                        <?php if($st->status == ''): ?>
                                                           <span onClick="suspend(<?= $st->id  ?>)" class="label label-warning mb-control" data-box="#mb-suspend" style="cursor: pointer;">got Suspend</span>
                                                            <span onClick="changeClass(<?= $st->id  ?>)" class="label label-info" data-toggle="modal" data-target="#change_class" style="cursor: pointer;">Change class</span>
                                                        <?php endif; ?>
                                                            
                                                        <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                            <input type="hidden" id="txtclassid" name="txtclassid" value="<?= Input::get('cls_id') ?>">
                                        </div>                                

                                    </div>
                                    <div class="panel-footer">
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
        <div class="modal" id="change_class" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                        <form id="cls_change" class="form-horizontal" method="post" role="form">                              
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="defModalHead">Change class</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Breach</label>
                            <div class="col-md-6 col-xs-12">                                            
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <select class="form-control select" id="choose_breach" name="choose_breach">
                                        <?php 
                                            $breach=$db->query('select * from tblbreach');
                                            foreach($breach->getResults() as $br):
                                         ?>
                                        <option value="<?= $br->id ?>"><?= $br->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>                                            
                                <span class="help-block">Just on witch breach change to.</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Time of Class</label>
                            <div class="col-md-9 col-xs-12">                                            
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" class="form-control" name="txtclass" id="txtclass" />
                                    <input type="hidden" class="form-control" name="class_id" id="class_id" />
                                </div>                                            
                                <span id="cls_des" class="help-block">Type in the time of that level</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btnsubmit" class="btn btn-primary">Change</button> 
                        <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                        </form>
                </div>
            </div>
        </div>
        

        <!-- MESSAGE BOX-->
            <?php require 'includes/messagebox.php'; ?>
            
            <!-- DELETE A ROW-->
<div class="message-box message-box-warning animated fadeIn" id="mb-suspend">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-times"></span> Suspend <strong>Student</strong> ?</div>
            <div class="mb-content">
                <p>Are you sure you want to suspend to this student?</p>                    
                <p>Press Yes if you sure.</p>
            </div>
            <div class="mb-footer">
                <div class="pull-right">
                    <button id="mb-control-yes" class="btn btn-success btn-lg mb-control-yes">Yes</button>
                    <button id="mb-control-no" class="btn btn-default btn-lg mb-control-close">No</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END DELETE A ROW--> 
        <!-- END MESSAGE BOX-->
        
        <?php require 'includes/footer.php'; ?>
        
        <link href="includes/css/jquery-ui.css" rel="stylesheet">
        <script src="includes/js/jquery-ui.js"></script>
        <script type="text/javascript" src="ajax/class_detail.js"></script>

    </body>
</html>

