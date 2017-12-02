<?php
namespace System\Helpers;

/**
 * String helper
 * Some functions are taken from CI and CI_Datamapper Library
 *
 */

class StringHelper
{
    /**
     * Pascal case string to separate words
     * @param string $text
     * @param string $separator the string words separator by default ' '
     * @return string
     */
    public static function pascalCase2Str($text, $separator=' ')
    {
        return preg_replace('/([a-z])([A-Z])/', '$1'.$separator.'$2', $text);
    }
    
    /**
     * String to pascal case
     * @param string $text
     * @param string $separator the string words separator by default ' '
     * @return string
     */
    public static function str2PascalCase($sep, $text)
    {
        $text = strtolower(str_replace($seps,' ',$text));
        $text = str_replace(' ','',ucwords($text));
        return $text;
    }
    
    /**
     * Pascal case word to word separated by uderscores
     * @param string $text
     * @return string
     */
    public static function pascalCase2Underscore($text)
    {
    	return preg_replace('/([a-z])([A-Z])/', '$1_$2', $text);
    }
    
    /**
     * Underscore to pascal case string
     * @param string $text
     * @return string
     */
    public static function underscore2PascalCase($text)
    {
    	$text = strtolower(str_replace('_',' ',$text));
    	$text = str_replace(' ','',ucwords($text));
    	return $text;
    }

    /**
     * String to camel case
     * @param string $str
     * @return string
     */
    public static function str2CameleCase($str)
    {
        $str = 'x'.strtolower(trim($str));
        $str = ucwords(preg_replace('/[\s_]+/', ' ', $str));
        return substr(str_replace(' ', '', $str), 1);
    }
    
    /**
     * unicode string to standard string
     * @param string $text
     * @return string
     */
    public static function transLiterateString($text) {
        $transliterationTable = array('á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ă' => 'a',
                                      'Ă' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A',
                                      'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 'ā' => 'a',
                                      'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE',
                                      'ḃ' => 'b', 'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c',
                                      'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c', 'Ċ' => 'C',
                                      'ç' => 'c', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd',
                                      'Ḋ' => 'D', 'đ' => 'd', 'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh',
                                      'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ĕ' => 'e',
                                      'Ĕ' => 'E', 'ê' => 'e', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E',
                                      'ë' => 'e', 'Ë' => 'E', 'ė' => 'e', 'Ė' => 'E', 'ę' => 'e',
                                      'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F',
                                      'ƒ' => 'f', 'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g',
                                      'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 'Ģ' => 'G',
                                      'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i',
                                      'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I',
                                      'ï' => 'i', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i',
                                      'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J',
                                      'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 'Ĺ' => 'L', 'ľ' => 'l',
                                      'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L',
                                      'ṁ' => 'm', 'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n',
                                      'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 'Ņ' => 'N',
                                      'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o',
                                      'Ô' => 'O', 'ő' => 'o', 'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O',
                                      'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o',
                                      'Ơ' => 'O', 'ö' => 'oe', 'Ö' => 'OE', '°'=>'O', 'ṗ' => 'p',
                                      'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r', 'Ř' => 'R',
                                      'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's',
                                      'Ŝ' => 'S', 'š' => 's', 'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S',
                                      'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS',
                                      'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't',
                                      'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T', 'ŧ' => 't', 'Ŧ' => 'T',
                                      'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u',
                                      'Ŭ' => 'U', 'û' => 'u', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U',
                                      'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'ų' => 'u',
                                      'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U',
                                      'ü' => 'ue', 'Ü' => 'UE', 'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w',
                                      'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W',
                                      'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y',
                                      'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'ź' => 'z', 'Ź' => 'Z',
                                      'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th',
                                      'Þ' => 'Th', 'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b',
                                      'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g', 'Г' => 'g',
                                      'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'e', 'ё' => 'e',
                                      'Ё' => 'e', 'ж' => 'zh', 'Ж' => 'zh', 'з' => 'z', 'З' => 'z',
                                      'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k',
                                      'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm',
                                      'н' => 'n', 'Н' => 'n', 'о' => 'o', 'О' => 'o', 'п' => 'p',
                                      'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's',
                                      'т' => 't', 'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f',
                                      'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 'Ц' => 'c',
                                      'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch',
                                      'Щ' => 'sch', 'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '',
                                      'Ь' => '', 'э' => 'e', 'Э' => 'e', 'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja',
                                      'Я' => 'ja');
        $text = str_replace(array_keys($transliterationTable), array_values($transliterationTable), $text);
        return $text;
    }
    
