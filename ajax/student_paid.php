<?php 
	require_once '../core/init.php';

if(Input::exists('get')){
	$db = DB::getInstance();
	if(Input::get('data')=='get'){
		try{
			$class = $db->query("SELECT * FROM v_student_paid ". Input::get('sql'));
			if($class->count()){
				foreach($class->getResults() as $sta){  
					
					$staffOut[] = array($sta->name ,$sta->gender, $sta->phone, $sta->dob, $sta->payment_id, $sta->date);
				}
				echo json_encode($staffOut);
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
}


