<?php 
class Session {
    /**
     * 
     * @param string $name session name
     * @return boolen
     */
    public static function exists($name) {
        return (isset($_SESSION[$name])) ? true : false;
    }
    /**
     * 
     * @param string $name session name
     * @param string $value session value
     * @return obj session result
     */
    public static function set($name, $value) {
        return $_SESSION[$name] = $value;
    }
    /**
     * 
     * @param string $name session name
     * @return string session value
     */
    public static function get($name) {
        return $_SESSION[$name];
    }
    /**
     * 
     * @param string $name name of value
     */
    public static function delete($name) {
        if(self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }
    /**
     * 
     * @param string $name session name
     * @param string $string value of session send to ..
     * @return string session value
     */
    public static function flash($name, $string = '') {
        if(self::exists($name)) {
            $session = self::get($name);
            self::delete($name);
            return $session;
        }else {
            self::set($name, $string);
        }		
    }
}