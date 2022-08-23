<?php 
	require_once '../core/init.php';

$user = new User;
$log = new Log;

if(Input::exists('get')){
	$db = DB::getInstance();
	if(Input::get('data')=='get'){
		$option = '';
		$room = $db->query('select * from tblroom');
		if($room->count()){
			foreach($room->getResults() as $tm){
				if(!$user->hasPermission('user')){
					$option = '<a href="#" id="room_'.$tm->id.'" class="btn btn-default btn-rounded btn-sm" onclick="editRoom('. $tm->id .');"><span class="fa fa-edit"></span></a>';
					if(!$user->hasPermission('editor')){
						$option .= '<a href="#" id="room_'.$tm->id.'" class="btn btn-danger btn-rounded btn-sm" onclick="deleteRoom('. $tm->id .');"><span class="fa fa-times"></span></a>';
					}
				}
				
				$roomOut[] = array($tm->room, $tm->description, $option);
			}
			echo json_encode($roomOut);
		}
		else{
			echo "no query!!";
		}
	}

	if(Input::get('data')=='add'){
		try{
			$result = $db->insert('tblroom', array(
				'room' => Input::get('txtroom'),
				'description' => Input::get('txtroomdes')
			));
			if($result){
				$log->insert($user->getData()->id, "Insert a new room.");
				echo "success";
			}
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}

	if(Input::get('data')=='get-at'){
		$room = $db->get('tblroom', array('id', '=', Input::get('id')));
		$tm = $room->first();
		$roomOut[] = array($tm->room, $tm->description,);
		echo json_encode($roomOut);
	}

	if(Input::get('data')=='edit'){
		try{
			$email = (Input::get('txtemail')=='')?'No email':Input::get('txtemail');
			$result = $db->update('tblroom', Input::get('id'), array(
				'room' => Input::get('txtroom'),
				'description' => Input::get('txtroomdes')
			));	
			if($result){
				$log->insert($user->getData()->id, "Edit a room info.");
				echo "success";
			}
		}catch(Exception $e) {
			die($e->getMessage());
		}
	}
	if(Input::get('data')=='delete'){
		$result = $db->delete('tblroom', array('id', '=', Input::get('id')));
		if($result){
				$log->insert($user->getData()->id, "Delete a room info.");
			echo "success";
		}
	}
}


