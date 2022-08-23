<?php 
	require_once '../core/init.php';

$user = new User;
$log = new Log;

if(Input::exists('get')){
	$db = DB::getInstance();

	if(Input::get('data')=='save'){
		try{
			$sql = "INSERT INTO tblscore(study_id, asg, read_pro, speak, gram, listen, `read`, `write`, term) VALUES ";
			for($i=1;$i<=Input::get('txtrow');$i++){
				$sql .= "(". Input::get('study_'.$i).", ". Input::get('asg_'.$i).", ". Input::get('read_pro_'.$i).", ". Input::get('speak_'.$i).", ". Input::get('gram_'.$i) . ", ". Input::get('listen_'.$i) .", ". Input::get('read_'.$i) .", ".  Input::get('write_'.$i) .", ".  Input::get('txtterm'). ")";
				if($i<Input::get('txtrow')){
					$sql .= ", ";
					}
			}
			$sql .= " ON DUPLICATE KEY UPDATE asg=VALUES(asg), read_pro=VALUES(read_pro), speak=VALUES(speak), gram=VALUES(gram), listen=VALUES(listen), `read`=VALUES(`read`), `write`=VALUES(`write`)";

			if(!$db->query($sql)->error()){
				$log->insert($user->getData()->id, "Insert new score to student!");
				echo "saved";
			}
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}

	if(Input::get('data')=='get-at'){
		try{
			$score = $db->query('SELECT * FROM tblscore INNER JOIN tblstudy ON tblstudy.id=study_id WHERE class_id=? AND term=?', array(Input::get('class'), Input::get('term')));
			if($score->count()){
				foreach($score->getResults() as $s){
					$scoreOut[] = array($s->asg, $s->read_pro, $s->speak, $s->gram, $s->listen, $s->read, $s->write);
				}
				echo json_encode($scoreOut);
			}else{
				echo "no_record";
			}
		}catch(Exception $e) {
			echo $e->getMessage();
		}
		
		
	}

}


