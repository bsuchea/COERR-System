<?php 
	require_once '../core/init.php';

if(Input::exists('get')){
	$db = DB::getInstance();
	if(Input::get('data')=='get'){
		try{
			$class = $db->query('SELECT tblclass.id, tblstaff.`name` staff_name, tbllevel.lv, tblroom.room, tbltime.time, tbltime.type, tblclass.description FROM tblclass INNER JOIN tblroom ON tblclass.room_id = tblroom.id INNER JOIN tbllevel ON tblclass.level_id = tbllevel.id INNER JOIN tbltime ON tblclass.time_id = tbltime.id INNER JOIN tblstaff ON tblclass.staff_id = tblstaff.id WHERE semester_id='.Input::get("semester").' AND breach_id='.Input::get("breach"));
			if($class->count()){
				foreach($class->getResults() as $sta){  
					
					$staffOut[] = array($sta->id ,$sta->staff_name, $sta->lv, $sta->room, $sta->time .' ('. $sta->type.')', $sta->description);
				}
				echo json_encode($staffOut);
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
}


