<?php

class Validate {
    private $_passed = false,
            $_errors = array(),
            $_db = null;

    public function __construct() {
        $this->_db = DB::getInstance();
    }
    /**
     * 
     * @param string $source method of form
     * @param array $items validate of form
     * @return \Validate
     */
    public function check($source, $items = array()) {
        foreach($items as $item => $rules) {
            foreach($rules as $rule => $rule_value) {

                $value = trim($source[$item]);

                if($rule === 'required' && empty($value)) {
                        $this->addError("{$item} is required");
                }else if(!empty($value)) {
                    switch($rule) {
                        case 'min':
                            if(strlen($value) < $rule_value) {
                                $this->addError("{$item} must be a minimum of {$rule_value} characters.");
                            }
                        break;
                        case 'max':
                            if(strlen($value) > $rule_value) {
                                $this->addError("{$item} must be a maximum of {$rule_value} characters.");
                            }
                        break;
                        case 'matches':
                            if($value != $source[$rule_value]) {
                                $this->addError("{$rule_value} must be matches {$item}.");
                            }
                        break;
                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if($check->count()) {
                                $this->addError("{$item} is already exists.");
                            }
                        break;
                    }
                }

            }
        }

        if(empty($this->_errors)) {
                $this->_passed = true;
        }

        return $this;
    } 
    /**
     * 
     * @param string $error adding errors to validation
     */
    private function addError($error) {
            $this->_errors[] = $error;
    }
    /**
     * 
     * @return string validation result
     */
    public function getErrors() {
            return $this->_errors;
    }
    /**
     * 
     * @return boolen 
     */
    public function passed() {
        return $this->_passed;
    }
}