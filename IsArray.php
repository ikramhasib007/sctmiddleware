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
        if (!$flag) {
            // with old index
            foreach ($this->data as $data_v) {
                $array[] = $this->array_with_all_index($data_v);
            }
        } else {
            // without old index
            foreach ($this->data as $data_v) {
                $array[] = $this->array_with_new_index($data_v);
            }
        }
        $this->data = $array;
        return $this->data;
    }

    private function array_with_all_index(array $arr) {
        if(!$this->keys)
            return $arr;
        foreach ($this->keys as $old_key => $new_key) {
            //echo 'Old key: '.$old_key.' New key: '.print_r($new_key, true).'<br>';
            if(is_array($new_key)){
//                echo '<pre>';
//                var_dump($new_key);
                //$depthArr = array();
                foreach ($arr as $arr_key => $arr_value){
                    if(is_array($arr_value)){
                        echo '<pre>';
                        print_r($arr_value);
                        echo '</pre>';
                        foreach ($new_key as $key => $value) {
                            echo 'Old key: '.$key.' New key: '.print_r($value, true).'<br>';
                            if (array_key_exists($key, $arr_value)) {
                                $arr_value[$key] = $arr_value[$value];
                                unset($arr_value[$value]);
                            }
                        }
                    }
                }
                $arr[$old_key] = $new_key;
                echo '<pre>';
                var_dump($arr);
                echo '</pre>';
                //unset($arr[$old_key]);
                //echo 'I m array. ok!! ';
            } else {
                if (array_key_exists($old_key, $arr)) {
                    $arr[$new_key] = $arr[$old_key];
                    unset($arr[$old_key]);
                }
            }
            
        }
        return $arr;
    }

    private function array_with_new_index(array $arr) {
        $temp = array();
        if(!$this->keys)
            return $arr;
        foreach ($this->keys as $old_key => $new_key) {
            if (array_key_exists($old_key, $arr)) {
                $temp[$new_key] = $arr[$old_key];
            }
        }
        return $temp;
    }

    public function decode_process($flag = false) {
        $array = array();
        if($this->keys)
            $this->keys = array_flip($this->keys);
        if (!$flag) {
            // with old index
            foreach ($this->data as $data_v) {
                $array[] = $this->array_with_all_index($data_v);
            }
        } else {
            // without old index
            foreach ($this->data as $data_v) {
                $array[] = $this->array_with_new_index($data_v);
            }
        }
        $this->data = $array;
        return $this->data;
    }

    public function __toString() {
        return $this->data;
    }

}
