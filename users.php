<?php 

require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
    Redirect::to('login.php');
}
if(!$user->hasPermission('admin') and !$user->hasPermission('moderator')){
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
                    <li class="active">Users View</li>
                </ul>
                <!-- END BREADCRUMB -->                       
                <?php $db = DB::getInstance(); ?>
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap" id="page-content-wrap">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <p>Use search to find users. You can search by: name, phone and email. Or use the advanced search.</p>
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-search"></span>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Who are you looking for?"/>
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-primary">Search</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <?php if($user->hasPermission('admin')): ?>
                                                <a href="user_add.php" class="btn btn-success btn-block"><span class="fa fa-user-plus"></span> Add new user</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </form>                                    
                                </div>
                            </div>
                            
                        </div> 
                    </div><!-- end row -->
                    <?php 
                        $sql = "SELECT * FROM v_users_detail";
                        $usrs = $db->query($sql);
                     ?>
                    <div class="row">
                        <?php foreach($usrs->getResults() as $usr): ?>
                        <div class="col-md-3" id="usr<?= $usr->id ?>">
                            <!-- CONTACT ITEM -->
                            <div class="panel panel-default">
                                <div class="panel-body profile">
                                    <div class="profile-image">
                                        <a href="user_add.php?usr_id=<?= $usr->id ?>">
                                            <img src="includes/assets/images/users/no-image.jpg" alt="Nadia Ali"/>
                                        </a>
                                    </div>
                                    <div class="profile-data">
                                        <div class="profile-data-name"><?= $usr->name ?></div>
                                        <div class="profile-data-title"><?= $usr->group ?></div>
                                    </div>
                                    <div class="profile-controls">
                                        <a href="<?= ($user->hasPermission('admin'))?'user_add.php?usr_id='.$usr->id:'#' ?>" class="profile-control-left"><span class="fa fa-info"></span></a>
                                        <a href="#" <?= ($user->hasPermission('admin'))?'onclick="removeUsr('.$usr->id.')"':'' ?> class="profile-control-right"><span class="fa fa-trash-o"></span></a>
                                    </div>
                                </div>
                                <div class="panel-body">                                    
                                    <div class="contact-info">
                                        <p><small>Position</small><br/><?= $usr->function ?></p>
                                        <p><small>Mobile</small><br/><?= $usr->phone ?></p>
                                        <p><small>Email</small><br/><?= $usr->email ?></p>
                                        <p><small>Address</small><br/><?= $usr->address ?></p>                
                                    </div>
                                </div>                                
                            </div>
                            <!-- END CONTACT ITEM -->
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- end row -->                                     
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

<?php if($user->hasPermission('admin')): ?>
    <script>
        function removeUsr(id) {

            playAudio('alert');
            var box = $("#mb-remove-row");
            box.addClass("open");
            
            var i=0;
            box.find(".mb-control-close").on("click",function(){
                i++;
            });
            
            box.find(".mb-control-yes").on("click", function(){
                box.removeClass("open");

                //protect error loop with old 
                if(i>0){
                    return false;
                }

                //proccess delete on ajax
                $.ajax({
                    url:          'remove_usr.php?id='+id,
                    cache:        false,
                    success: function(e){
                        noty({text: e, layout: 'topCenter', type: 'success'});
                    }, error: function(e){
                        console.log(e.responseText); 
                    }
                    
                });

                $("#usr"+id).hide("slow",function(){
                    $(this).remove();
                });
            });

            return false;
        }

    </script>
<?php endif; ?>

    </body>
</html>

