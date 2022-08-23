
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
            textarea{
                max-width: 100%;
            }
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
            <?php $p = (null!=Input::get('p'))?Input::get('p'):'breach' ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>                    
                    <li><a href="#">Data</a></li>                    
                    <li class="active"><?= isset($p)?$p:'breach' ?></li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap" id="page-content-wrap">
                    
                    <div class="col-md-12">
                                        
                        <div class="panel panel-default tabs">      
                            <ul class="panel-controls">
                                <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                                <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                            </ul>                      
                            <ul class="nav nav-tabs" role="tablist">
                                <li <?= ($p=='breach')?'class="active"':'' ?>><a href="#tab-first" role="tab" data-toggle="tab">Breach</a></li>
                                <li <?= ($p=='semester')?'class="active"':'' ?>><a href="#tab-second" role="tab" data-toggle="tab">Semester</a></li>
                            </ul>
                            <div class="panel-body tab-content">
                                <div class="tab-pane <?= ($p=='breach')?'active':'' ?>" id="tab-first">
                                    <div class="row">

                                        <!-- form breach -->
                                        <div class="col-md-5">
                                            <form id="form-breach" action="" method="post" class="form-horizontal form-add" role="form">
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Breach</label>
                                                    <div class="col-md-10">
                                                        <input type="text" name="txtbreach" id="txtbreach" class="form-control" placeholder="breach">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Description</label>
                                                    <div class="col-md-10">
                                                        <textarea name="txtbreachdes" id="txtbreachdes" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button type="submit" id="btnsubmit" class="btn btn-primary">Insert</button> 
                                                        <button type="reset" class="btn btn-default" onclick="addBreach();">Clear</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- end form breach -->

                                        <!-- table breach -->
                                        <div class="col-md-7">
                                            <table  id="breach" class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Breach</th>
                                                        <th>Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <!-- table breach -->
                                    </div>
                                </div>

                                <div class="tab-pane <?= ($p=='semester')?'active':'' ?>" id="tab-second">
                                    <div class="row">
                                        <!-- form semester -->
                                        <div class="col-md-5">
                                            <form id="form-semester" action="" method="post" class="form-horizontal form-add" role="form">
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Semester</label>
                                                    <div class="col-md-10">
                                                        <input type="text" name="txtsemester" id="txtsemester" class="form-control" placeholder="Semester">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Year</label>
                                                    <div class="col-md-10">
                                                        <input type="text" name="txtyear" id="txtyear" class="form-control" placeholder="year of semester">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Description</label>
                                                    <div class="col-md-10">
                                                        <textarea name="txtsemesterdes" id="txtsemesterdes" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button type="submit" id="btnsubmitsm" class="btn btn-primary">Insert</button> 
                                                        <button type="reset" class="btn btn-default" onclick="addsemester();">Clear</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- end form semester -->

                                        <!-- table semester -->
                                        <div class="col-md-7">
                                            <table  id="semester" class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Semester</th>
                                                        <th>Year</th>
                                                        <th>Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <!-- table semester -->
                                    </div>
                                </div>                                        
                                
                            </div>
                            <div class="panel-footer">

                            </div>
                        </div>  
                         <!-- end panel -->
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

        <script type="text/javascript" src="ajax/breach.js"></script>
        <script type="text/javascript" src="ajax/semester.js"></script>

    </body>
</html>

