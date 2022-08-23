<?php
class Token {
    /**
     * 
     * @return strig velue of token
     */
    public static function generate() {
        return Session::set(Config::get('session/token_name'), md5(uniqid()));
    }
    /**
     * 
     * @param string $token token name
     * @return boolean
     */
    public static function check($token) {
        $tokenName = Config::get('session/token_name');

        if(Session::exists($tokenName) && $token === Session::get($tokenName)) {
            Session::delete($tokenName);
            return true;
        }

        return false;
    }
}