<?php 
class User {
    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn;

    public function __construct($user = null) {
        $this->_db = DB::getInstance();

        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if(!$user) {
            if(Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName) ;

                if($this->find($user)) {
                    $this->_isLoggedIn = true;
                }else {
                    $this->logout();
                }
            }
        }else {
            $this->find($user);
        }
    }
    /**
     * 
     * @param array $fields fields name of table as key of array
     * @param int $id id of table 
     * @throws Exception
     */
    public function update($fields = array(), $id = null) {

        if(!$id && $this->isLoggedIn()) {
            $id = $this->getData()->id;
        }

        if(!$this->_db->update('users', $id, $fields)) {
            throw new Exception('There was a proplem updating');
        }
    }
    /**
     * 
     * @param string $fields fields name of table as key of array
     * @throws Exception
     */
    public function create($fields = array()) {
        if(!$this->_db->insert('users', $fields)) {
            throw new Exception('There was a proplem creating an account.');
        }
    }
    /**
     * 
     * @param type $user
     * @return boolean
     */
    public function find($user = null) {

        if($user) {

            $field = (is_numeric($user)) ? 'id' : 'username' ;
            $data = $this->_db->get('v_users_detail', array($field, '=', $user));

            if($data->count()) {
                $this->_data = $data->first();
                return true;
            }

        }

    }
    /**
     * 
     * @param sting $username username 
     * @param string $password password
     * @param boolen $remember 
     * @return boolean
     */
    public function login($username = null, $password = null, $remember = false) {
        if(!$username && !$password && $this->exists()) {
            Session::set($this->_sessionName, $this->getData()->id) ;
        } else {

            $user = $this->find($username) ;
            
            if($user) {
                if($this->getData()->password === Hash::make($password, $this->getData()->salt)) {
                    Session::set($this->_sessionName, $this->getData()->id);
                    if($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->getData()->id));

                        if(!$hashCheck->count()) {
                            $this->_db->insert('users_session', array(
                                'user_id' => $this->getData()->id,
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::set($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));

                    }

                    return true;
                }
            }

        }

        return false;
    }
    /**
     * 
     * @param string $key key of permisstion
     * @return boolean
     */
    public function hasPermission($key) {
        $group = $this->_db->get('groups', array('id', '=', $this->getData()->group_id));

        if($group->count()) {
            $permission = json_decode($group->first()->permission, true);
            if(array_key_exists($key, $permission)){
                if($permission[$key] == true) {
                    return true;
                }
            }
        }

        return false;
    }
    /**
     * 
     * @return boolen
     */
    public function exists() {
        return (!empty($this->_data)) ? true : false;
    }
    /**
     * get logout of user
     */
    public function logout() {

        $this->_db->delete('users_session', array('user_id', '=', $this->getData()->id));

        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }
    /**
     * 
     * @return string get current data of user
     */
    public function getData() {
        return $this->_data;
    }
    /**
     * check login or not
     * @return boolen
     */
    public function isLoggedIn() {
        return $this->_isLoggedIn;
    }
}