    /**
     * Removes extra white spaces in a string
     * @param string $text
     * @return string
     */
    public static function removeExtraWhiteSpaces($text)
    {
        return preg_replace('/\s+/', ' ',$text);
    }
    
    /**
     * Singular value of a word
     * @param string $str
     * @return string
     */
    public static function str2Singular($str)
    {
        $str = strtolower(trim($str));
        $end5 = substr($str, -5);
        $end4 = substr($str, -4);
        $end3 = substr($str, -3);
        $end2 = substr($str, -2);
        $end1 = substr($str, -1);
        
        if ($end5 == 'eives')
        {
            $str = substr($str, 0, -3).'f';
        }
        elseif ($end4 == 'eaux')
        {
            $str = substr($str, 0, -1);
        }
        elseif ($end4 == 'ives')
        {
            $str = substr($str, 0, -3).'fe';
        }
        elseif ($end3 == 'ves')
        {
            $str = substr($str, 0, -3).'f';
        }
        elseif ($end3 == 'ies')
        {
            $str = substr($str, 0, -3).'y';
        }
        elseif ($end3 == 'men')
        {
            $str = substr($str, 0, -2).'an';
        }
        elseif ($end3 == 'xes' && strlen($str) > 4 OR in_array($end3, array('ses', 'hes', 'oes')))
        {
            $str = substr($str, 0, -2);
        }
        elseif (in_array($end2, array('da', 'ia', 'la')))
        {
            $str = substr($str, 0, -1).'um';
        }
        elseif (in_array($end2, array('bi', 'ei', 'gi', 'li', 'mi', 'pi')))
        {
            $str = substr($str, 0, -1).'us';
        }
        else
        {
            if ($end1 == 's' && $end2 != 'us' && $end2 != 'ss')
            {
                $str = substr($str, 0, -1);
            }
        }
        
        return $str;
    }
    
    /**
     * Plural value of a word
     * @param string $str
     * @param string $force
     * @return string
     */
    public static function str2Plural($str, $force = FALSE)
    {
        
        $str = strtolower(trim($str));
        $end3 = substr($str, -3);
        $end2 = substr($str, -2);
        $end1 = substr($str, -1);
        if ($end3 == 'eau')
        {
            $str .= 'x';
        }
        elseif ($end3 == 'man')
        {
            $str = substr($str, 0, -2).'en';
        }
        elseif (in_array($end3, array('dum', 'ium', 'lum')))
        {
            $str = substr($str, 0, -2).'a';
        }
        elseif (strlen($str) > 4 && in_array($end3, array('bus', 'eus', 'gus', 'lus', 'mus', 'pus')))
        {
            $str = substr($str, 0, -2).'i';
        }
        elseif ($end3 == 'ife')
        {
            $str = substr($str, 0, -2).'ves';
        }
        elseif ($end1 == 'f')
        {
            $str = substr($str, 0, -1).'ves';
        }
        elseif ($end1 == 'y')
        {
            if(preg_match('#[aeiou]y#i', $end2))
            {
                // ays, oys, etc.
                $str = $str . 's';
            }
            else
            {
                $str = substr($str, 0, -1).'ies';
            }
        }
        elseif ($end1 == 'o')
        {
            if(preg_match('#[aeiou]o#i', $end2))
            {
                // oos, etc.
                $str = $str . 's';
            }
            else
            {
                $str .= 'es';
            }
        }
        elseif ($end1 == 'x' || in_array($end2, array('ss', 'ch', 'sh')) )
        {
            $str .= 'es';
        }
        elseif ($end1 == 's')
        {
            if ($force == TRUE)
            {
                $str .= 'es';
            }
        }
        else
        {
            $str .= 's';
        }
        return $str;
    }
    
}