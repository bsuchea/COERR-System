<?php 
require_once 'core/init.php';

$user = new User();
$log = new Log;

    if(Input::get('data')=='pass') {

        try{
            if(Hash::make(Input::get('password_current'), $user->getData()->salt) === $user->getData()->password) {
                
                $salt = Hash::salt(32);

                DB::getInstance()->update('v_users_detail', $user->getData()->id, array(
                    'password' => Hash::make(Input::get('password_new'), $salt),
                    'salt' => $salt
                ));
                $log->insert($user->getData()->id, "Change password.");
                echo 'Your name and password have been change!';
                
            } else {
                echo 'your current password is wrong!';
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
     
    }

    if(Input::get('data')=='info') {
        try{
            if(Hash::make(Input::get('password_current'), $user->getData()->salt) === $user->getData()->password) {
            
                DB::getInstance()->update('v_users_detail', $user->getData()->id, array(
                    'name' => Input::get('txtname'),
                    'phone' => Input::get('txtphone'),
                    'email' => Input::get('txtemail') 
                ));

                $log->insert($user->getData()->id, "Update Info.");
                echo 'Your info have been change';
            } else {
                echo 'Your current password is wrong';
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }

    }



