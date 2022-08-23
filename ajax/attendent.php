<?php 
	require_once '../core/init.php';

$user = new User;
$log = new Log;

if(Input::exists('get')){
	$db = DB::getInstance();

	if(Input::get('data')=='get'){
		$attendent = $db->query('SELECT * FROM v_atten_detail WHERE class_id='.Input::get('class_id'));
		if($attendent->count()){
			foreach($attendent->getResults() as $att){
				$option = '';
				if(!$user->hasPermission('user')){
					$option = '<a href="#" id="trow'.$att->id.'_'. $att->date .'" class="btn btn-danger btn-sm" onClick="del(\''. $att->id .'_'. $att->date.'\')"><span class="fa fa-times"></span></a>';
				}
				$attendentOut[] = array( $att->name, $att->status, $att->le_time, $att->date, $att->reason, $option);
			}
			echo json_encode($attendentOut);
		}
		
	}
	
	if(Input::get('data')=='save'){
		try{
			//process insert
			$sql = "INSERT INTO tblattendent(study_id, `status`, le_time, `date`, reason) VALUES ";
			$x = 0;
			for($i=1;$i<=Input::get('txtrow');$i++){
				if(Input::get('status_'.$i)){
					$x++;
				}
			}
			$e = 1;
			for($i=1;$i<=Input::get('txtrow');$i++){
				if(Input::get('status_'.$i)){
					$le_time = (Input::get('le_time_'.$i)==''?5:Input::get('le_time_'.$i));
					$sql .= "(". Input::get('study_'.$i).", ". Input::get('status_'.$i).", '". Input::get('le_time_'.$i) ."', '". Input::get('txtdate') ."', '". Input::get('reason_'.$i). "')";
					if($e<$x){
						$sql .= ", ";
					}
					$e++;
				}
			}

			$sql .= " ON DUPLICATE KEY UPDATE `status`=VALUES(`status`), le_time=VALUES(le_time), reason=VALUES(reason)";
			if(!$db->query($sql)->error()){
				$log->insert($user->getData()->id, "Insert new attendant to student.");
				echo "insert";
			}
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}

	if(Input::get('data')=='delete'){
		$result = $db->query("DELETE FROM tblattendent WHERE study_id= ? AND date=?", array(Input::get('study_id'), Input::get('date')));
		if($result){
			$log->insert($user->getData()->id, "Delete student attendant.");
			echo "deleted!";
		}
	}

}


