<?php

/**
 * 
 */
class IsArray extends Middleware {

    protected $data;
    protected $keys;

    function __construct(array $middleware) {
        parent::__construct();
        $this->data = $middleware;
    }

    public function keys($keys) {
        if ($keys) {
            $this->keys = $keys;
        }
    }

    public function encode_process($flag = false) {
        $array = array();
        $i = 0;
        if (!$flag) {
            // with old index
            foreach ($this->data as $data_v) {
                foreach ($this->keys as $old_key => $new_key) {
                    if (array_key_exists($old_key, $data_v)) {
                        $data_v[$new_key] = $data_v[$old_key];
                        unset($data_v[$old_key]);
                    }
                }
                $array[] = $data_v;
            }
        } else {
            // without old index
            foreach ($this->data as $data_v) {
                foreach ($data_v as $key => $value) {
                    foreach ($this->keys as $old_key => $new_key) {
                        if ($old_key == $key) {
                            $array[$i][$new_key] = $value;
                        }
                    }
                }
                $i++;
            }
        }
        $this->data = $array;
        return $this->data;
    }
    
    public function decode_process($flag = false) {
        $array = array();
        $i = 0;
        $this->keys = array_flip($this->keys);
        if (!$flag) {
            // with old index
            foreach ($this->data as $data_v) {
                foreach ($this->keys as $old_key => $new_key) {
                    if (array_key_exists($old_key, $data_v)) {
                        $data_v[$new_key] = $data_v[$old_key];
                        unset($data_v[$old_key]);
                    }
                }
                $array[] = $data_v;
            }
        } else {
            // without old index
            foreach ($this->data as $data_v) {
                foreach ($this->keys as $old_key => $new_key) {
                    foreach ($data_v as $key => $value) {
                        if ($old_key == $key) {
                            $array[$i][$new_key] = $value;
                        }
                    }
                }
                $i++;
            }
        }
        $this->data = $array;
        return $this->data;
    }

    public function __toString() {
        return $this->data;
    }

}
