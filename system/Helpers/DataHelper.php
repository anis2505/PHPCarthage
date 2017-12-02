<?php

class DataHelper
{
    protected static function echoJson($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}