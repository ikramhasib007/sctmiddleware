<?php

/**
 * 
 */
class IsArray {

    protected $data;
    protected $keys;

    function __construct(array $middleware) {
        $this->data = $middleware;
    }

    public function keys($keys) {
        if ($keys) {
            $this->keys = $keys;
        }
    }

    public function encode_process($flag = false) {
        $array = array();
        $keys = $this->keys;
        if (!$flag) {
            // with all index
            foreach ($this->data as $data_v) {
                $array[] = $this->array_with_all_index($data_v, $keys);
            }
        } else {
            // without old index
            foreach ($this->data as $data_v) {
                $array[] = $this->array_with_new_index($data_v, $keys);
            }
        }
        $this->data = $array;
        return $this->data;
    }

    private function array_with_all_index(array $arr, $keys) {
        if(!$keys)
            return $arr;
         foreach ($keys as $old_key => $new_key) {
             if (array_key_exists($old_key, $arr)) {
                 $arr[$new_key] = $arr[$old_key];
                 unset($arr[$old_key]);
             }
         }
         return $arr;
    }

    private function array_with_new_index(array $arr, $keys) {
        $temp = array();
        if(!$keys)
            return $arr;
        foreach ($keys as $old_key => $new_key) {
            if (array_key_exists($old_key, $arr)) {
                $temp[$new_key] = $arr[$old_key];
            }
        }
        return $temp;
    }

    public function decode_process($flag = false) {
        $array = array();
        $keys = $this->keys;
        if($keys){
            $keys = array_flip($keys);
        }
        if (!$flag) {
            // with all index
            foreach ($this->data as $data_v) {
                $array[] = $this->array_with_all_index($data_v, $keys);
            }
        } else {
            // without old index
            foreach ($this->data as $data_v) {
                $array[] = $this->array_with_new_index($data_v, $keys);
            }
        }
        $this->data = $array;
        return $this->data;
    }
    
    public function contains_array($array){
        foreach($array as $value){
            if(is_array($value)) {
              return true;
            }
        }
        return false;
    }

    public function __toString() {
        return $this->data;
    }

}
