<?php
require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if(Input::exists()) {
    
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
        'name' => array(
            'required' => true,
            'min' => 6,
            'max' => 32
        )
    ));
    
    if($validation->passed()) {
        try{
            $user->update(array(
                'name' => Input::get('name')
            ));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }  else {
        foreach ($validation->getErrors() as $error) {
            echo $error, "<br>";
        }
    }
}

?>

<form action="" method="post">
    <div class="field">
        <label for="name"> Username </label>
        <input type="text" name="name" id="name" value="<?php echo escape($user->getData()->name); ?>">
    </div>
    <input type="submit" value="Update" >
</form>