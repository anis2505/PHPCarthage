<?php
echo "<pre>";
var_dump($users);

foreach ($users as $user)
{
    echo '<br/>Firstname: '.$user->first_name;
    echo '<br/>Lastname: '.$user->last_name;
    echo '<br/>DOB: '.$user->dob.'<br/><hr/>';
}