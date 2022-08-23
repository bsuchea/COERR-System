<?php 
	require_once '../core/init.php';
	
$user = new User;
$log = new Log;

if(Input::exists('get')){
	$db = DB::getInstance();
	
	if(Input::get('data')=='add'){
		try{
			$email = (Input::get('txtemail')=='')?'No email':Input::get('txtemail');
			$result = $db->insert('tblstaff', array(
				'name' => Input::get('txtname'),
				'gender' => Input::get('txtgender'),
				'function' => Input::get('txtposition'),
				'phone' => Input::get('txtphone'),
				'email' => $email,
                		'status' => Input::get('txtactive'),
                		'start' => date('Y-m-d'),
				'address' => Input::get('txtaddress')
			));	
			if($result){
				$log->insert($user->getData()->id, "Insert a new staff info.");
				echo "success";
			}
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}

	if(Input::get('data')=='get-at'){
		$staff = $db->get('tblstaff', array('id', '=', Input::get('id')));
		$st = $staff->first();
		$staffOut[] = array($st->name, $st->gender, $st->function, $st->phone, $st->email, $st->status, $st->address);
		echo json_encode($staffOut);
	}

	if(Input::get('data')=='edit'){
		try{
			$email = (Input::get('txtemail')=='')?'No email':Input::get('txtemail');
			$enddate = (Input::get('txtactive')=='stop')?date('Y-m-d'):'';
			$result = $db->update('tblstaff', Input::get('id'), array(
				'name' => Input::get('txtname'),
				'gender' => Input::get('txtgender'),
				'function' => Input::get('txtposition'),
				'phone' => Input::get('txtphone'),
				'email' => $email,
                		'status' => Input::get('txtactive'),
                		'end' => $enddate,
				'address' => Input::get('txtaddress')
			));	
			if($result){
				$log->insert($user->getData()->id, "Edit a staff info.");
				echo "success";
			}
		}catch(Exception $e) {
			die($e->getMessage());
		}
	}
	if(Input::get('data')=='delete'){
		$result = $db->delete('tblstaff', array('id', '=', Input::get('id')));
		if($result){
				$log->insert($user->getData()->id, "Delete a staff info.");
			echo "success";
		}
	}
}


