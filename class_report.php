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
                    <li class="active">Class Report</li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap" id="page-content-wrap">
                    
                    <div class="col-md-12">

                        <?php $db = DB::getInstance(); ?>
                            <?php 
                                $class = $db->query('SELECT tblclass.id,tblclass.semester_id, tblclass.level_id, tblstaff.`name` staff_name, tbllevel.lv, tblroom.room, tbltime.time, tbltime.type, tblsemester.semester, tblsemester.year, tblbreach.`name` breach_name FROM tblclass INNER JOIN tblroom ON tblclass.room_id = tblroom.id INNER JOIN tbllevel ON tblclass.level_id = tbllevel.id INNER JOIN tblsemester ON tblclass.semester_id = tblsemester.id INNER JOIN tbltime ON tblclass.time_id = tbltime.id INNER JOIN tblbreach ON tblclass.breach_id = tblbreach.id INNER JOIN tblstaff ON tblclass.staff_id = tblstaff.id WHERE tblclass.id='.Input::get("cls_id"));
                                if($class->count()){
                                    $cls = $class->first();
                                }
                                $lv_id = $cls->level_id;
                                $sem_id = $cls->semester_id;
                                
                             ?>
                        <div class="row">
                            <div class="page-title">  
                                <div id="class_detail" style="font-size: 16px; font-style: bold;">
                                    <span class="fa fa-arrow-circle-o-left" style="font-size: 22px; font-style: bold;"></span>
                                    Student List on: 
                                    <?php echo  $cls->lv." by ".$cls->staff_name." at ". $cls->room. " on ". $cls->time .' ('. $cls->type.') - '. $cls->breach_name ?>, semester: <?= $cls->semester ?>, year: <?= $cls->year ?> 
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default tabs">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active"><a href="#tab_atten" role="tab" data-toggle="tab">Attendant Report</a></li>
                                <li><a href="#tab_score" role="tab" data-toggle="tab">Score Result</a></li>
                            </ul>
                            <div class="panel-body tab-content">
                                <div class="tab-pane active" id="tab_atten">
                                    <div class="panel panel-default">
                                        <div class="panel-heading ui-draggable-handle">
                                            <h3 class="panel-title"> </h3>
                                            <ul class="panel-controls">
                                                <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                                            </ul>
                                            <div class="pull-right">
                                                <div class="btn-group">
                                                    <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="#" onClick ="$('#atten_list').tableExport({type:'csv',escape:'false'});"><img src='img/icons/csv.png' width="24"/> CSV</a></li>
                                                        <li><a href="#" onClick ="$('#atten_list').tableExport({type:'txt',escape:'false'});"><img src='img/icons/txt.png' width="24"/> TXT</a></li>
                                                        <li class="divider"></li>
                                                        <li><a href="#" onClick ="$('#atten_list').tableExport({type:'excel',escape:'false'});"><img src='img/icons/xls.png' width="24"/> XLS</a></li>
                                                        <li><a href="#" onClick ="$('#atten_list').tableExport({type:'doc',escape:'false'});"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                                        <li><a href="#" onClick ="$('#atten_list').tableExport({type:'powerpoint',escape:'false'});"><img src='img/icons/ppt.png' width="24"/> PowerPoint</a></li>
                                                        <li class="divider"></li>
                                                        <li><a href="#" onClick ="$('#atten_list').tableExport({type:'png',escape:'false'});"><img src='img/icons/png.png' width="24"/> PNG</a></li>
                                                        <li><a href="#" onClick ="$('#atten_list').tableExport({type:'pdf',escape:'false'});"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
                                                    </ul>
                                                </div> 
                                            </div>
                                        </div>
                                        <!-- end penel heading -->
                                        <div class="panel-body panel-body-table">
                                            <div class="table-responsive">
                                                <table id="atten_list" class="table table-bordered table-actions">
                                                    <thead>
                                                        <tr>
                                                            <th width="50">#</th>
                                                            <th>Student Name</th>
                                                            <th width="150">Absent</th>
                                                            <th width="150">Permission</th>
                                                            <th width="150">Late/Early leave</th>
                                                            <th width="150">Total</th>
                                                            <th width="150">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $sts = $db->query('SELECT * FROM v_absent_report where class_id='.Input::get('cls_id'));
                                                            $i=0;
                                                            foreach($sts->getResults() as $st):

                                                            $totalAb=round(($st->le/3)+$st->permission+$st->absent)
                                                         ?>                                   
                                                        <tr 
                                                        <?php 
                                                            if(($totalAb<7)) echo '';
                                                            elseif(($totalAb<12)) echo 'class="active"';
                                                            elseif($totalAb<17) echo 'class="warning"';
                                                            else echo 'class="danger"';
                                                         ?>
                                                        >
                                                            <td><strong><?= ++$i  ?></strong></td>
                                                            <td><strong><?= $st->name  ?></strong></td>
                                                            <td><?= $st->absent  ?></td>
                                                            <td><?= $st->permission  ?></td>
                                                            <td><?= $st->le  ?></td>
                                                            <td><?= $totalAb ?></td>
                                                            <td>
                                                            <?php 
                                                                if($totalAb>=22){
                                                                    $db->query('UPDATE tblstudy SET status="dropped", date="'.date('Y-m-d'). '" WHERE status IS NULL AND class_id='. $st->class_id .' AND student_id='. $st->id);
                                                                    echo '<span class="label label-danger">Dropped</span>';
                                                                }
                                                                
                                                             ?>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div> 
                                            <!-- end table responsive -->
                                        </div>
                                    </div>
                                    <!-- end panel    -->
                                </div>
                                <!-- end tab atten -->

                                <div class="tab-pane" id="tab_score">
                                    <div class="panel panel-default">
                                        <div class="panel-heading ui-draggable-handle">
                                            <h3 class="panel-title"> </h3>
                                            <ul class="panel-controls">
                                                <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                                            </ul>
                                            <div class="pull-right">
                                                <div class="btn-group">
                                                    <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="#" onClick ="$('#score_list').tableExport({type:'csv',escape:'false'});"><img src='img/icons/csv.png' width="24"/> CSV</a></li>
                                                        <li><a href="#" onClick ="$('#score_list').tableExport({type:'txt',escape:'false'});"><img src='img/icons/txt.png' width="24"/> TXT</a></li>
                                                        <li class="divider"></li>
                                                        <li><a href="#" onClick ="$('#score_list').tableExport({type:'excel',escape:'false'});"><img src='img/icons/xls.png' width="24"/> XLS</a></li>
                                                        <li><a href="#" onClick ="$('#score_list').tableExport({type:'doc',escape:'false'});"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                                        <li><a href="#" onClick ="$('#score_list').tableExport({type:'powerpoint',escape:'false'});"><img src='img/icons/ppt.png' width="24"/> PowerPoint</a></li>
                                                        <li class="divider"></li>
                                                        <li><a href="#" onClick ="$('#score_list').tableExport({type:'png',escape:'false'});"><img src='img/icons/png.png' width="24"/> PNG</a></li>
                                                        <li><a href="#" onClick ="$('#score_list').tableExport({type:'pdf',escape:'false'});"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
                                                    </ul>
                                                </div> 
                                            </div>
                                        </div>
                                        <!-- end penel heading -->
                                        <div class="panel-body panel-body-table">
                                            <div class="table-responsive">
                                                <table id="score_list" class="table table-bordered table-striped table-actions">
                                                    <thead>
                                                        <tr>
                                                            <th width="50">#</th>
                                                            <th>Student Name</th>
                                                            <th width="150">Mid-term</th>
                                                            <th width="150">Promotion</th>
                                                            <th width="150">Total</th>
                                                            <th width="150">Mention</th>
                                                            <th width="150">Grade</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $get_sdv = $db->query('SELECT * FROM v_final_score where semester_id='.$sem_id.' AND level_id='.$lv_id);
                                                            $stotal[] = '';
                                                            foreach($get_sdv->getResults() as $gsdv){
                                                                array_push($stotal, round(($gsdv->midterm + ($gsdv->promotion * 2))/3));
                                                            }
                                                            $n = count($stotal);
                                                            $mean = array_sum($stotal)/$n;
                                                            $carry =0;
                                                            foreach ($stotal as $val) {
                                                                $d = ((double) $val) - $mean;
                                                                $carry += $d * $d;
                                                            }
                                                             
                                                            $sdv = round(sqrt($carry / $n));
                                                        
                                                            $sts = $db->query('SELECT * FROM v_final_score where class_id='.Input::get('cls_id'));
                                                            $i=0;
                                                            
                                                            foreach($sts->getResults() as $st):
                                                         ?>                                   
                                                        <tr>
                                                            <td><strong><?= ++$i  ?></strong></td>
                                                            <td><strong><?= $st->name  ?></strong></td>
                                                            <td><?= $st->midterm  ?></td>
                                                            <td><?= $st->promotion  ?></td>
                                                            <td><?= $total = round(($st->midterm + ($st->promotion * 2))/3)   ?></td>
                                                            <td>
                                                            <?php 
                                                                $cd = $mean - $sdv;
                                                                $c = $cd + $sdv / 2;
                                                                $cb = $c + $sdv / 2;
                                                                $bd = $cb + $sdv / 2;
                                                                $b = $bd + $sdv / 2;
                                                                $bb = $b + $sdv / 2;
                                                                $a = $bb + $sdv / 2;
                                                                
                                                                if($total< $cd ){
                                                                    $db->query('UPDATE tblstudy SET status="repeat", date="'.date('Y-m-d'). '" WHERE status IS NULL AND class_id='. $st->class_id .' AND student_id='. $st->id);
                                                                        echo 'Repeat';
                                                                }
                                                                elseif($total<$c)
                                                                    echo 'Below Average';
                                                                elseif($total<$cb)
                                                                    echo 'Average';
                                                                elseif($total<$bd)
                                                                    echo 'Above Average';
                                                                elseif($total<$b)
                                                                    echo 'Fairly Good';
                                                                elseif($total<$bb)
                                                                    echo 'Good';
                                                                elseif($total<$a)
                                                                    echo 'Very Good';
                                                                else
                                                                    echo 'Excellent';

                                                             ?>
                                                            </td>
                                                            <td> 
                                                            <?php 
                                                                if($total< $cd )
                                                                    echo 'F';
                                                                elseif($total<$c)
                                                                    echo 'C-';
                                                                elseif($total<$cb)
                                                                    echo 'C';
                                                                elseif($total<$bd)
                                                                    echo 'C+';
                                                                elseif($total<$b)
                                                                    echo 'B-';
                                                                elseif($total<$bb)
                                                                    echo 'B';
                                                                elseif($total<$a)
                                                                    echo 'B+';
                                                                else
                                                                    echo 'A';
                                                             ?>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div> 
                                            <!-- end table responsive -->
                                        </div>
                                    </div>
                                    <!-- end panel    -->
                                </div>
                                <!-- end tab score -->
                            </div>
                            <!-- end body tab -->
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

    </body>
</html>

