<?php 
	require_once '../core/init.php';

$user = new User;
$log = new Log;

if(Input::exists('get')){
	$db = DB::getInstance();
	if(Input::get('data')=='get'){
		$option = '';
		$level = $db->query('select * from tbllevel');
		if($level->count()){
			foreach($level->getResults() as $tm){
				if(!$user->hasPermission('user')){
					$option = '<a href="#" id="level_'.$tm->id.'" class="btn btn-default btn-rounded btn-sm" onclick="editLevel('. $tm->id .');"><span class="fa fa-edit"></span></a>';
					if(!$user->hasPermission('editor')){
						$option .= '<a href="#" id="level_'.$tm->id.'" class="btn btn-danger btn-rounded btn-sm" onclick="deleteLevel('. $tm->id .');"><span class="fa fa-times"></span></a>';
					}
				}
				
				$levelOut[] = array($tm->lv, '$'.$tm->lv_price, $tm->description, $option);
			}
			echo json_encode($levelOut);
		}
		else{
			echo "no query!!";
		}
	}

	if(Input::get('data')=='add'){
		try{
			$result = $db->insert('tbllevel', array(
				'lv' => Input::get('txtlevel'),
				'lv_price' => Input::get('txtlevelprice'),
				'description' => Input::get('txtleveldes')
			));
			if($result){
				$log->insert($user->getData()->id, "Insert new level.");
				echo "success";
			}
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}

	if(Input::get('data')=='get-at'){
		$level = $db->get('tbllevel', array('id', '=', Input::get('id')));
		$tm = $level->first();
		$levelOut[] = array($tm->lv, $tm->lv_price, $tm->description,);
		echo json_encode($levelOut);
	}

	if(Input::get('data')=='edit'){
		try{
			$email = (Input::get('txtemail')=='')?'No email':Input::get('txtemail');
			$result = $db->update('tbllevel', Input::get('id'), array(
				'lv' => Input::get('txtlevel'),
				'lv_price' => Input::get('txtlevelprice'),
				'description' => Input::get('txtleveldes')
			));	
			if($result){
				$log->insert($user->getData()->id, "Edit level info.");
				echo "success";
			}
		}catch(Exception $e) {
			die($e->getMessage());
		}
	}
	if(Input::get('data')=='delete'){
		$result = $db->delete('tbllevel', array('id', '=', Input::get('id')));
		if($result){
				$log->insert($user->getData()->id, "Delete a level info.");
			echo "success";
		}
	}
}


