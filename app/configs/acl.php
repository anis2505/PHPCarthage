<?php
/**
 * Created by PhpStorm.
 * User: anis
 * Date: 7/27/15
 * Time: 11:17 PM
 */
// 'group' =>['parent', 'uri1', 'uri2', ...]
return
    [
    'anonymous' => [null,'/'],
    'user'      => ['anonymous','account/'],
    'admin'     => ['user','account/','admin/']
    ];