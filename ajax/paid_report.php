<?php 
	require_once '../core/init.php';

if(Input::exists('get')){
	$db = DB::getInstance();
	if(Input::get('data')=='get'){
		try{
			$class = $db->query("SELECT * FROM v_paid_report ". Input::get('sql'));
			if($class->count()){
				foreach($class->getResults() as $sta){  
					
					$staffOut[] = array($sta->st_paid ,'$ ' . $sta->total_paid, $sta->lv, $sta->breach_name);
				}
				echo json_encode($staffOut);
			}
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
}


