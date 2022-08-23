<?php 
class Log {
    private $_db,
            $_data;

    public function __construct() {

        $this->_db = DB::getInstance();

    }

    public function insert($userId, $action) {
        if(!$this->_db->insert('tbllog',array(
                'user_id' => $userId,
                'date' => date('Y-m-d H:i:s'),
                'action' => $action
            ) )) {
            throw new Exception('There was a proplem creating a log file.');
        }
    }

    public function getData() {

        $data = $this->_db->query("SELECT * FROM v_log");

        if($data->count()) {
            $this->_data = $data->getResults();
            return $this->_data;
        }

    }

}