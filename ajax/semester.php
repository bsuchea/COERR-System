<?php 
	require_once '../core/init.php';

$user = new User;
$log = new Log;

if(Input::exists('get')){
	$db = DB::getInstance();
	if(Input::get('data')=='get'){
		try{
			$option = '';
			$semester = $db->query('select * from tblsemester');
			if($semester->count()){
				foreach($semester->getResults() as $tm){
					if(!$user->hasPermission('user')){
						$option = '<a href="#" id="semester_'.$tm->id.'" class="btn btn-default btn-rounded btn-sm" onclick="editsemester('. $tm->id .');"><span class="fa fa-edit"></span></a>';
						if(!$user->hasPermission('editor')){
							$option .= '<a href="#" id="semester_'.$tm->id.'" class="btn btn-danger btn-rounded btn-sm" onclick="deletesemester('. $tm->id .');"><span class="fa fa-times"></span></a>';
						}
					}
					
					$semesterOut[] = array($tm->semester, $tm->year, $tm->description, $option);
				}
				echo json_encode($semesterOut);
			}
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}

	if(Input::get('data')=='add'){
		try{
			$result = $db->insert('tblsemester', array(
				'semester' => Input::get('txtsemester'),
				'year' => Input::get('txtyear'),
				'description' => Input::get('txtsemesterdes')
			));	
			if($result){
				$log->insert($user->getData()->id, "Insert a new semester info.");
				echo "success";
			}
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}

	if(Input::get('data')=='get-at'){
		$semester = $db->get('tblsemester', array('id', '=', Input::get('id')));
		$tm = $semester->first();
		$semesterOut[] = array($tm->semester, $tm->year, $tm->description,);
		echo json_encode($semesterOut);
	}

	if(Input::get('data')=='edit'){
		try{
			$result = $db->update('tblsemester', Input::get('id'), array(
				'semester' => Input::get('txtsemester'),
				'year' => Input::get('txtyear'),
				'description' => Input::get('txtsemesterdes')
			));	
			if($result){
				$log->insert($user->getData()->id, "Edit a semester info.");
				echo "success";
			}
		}catch(Exception $e) {
			die($e->getMessage());
		}
	}
	if(Input::get('data')=='delete'){
		$result = $db->delete('tblsemester', array('id', '=', Input::get('id')));
		if($result){
				$log->insert($user->getData()->id, "Delete a semester info.");
			echo "success";
		}
	}
}


