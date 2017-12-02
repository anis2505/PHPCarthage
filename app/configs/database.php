<?php

return [
    
    'dev'=> [
        
        'driver'=>'mysql',
        'mysql'=>[
            'hostname' => 'localhost',
            'port'	   => '',
            'username' => 'root',
            'password' => '',
            'database' => 'carthage_dev_db',
            'dbprefix' => '',
            'charset' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
        ],
        
    ],
    
    'prod'=> [
        
        'driver'=>'mysql',
        'mysql'=>[
            'hostname' => 'localhost',
            'port'	   => '',
            'username' => 'root',
            'password' => '',
            'database' => 'carthage_prod_db',
            'dbprefix' => '',
            'charset' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
        ],
        
    ],
    
    'test'=> [
        
        'driver'=>'mysql',
        'mysql'=>[
            'hostname' => 'localhost',
            'port'	   => '',
            'username' => 'root',
            'password' => '',
            'database' => 'carthag_test_db',
            'dbprefix' => '',
            'charset' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
        ],
        
    ]

	

];
