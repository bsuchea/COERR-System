<?php require_once 'core/init.php'; ?>

<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title>COERR.Mgr</title>            
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
        <div class="login-container">
        
            <div class="login-box animated fadeInDown">
                <div class="login-logo"></div>
                <div class="login-body">
                    <div class="login-title"><strong>Welcome</strong>, Please login</div>
                    <div style="color: #fff; margin-bottom: 10px;">
<?php

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array('required' => true),
            'password' => array('required' => true),
        ));
        if ($validation->passed()) {
            $remember = (Input::get('remember') === 'on') ? true : false;
            $user = new User();
            $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            if ($login) {
                if(!$user->getData()->is_active) Redirect::to('de_user.php');
                Redirect::to('index.php');
            } else {
                echo 'Incorrect username or password!';
            }
        } else {
            foreach ($validation->getErrors() as $error) {
                echo $error . '<br>';
            }
        }
    }
}
?>
                    </div>
                    <form action="" class="form-horizontal" method="post">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="false" class="form-control" placeholder="Username"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label  class="form-control">
                                <input type="checkbox" name="remember" id="remember"> Remember me 
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <a href="#" class="btn btn-link btn-block">Forgot your password?</a>
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" >
                            <button class="btn btn-info btn-block">Log In</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="login-footer">
                    <div class="pull-left">
                        &copy; 2016 COERR.Mgr
                    </div>
                    <div class="pull-right">
                        <a href="https://www.facebook.com/coerrbtb" target="_black">About</a> |
                        <a href="https://www.facebook.com/coerrbtb" target="_black">Privacy</a> |
                        <a href="https://www.facebook.com/coerrbtb" target="_black">Contact Us</a>
                    </div>
                    
                </div>
            </div>
            
        </div>
        
    </body>
</html>