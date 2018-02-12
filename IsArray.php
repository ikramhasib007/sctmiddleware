<?php

/**
 * IsArray Class process array as arguments.
 * process
 * reprocess
 * return array 
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
        $array_depth = '';
        if (!$flag) {
            //** with all index **/
            if (!$this->array_assoc_keys($this->data)) {
                foreach ($this->data as $data_v) {
//            echo count($this->data);
//                echo '<pre>';
//                print_r($this->data);
//                echo '</pre>';
//                exit();
//                echo $this->array_depth($data_v);


                    if ($this->contains_array($data_v)) {
//                    $array_depth = $this->array_depth($data_v);
//                    foreach ($data_v as $arr_key => $value){
//                        if(is_array($value)){
//                            echo $arr_key;
//                            echo '<pre>';
//                            print_r($value);
////                            exit();
//                        }
//                    }
//                    echo $array_depth;
//                    echo '<pre>';
//                    print_r($data_v);
//                    exit();
//                    for($count = 2; $count < $array_depth; $count++){
//                        
//                    }
                        $array[] = $this->array_with_array_indexing($data_v, $keys);
                    } else {
                        $array[] = $this->array_with_all_index($data_v, $keys);
                    }
                }
            } else {
                //** non indexed array */
                if ($this->contains_array($this->data)) {
                    $array[] = $this->array_with_array_indexing($this->data, $keys);
                } else {
                    $array[] = $this->array_with_all_index($this->data, $keys);
                }
            }
        } else {
            //** without old index, only new index **/
            if (!$this->array_assoc_keys($this->data)) {
                foreach ($this->data as $data_v) {
                    if ($this->contains_array($data_v)) {
                        $array[] = $this->array_with_array_new_indexing($data_v, $keys);
                    } else {
                        $array[] = $this->array_with_new_index($data_v, $keys);
                    }
                }
            } else {
                //** non indexed array */
                if ($this->contains_array($this->data)) {
                    $array[] = $this->array_with_array_new_indexing($this->data, $keys);
                } else {
                    $array[] = $this->array_with_new_index($this->data, $keys);
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
//        echo '<pre>';
//        print_r($array);
//        exit();
        foreach ($arr as $o_key => $a) {
            if (is_array($a)) {
                if (array_key_exists(0, $a)) {
                    //** indexed array **/
                    $indexedArray = TRUE;
                    $numberOfIndexedArray = count($a);
                    $depthArray = $a;
                } else {
                    //** not index array. it's direct array **/
                    $depthArray = $a;
                }
                $old_key = $o_key;
            }
        }
        if ($this->contains_array($keys)) {
            foreach ($keys as $n_key => $k) {
                if (is_array($k)) {
                    $new_key = $n_key;
                    $depthKey = $k;
                }
            }
        } else {
            $new_key = $old_key;
            $depthKey = $keys;
        }
        if ($indexedArray) {
            foreach ($depthArray as $d_key => $depthA) {
                //** iteration of all indexed array **/
                $secondArray[$d_key] = $this->array_with_all_index($depthA, $depthKey);
            }
        } else {
            //** iteration of associative array **/
            $secondArray = $this->array_with_all_index($depthArray, $depthKey);
        }
        if ($old_key == $new_key) {
            $array[$new_key] = $secondArray;
        } else {
//            if (array_key_exists($old_key, $array)) {
            $array = $this->replace_keys_with_array($old_key, $new_key, $array, $secondArray);
//                $array[$new_key] = $secondArray;
//                unset($array[$old_key]);
//            }
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
        foreach ($arr as $o_key => $a) {
            if (is_array($a)) {
                if (array_key_exists(0, $a)) {
                    //** indexed array **/
                    $indexedArray = TRUE;
                    $numberOfIndexedArray = count($a);
                    $depthArray = $a;
                } else {
                    //** not index array. it's direct array **/
                    $depthArray = $a;
                }
                $old_key = $o_key;
            }
        }
        if ($this->contains_array($keys)) {
            foreach ($keys as $n_key => $k) {
                if (is_array($k)) {
                    $new_key = $n_key;
                    $depthKey = $k;
                }
            }
        } else {
            $new_key = $old_key;
            $depthKey = $keys;
        }

        if ($indexedArray) {
            foreach ($depthArray as $d_key => $depthA) {
                //** iteration of all indexed array **/
                $secondArray[$d_key] = $this->array_with_new_index($depthA, $depthKey);
            }
        } else {
            //** iteration of associative array **/
            $secondArray = $this->array_with_new_index($depthArray, $depthKey);
        }
        if ($old_key == $new_key) {
            $array[$new_key] = $secondArray;
        } else {
            $array[$new_key] = $secondArray;
            unset($array[$old_key]);
        }
        return $array;
    }

    private function array_with_all_index(array $arr, $keys) {
        if (!$keys)
            return $arr;
        foreach ($keys as $old_key => $new_key) {
            if (is_array($new_key))
                break;
//            if (array_key_exists($old_key, $arr)) {
            $arr = $this->replace_keys($old_key, $new_key, $arr);
////                 $arr[$new_key] = &$arr[$old_key];
////                 if($old_key != $new_key)
////                    unset($arr[$old_key]);
//            }
        }
        return $arr;
    }

    private function array_with_new_index(array $arr, $keys) {
        $temp = array();
        if (!$keys)
            return $arr;
        foreach ($keys as $old_key => $new_key) {
            if (is_array($new_key))
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
        if ($keys) {
            $tempKey = array();
            $keyIndex = '';
            if ($this->contains_array($keys)) {
                foreach ($keys as $index => $key) {
                    if (is_array($key)) {
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
                if ($this->contains_array($data_v)) {
                    $array[] = $this->array_with_array_indexing($data_v, $keys);
                } else {
                    $array[] = $this->array_with_all_index($data_v, $keys);
                }
            }
        } else {
            // without old index
            foreach ($this->data as $data_v) {
                if ($this->contains_array($data_v)) {
                    $array[] = $this->array_with_array_new_indexing($data_v, $keys);
                } else {
                    $array[] = $this->array_with_new_index($data_v, $keys);
                }
            }
        }
        $this->data = $array;
        return $this->data;
    }

    private function contains_array($array) {
        foreach ($array as $value) {
            if (is_array($value)) {
                return true;
            }
        }
        return false;
    }

    private function replace_keys($oldKey, $newKey, array $input) {
        $return = array();
        foreach ($input as $key => $value) {
            if ($key === $oldKey)
                $key = $newKey;

//            if (is_array($value))
//                $value = replace_keys( $oldKey, $newKey, $value);

            $return[$key] = $value;
        }
        return $return;
    }

    private function replace_keys_with_array($oldKey, $newKey, array $input, array $replaced) {
        $return = array();
        foreach ($input as $key => $value) {
            if ($key === $oldKey) {
                $key = $newKey;
                $value = $replaced;
            }
//            if (is_array($value))
//                $value = replace_keys( $oldKey, $newKey, $value);

            $return[$key] = $value;
        }
        return $return;
    }

    private function array_depth(array $array) {
        $max_depth = 1;
        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = $this->array_depth($value) + 1;
                if ($depth > $max_depth) {
                    $max_depth = $depth;
                }
            }
        }
        return $max_depth;
    }
    
    private function array_assoc_keys(array $array) {
        return count(array_filter(array_keys($array), 'is_string')) > 0;
    }

    public function __toString() {
        return $this->data;
    }

}
