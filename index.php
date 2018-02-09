<?php

	/**
	* 
	*/
	require 'SCTMiddleware.php';
        
        $rows = json_decode(file_get_contents('sampledata/array_1.php'),TRUE);
        
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

	echo "<pre>";
	print_r($obj->response());
	exit();