<?php 
class Hash {
    /**
     * 
     * @param string $string
     * @param string $salt
     * @return string
     */
    public static function make($string, $salt = ''){
        return hash('sha256', $string . $salt);
    }
    /**
     * 
     * @param int $length length of salt
     * @return string
     */
    public static function salt($length){
        return mcrypt_create_iv($length);	
    }
    /**
     * 
     * @return string hash value
     */
    public static function unique(){
        return self::make(uniqid());
    }
}
