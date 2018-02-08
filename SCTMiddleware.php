<?php

/**
 * SCTMiddleware class
 * Develop by Ikram - Ud - Daula
 * Software Developer
 * SCT-Bangla Limited
 */
require 'Middleware.php';

class SCTMiddleware extends Middleware {
    
    protected $keys = [];

    public function setKey($key, $value) {
        $this->keys[$key] = $value;
        $this->keys($this->keys);
    }
    
    public function setKeys(array $args) {
        $this->keys($args);
    }

}
