<?php 
	require_once '../core/init.php';

$user = new User;
$log = new Log;

if(Input::exists('get')){
	$db = DB::getInstance();
	if(Input::get('data')=='get'){
		try{
			$option = '';
			$breach = $db->query('select * from tblbreach');
			if($breach->count()){
				foreach($breach->getResults() as $tm){
					if(!$user->hasPermission('user')){
						$option = '<a href="#" id="breach_'.$tm->id.'" class="btn btn-default btn-rounded btn-sm" onclick="editbreach('. $tm->id .');"><span class="fa fa-edit"></span></a>';
						if(!$user->hasPermission('editor')){
			                $option .= '<a href="#" id="breach_'.$tm->id.'" class="btn btn-danger btn-rounded btn-sm" onclick="deletebreach('. $tm->id .');"><span class="fa fa-times"></span></a>';
						}
					}
					$breachOut[] = array($tm->name, $tm->description, $option);
				}
				echo json_encode($breachOut);
			}
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}

	if(Input::get('data')=='add'){
		try{
			$result = $db->insert('tblbreach', array(
				'name' => Input::get('txtbreach'),
				'description' => Input::get('txtbreachdes')
			));	
			if($result){
				$log->insert($user->getData()->id, "Insert new breach.");
				echo "success";
			}
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}

	if(Input::get('data')=='get-at'){
		$breach = $db->get('tblbreach', array('id', '=', Input::get('id')));
		$tm = $breach->first();
		$breachOut[] = array($tm->name, $tm->description,);
		echo json_encode($breachOut);
	}

	if(Input::get('data')=='edit'){
		try{
			$result = $db->update('tblbreach', Input::get('id'), array(
				'name' => Input::get('txtbreach'),
				'description' => Input::get('txtbreachdes')
			));	
			if($result){
				$log->insert($user->getData()->id, "Edit breach info.");
				echo "success";
			}
		}catch(Exception $e) {
			die($e->getMessage());
		}
	}
	if(Input::get('data')=='delete'){
		$result = $db->delete('tblbreach', array('id', '=', Input::get('id')));
		if($result){
			$log->insert($user->getData()->id, "Delete a breach info.");
			echo "success";
		}
	}
}


