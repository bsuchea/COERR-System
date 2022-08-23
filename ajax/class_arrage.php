<?php 
	require_once '../core/init.php';

$user = new User;
$log = new Log;

if(Input::exists('get')){
	$db = DB::getInstance();
	if(Input::get('data')=='get'){
		try{
			$class = $db->query('SELECT tblclass.id, tblstaff.`name` staff_name, tbllevel.lv, tblroom.room, tbltime.time, tbltime.type, tblclass.description FROM tblclass INNER JOIN tblroom ON tblclass.room_id = tblroom.id INNER JOIN tbllevel ON tblclass.level_id = tbllevel.id INNER JOIN tbltime ON tblclass.time_id = tbltime.id INNER JOIN tblstaff ON tblclass.staff_id = tblstaff.id WHERE semester_id='.Input::get("semester").' AND breach_id='.Input::get("breach"));
			if($class->count()){
				foreach($class->getResults() as $sta){  
					$showId = '<input type="radio" value="'.$sta->id.'" id="trow_'.$sta->id.'" class="classid" name="classid" onClick="setId('. $sta->id .');"/>';
					
					$staffOut[] = array($showId ,$sta->staff_name, $sta->lv, $sta->room, $sta->time .' ('. $sta->type.')', $sta->description);
				}
				echo json_encode($staffOut);
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}

	if(Input::get('data')=='add'){
		try{
			$result = $db->insert('tblclass', array(
				'semester_id' => Input::get('txtsemester'),
				'room_id' => Input::get('txtrm'),
				'staff_id' => Input::get('txtstaff'),
				'level_id' => Input::get('txtlv'),
				'time_id' => Input::get('txttime'),
				'breach_id' => Input::get('txtbreach'),
				'description' => Input::get('txtdescription')
			));	
			if($result){
				$log->insert($user->getData()->id, "Arrange a new class.");
				echo "success";
			}
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}

	if(Input::get('data')=='get-at'){
		$class = $db->get('tblclass', array('id', '=', Input::get('id')));
		$st = $class->first();
		$classOut[] = array($st->breach_id, $st->semester_id, $st->level_id, $st->room_id, $st->time_id, $st->staff_id, $st->description);
		echo json_encode($classOut);
	}

	if(Input::get('data')=='edit'){
		try{
			$result = $db->update('tblclass', Input::get('id'), array(
				'semester_id' => Input::get('txtsemester'),
				'room_id' => Input::get('txtrm'),
				'staff_id' => Input::get('txtstaff'),
				'level_id' => Input::get('txtlv'),
				'time_id' => Input::get('txttime'),
				'breach_id' => Input::get('txtbreach'),
				'description' => Input::get('txtdescription')
			));	
			if($result){
				$log->insert($user->getData()->id, "Edit a class info.");
				echo "success";
			}
		}catch(Exception $e) {
			die($e->getMessage());
		}
	}
	if(Input::get('data')=='delete'){
		$result = $db->delete('tblclass', array('id', '=', Input::get('id')));
		if($result){
				$log->insert($user->getData()->id, "Delete a class info.");
			echo "success";
		}
	}

	if(Input::get('data')=='check'){
		try{
			$cls = $db->query("SELECT id FROM tblclass WHERE semester_id = ? and breach_id = ? and room_id = ? and time_id = ? ", array(Input::get("txtsemester"), Input::get("txtbreach"), Input::get("txtrm"), Input::get("txttime")));
			if($cls->count()){
				echo 'busy';
			}else{
				echo 'no';
			}
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
}


