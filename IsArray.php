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

    public function processed($flag = false) {
        $array = array();
        $keys = $this->keys;
        if (!$flag) {
            // with all index
            foreach ($this->data as $data_v) {
                if($this->contains_array($data_v)){
                    $array[] = $this->array_with_array_indexing($data_v, $keys);
                } else {
                    $array[] = $this->array_with_all_index($data_v, $keys);
                }
            }
        } else {
            // without old index
            foreach ($this->data as $data_v) {
                if($this->contains_array($data_v)){
                    $array[] = $this->array_with_array_new_indexing($data_v, $keys);
                } else {
                    $array[] = $this->array_with_new_index($data_v, $keys);
                }
            }
        }
        $this->data = $array;
        return $this->data;
    }
    private function array_with_array_indexing(array $arr, $keys) {
        $depthKey = '';
        $depthArray = '';
        $new_key = '';
        $old_key = '';
        $indexedArray = FALSE;
        $numberOfIndexedArray = '';
        $array = $this->array_with_all_index($arr, $keys);
        foreach ($arr as $o_key => $a){
            if(is_array($a)){
                if(array_key_exists(0, $a)){
                    // indexed array
                    $indexedArray = TRUE;
                    $numberOfIndexedArray = count($a);
                    $depthArray = $a;
                } else {
                    //not index array. it's direct array
                    $depthArray = $a;
                }
                $old_key = $o_key;
            }
        }
        if($this->contains_array($keys)){
            foreach ($keys as $n_key => $k){
                if(is_array($k)){
                    $new_key = $n_key;
                    $depthKey = $k;
                }
            }
        } else {
            $new_key = $old_key;
            $depthKey = $keys;
        }
        if($indexedArray){
            foreach ($depthArray as $d_key => $depthA){
                // iteration of all indexed array
                $secondArray[$d_key] = $this->array_with_all_index($depthA, $depthKey);
            }
        } else {
            // iteration of associative array
            $secondArray = $this->array_with_all_index($depthArray, $depthKey);
        }
        if($old_key == $new_key){
            $array[$new_key] = $secondArray;
        } else {
            if (array_key_exists($old_key, $array)) {
                $array[$new_key] = $secondArray;
                unset($array[$old_key]);
            }
        }
        return $array;
    }
    private function array_with_array_new_indexing(array $arr, $keys) {
        $depthKey = '';
        $depthArray = '';
        $new_key = '';
        $old_key = '';
        $indexedArray = FALSE;
        $numberOfIndexedArray = '';
        $array = $this->array_with_new_index($arr, $keys);
        foreach ($arr as $o_key => $a){
            if(is_array($a)){
                if(array_key_exists(0, $a)){
                    // indexed array
                    $indexedArray = TRUE;
                    $numberOfIndexedArray = count($a);
                    $depthArray = $a;
                } else {
                    //not index array. it's direct array
                    $depthArray = $a;
                }
                $old_key = $o_key;
            }
        }
        if($this->contains_array($keys)){
            foreach ($keys as $n_key => $k){
                if(is_array($k)){
                    $new_key = $n_key;
                    $depthKey = $k;
                }
            }
        } else {
            $new_key = $old_key;
            $depthKey = $keys;
        }
        
        if($indexedArray){
            foreach ($depthArray as $d_key => $depthA){
                // iteration of all indexed array
                $secondArray[$d_key] = $this->array_with_new_index($depthA, $depthKey);
            }
        } else {
            // iteration of associative array
            $secondArray = $this->array_with_new_index($depthArray, $depthKey);
        }
        if($old_key == $new_key){
            $array[$new_key] = $secondArray;
        } else {
//            if (array_key_exists($old_key, $array)) {
                $array[$new_key] = $secondArray;
                unset($array[$old_key]);
//            }
        }
        return $array;
    }

    private function array_with_all_index(array $arr, $keys) {
        if(!$keys)
            return $arr;
         foreach ($keys as $old_key => $new_key) {
             if(is_array($new_key))
                 break;
             if (array_key_exists($old_key, $arr)) {
                 $arr[$new_key] = $arr[$old_key];
                 if($old_key != $new_key)
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
            if(is_array($new_key))
                 break;
            if (array_key_exists($old_key, $arr)) {
                $temp[$new_key] = $arr[$old_key];
            }
        }
        return $temp;
    }

    public function reprocessed($flag = false) {
        $array = array();
        $keys = $this->keys;
        if($keys){
            $tempKey = array();
            $keyIndex = '';
            if($this->contains_array($keys)){
                foreach ($keys as $index => $key){
                    if(is_array($key)){
                        $tempKey = array_flip($key);
                        $keyIndex = $index;
                    }
                }
                error_reporting(E_ALL ^ E_WARNING);
                $keys = array_flip($keys);
                $keys[$keyIndex] = $tempKey;
            } else {
                $keys = array_flip($keys);
            }
        }
        if (!$flag) {
            // with all index
            foreach ($this->data as $data_v) {
                if($this->contains_array($data_v)){
                    $array[] = $this->array_with_array_indexing($data_v, $keys);
                } else {
                    $array[] = $this->array_with_all_index($data_v, $keys);
                }
            }
        } else {
            // without old index
            foreach ($this->data as $data_v) {
                if($this->contains_array($data_v)){
                    $array[] = $this->array_with_array_new_indexing($data_v, $keys);
                } else {
                    $array[] = $this->array_with_new_index($data_v, $keys);
                }
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
