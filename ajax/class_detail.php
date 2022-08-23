<?php 
	require_once '../core/init.php';
	
$user = new User;
$log = new Log;

if(Input::exists('get')){
	$db = DB::getInstance();
	
	//autocomplet class
	if(Input::get('data')=='getCls'){
		$class = $db->query('SELECT tblclass.id, tblstaff.`name` staff_name, tblroom.room, tbltime.time, tbltime.type FROM tblclass INNER JOIN tblroom ON tblclass.room_id = tblroom.id INNER JOIN tbltime ON tblclass.time_id = tbltime.id INNER JOIN tblstaff ON tblclass.staff_id = tblstaff.id WHERE semester_id=? AND breach_id=? AND level_id=?', array(Input::get("semester"), Input::get("breach"), Input::get('lv')));
		$clsJson = '';
		if($class->count()){
			foreach($class->getResults() as $cls){
				$clsJson[] = array("value" => $cls->id, "label" => $cls->time .' ('. $cls->type.')', "desc" => $cls->staff_name  .' - '. $cls->room );
			}
			echo json_encode($clsJson);
		}else{
			echo "no_class";
		}
	}

	// return breach id
	if(Input::get('data')=='getBrId'){
		$price = $db->query("SELECT breach_id, semester_id, level_id FROM tblclass where id = ?", array(Input::get('class')));
		if($price->count()){
			$out[] = $price->first()->breach_id;
			$out[] = $price->first()->semester_id;
			$out[] = $price->first()->level_id;
			echo json_encode($out);
		}
	}

	if(Input::get('data')=='save'){
		try{
			$q = $db->update("tblstudy", Input::get('study'), array(
					'class_id' => Input::get('class_id')
				));

			if($q){
				$log->insert($user->getData()->id, "Change class to student.");
				echo "saved";
			}
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}
    
    if(Input::get('data')=='suspend'){
		try{
			$q = $db->query("UPDATE tblstudy SET status='suspend' WHERE status IS NULL AND id=". Input::get('study'));

			if($q){
				$log->insert($user->getData()->id, "Set suspend class to student.");
				echo "saved";
			}
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}
}
