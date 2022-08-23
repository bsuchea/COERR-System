
<?php 
    $page = explode('/', $_SERVER["REQUEST_URI"]);
    $page = end($page);
    $p = '';
    if($page!=""){
        $page = explode('?', $page);
        if(isset($page[1])){
            $page[1] = explode('=', $page[1]);
            $p = end($page[1]);
        }else{
            $p = basename($page[0],'.php');
        }
    }else{
        $p = "index";
    }

 ?>

<div class="page-sidebar">
    <!-- START X-NAVIGATION -->
    <ul class="x-navigation">
        <li class="xn-logo">
            <a href="index.php">COERR</a>
            <a href="index.php" class="x-navigation-control"></a>
        </li>
        <li class="xn-profile">
            <a href="#" class="profile-mini">
                <img src="includes/assets/images/users/avatar.jpg" alt="John Doe"/>
            </a>
            <div class="profile">
                <div class="profile-image">
                    <img src="includes/assets/images/users/avatar.jpg" alt="John Doe"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name"><?= $user->getData()->name ?></div>
                    <div class="profile-data-title"><?= $user->getData()->function ?></div>
                </div>
                <div class="profile-controls">
                    <a href="profile.php" class="profile-control-left"><span class="fa fa-info"></span></a>
                    <a href="profile.php" class="profile-control-right"><span class="fa fa-phone"></span></a>
                </div>
            </div>                                                                        
        </li>
        <li class="xn-title">Navigation</li>
        <li <?= ($p=="index")?'class="active"':'' ?>>
            <a href="index.php"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>                        
        </li>                    
        <li class="xn-openable <?= ($parent_page=='data')?'active':'' ?>">
            <a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">Data</span></a>
            <ul>
                <li <?= ($p=="staff")?'class="active"':'' ?>><a href="staff.php"><span class="fa fa-user"></span> Staff</a></li>
                <li <?= ($p=="student")?'class="active"':'' ?>><a href="student.php"><span class="fa fa-users"></span> Student</a></li>
                <li <?= ($p=="time")?'class="active"':'' ?>><a href="tlr.php?p=time"><span class="fa fa-clock-o"></span> Time</a></li>
                <li <?= ($p=="room")?'class="active"':'' ?>><a href="tlr.php?p=room"><span class="fa fa-hourglass-end"></span> Room</a></li>
                <li <?= ($p=="level")?'class="active"':'' ?>><a href="tlr.php?p=level"><span class="fa fa-industry"></span> Level</a></li>
                <li <?= ($p=="breach")?'class="active"':'' ?>><a href="bs.php?p=breach"><span class="fa fa-map-marker"></span> Breach</a></li>                           
                <li <?= ($p=="semester")?'class="active"':'' ?>><a href="bs.php?p=semester"><span class="fa fa-shield"></span> Semester</a></li>                           
            </ul>
        </li>
        <li class="xn-openable <?= ($parent_page=='transaction')?'active':'' ?>">
            <a href="#"><span class="fa fa-share-alt"></span> <span class="xn-text">Transaction</span></a>
            <ul>
                <li <?= ($p=="class_arrage")?'class="active"':'' ?>><a href="class_arrage.php"><span class="fa fa-th"></span> Class Arrange</a></li>
                <li <?= ($p=="payment")?'class="active"':'' ?>><a href="payment.php"><span class="fa fa-credit-card"></span> Payment</a></li>
            </ul> 
        </li>

        <li class="xn-openable <?= ($parent_page=='report')?'active':'' ?>">
            <a href="#"><span class="fa fa-bar-chart-o"></span> <span class="xn-text"> Report</span></a>
            <ul>
                <li <?= ($p=="view_class")?'class="active"':'' ?>><a href="view_class.php"><span class="fa fa-area-chart"></span> Class Report</a></li>
                <li <?= ($p=="student_paid")?'class="active"':'' ?>><a href="student_paid.php"><span class="fa fa-line-chart"></span> Student Paid</a></li>
                <li <?= ($p=="student_filter")?'class="active"':'' ?>><a href="student_filter.php"><span class="fa fa-bar-chart"></span> Student Filter</a></li>
                <li <?= ($p=="paid_report")?'class="active"':'' ?>><a href="paid_report.php"><span class="fa fa-pie-chart"></span> Payment Income</a></li>
            </ul>
        </li> 

        <li class="xn-openable <?= ($parent_page=='setting')?'active':'' ?>">
            <a href="#"><span class="fa fa-cogs"></span> <span class="xn-text"> Setting</span></a>                        
            <ul>
                <li <?= ($p=="profile")?'class="active"':'' ?>><a href="profile.php"><span class="fa fa-user-secret"></span> Profile</a></li>                            
                <li <?= ($p=="users")?'class="active"':'' ?>><a href="users.php"><span class="fa fa-users"></span> Users</a></li>                            
                <!-- <li><a href="ui-elements.html"><span class="fa fa-cogs"></span> Group</a></li>
                <li><a href="ui-buttons.html"><span class="fa fa-square-o"></span> Permissions</a></li> -->
            </ul>
        </li>                    
        
        <li <?= ($p=="log")?'class="active"':'' ?>>
            <a href="log.php"><span class="fa fa-table"></span> <span class="xn-text">User Activities</span></a>
        </li>
        
    </ul>
    <!-- END X-NAVIGATION -->
</div>