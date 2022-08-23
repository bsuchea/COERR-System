<?php 

require_once '../core/init.php';

 $user = new User;
 $log = new Log;
 $db = DB::getInstance();


	if(Input::get('data')=='add'){
		try{
			$result = $db->insert('tblstudent', array(
				'name' => Input::get('txtname'),
				'gender' => Input::get('txtgender'),
				'job' => Input::get('txtjob'),
				'phone' => Input::get('txtphone'),
				'dob' => Input::get('txtdob'),
				'status' => Input::get('txtstatus'),
				'h' => Input::get('txthouse'),
				'g' => Input::get('txtgroup'),
				'v' => Input::get('txtvillage'),
				'c' => Input::get('txtcommune'),
				'd' => Input::get('txtdistrict'),
				'p' => Input::get('txtprovince'),
				'joined' => date('Y-m-d')
            ));	
			if($result){
				echo $db->getInsertedId();
				$log->insert($user->getData()->id, "Insert a new student.");
			}
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}

    if(Input::get('data')=='get-at'){
		$student = $db->get('tblstudent', array('id', '=', Input::get('id')));
		$st = $student->first();
		$studentOut[] = array($st->name, $st->gender, $st->job, $st->phone, $st->dob, $st->status, $st->h, $st->g, $st->v, $st->c, $st->d, $st->p);
		echo json_encode($studentOut);
	}

	if(Input::get('data')=='edit'){
		try{
			$result = $db->update('tblstudent', Input::get('id'), array(
				'name' => Input::get('txtname'),
				'gender' => Input::get('txtgender'),
				'job' => Input::get('txtjob'),
				'phone' => Input::get('txtphone'),
				'dob' => Input::get('txtdob'),
				'status' => Input::get('txtstatus'),
				'h' => Input::get('txthouse'),
				'g' => Input::get('txtgroup'),
				'v' => Input::get('txtvillage'),
				'c' => Input::get('txtcommune'),
				'd' => Input::get('txtdistrict'),
				'p' => Input::get('txtprovince')
			));	
            print_r($result) ;
			if($result){
				$log->insert($user->getData()->id, "edit a student info.");
				echo "success";
			}
		}catch(Exception $e) {
			die($e->getMessage());
		}
	}
	
	if(Input::get('data')=='delete'){
		$result = $db->delete('tblstudent', array('id', '=', Input::get('id')));
		if($result){
				$log->insert($user->getData()->id, "Delete a student info.");
			echo "success";
		}
	}

