<?php

/**
 * data class
 */
require 'IsObject.php';
require 'IsArray.php';

abstract class Middleware {

    protected $isArray;
    protected $isObject;
    protected $isNull;
    protected $response;
    protected $keys;
    protected $obj;
    protected $flag;

    //protected $response;

    public function __construct() {
        $this->isArray = false;
        $this->isObject = false;
        $this->isNull = false;
    }

    public function encode($agrs, $flag = false) {
        $this->argumentType($agrs);
        if ($this->isArray) {
            $this->obj = new IsArray($agrs);
            $this->obj->keys($this->keys);
            $this->response = $this->obj->encode_process($flag);
        }

        if ($this->isObject) {
            $this->obj = new IsObject($agrs);
        }
    }
    
    public function decode($agrs, $flag = false) {
        $this->argumentType($agrs);
        if ($this->isArray) {
            $this->obj = new IsArray($agrs);
            $this->obj->keys($this->keys);
            $this->response = $this->obj->decode_process($flag);
        }

        if ($this->isObject) {
            $this->obj = new IsObject($agrs);
        }
    }

    public function keys($keys) {
        $this->keys = $keys;
    }

    public function response() {
        return $this->response;
    }

    private function argumentType($agrs) {
        if (is_array($agrs)) {
            $this->isArray = true;
        }
        if (is_object($agrs)) {
            $this->isObject = true;
        }
        if (is_null($agrs)) {
            $this->isNull = true;
        }
    }

    public function __destruct() {
        $this->isArray = false;
        $this->isObject = false;
        $this->isNull = false;
    }

}
