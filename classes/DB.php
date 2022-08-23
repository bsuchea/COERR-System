<?php	
class DB{
    private static $_instance = null;
    private $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_count = 0;
    
    private function __construct(){
        try{
            $this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }	
    /**
     * 
     * @return Obj
     */
    public static function getInstance(){
        if(!isset(self::$_instance)){
            self::$_instance = new DB();
        }	
        return self::$_instance; 
    }
    /**
     * 
     * @param string $sql sql statement
     * @param array $params condition
     * @return \DB
     */
    public function query($sql, $params = array()){
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)){
            $x = 1;
            if(count($params)){
                foreach($params as $param){
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            if($this->_query->execute()){
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            }else{
                $this->_error = true;
            }

        }

        return $this;
    }
    /**
     * 
     * @param string $action action of query "SELECT" or "DELETE"
     * @param string $table table name
     * @param array $where condition
     * @return boolean|\DB
     */
    public function action($action, $table, $where = array()){
        if(count($where) === 3){
            $operators = array('=', '>', '<', '>=', '<=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} Where {$field} {$operator}  ?";

                if(!$this->query($sql,array($value))->error()){
                        return $this;
                }
            }
        }

        return false;
    }
    /**
     * 
     * @param string $table table name
     * @param array $where condition
     * @return string query result
     */
    public function get($table, $where){
        return $this->action("SELECT *", $table, $where);
    }
    /**
     * 
     * @param string $table table name
     * @param array $where condition
     * @return string query result
     */
    public function delete($table, $where){
        return $this->action("DELETE", $table, $where);
    }
    /**
     * 
     * @param table $table table name
     * @param array $fields field of table as Key of array 
     * @return boolean
     */
    public function insert($table, $fields=array()){
        $keys = array_keys($fields);
        $value = null;
        $x = 1; 

        foreach($fields as $field){
            $value .= '?';
            if($x < count($fields)){
                $value .= ', ';
            }
            $x++;
        }

        $sql = "INSERT INTO {$table} (`". implode('`, `', $keys)."`) VALUES ({$value}) ";

        if(!$this->query($sql, $fields)->error()){
            return true;
        }

        return false;
    }
    /**
     * 
     * @param string $table table name
     * @param int $id id of recorde
     * @param array $fields field of table as Key of array
     * @return boolean
     */
    public function update($table, $id, $fields){
        $set = '';
        $x = 1;

        foreach($fields as $name => $value){
            $set .= "{$name} = ?";
            if($x < count($fields)){
                $set .= ", ";
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

        if(!$this->query($sql, $fields)->error()){
            return true;
        }

        return false;
    }
    /**
     * 
     * @return string result of query
     */
    public function getResults(){
            return $this->_results; 
    }
    /**
     * 
     * @return string result first recorde
     */
    public function first(){
        return $this->getResults()[0];
    }
    /**
     * 
     * @return id of the last inserted row
     */
    public function getInsertedId(){
        return $this->_pdo->lastInsertId();
    }
    /**
     * 
     * @return boolen errors of query
     */
    public function error(){
        return $this->_error;
    }
    /**
     * 
     * @return int count of recorde
     */
    public function count(){
        return $this->_count;
    }

}