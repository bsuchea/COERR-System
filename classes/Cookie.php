<?php 
class Cookie {
    /**
     * 
     * @param string $name 
     * @return boolen
     */
    public static function exists($name) {
        return (isset($_COOKIE[$name])) ? true : false;
    }
    /**
     * 
     * @param string $name cookie name
     * @return string cookie value
     */
    public static function get($name) {
        return $_COOKIE[$name];
    }
    /**
     * 
     * @param string $name cookie name
     * @param string $value cookie value
     * @param int $expiry time expiry
     * @return boolean
     */
    public static function set($name, $value, $expiry) {
        if(setcookie($name, $value, time() + $expiry, '/' )) {
            return true;
        }

        return false;
    }
    /**
     * 
     * @param string $name cookie name
     */
    public static function delete($name) {
        self::set($name, '', time() -1 );
    }
}
