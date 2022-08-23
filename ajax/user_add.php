<?php 
require_once '../core/init.php';

$usr = new User;
$log = new Log;

    if(Input::get('data')=='add') {

        try{
            $user = new User();

            $check = DB::getInstance()->get('users', array('username', '=', Input::get('txtusername')));
            if($check->count()) {
                echo "Username is already exists!";
            }

            $salt = Hash::salt(32);
            
            $user->create(array(
                'username' => Input::get('txtusername'),
                'password' => Hash::make(Input::get('password'), $salt),
                'salt' => $salt,
                'staff_id' => Input::get('txtstaff'),
                'joined' => date('Y-m-d H:i:s'),
                'is_active' => Input::get('txtisactive'),
                'group_id' => Input::get('txtgroup')
            ));
            
            $log->insert($usr->getData()->id, "Insert a new user.");
            echo 'New user have been insterted!';

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    if(Input::get('data')=='edit') {
        try{
            
            $user = new User(Input::get('user_id'));

            $check = DB::getInstance()->query("SELECT id FROM users WHERE id != ? AND username = ?", array(Input::get('user_id'), Input::get('txtusername')));
            if($check->count()) {
                echo "Username is already exists! ";
                die();
            }

            $salt = Hash::salt(32);
            
            DB::getInstance()->update('users', Input::get('user_id'), array(
                'username' => Input::get('txtusername'),
                'password' => Hash::make(Input::get('password'), $salt),
                'salt' => $salt,
                'staff_id' => Input::get('txtstaff'),
                'is_active' => Input::get('txtisactive'),
                'group_id' => Input::get('txtgroup')
            ));
            
                $log->insert($usr->getData()->id, "Update a user info.");
            echo 'User info have been updated!';

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }



