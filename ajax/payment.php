<?php 
	require_once '../core/init.php';

$user = new User;
$log = new Log;

if(Input::exists('get')){
	$db = DB::getInstance();
	if(Input::get('data')=='get'){
		try{
			$payHis = $db->query("SELECT * FROM v_pay_history WHERE semester_id = ? AND breach_id = ?", array(Input::get("semester"), Input::get("breach")));
			if($payHis->count()){
				foreach($payHis->getResults() as $sta){ 
					$option = '<a href="#" id="trow'.$sta->id .'" data-toggle="modal" class="btn btn-primary btn-sm" onClick="print('. $sta->id. ')"><span class="fa fa-print"></span></a>'; 
                    if($user->hasPermission('admin') or $user->hasPermission('moderator')){
                    	$option .= '<a href="#" id="trow'.$sta->id .'" class="btn btn-danger btn-sm" onClick="del('. $sta->id.')"><span class="fa fa-times"></span></a>';
                    }
					
					$staffOut[] = array($sta->id ,$sta->date, $sta->lv.' - '. $sta->room.' - '.$sta->time .' ('. $sta->type.')', $sta->name, $sta->pay_amount, $sta->staff_name, $option);
				}
				echo json_encode($staffOut);
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}

	//autocomplet class
	if(Input::get('data')=='getCls'){
		$class = $db->query("SELECT tblclass.id, tblstaff.`name` staff_name, tbllevel.lv, tblroom.room, tbltime.time, tbltime.type FROM tblclass INNER JOIN tblroom ON tblclass.room_id = tblroom.id INNER JOIN tbllevel ON tblclass.level_id = tbllevel.id INNER JOIN tbltime ON tblclass.time_id = tbltime.id INNER JOIN tblstaff ON tblclass.staff_id = tblstaff.id WHERE semester_id=".Input::get("semester")." AND breach_id=".Input::get("breach"));
		$clsJson = '';
		if($class->count()){
			foreach($class->getResults() as $cls){
				$clsJson[] = array("value" => $cls->id, "label" => $cls->lv, "desc" => $cls->staff_name  .' - '. $cls->room .' - '. $cls->time .' ('. $cls->type.')') ;
			}
			echo json_encode($clsJson);
		}
	}

	// autoComplete student
	if(Input::get('data')=='getSt'){
		$studnet = $db->query('SELECT * FROM tblstudent');
		$toJson = '';
		if($studnet->count()){
			foreach($studnet->getResults() as $st){
				$toJson[] = array("value" => $st->id, "label" => $st->name, "desc" => $st->status .' - '.$st->dob .' - '.$st->phone .' - '. $st->job );
			}
			//file_put_contents('auto_student.json', json_encode($toJson));
			echo json_encode($toJson);
		}
	}

	// get lv price
	if(Input::get('data')=='getPrice'){
		$price = $db->query('SELECT lv_price FROM tblclass INNER JOIN tbllevel on tbllevel.id = level_id WHERE tblclass.id = ?', array(Input::get('class')));
		$toJson = '';
		if($price->count()){
			echo $price->first()->lv_price;
		}
	}

	if(Input::get('data')=='add'){
		try{
			$result = $db->insert('tblstudy', array(
				'class_id' => Input::get('class_id'),
				'student_id' => Input::get('student_id')
			));	

			if($result){
				$studyId = $db->getInsertedId();
				$res = $db->insert('tblpayment', array(
					'study_id' => $studyId,
					'user_id' => $user->getData()->id,
					'pay_amount' => Input::get('txtprice'),
					'date' => date('Y-m-d h:i:s'),
					'discount' => Input::get('txtdiscount')
				));
				echo $db->getInsertedId();
				$log->insert($user->getData()->id, "Insert a new payment for a student");
                $db->update('tblstudent', Input::get('student_id'), array(
                    'status' => 'active'
                ));
			}
			
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}


	if(Input::get('data')=='print'){
		try{
			$printdata = $db->query("SELECT * FROM v_pay_history WHERE id = ?", array(Input::get("id")));
			if($printdata->count()){
				$sta = $printdata->first();		
					$date = date_format(date_create($sta->date), 'F jS, Y')	;		
					$out = array($sta->id, $date, $sta->lv.' - '. $sta->room.' - '.$sta->time .' ('. $sta->type.')', $sta->name, $sta->pay_amount, $sta->staff_name);
				echo json_encode($out);
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}


	if(Input::get('data')=='delete'){
		try{
			$q = $db->query("SELECT study_id FROM tblpayment WHERE id=?", array(Input::get('id')));
			$study_id = $q->first()->study_id;
			$result = $db->delete('tblpayment', array('id', '=', Input::get('id')));
			$log->insert($user->getData()->id, "Delete a payment");
			if($result){
				$res = $db->delete('tblstudy', array('id', '=', $study_id));
				echo $study_id;
			}
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}

	if(Input::get('data')=='check'){
		try{
			$cls = $db->query("SELECT tblstudy.id FROM tblclass INNER JOIN tblstudy ON tblstudy.class_id = tblclass.id WHERE semester_id = ? and tblstudy.student_id = ? ", array(Input::get("choose_semester"), Input::get("student_id")));
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


