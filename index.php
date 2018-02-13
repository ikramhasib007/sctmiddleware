<?php

	/**
	* 
	*/
	require 'SCTMiddleware.php';

	$con = mysqli_connect('localhost', 'root','', 'rawphp');
	if(!$con)
		die('Connection error. '.mysqli_errno());

	$sql = 'SELECT * FROM t_tpm_data GROUP BY(masch_id) LIMIT 20';
	$result = mysqli_query($con, $sql);
	$rows = [];
        $i = 1;
	while ($r = mysqli_fetch_assoc($result)) {
            $j = 0;
            $k = 0;
            $l = 0;
            $m = 0;
            if(!($i%2==0)){
                $rows[$i] = $r; 
            } else{
                $rows[$i-1]['mydata'][$j] = $r; 
                $rows[$i-1]['mydata'][$j+1] = $r;
                if($i>1 && $i<7){
                    $rows[$i-1]['mydata'][$j+1]['newarray'][$k] = $r;
                    $rows[$i-1]['mydata'][$j+1]['newarray'][$k+1] = $r;
                }
//                if($i>1 && $i<7){
//                    $rows[$i-1]['mydata'][$j+1]['newarray'][$k]['fourth_array'][$l] = $r;
//                    $rows[$i-1]['mydata'][$j+1]['newarray'][$k]['fourth_array'][$l+1] = $r;
//                    $rows[$i-1]['mydata'][$j+1]['newarray'][$k+1]['fourth_array'][$l] = $r;
//                    $rows[$i-1]['mydata'][$j+1]['newarray'][$k+1]['fourth_array'][$l+1] = $r;
//                }
//                if($i>1 && $i<7){
//                    $rows[$i-1]['mydata'][$j+1]['newarray'][$k]['fourth_array'][$l]['fifth_array'][$m] = $r;
//                    $rows[$i-1]['mydata'][$j+1]['newarray'][$k]['fourth_array'][$l+1]['fifth_array'][$m+1] = $r;
//                    $rows[$i-1]['mydata'][$j+1]['newarray'][$k+1]['fourth_array'][$l]['fifth_array'][$m] = $r;
//                    $rows[$i-1]['mydata'][$j+1]['newarray'][$k+1]['fourth_array'][$l+1]['fifth_array'][$m+1] = $r;
//                }
            }
            $i++;
	}
        //file_put_contents('sampledata/array_5.php', json_encode($rows));
        
        
        //$rows = json_decode(file_get_contents('sampledata/array_1.php'),TRUE);
        
        /* Now array is third depth array */
        
//        echo '<pre>';
//        print_r($rows);
//        exit();
	
	$obj = new SCTMiddleware;
        $arr = [
            'uid'=>'serial',
            'task_id'=>'task_serial',
            'masch_id'=>'masch_id',
            'week_year'=>'week_number',
            'date'=>'updated_date',
            'mydata' => array(
                'is_active'=> 'satus',
                'input_value'=> 'value',
                'masch_id'=>'machine_number',
                'task_id'=>'task_id',
            )
        ];
        
//	$obj->setKey('uid','serial');
//	$obj->setKey('masch_id','machine_number');
//	$obj->setKey('week_year','week_number');
//	$obj->setKey('date','updated_date');
//	
        $obj->setKeys($arr);
        
        $obj->process($rows);
        //$obj->reprocess($obj->response(), TRUE);
//        exit();
	//$obj->setKeys();

	echo "<pre>";
	print_r($obj->response());
	exit();