<?php 
	require_once '../core/init.php';

$user = new User;
$log = new Log;

if(Input::exists('get')){
	$db = DB::getInstance();
	if(Input::get('data')=='get'){
		$option = '';
		$time = $db->query('select * from tbltime');
		if($time->count()){
			foreach($time->getResults() as $tm){
				if(!$user->hasPermission('user')){
					$option = '<a href="#" id="time_'.$tm->id.'" class="btn btn-default btn-rounded btn-sm" onclick="editTime('. $tm->id .');"><span class="fa fa-edit"></span></a>';
					if(!$user->hasPermission('editor')){
						$option .= '<a href="#" id="time_'.$tm->id.'" class="btn btn-danger btn-rounded btn-sm" onclick="deleteTime('. $tm->id .');"><span class="fa fa-times"></span></a>';
					}
				}
				
				$timeOut[] = array($tm->time, $tm->type, $tm->description, $option);
			}
			echo json_encode($timeOut);
		}
	}

	if(Input::get('data')=='add'){
		try{
			$result = $db->insert('tbltime', array(
				'time' => Input::get('txttime'),
				'type' => Input::get('txttimetype'),
				'description' => Input::get('txttimedes')
			));	
			if($result){
				$log->insert($user->getData()->id, "Insert a new study time.");
				echo "success";
			}
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}

	if(Input::get('data')=='get-at'){
		$time = $db->get('tbltime', array('id', '=', Input::get('id')));
		$tm = $time->first();
		$timeOut[] = array($tm->time, $tm->type, $tm->description,);
		echo json_encode($timeOut);
	}

	if(Input::get('data')=='edit'){
		try{
			$email = (Input::get('txtemail')=='')?'No email':Input::get('txtemail');
			$result = $db->update('tbltime', Input::get('id'), array(
				'time' => Input::get('txttime'),
				'type' => Input::get('txttimetype'),
				'description' => Input::get('txttimedes')
			));	
			if($result){
				$log->insert($user->getData()->id, "Edit a time info.");
				echo "success";
			}
		}catch(Exception $e) {
			die($e->getMessage());
		}
	}
	if(Input::get('data')=='delete'){
		$result = $db->delete('tbltime', array('id', '=', Input::get('id')));
		if($result){
				$log->insert($user->getData()->id, "Delete a time info.");
			echo "success";
		}
	}
}


