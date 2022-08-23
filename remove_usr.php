<?php 
require_once 'core/init.php';
$user = new User;
$log = new Log;
    try{

        $salt = Hash::salt(32);

        $res = DB::getInstance()->delete('tbllog', array('user_id', '=', Input::get('id') ));
        if($res){
            DB::getInstance()->delete('users', array('id', '=', Input::get('id') ));
            $log->insert($user->getData()->id, "Delete a user info.");
            echo 'User has been delete!';
        } else {
            echo 'something goes wrong!';
        }
    } catch (Exception $e) {
        die($e->getMessage());
    }


