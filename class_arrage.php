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
        .input-group-addon { border-color: #ddd;color:#3c3c3c; background-color: #fff;}
        .form-control{background-color: #fff;}
        .show{display:block;}
        .hide{display:none;}
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
                    <li class="active">Class Arrage</li>
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
                                            <select class="form-control select" onchange="getData()" id="choose_breach" name="choose_breach">
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
                                            <?php if(!$user->hasPermission('user')): ?>
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#form_data" onClick="add();">Arrage New Class</button>
                                            <?php endif; ?>
                                    </div>
                                </div>                             
                            </div>
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Class Information </h3>

                                    <div class="pull-right">
                                        <ul class="panel-controls panel-collapse panel-refresh panel-hidden-controls">
                                            <li><a href="#" class="panel-refresh"  onClick="getData();"><span class="fa fa-refresh"></span></a></li>
                                            <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                                        </ul>  
                                        <div class="btn-group">
                                            <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                            <ul class="dropdown-menu">
                                                <li><a href="#" onClick ="$('#class').tableExport({type:'csv',escape:'false'});"><img src='img/icons/csv.png' width="24"/> CSV</a></li>
                                                <li><a href="#" onClick ="$('#class').tableExport({type:'txt',escape:'false'});"><img src='img/icons/txt.png' width="24"/> TXT</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#" onClick ="$('#class').tableExport({type:'excel',escape:'false'});"><img src='img/icons/xls.png' width="24"/> XLS</a></li>
                                                <li><a href="#" onClick ="$('#class').tableExport({type:'doc',escape:'false'});"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                                <li><a href="#" onClick ="$('#class').tableExport({type:'powerpoint',escape:'false'});"><img src='img/icons/ppt.png' width="24"/> PowerPoint</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#" onClick ="$('#class').tableExport({type:'png',escape:'false'});"><img src='img/icons/png.png' width="24"/> PNG</a></li>
                                                <li><a href="#" onClick ="$('#class').tableExport({type:'pdf',escape:'false'});"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
                                            </ul>
                                        </div> 
                                    </div>  

                                    <div id="option" class="pull-right hide" style="margin-right: 10px;">
                                        <div class="form-group">
                                            <a href="#" id="btnAttendent" class="btn btn-default btn-rounded">Attendent</a>
                                            <?php if(!$user->hasPermission('user')): ?>
                                            <a href="#" id="btnScore" class="btn btn-primary btn-rounded">Score</a>
                                            <?php endif; ?>
                                            <a href="#" id="btnDetail" class="btn btn-info btn-rounded">Class List</a>
                                            <a href="#" id="btnReport" class="btn btn-success btn-rounded">Class Report</a>
                                            <?php if(!$user->hasPermission('user')): ?>
                                            <a href="#" id="btnEdit" data-toggle="modal" data-target="#form_data" onClick="edit()" class="btn btn-warning btn-rounded">Edit</a>
                                                <?php if(!$user->hasPermission('editor')): ?>
                                            <a href="#" onClick="deleteARow()" class="btn btn-danger btn-rounded">Delete</a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
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

        <!-- MODALS -->        
        <div class="modal" id="form_data" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="form-class" class="form-horizontal" method="post" role="form">                              
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="defModalHead">Class Arrage Form</h4>
                    </div>
                    <div class="modal-body">
                        <!-- START DEFAULT FORM ELEMENTS -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Breach :</label>
                                <div class="col-sm-9">
                                    <select class="form-control select" id="txtbreach" name="txtbreach">
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
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Semester :</label>
                                <div class="col-sm-9">
                                    <select class="form-control select" name="txtsemester" id="txtsemester" data-live-search="true">
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
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Teacher :</label>
                                <div class="col-sm-9">
                                    <select class="form-control select" name="txtstaff" id="txtstaff" data-live-search="true">
                                        <option value="">Choose teacher ...</option>
                                        <?php 
                                            $staff=$db->query('select * from tblstaff');
                                            foreach($staff->getResults() as $sta):
                                         ?>
                                        <option value="<?= $sta->id ?>"><?= $sta->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Level :</label>
                                <div class="col-sm-9">
                                    <select class="form-control select" name="txtlv" id="txtlv" data-live-search="true">
                                        <option value="">Choose level ...</option>
                                        <?php 
                                            $lev=$db->query('select * from tbllevel');
                                            foreach($lev->getResults() as $lv):
                                         ?>
                                        <option value="<?= $lv->id ?>"><?= $lv->lv ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Room :</label>
                                <div class="col-sm-9">
                                    <select class="form-control select" name="txtrm" id="txtrm" data-live-search="true">
                                        <option value="">Choose room ...</option>
                                        <?php 
                                            $room=$db->query('select * from tblroom');
                                            foreach($room->getResults() as $rm):
                                         ?>
                                        <option value="<?= $rm->id ?>"><?= $rm->room ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Time :</label>
                                <div class="col-sm-9">
                                    <select class="form-control select" name="txttime" id="txttime" data-live-search="true">
                                        <option value="">Choose time ...</option>
                                        <?php 
                                            $time=$db->query('select * from tbltime');
                                            foreach($time->getResults() as $tim):
                                         ?>
                                        <option value="<?= $tim->id ?>"><?= $tim->time ?> (<?= $tim->type ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>                                                      
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Description :</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="txtdescription" id="txtdescription" rows="5"></textarea>
                                </div>
                            </div>                    
                        <!-- END DEFAULT FORM ELEMENTS -->
                    </div>
                    <!-- end model body -->
                    <div class="modal-footer">
                        <button type="submit" id="btnsubmit" class="btn btn-primary">Insert</button> 
                        <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                        </form>
                </div>
            </div>
        </div>
        <!-- END MODALS -->   

        <!-- MESSAGE BOX-->
            <?php require 'includes/messagebox.php'; ?>
        <div class="message-box message-box-danger animated fadeIn" data-sound="fail" id="busy">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-times"></span> Busy Room!</div>
                    <div class="mb-content">
                        <h4 style="color: #fff">The Room on that time already busy!</h4>                  
                    </div>
                    <div class="mb-footer">
                        <button class="btn btn-default btn-lg pull-right mb-control-close">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->
        
        <?php require 'includes/footer.php'; ?>

        <script type="text/javascript" src="ajax/class_arrage.js"></script>

    </body>
</html>

