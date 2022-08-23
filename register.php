<?php

require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
    Redirect::to('login.php');
}


if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 4,
                'max' => 32,
                'unique' => 'users'
            ),
            'password' => array(
                'required' => true,
                'min' => 4,
                'max' => 32
            ),
            'password_again' => array(
                'required' => true,
                'matches' => 'password'
            ),
            'name' => array(
                'required' => true,
                'min' => 4,
                'max' => 32
            )
        ));

        if($validation->passed()){
            try{
                $user = new User();
                
                $salt = Hash::salt(32);
                
                $user->create(array(
                    'username' => Input::get('username'),
                    'password' => Hash::make(Input::get('password'), $salt),
                    'salt' => $salt,
                    'joined' => date('Y-m-d H:i:s'),
                    'name' => Input::get('name'),
                    'group' => 2
                ));
                
                Redirect::to('login.php');
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }else {
            foreach($validation->getErrors() as $error) {
                echo $error. '<br>';
            }
        }
    }
}

?>
<form action="" method="post">
    <div class="field">
        <label for="username"> Username </label>
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="false">
    </div>
    
    <div class="field">
        <label for="password"> Choose your password </label>
        <input type="password" name="password" id="password">
    </div>
    
    <div class="field">
        <label for="password_again"> Enter your password again </label>
        <input type="password" name="password_again" id="password_again">
    </div>
    
    <div class="field">
        <label for="name"> Your name </label>
        <input type="text" name="name" id="name" value="<?php echo escape(Input::get('name')); ?>">
    </div>
    
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" >

    <input type="submit" value="Register" >
</form>