<?php
namespace System\Helpers;

class HttpHelper {
    
    public static function getErrorCodeStatus($code)
    {
        $msg;
        switch($code)
        {
            case 400 :
                $msg = "400 Bad Request";
                break;
            case 401 :
                $msg = "401 Unauthorized";
                break;
            case 403 :
                $msg = "403 Forbidden";
                break;
            case 404 :
                $msg = "404 Not Found";
                break;
            case 404 :
                $msg = "404 Not Found";
                break;
            case 500 :
                $msg = "500 Internal Server Error";
                break;
            case 501 :
                $msg = "501 Not Implemented";
                break;
            case 502 :
                $msg = "502 Bad Gateway";
                break;
            case 503 :
                $msg = "503 Service Unavailable";
                break;
            case 504 :
                $msg = "504 Gateway Timeout";
                break;
            case 505 :
                $msg = "505 HTTP Version Not Supported";
                break;
            case 506 :
                $msg = "506 Variant Also Negotiates";
                break;
            case 507 :
                $msg = "507 Insufficient Storage";
                break;
            case 509 :
                $msg = "509 Bandwidth Limit Exceeded";
                break;
            case 510 :
                $msg = "510 Not Extended";
                break;
            default:
                $msg = null;
                break;
        }
        return $msg;
    }
    
}
