<?php 
	require_once '../core/init.php';

if(Input::exists('get')){
	$db = DB::getInstance();
	if(Input::get('data')=='get'){
		try{
            
			$class = $db->query("SELECT * FROM v_student_filter ". Input::get('sql'));
			if($class->count()){
				foreach($class->getResults() as $st){  					
					$student[] = array($st->st_name ,$st->gender, $st->phone, ($st->status=="")?'active':$st->status, $st->date, $st->lv, $st->staff_name, ($st->status!=="suspend")?"":'<span onclick="returnClass(' .$st->student_id . ')" class="label label-info" data-toggle="modal" data-target="#return_class" style="cursor: pointer;">Return</span>');
                    
				}
				echo json_encode($student);
            }
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
    
    if(Input::get('data')=='save'){
		try{
			$rs = $db->query('SELECT id FROM tblstudy WHERE class_id = '.Input::get('class').' and student_id = '.Input::get('student'));
            if($rs->count()){
                //update only status
                $q = $db->query("UPDATE tblstudy SET status='suspend' WHERE id=". $rs->first()->id);
                if($q){
                    $log->insert($user->getData()->id, "Return same class to suspend student.");
                    echo "saved";
                }
            }else{
            //get score and Attendent to the new term
                //insert new class
                $db->insert('tblstudy', array(
                    'class_id' => Input::get('class'),
                    'student_id' => Input::get('student')
                ));	
                $newStudyId = $db->getInsertedId();
                //get score
                $score = $db->query('SELECT * FROM tblscore WHERE study_id = '. $rs->first()->id);
                foreach($score->getResults() as $sc){
                    $db->insert('tblscore', array(
                        'study_id' => $newStudyId,
                        'asg' => $sc->asg,
                        'read_pro' => $sc->read_pro,
                        'speak' => $sc->speak,
                        'gram' => $sc->gram,
                        'listen' => $sc->listen,
                        'read' => $sc->read,
                        'write' => $sc->write,
                        'term' => $sc->term
                        )
                    );
                }
                //get attendent
                $atten = $db->query('SELECT * FROM tblattendent WHERE study_id = '. $rs->first()->id);
                foreach($score->getResults() as $at){
                    $db->insert('tblscore', array(
                        'study_id' => $newStudyId,
                        'status' => $at->status,
                        'le_time' => $at->le_time,
                        'date' => $at->date,
                        'reason' => $sc->reason
                        )
                    );
                }
                $log->insert($user->getData()->id, "Return new class to suspend student.");
                echo "saved";

            }

			
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}
    
}


