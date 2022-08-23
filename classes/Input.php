<?php 
class Input {
    /**
     * 
     * @param string $type method of form
     * @return boolean
     */
    public static function exists($type = 'post') {
        switch($type){
            case 'post':
                return (!empty($_POST)) ? true : false;
                break;
            case 'get':
                return (!empty($_GET)) ? true : false;
                break;
            default:
                return false;
                break;
        }
    }
    /**
     * 
     * @param string $item name of control
     * @return string
     */
    public static function get($item){
        if(isset($_POST[$item])) {
            return trim($_POST[$item]);
        }else if(isset($_GET[$item])) {
            return trim($_GET[$item]);
        }
        return '';
    }
}

