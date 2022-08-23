
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
            <?php $p = (null!=Input::get('p'))?Input::get('p'):'time' ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>                    
                    <li><a href="#">Data</a></li>                    
                    <li class="active"><?= isset($p)?$p:'Time' ?></li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap" id="page-content-wrap">
                    
                    <div class="col-md-12">
                                        
                        <div class="panel panel-default panel-hidden-controls tabs">
                            
                            <ul class="panel-controls">
                                <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                                <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                            </ul>

                            <ul class="nav nav-tabs" role="tablist">
                                <li <?= ($p=='time')?'class="active"':'' ?>><a href="#tab-first" role="tab" data-toggle="tab">Time</a></li>
                                <li <?= ($p=='level')?'class="active"':'' ?>><a href="#tab-second" role="tab" data-toggle="tab">Level</a></li>
                                <li <?= ($p=='room')?'class="active"':'' ?>><a href="#tab-third" role="tab" data-toggle="tab">Room</a></li>
                            </ul>
                            <div class="panel-body tab-content">
                                <div class="tab-pane <?= ($p=='time')?'active':'' ?>" id="tab-first">
                                    <div class="row">

                                        <!-- form time -->
                                        <div class="col-md-5">
                                            <form id="form-time" action="" method="post" class="form-horizontal form-add" role="form">
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Time</label>
                                                    <div class="col-md-10">
                                                        <input type="text" name="txttime" id="txttime" class="form-control" placeholder="time">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Type</label>
                                                    <div class="col-md-10">
                                                        <select name="txttimetype" id="txttimetype" class="form-control" >
                                                            <option value="">Choose time Type</option>
                                                            <option value="Weekday">Weekday</option>
                                                            <option value="Weekend">Weekend</option>
                                                        </select> 
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Description</label>
                                                    <div class="col-md-10">
                                                        <textarea name="txttimedes" id="txttimedes" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button type="submit" id="btnsubmit" class="btn btn-primary">Insert</button> 
                                                        <button type="reset" class="btn btn-default" onclick="addTime();">Clear</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- end form time -->

                                        <!-- table time -->
                                        <div class="col-md-7">
                                            <table  id="time" class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Time</th>
                                                        <th>Type</th>
                                                        <th>Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <!-- table time -->
                                    </div>
                                </div>
                                <div class="tab-pane <?= ($p=='level')?'active':'' ?>" id="tab-second">
                                    <div class="row">
                                        <!-- form Level -->
                                        <div class="col-md-5">
                                            <form id="form-level" action="" method="post" class="form-horizontal form-add" role="form">
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Level</label>
                                                    <div class="col-md-10">
                                                        <input type="text" name="txtlevel" id="txtlevel" class="form-control" placeholder="level">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Price $</label>
                                                    <div class="col-md-10">
                                                        <input type="number" name="txtlevelprice" id="txtlevelprice" class="form-control" placeholder="Level Price">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Description</label>
                                                    <div class="col-md-10">
                                                        <textarea name="txtleveldes" id="txtleveldes" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button type="submit" id="btnsubmitlv" class="btn btn-primary">Insert</button> 
                                                        <button type="reset" class="btn btn-default" onclick="addLevel();">Clear</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- end form Level -->

                                        <!-- table Level -->
                                        <div class="col-md-7">
                                            <table  id="level" class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Level</th>
                                                        <th>Price</th>
                                                        <th>Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <!-- table Level -->
                                    </div>
                                </div>                                        
                                <div class="tab-pane <?= ($p=='room')?'active':'' ?>" id="tab-third">
                                    <div class="row">
                                        <!-- form room -->
                                        <div class="col-md-5">
                                            <form id="form-room" action="" method="post" class="form-horizontal form-add" role="form">
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Room</label>
                                                    <div class="col-md-10">
                                                        <input type="text" name="txtroom" id="txtroom" class="form-control" placeholder="Room Name">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Description</label>
                                                    <div class="col-md-10">
                                                        <textarea name="txtroomdes" id="txtroomdes" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button type="submit" id="btnsubmitr" class="btn btn-primary">Insert</button> 
                                                        <button type="reset" class="btn btn-default" onclick="addRoom();">Clear</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- end form room -->

                                        <!-- table room -->
                                        <div class="col-md-7">
                                            <table  id="room" class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Room Name</th>
                                                        <th>Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <!-- table room -->
                                    </div><!-- / row -->
                                </div>
                                <!-- panel tab -->
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

        <script type="text/javascript" src="ajax/time.js"></script>
        <script type="text/javascript" src="ajax/level.js"></script>
        <script type="text/javascript" src="ajax/room.js"></script>

    </body>
</html>

