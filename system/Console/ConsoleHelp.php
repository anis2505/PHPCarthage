<?php
/**
 * Created by PhpStorm.
 * User: anis
 * Date: 8/4/15
 * Time: 4:45 PM
 */

include 'Classes'.DS.'CliColor.php';

$colors = new Colors();

print $colors->getColoredString("    \tConsole Help\t    ",'white','blue');
print "\n\n";
print $colors->getColoredString(" -v:\tConsole version\n",'blue');
print $colors->getColoredString(" -h:\tConsole help\n",'blue');
print "\n\n";

print $colors->getColoredString("    \tBasic usage\t    ",'white','blue');
print "\n\n";
print $colors->getColoredString(" $> Console.php ","green");
print $colors->getColoredString(" command ","blue");
print $colors->getColoredString(" param1 param2","red");

print("\n\n");
print $colors->getColoredString(" WHERE:","blue");
print("\n\n");
print $colors->getColoredString(" command:\tThe requested command","blue");
print("\n");
print $colors->getColoredString(" param:\t\tThe command parameters","blue");

print "\n\n";