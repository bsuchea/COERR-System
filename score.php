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
                    <li class="active">Score</li>
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
                                    Student Score on: 
                                    <?php echo  $cls->lv." by ".$cls->staff_name." at ". $cls->room. " on ". $cls->time .' ('. $cls->type.') - '. $cls->breach_name ?>, semester: <?= $cls->semester ?>, year: <?= $cls->year ?> 
                                </div>
                            </div>
                            
                            <!-- START Payment form -->
                            <form class="form-horizontal" id="score" name="score">
                                <div class="panel panel-default">
                                    <div class="panel-heading ui-draggable-handle">
                                        <div class="pull-left">
                                            <div class="form-inline" role="form">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Term </span>
                                                    <select name="txtterm" id="txtterm" class="validate[required] form-control" aria-required="true">
                                                        <option value="">Choose term</option>
                                                        <option value="1">Mid-term</option>
                                                        <option value="2">Promotion</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="option" class="pull-right" style="margin-right: 10px;">
                                            <div class="form-group">
                                                <a id="btnAttendent" class="btn btn-default btn-rounded">Attendent</a>
                                                <a id="btnDetail" class="btn btn-info btn-rounded">Class List</a>
                                                <a id="btnReport" class="btn btn-success btn-rounded">Class Report</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body panel-body-table">

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-actions">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Student Name</th>
                                                        <th width="110">H. Assignment</th>
                                                        <th width="100">Reading Pro.</th>
                                                        <th width="100">Speaking</th>
                                                        <th width="100">Grammer</th>
                                                        <th width="100">Lestenning</th>
                                                        <th width="100">Reading</th>
                                                        <th width="100">Writing</th>
                                                    </tr>
                                                </thead>
                                                <form id="attendent" action="">
                                                <tbody>
                                                    <?php 
                                                        $aps = $db->query('SELECT id, name FROM v_study_detail where class_id='.Input::get('cls_id'));
                                                        $i=0;
                                                        foreach($aps->getResults() as $ap):
                                                     ?>                                   
                                                    <tr id="trow_<?= $ap->id  ?>">
                                                        <td>
                                                            <strong><?= ++$i  ?></strong>
                                                            <input type="hidden" name="study_<?= $i ?>" value="<?= $ap->id  ?>">
                                                        </td>
                                                        <td><strong><?= $ap->name  ?></strong></td>
                                                        <td>
                                                            <input id="asg_<?= $i ?>" name="asg_<?= $i ?>" type="text" value="0" class="validate[required,custom[number],min[0],max[16]] form-control">
                                                        </td>
                                                        <td>
                                                            <input id="read_pro_<?= $i ?>" name="read_pro_<?= $i ?>" type="text" value="0" class="validate[required,custom[number],min[0],max[16]] form-control">
                                                        </td>
                                                        <td>
                                                            <input id="speak_<?= $i ?>" name="speak_<?= $i ?>" type="text" value="0" class="validate[required,custom[number],min[0],max[16]] form-control">
                                                        </td>
                                                        <td>
                                                            <input id="gram_<?= $i ?>" name="gram_<?= $i ?>" type="text" value="0" class="validate[required,custom[number],min[0],max[16]] form-control">
                                                        </td>
                                                        <td>
                                                            <input id="listen_<?= $i ?>" name="listen_<?= $i ?>" type="text" value="0" class="validate[required,custom[number],min[0],max[16]] form-control">
                                                        </td>
                                                        <td>
                                                            <input id="read_<?= $i ?>" name="read_<?= $i ?>" type="text" value="0" class="validate[required,custom[number],min[0],max[16]] form-control">
                                                        </td>
                                                        <td>
                                                            <input id="write_<?= $i ?>" name="write_<?= $i ?>" type="text" value="0" class="validate[required,custom[number],min[0],max[16]] form-control">
                                                        </td>
                                                    </tr>                                                    
                                                    <?php endforeach; ?>
                                                </tbody>
                                                <input type="hidden" id="txtrow" name="txtrow" value="<?= $i ?>">
                                                <input type="hidden" id="txtclassid" name="txtclassid" value="<?= Input::get('cls_id') ?>">
                                                </form>
                                            </table>
                                        </div>                                

                                    </div>
                                    <div class="panel-footer">
                                        <button type="reset" class="btn btn-default">Clear Form</button>                                    
                                        <button type="submit" class="btn btn-primary pull-right">Save</button>
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

        <!-- MESSAGE BOX-->
            <?php require 'includes/messagebox.php'; ?>
        <!-- END MESSAGE BOX-->
        
        <?php require 'includes/footer.php'; ?>

        <script type="text/javascript" src="ajax/score.js"></script>

    </body>
</html>

