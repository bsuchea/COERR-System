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
                    <li class="active">Student filter</li>
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
                                            <div class="row">
                                                
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
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label class="check">
                                                <input type="checkbox" id="st_drop" name="st_drop" class="icheckbox"> 
                                                Drop out Student
                                            </label>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="check">
                                                <input type="checkbox" id="st_repeat" name="st_repeat" class="icheckbox"> 
                                                Repeat Student
                                            </label>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="check">
                                                <input type="checkbox" id="st_suspend" name="st_suspend" class="icheckbox"> 
                                                Suspend Student
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- end panel body -->
                                <div class="panel-body">                                
                                    <table id="student_filter" class="display table table-bordered datatable">
                                        <thead>
                                            <tr>
                                                <th>Student name</th>
                                                <th>Gender</th>
                                                <th>Phone</th>                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Level</th>
                                                <th>Teacher</th>
                                                <th>action</th>
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
        
        <!-- MODALS -->        
        <div class="modal" id="return_class" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                        <form id="cls_return" class="form-horizontal" method="post" role="form">                              
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="defModalHead">Return class</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Breach</label>
                            <div class="col-md-6 col-xs-12">                                            
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <select class="form-control select" name="ch_breach" id="ch_breach" onChange="getClass()">
                                        <option value="">Choose breach ...</option>
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
                            <label class="col-md-3 col-xs-12 control-label">Semester </label>
                            <div class="col-md-6 col-xs-12">                                            
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <select class="form-control select" name="ch_semester" id="ch_semester" onChange="getClass()" data-live-search="true">
                                        <option value="">Choose semester ...</option>
                                        <?php 
                                            $semester=$db->query('select * from tblsemester order by id desc');
                                            foreach($semester->getResults() as $sem):
                                         ?>
                                        <option value="<?= $sem->id ?>"><?= $sem->semester ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>                                            
                                <span class="help-block">Choose the semester that one to return.</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Class List</label>
                            <div class="col-md-9 col-xs-12">                                            
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" class="form-control" name="txtclass" id="txtclass" />
                                    <input type="hidden" class="form-control" name="class_id" id="class_id" />
                                </div>                                            
                                <span id="cls_des" class="help-block">Type level name in and choose the correct class</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btnsubmit" class="btn btn-primary">Return</button> 
                        <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                        </form>
                </div>
            </div>
        </div>
        

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
        
        <link href="includes/css/jquery-ui.css" rel="stylesheet">
        <script src="includes/js/jquery-ui.js"></script>
        <script src="ajax/student_filter.js" type="text/javascript"></script>

    </body>
</html>

