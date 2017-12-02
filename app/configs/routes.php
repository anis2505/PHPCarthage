<?php


/**
*	Routing parameters
*	Based on altorouter library( altorouter.com ]
*
*	@params (method, 'uri', 'namespace\\controller#action']
*	method(GET, PUT, POST, DELETE, PATCH]
*
*
*/

return [

    ['GET', '/', 'App.Controllers.Home', 'main'],
    ['GET', '/test/','App.Controllers.Home@test', 'test'],
    ['GET', '/home/[:id]/[*:name]', 'App.Controllers.Home@salute'],
    //['GET', '/home/[*:name]', 'App.Controllers.Home'],
	['GET', '/users/[i:id]', 'App.Controllers.Home@salute', 'salute'],
	['GET', '/get', 'App.Controllers.Home@get'],
    ['GET','/logout',function(){
        System\DIContainer::getInstance()->get('UserManager')->logUserOut();
        echo "Logged Out";
    }]

];
