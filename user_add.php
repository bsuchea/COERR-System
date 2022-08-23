<?php 

require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
    Redirect::to('login.php');
}

if(!$user->hasPermission('admin')){
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

    </head>
    <body>

        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            
            <?php $parent_page = "setting"; ?>
            
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
                    <li class="active">User profile</li>
                </ul>
                <!-- END BREADCRUMB -->                       
                <?php 
                    $db = DB::getInstance();
                    $username = '';
                    if(Input::get('usr_id')) {
                        $user = new User(Input::get('usr_id'));
                        $usr = $user->getData();
                    }


                 ?>
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap" id="page-content-wrap">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            
                            <div class="panel panel-default">
                                <div class="panel-body profile" style="background: url('includes/assets/images/ocean.jpg') center center no-repeat; background-size: 100%;">
                                    <div class="profile-image">
                                        <img src="includes/assets/images/users/avatar.jpg" alt="Nadia Ali"/>
                                    </div>
                                    <div class="profile-controls">
                                        <a href="#" class="profile-control-left twitter"><span class="fa fa-twitter"></span></a>
                                        <a href="#" class="profile-control-right facebook"><span class="fa fa-facebook"></span></a>
                                    </div>                                    
                                </div>                                
                                <div class="panel-body">                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-danger btn-rounded btn-block"><span class="fa fa-times"></span> Remove image</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-primary btn-rounded btn-block"><span class="fa fa-plus"></span> add image</button>
                                        </div>
                                    </div>
                                </div>
                                <ul class="panel-body list-group border-bottom">
                                    <a href="#" class="list-group-item active"><span class="fa fa-bar-chart-o"></span> User Info</a>
                                    <li class="list-group-item"> 
                                        <!-- START DEFAULT FORM ELEMENTS -->
                                        <form id="form_user_<?= isset($usr->id)?'edit':'add' ?>" class="form-horizontal" method="post" role="form">
                                            <input type="hidden" name="user_id" id="user_id" value="<?= isset($usr->id)?$usr->id:'' ?>">                                 
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Username: </label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="txtusername" id="txtusername" class="form-control" value="<?= isset($usr->username)?$usr->username:'' ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Staff: </label>
                                                <div class="col-sm-7">
                                                    <select class="form-control select" name="txtstaff" id="txtstaff" data-live-search="true">
                                                        <option value="">Choose staff ...</option>
                                                        <?php 
                                                            $staff=$db->query('select * from tblstaff');
                                                            foreach($staff->getResults() as $sta):
                                                         ?>
                                                        <option value="<?= $sta->id ?>" <?php if(isset($usr->id)) echo ($usr->staff_id==$sta->id)?'selected':'' ?>><?= $sta->name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Group: </label>
                                                <div class="col-sm-7">
                                                    <select class="form-control select" name="txtgroup" id="txtgroup">
                                                        <option value="">Choose group ...</option>
                                                        <?php 
                                                            $group=$db->query('select * from groups');
                                                            foreach($group->getResults() as $grp):
                                                         ?>
                                                        <option value="<?= $grp->id ?>" <?php if(isset($usr->id)) echo ($usr->group_id==$grp->id)?'selected':'' ?>><?= $grp->name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Is Active: </label>
                                                <div class="col-sm-7">
                                                    <select class="form-control select" name="txtisactive" id="txtisactive">
                                                        <option value="1">True</option>
                                                        <option value="0" <?php if(isset($usr->id)) echo ($usr->is_active==0)?'selected':'' ?>>False</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Password: </label>
                                                <div class="col-sm-6">
                                                    <input type="password" id="password" name="password" class="form-control">
                                                </div>
                                                <a id="btnpass" class="btn btn-link"><span class="fa fa-eye"></span></a>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"></label>
                                                <div class="col-sm-7">
                                                    <button type="reset" class="btn btn-default">Cencel</button>
                                                    <button type="submit" id="btnsubmit" class="btn btn-primary"><?= isset($usr->id)?'Update':'Insert' ?></button> 
                                                </div>
                                            </div>
                                        </form>                   
                                        <!-- END DEFAULT FORM ELEMENTS -->
                                    </li>
                                </ul>
                            </div>  
                            <!-- end panel                           -->
                        </div>
                    </div>                                   
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
        <script src="ajax/user_add.js" type="text/javascript"></script>

    </body>
</html>

