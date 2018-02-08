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
        foreach ($this->keys as $old_key => $new_key) {
            if (array_key_exists($old_key, $arr)) {
                $arr[$new_key] = $arr[$old_key];
                unset($arr[$old_key]);
            }
        }
        return $arr;
    }

    private function array_with_new_index(array $arr) {
        $temp = array();
        foreach ($this->keys as $old_key => $new_key) {
            if (array_key_exists($old_key, $arr)) {
                $temp[$new_key] = $arr[$old_key];
            }
        }
        return $temp;
    }

    public function decode_process($flag = false) {
        $array = array();
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
