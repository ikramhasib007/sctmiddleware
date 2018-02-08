<?php

	/**
	* 
	*/
	require 'SCTMiddleware.php';

	$con = mysqli_connect('localhost', 'root','', 'rawphp');
	if(!$con)
		die('Connection error. '.mysqli_errno());

	$sql = 'SELECT * FROM t_tpm_data LIMIT 10';
	$result = mysqli_query($con, $sql);
	$rows = [];
        $i = 1;
	while ($r = mysqli_fetch_assoc($result)) {
            if(!($i%2==0)){
                $rows[$i] = $r; 
            } else{
                $rows[$i-1]['mydata'] = $r; 
            }
            $i++;
	}
        
//        echo '<pre>';
//        print_r($rows);
//        exit();
	
	$obj = new SCTMiddleware;
        $arr = [
            'uid'=>'serial',
            'task_id'=>'task_serial',
//            'masch_id'=>'machine_number',
            'week_year'=>'week_number',
            'date'=>'updated_date',
            'mydata' => array(
                'is_active'=> 'satus',
                'input_value'=> 'value',
                'masch_id'=>'machine_number',
            )
        ];
        
//	$obj->setKey('uid','serial');
//	$obj->setKey('masch_id','machine_number');
//	$obj->setKey('week_year','week_number');
//	$obj->setKey('date','updated_date');
//	
        $obj->setKeys($arr);
        
        $obj->encode($rows);
        //$obj->decode($obj->response(), true);
//        exit();
	//$obj->setKeys();

	echo "<pre>";
	print_r($obj->response());
	exit();