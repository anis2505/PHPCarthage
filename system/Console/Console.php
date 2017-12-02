#! /usr/bin/env php

<?php
require_once '../../bootstrap.php';

//print "BASE_PATH ".BASE_PATH;

if($argc==1)
{
    include 'ConsoleHelp.php';
    exit;
}

print "\n$argc arguments were passed. In order: \n";
for ($i = 0; $i <= $argc -1; ++$i)
{
    print "$i: $argv[$i]\n";
}


//namespace Darwin\Console;



class Console
{

    public static function hello()
    {
        print "Hello World";
    }

}

Console::hello();
