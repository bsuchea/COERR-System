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
        .ui-autocomplete {
            max-height: 350px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
        }
        /* IE 6 doesn't support max-height
        * we use height instead, but this forces the menu to always be this tall
        */
        * html .ui-autocomplete {
            height: 350px;
        }

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
                    <li class="active">Payment</li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap" id="page-content-wrap">
                    
                    <div class="col-md-12">

                        <?php $db = DB::getInstance(); ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Choose to pay on : &nbsp;&nbsp;&nbsp; </h3>
                                    <div class="form-inline" role="form">
                                        <div class="input-group">
                                            <span class="input-group-addon">Breach</span>
                                            <select class="form-control select" id="choose_breach" name="choose_breach" onchange="getClass()">
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
                                            <select class="form-control select" name="choose_semester" id="choose_semester" onchange="getClass()" data-live-search="true">
                                                <option value="">Choose semester ...</option>
                                                <?php 
                                                    $semester=$db->query('select * from tblsemester');
                                                    foreach($semester->getResults() as $sem):
                                                 ?>
                                                <option value="<?= $sem->id ?>"><?= $sem->semester ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>                                   
                                        <button type="submit" id="view_class" onClick="getClass()" class="btn btn-info">Start Payment</button>
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#form_data" onClick="viewHistory()">View Payment History</button>
                                        <!-- <button  data-toggle="modal" data-target="#print_inv" class="btn btn-default">test print</button> -->                   
                                    </div>
                                </div>                             
                            </div>
                            
                            <!-- START Payment form -->
                            <form class="form-horizontal" id="payment" name="payment">
                                <div class="panel panel-default">
                                    <div class="panel-heading ui-draggable-handle">
                                        <h3 class="panel-title"><strong>Form Payment</strong></h3>
                                    </div>
                                    <div class="panel-body">
                                        <p>choose breach and semester, click on <code>start payment</code> button, then the class will be appare bellow.</p>
                                    </div>
                                    <div class="panel-body form-group-separated">
                                        
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">New Class</label>
                                            <div class="col-md-6 col-xs-12">                                            
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control" name="txtclass" id="txtclass" />
                                                    <input type="hidden" class="form-control" name="class_id" id="class_id" />
                                                </div>                                            
                                                <span id="cls_des" class="help-block">Type level name in and choose the correct class</span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">                                        
                                            <label class="col-md-3 col-xs-12 control-label">Student </label>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                                    <input type="text" id="student" name="txtstudentname" class="form-control">
                                                    <input type="hidden" id="student_id" name="student_id" class="form-control">
                                                </div>            
                                                <span id="student_des" class="help-block">Type in and choose the correct student</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label"></label>
                                            <div class="col-md-6 col-xs-12">     
                                                <label class="check">
                                                    <input type="checkbox" id="newstudent" name="newstudent" class="icheckbox"> 
                                                    New Student
                                                </label>
                                                <span class="help-block">Check for new student</span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Discount </label>
                                            <div class="col-md-6 col-xs-12">           
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-percent"></span></span>
                                                    <input type="number" value="0" min="0" max="100" id="txtdiscount" name="txtdiscount" class="form-control">
                                                </div>
                                                <span class="help-block">You can put the percentage of discount.</span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">                                        
                                            <label class="col-md-3 col-xs-12 control-label">Price</label>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-dollar"></span></span>
                                                    <input type="number" id="txtprice" name="txtprice" class="form-control" style="background-color:#f9f9f9;color: #333;" readonly>                                            
                                                </div>
                                                <span class="help-block">It will be change when other option has change.</span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="panel-footer">
                                        <button type="reset" id="btnClear" id="btnClear" class="btn btn-default">Clear Form</button>
                                        <button type="submit" class="btn btn-primary pull-right">Save & Print</button>
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
        <div class="modal" id="form_data" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="defModalHead">Payment</h4>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                        <table id="pay_his" class="display table table-bordered table-striped datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="140">Date</th>
                                    <th>Class </th>
                                    <th width="170">Student Name</th>
                                    <th width="140">Amount ($)</th>
                                    <th width="150">Recipient</th>
                                    <th width="140">Action</th>
                                </tr>
                            </thead>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            #printing{
                width: 450px;
                height: 290px;
                margin: 0 auto;
            }
        </style>

        <!-- MODALS -->        
        <div class="modal" id="print_inv" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">        
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="defModalHead">Print Invoice</h4>
                    </div>
                    <div class="modal-body">
                        <div id="printing">
                            <div class="row">
                                <div class="col-sm-12" style="text-align: center;">
                                    <h3 style="color: #4CAF50;">COERR Language Skills Center</h3>
                                    <h4 style="color: #07a9a3; margin-bottom: 0px;">RECEIPT for MONEY RECEIVED</h4>
                                </div>
                            </div>
                            <hr style="margin: 10px;">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p id="inv_id" style="text-align: right;">No :<b style="color: red;"> 000343</b></p>
                                    <h6 id="from">Received From : Dem DeaTeng</h6>
                                    <h6 id="cls_lv">Study in class : Room 3 - 3:00 - 5:30 pm (Weekend)</h6>
                                    <h6 id="amount">The Amount : $50</h6>
                                    <p>This Payment for semester/session [6 month]</p>
                                </div>
                            </div>
                            <div class="row" style="text-align: right;">
                                <p id="date"><b>Date : July 23rd, 2016</b></p>
                                <h6>Recipient</h6> <br><br>
                                <h5 id="recipient">Rom Vannarith</h5>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal">Close</button>
                        <button id="btnprint" class="btn btn-primary">Print</button> 
                    </div>
                </div>
            </div>
        </div>

        <!-- MESSAGE BOX-->
            <?php require 'includes/messagebox.php'; ?>

        <div class="message-box message-box-danger animated fadeIn" data-sound="fail" id="fail_pay">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-times"></span> Failure Submission!</div>
                    <div class="mb-content">
                        <h4 style="color: #fff">Please field in textbox Class and Student!</h4>                  
                    </div>
                    <div class="mb-footer">
                        <button class="btn btn-default btn-lg pull-right mb-control-close">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="message-box message-box-danger animated fadeIn" data-sound="fail" id="busy">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-times"></span> Student Paid!</div>
                    <div class="mb-content">
                        <h4 style="color: #fff">This student alrealy paid on this semester!</h4>                  
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
        <script src="includes/js/jQuery.print.js"></script>
        <script type="text/javascript" src="ajax/payment.js"></script>
    </body>
</html>

