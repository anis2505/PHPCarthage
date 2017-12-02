<?php

return [

	'base_url' 		=> 'localhost/~anis/personal',
	'index_name' 	=> 'index.php',

    
    /**
     * Routing settings
     * router_path: if your site is in a subdomain set it to the subdomain/path
     * example for domain.com/subdomain/path set it to subdomain/path
     * hard_routing_enabled: when true the app will try to manually load based on the router
     */
    'routing'=> [
	       'router_path'   => '/~anis/personal',
           'hard_routing_enabled' => true
    ],
    
	/**
	 * System timezone
	 */
    'timezone' =>  'Africa/Tunis',

    /**
     * Session settings
     */
	'session' => [

			'name'	  	            =>  'change_session_name',
	        'lifetime'            	=>	'3600',
			'save_path'             =>  '',
            'cookie_secure_mode'  	=>	0,//false,
            'cookie_httponly'     	=>	1,//false, // keep it true unless you want the cookie to be accessed via javascript NOT RECOMMENDED
    	    'cookie_path'         	=>	'/',
            'cookie_domain'       	=>	'',//localhost:80',///~anis/personal',
	        'handler' 	            =>  '\\System\\Libs\\Session\\DatabaseSessionHandler',
	        'handler_params'        =>  ['db_table' =>  'sessions']
	        /*
	        'handler'               =>  '\\System\\Libs\\Session\\EncryptedSessionHandler',
	        'handler_params'                =>[
	            'encryption_key' 		=>	'12345678912345678912345678912345',
	            'encryption_algorithm'	=>	'aes-256-ctr'
                ]
	        */

	],
    
    'localization' => [
        'enabled'               => true,
        'folder'                => 'locale',
        'session_key'           => 'lang',
        'default_lang'          => 'en',
        'encoding'              => 'UTF-8',
        'domain'                => 'messages',
        'locales'               => ['en' => 'en_US','fr' => 'fr_FR','ar' => 'ar_TN'],
        'handler'               =>'System\\Libs\\Localization\\GetTextLocalization'
        //'handler'               =>'System\\Libs\\Localization\\ArrayLocalization'
        
    ],
    
    'template' => [
        
        'templates_dir'     => 'views',
        'partials_dir'      =>'views.Partials',
        'layouts_dir'       =>'templates',
        'extension'         =>'php',
        'cache_enabled'     => false,
        'plugins'           => [
                            'System\\Libs\\Template\\Plugins\\Translate',
                            'System\\Libs\\Template\\Plugins\\Form',
                            'System\\Libs\\Template\\Plugins\\Asset',
                            'System\\Libs\\Template\\Plugins\\URL'
            ],
        'assets_folder' 	=>'' // For assets plugin
        
        
    ],
    
    /**
     *  Cache options
     *  cache_enabled : sets if cache should be enabled or not
     *  cache_folder  : sets where the cache files should be stored
     *  cache_time    : the cache files lifetime in seconds
     *  handler       : Custom Cache class used instead of the frameworks default cache class
     */
    'cache'   => [
        
        'cache_enabled' => false,
        
        'cache_time'    => 3600,
        'cache_folder'  =>'cache',  // Needed for File
        'hostname'	     =>'127.0.0.1',	// Needed for MemCached
        'port'		    =>'11211',		// Needed for MemCached
        
        'handler'       => 'File',// Supports APC, Memcached, File
        'handlers'      => [
                        'File'      =>'System\\Libs\\Cache\\FileCache',
                        'APC'       =>'System\\Libs\\Cache\\APCCache',
                        'Memcached' =>'System\\Libs\\Cache\\MemCachedCache',
            ],
        
    ],
    
    /**
     * Form Settings
     */
    'form' => [
        'csrf'  => [
            'lifetime'  => 900,//900 seconds
            'salt'      => 'change me'
        ]
    ],
    
    /**
     * UserManager settings
     *
     */
    'user' => [
        
        'entity'                        =>  'System\\Libs\\UserManager\\User',
        'table'                         =>  'users',
        'hash_algorithm'                =>  PASSWORD_BCRYPT,
        'salt'                          =>  'change me',
        'session_variable'              =>  'user',
        'cookie_name'                   =>  'user',
        'cookie_lifetime'               =>  '3600'
    ]


];

