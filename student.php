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
    .modal { z-index: 9; }
</style>
    </head>
    <body>

        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            <?php $parent_page = "data"; ?>
            
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
                    <li><a href="#">Data</a></li>                    
                    <li class="active">Student</li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap" id="page-content-wrap">
                    
                    <div class="col-md-12">
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading ui-draggable-handle">
                                    <h3 class="panel-title">Student Information </h3>
                                    
                                    <div class="pull-right">
                                        <ul class="panel-controls">
                                            <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                                            <li><a href="#" class="panel-refresh"  onClick="getData();"><span class="fa fa-refresh"></span></a></li>
                                        </ul>    
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#form_data" onClick="add();">Add New student</button> 
                                        <div class="btn-group">
                                            <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                            <ul class="dropdown-menu">
                                                <li><a href="#" onClick ="$('#student').tableExport({type:'csv',escape:'false'});"><img src='img/icons/csv.png' width="24"/> CSV</a></li>
                                                <li><a href="#" onClick ="$('#student').tableExport({type:'txt',escape:'false'});"><img src='img/icons/txt.png' width="24"/> TXT</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#" onClick ="$('#student').tableExport({type:'excel',escape:'false'});"><img src='img/icons/xls.png' width="24"/> XLS</a></li>
                                                <li><a href="#" onClick ="$('#student').tableExport({type:'doc',escape:'false'});"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                                <li><a href="#" onClick ="$('#student').tableExport({type:'powerpoint',escape:'false'});"><img src='img/icons/ppt.png' width="24"/> PowerPoint</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#" onClick ="$('#student').tableExport({type:'png',escape:'false'});"><img src='img/icons/png.png' width="24"/> PNG</a></li>
                                                <li><a href="#" onClick ="$('#student').tableExport({type:'pdf',escape:'false'});"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
                                            </ul>
                                        </div> 
                                    </div> 
                                    
                                </div>
                                <div class="panel-body">
                                   <div>
                                        Toggle column:  
                                        <a class="toggle-vis" data-column="1">gender</a> - 
                                        <a class="toggle-vis" data-column="2">Organization</a> - 
                                        <a class="toggle-vis" data-column="3">Phone</a> - 
                                        <a class="toggle-vis" data-column="4">Date of Birth</a> - 
                                        <a class="toggle-vis" data-column="5">Status</a> - 
                                        <a class="toggle-vis" data-column="6">House</a> - 
                                        <a class="toggle-vis" data-column="7">Group</a> - 
                                        <a class="toggle-vis" data-column="8">Village</a> - 
                                        <a class="toggle-vis" data-column="9">Commune</a> - 
                                        <a class="toggle-vis" data-column="10">District</a> - 
                                        <a class="toggle-vis" data-column="11">Province</a> - 
                                        <a class="toggle-vis" data-column="12">Register Date</a>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="student" class="display table table-hover datatable">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Gender</th>
                                                    <th>Organization</th>
                                                    <th>Phone</th>
                                                    <th>Date of Birth</th>
                                                    <th>Status</th>
                                                    <th>House</th>
                                                    <th>Group</th>
                                                    <th>Village</th>
                                                    <th>Commune</th>
                                                    <th>District</th>
                                                    <th>Province</th>
                                                    <th>Register Date</th>
                                                    <th>actions</th>
                                                </tr>
                                            </thead>
                                        </table>  
                                    </div>
                                                                      
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
                        <form id="form-student" class="form-horizontal" method="post" role="form">                                    
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="defModalHead">Student Form</h4>
                    </div>
                    <div class="modal-body">
                        <!-- START DEFAULT FORM ELEMENTS -->
                        <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Student Name</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txtname" id="txtname" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Gender</label>
                                <div class="col-sm-9">
                                    <select name="txtgender" id="txtgender" class="form-control" >
                                        <option value="">Choose Gender</option>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Organization</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txtjob" id="txtjob" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Phone</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txtphone" id="txtphone" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Date Of Birth</label>
                                <div class="col-sm-9">
                                    <input type="text" name="txtdob" id="txtdob" class="form-control datepicker" value="2000-07-07" />
                                </div>
                            </div>       
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-9">
                                    <select name="txtstatus" id="txtstatus" class="form-control" >
                                        <option value="new">New</option>
                                        <option value="active">Active</option>
                                        <option value="drop out">Drop Out</option>
                                    </select>         
                                </div>
                            </div>                                               
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Address</label>
                                <div class="col-sm-9">
                                    <div class="row" style="margin-left: -10px;">
                                       <div class="col-sm-3">
                                           <input type="text" name="txthouse" id="txthouse" class="form-control" placeholder="House">                                           
                                       </div>
                                       <div class="col-sm-3">
                                           <input type="text" name="txtgroup" id="txtgroup" class="form-control" placeholder="Group">                                           
                                       </div>
                                        <div class="col-sm-6">
                                           <input type="text" name="txtvillage" id="txtvillage" class="form-control" placeholder="Village">
                                        </div>                     
                                    </div>
                                    <br>
                                    <div class="row"  style="margin-left: -10px;">
                                       <div class="col-sm-6">
                                           <input type="text" name="txtcommune" id="txtcommune" class="form-control" placeholder="Commune">                                           
                                       </div>
                                        <div class="col-sm-6">
                                           <input type="text" name="txtdistrict" id="txtdistrict" class="form-control" placeholder="District">
                                        </div>                     
                                    </div>
                                    <br>
                                    <div class="row"  style="margin-left: -10px;">
                                        <div class="col-sm-12">
                                           <input type="text" name="txtprovince" id="txtprovince" class="form-control" placeholder="Province">
                                        </div>                     
                                    </div>
                                </div>
                            </div>         
                        <!-- END DEFAULT FORM ELEMENTS -->
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btnsubmit" class="btn btn-primary">Insert</button> 
                        <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- MESSAGE BOX-->
            <?php require 'includes/messagebox.php'; ?>
        <!-- END MESSAGE BOX-->
        
        <?php require 'includes/footer.php'; ?>

        <script type="text/javascript" src="ajax/student.js"></script>

    </body>
</html>

