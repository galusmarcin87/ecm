<?php

namespace app\components\mgcms;

use Yii;
use app\models\mgcms\db\Setting;

/**
 * Helpers class
 * @author marcin
 */
class MgHelpers extends \yii\base\Component
{

    const FLASH_TYPE_SUCCESS = 'success';
    const FLASH_TYPE_INFO = 'info';
    const FLASH_TYPE_WARNING = 'warning';
    const FLASH_TYPE_ERROR = 'error';

    /**
     * return string file size in KB, MB etc from byte size
     * @param int $size
     * @return string
     */
    public static function getFormatedFileSize($size)
    {
        if ($size < 1024)
            return $size . ' B';
        elseif ($size < 1048576)
            return round($size / 1024, 2) . ' KB';
        elseif ($size < 1073741824)
            return round($size / 1048576, 2) . ' MB';
        elseif ($size < 1099511627776)
            return round($size / 1073741824, 2) . ' GB';
        else
            return round($size / 1099511627776, 2) . ' TB';
    }

    /**
     * cuts string with limit and add pad on the end if length > limit
     * @param string $string
     * @param int $limit
     * @param string $pad
     * @return string
     */
    public static function truncate($string, $limit, $pad = "...")
    {
        // return with no change if string is shorter than $limit
        if (strlen($string) <= $limit)
            return $string;
        else {
            $string = substr($string, 0, $limit) . $pad;
        }
        return $string;
    }

    /**
     * Replaces special characters in a string with their "non-special" counterpart.
     *
     * Useful for friendly URLs.
     *
     * @access public
     * @param string
     * @return string
     */
    public static function convertAccentsAndSpecialToNormal($string)
    {
        $table = array(
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Ă' => 'A', 'Ā' => 'A', 'Ą' => 'A', 'Æ' => 'A', 'Ǽ' => 'A',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'ă' => 'a', 'ā' => 'a', 'ą' => 'a', 'æ' => 'a', 'ǽ' => 'a',
            'Þ' => 'B', 'þ' => 'b', 'ß' => 'Ss',
            'Ç' => 'C', 'Č' => 'C', 'Ć' => 'C', 'Ĉ' => 'C', 'Ċ' => 'C',
            'ç' => 'c', 'č' => 'c', 'ć' => 'c', 'ĉ' => 'c', 'ċ' => 'c',
            'Đ' => 'Dj', 'Ď' => 'D', 'Đ' => 'D',
            'đ' => 'dj', 'ď' => 'd',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ĕ' => 'E', 'Ē' => 'E', 'Ę' => 'E', 'Ė' => 'E',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ĕ' => 'e', 'ē' => 'e', 'ę' => 'e', 'ė' => 'e',
            'Ĝ' => 'G', 'Ğ' => 'G', 'Ġ' => 'G', 'Ģ' => 'G',
            'ĝ' => 'g', 'ğ' => 'g', 'ġ' => 'g', 'ģ' => 'g',
            'Ĥ' => 'H', 'Ħ' => 'H',
            'ĥ' => 'h', 'ħ' => 'h',
            'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'İ' => 'I', 'Ĩ' => 'I', 'Ī' => 'I', 'Ĭ' => 'I', 'Į' => 'I',
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'į' => 'i', 'ĩ' => 'i', 'ī' => 'i', 'ĭ' => 'i', 'ı' => 'i',
            'Ĵ' => 'J',
            'ĵ' => 'j',
            'Ķ' => 'K',
            'ķ' => 'k', 'ĸ' => 'k',
            'Ĺ' => 'L', 'Ļ' => 'L', 'Ľ' => 'L', 'Ŀ' => 'L', 'Ł' => 'L',
            'ĺ' => 'l', 'ļ' => 'l', 'ľ' => 'l', 'ŀ' => 'l', 'ł' => 'l',
            'Ñ' => 'N', 'Ń' => 'N', 'Ň' => 'N', 'Ņ' => 'N', 'Ŋ' => 'N',
            'ñ' => 'n', 'ń' => 'n', 'ň' => 'n', 'ņ' => 'n', 'ŋ' => 'n', 'ŉ' => 'n',
            'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ō' => 'O', 'Ŏ' => 'O', 'Ő' => 'O', 'Œ' => 'O',
            'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ō' => 'o', 'ŏ' => 'o', 'ő' => 'o', 'œ' => 'o', 'ð' => 'o',
            'Ŕ' => 'R', 'Ř' => 'R',
            'ŕ' => 'r', 'ř' => 'r', 'ŗ' => 'r',
            'Š' => 'S', 'Ŝ' => 'S', 'Ś' => 'S', 'Ş' => 'S',
            'š' => 's', 'ŝ' => 's', 'ś' => 's', 'ş' => 's',
            'Ŧ' => 'T', 'Ţ' => 'T', 'Ť' => 'T',
            'ŧ' => 't', 'ţ' => 't', 'ť' => 't',
            'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ũ' => 'U', 'Ū' => 'U', 'Ŭ' => 'U', 'Ů' => 'U', 'Ű' => 'U', 'Ų' => 'U',
            'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ũ' => 'u', 'ū' => 'u', 'ŭ' => 'u', 'ů' => 'u', 'ű' => 'u', 'ų' => 'u',
            'Ŵ' => 'W', 'Ẁ' => 'W', 'Ẃ' => 'W', 'Ẅ' => 'W',
            'ŵ' => 'w', 'ẁ' => 'w', 'ẃ' => 'w', 'ẅ' => 'w',
            'Ý' => 'Y', 'Ÿ' => 'Y', 'Ŷ' => 'Y',
            'ý' => 'y', 'ÿ' => 'y', 'ŷ' => 'y',
            'Ž' => 'Z', 'Ź' => 'Z', 'Ż' => 'Z', 'Ž' => 'Z',
            'ž' => 'z', 'ź' => 'z', 'ż' => 'z', 'ž' => 'z',
            '“' => '"', '”' => '"', '‘' => "'", '’' => "'", '•' => '-', '…' => '...', '—' => '-', '–' => '-', '¿' => '?', '¡' => '!', '°' => ' degrees ',
            '¼' => ' 1/4 ', '½' => ' 1/2 ', '¾' => ' 3/4 ', '⅓' => ' 1/3 ', '⅔' => ' 2/3 ', '⅛' => ' 1/8 ', '⅜' => ' 3/8 ', '⅝' => ' 5/8 ', '⅞' => ' 7/8 ',
            '÷' => ' divided by ', '×' => ' times ', '±' => ' plus-minus ', '√' => ' square root ', '∞' => ' infinity ',
            '≈' => ' almost equal to ', '≠' => ' not equal to ', '≡' => ' identical to ', '≤' => ' less than or equal to ', '≥' => ' greater than or equal to ',
            '←' => ' left ', '→' => ' right ', '↑' => ' up ', '↓' => ' down ', '↔' => ' left and right ', '↕' => ' up and down ',
            '℅' => ' care of ', '℮' => ' estimated ',
            'Ω' => ' ohm ',
            '♀' => ' female ', '♂' => ' male ',
            '©' => ' Copyright ', '®' => ' Registered ', '™' => ' Trademark ',
        );

        $string = strtr($string, $table);
        // Currency symbols: £¤¥€  - we dont bother with them for now
        $string = preg_replace("/[^\x9\xA\xD\x20-\x7F]/u", "", $string);

        return $string;
    }

    public static function getConfigParam($name)
    {
        return isset(Yii::$app->params[$name]) ? Yii::$app->params[$name] : false;
    }

    public static function getConfigParamByPath($path)
    {
        return self::arraySearch($path, Yii::$app->params['components']);
    }

    public static function normalizeUnderlinedString($string, $toUpperWords = true)
    {
        return ucwords(str_replace('_', ' ', $string));
    }

    /**
     * if uri = true return with $_SERVER['REQUEST_URI'] otherwise with $_SERVER['SCRIPT_NAME']
     * @param bool $ifUri
     * @return string
     */
    public static function getCurrentUrl($ifUri = true)
    {
        $s = (empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on")) ? "s" : "";
        $protocol = self::strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/") . $s;
        $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":" . $_SERVER["SERVER_PORT"]);
        $url = $ifUri ? $_SERVER['REQUEST_URI'] : $_SERVER['SCRIPT_NAME'];
        return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $url;
    }

    /**
     * if uri = true return with $_SERVER['REQUEST_URI'] otherwise with $_SERVER['SCRIPT_NAME']
     * @param bool $ifUri
     * @return string
     */
    public static function getCurrentUrlPath($ifUri = true)
    {
        $url = $ifUri ? $_SERVER['REQUEST_URI'] : $_SERVER['SCRIPT_NAME'];
        return $url;
    }

    /**
     * return absolute url of project
     * @return string
     */
    public static function getProjectBaseUrl()
    {
        $s = (empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on")) ? "s" : "";
        $protocol = self::strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/") . $s;
        $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":" . $_SERVER["SERVER_PORT"]);
        return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port;
    }

    public static function strleft($s1, $s2)
    {
        return substr($s1, 0, strpos($s1, $s2));
    }

    /**
     * recursively remove a directory
     * @param string $dir
     */
    public static function rrmdir($dir)
    {
        foreach (glob($dir . '/*') as $file) {
            if (is_dir($file))
                self::rrmdir($file);
            else
                unlink($file);
        }
        if (is_dir($dir))
            rmdir($dir);
    }

    public static function getErrorsString($errorsArray)
    {
        $errorsStr = '';
        foreach ($errorsArray as $errors) {
            foreach ($errors as $error) {
                $errorsStr .= $error . ' ';
            }
        }
        return $errorsStr;
    }

    /**
     * Search array in . notation.
     * E.g. $path=type.subtype returns value of $array[type][subtype]
     * or $default if specified path does not exist.
     * @param string $path
     * @param array $array
     * @param mixed $default
     * @return mixed
     */
    public static function arraySearch($path, array $array, $default = null)
    {
        $path = explode('.', $path);
        foreach ($path as $index) {
            if ($index && isset($array[$index]))
                $array = $array[$index];
            else
                return $default;
        }
        return $array;
    }

    public static function setPrettyPhoto($opts = false)
    {
        //jqPrettyPhoto
        Yii::import('ext.jqPrettyPhoto');
        $jqPrettyPhotoOptions = $opts ? $opts : array(
            'slideshow' => 5000,
            'autoplay_slideshow' => false,
            'show_title' => false,
            'overlay_gallery' => false
        );
        jqPrettyPhoto::addPretty('.lightbox', jqPrettyPhoto::PRETTY_GALLERY, jqPrettyPhoto::THEME_LIGHT_ROUNDED, $jqPrettyPhotoOptions);
    }

    /**
     * return string defining user browser: ie, firefox, safari, chrome, flock, opera
     * @return string
     */
    public static function getUserBrowser()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $ub = '';
        if (preg_match('/MSIE/i', $u_agent)) {
            $ub = "ie";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $ub = "firefox";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $ub = "safari";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $ub = "chrome";
        } elseif (preg_match('/Flock/i', $u_agent)) {
            $ub = "flock";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $ub = "opera";
        }

        return $ub;
    }

    public static function registerJqueryUI()
    {
        Yii::$app->clientScript->registerCoreScript('jquery.ui');
        Yii::$app->clientScript->registerCssFile(Yii::$app->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css');
    }

    /**
     * @param array $array
     * @param boolean $translated
     * @return array
     */
    public static function arrayKeyValueFromArray($array, $translated = false)
    {
        $retArray = array();
        if (!is_array($array)) {
            return array();
        }
        foreach ($array as $item) {
            if ($item)
                $retArray[$item] = $translated ? Yii::t('app', $item) : $item;
        }
        return $retArray;
    }

    /**
     * @param array $array
     * @param boolean $translated
     * @return array
     */
    public static function arrayTranslateValues($array)
    {
        $retArray = array();
        if (!is_array($array)) {
            return array();
        }
        foreach ($array as $key => $item) {
            if ($item)
                $retArray[$key] = Yii::t('app', $item);
        }
        return $retArray;
    }

    /**
     * @param array $array
     * @return array
     */
    public static function translatedSBValueFromArray($array)
    {
        $retArray = array();
        if (!is_array($array)) {
            return array();
        }
        foreach ($array as $item) {
            if (isset($item)) {
                $retArray[$item] = Yii::t('app', $item);
            }
        }
        return $retArray;
    }

    /**
     * @param $name
     * @param bool $textValue
     * @param string $defaultValue
     * @param string $type System or text
     * @return string
     */
    public static function getSetting($name, $textValue = false, $defaultValue = '', $type = Setting::TYPE_SYSTEM)
    {
        $setting = Setting::find()->cache(36000)->where(['key' => $name, 'type' => $type])->one();

        if (!$setting) {
            $setting = new Setting;
            $setting->scenario = 'insert';
            $setting->key = $name;
            $setting->type = $type;
            if ($textValue) {
                $setting->value_text = (string)$defaultValue;
            } else {
                $setting->value = (string)$defaultValue;
            }

            $saved = $setting->save();
            if (!$saved) {
                //problem with cache
                $setting = Setting::find()->where(['key' => $name])->one();
            }
            return $defaultValue;
        }

        return $textValue ? $setting->value_text : $setting->value;
    }

    /**
     * get setting by type text (non system)
     * @param $name
     * @param bool $textValue
     * @param string $defaultValue
     * @return string
     */
    public static function getSettingTypeText($name, $textValue = false, $defaultValue = '')
    {
        return self::getSetting($name, $textValue, $defaultValue, Setting::TYPE_TEXT);
    }

    public static function getSettingTranslated($name, $defaultValue = '')
    {
        $setting = self::getSettingTypeText($name, false, $defaultValue);
        if ($setting) {
            return Yii::t('db', $setting);
        }
        return $defaultValue;
    }

    public static function slug($title)
    {
        $title = strip_tags($title);
        // Preserve escaped octets.
        $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
        // Remove percent signs that are not part of an octet.
        $title = str_replace('%', '', $title);
        // Restore octets.
        $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

        $title = self::remove_accents($title);
        if (self::seems_utf8($title)) {
            if (function_exists('mb_strtolower')) {
                $title = mb_strtolower($title, 'UTF-8');
            }
            $title = self::utf8_uri_encode($title, 200);
        }

        $title = strtolower($title);
        $title = preg_replace('/&.+?;/', '', $title); // kill entities
        $title = str_replace('.', '-', $title);
        $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
        $title = preg_replace('/\s+/', '-', $title);
        $title = preg_replace('|-+|', '-', $title);
        $title = trim($title, '-');


        $title = urldecode($title);


        return $title;
    }

    private static function seems_utf8($str)
    {
        $length = strlen($str);
        for ($i = 0; $i < $length; $i++) {
            $c = ord($str[$i]);
            if ($c < 0x80)
                $n = 0;# 0bbbbbbb
            elseif (($c & 0xE0) == 0xC0)
                $n = 1;# 110bbbbb
            elseif (($c & 0xF0) == 0xE0)
                $n = 2;# 1110bbbb
            elseif (($c & 0xF8) == 0xF0)
                $n = 3;# 11110bbb
            elseif (($c & 0xFC) == 0xF8)
                $n = 4;# 111110bb
            elseif (($c & 0xFE) == 0xFC)
                $n = 5;# 1111110b
            else
                return false;# Does not match any model
            for ($j = 0; $j < $n; $j++) { # n bytes matching 10bbbbbb follow ?
                if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
                    return false;
            }
        }
        return true;
    }

    private static function utf8_uri_encode($utf8_string, $length = 0)
    {
        $unicode = '';
        $values = array();
        $num_octets = 1;
        $unicode_length = 0;

        $string_length = strlen($utf8_string);
        for ($i = 0; $i < $string_length; $i++) {

            $value = ord($utf8_string[$i]);

            if ($value < 128) {
                if ($length && ($unicode_length >= $length))
                    break;
                $unicode .= chr($value);
                $unicode_length++;
            } else {
                if (count($values) == 0)
                    $num_octets = ($value < 224) ? 2 : 3;

                $values[] = $value;

                if ($length && ($unicode_length + ($num_octets * 3)) > $length)
                    break;
                if (count($values) == $num_octets) {
                    if ($num_octets == 3) {
                        $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]) . '%' . dechex($values[2]);
                        $unicode_length += 9;
                    } else {
                        $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]);
                        $unicode_length += 6;
                    }

                    $values = array();
                    $num_octets = 1;
                }
            }
        }

        return $unicode;
    }

    private static function remove_accents($string)
    {
        if (!preg_match('/[\x80-\xff]/', $string))
            return $string;

        if (self::seems_utf8($string)) {
            $chars = array(
                // Decompositions for Latin-1 Supplement
                chr(195) . chr(128) => 'A', chr(195) . chr(129) => 'A',
                chr(195) . chr(130) => 'A', chr(195) . chr(131) => 'A',
                chr(195) . chr(132) => 'A', chr(195) . chr(133) => 'A',
                chr(195) . chr(135) => 'C', chr(195) . chr(136) => 'E',
                chr(195) . chr(137) => 'E', chr(195) . chr(138) => 'E',
                chr(195) . chr(139) => 'E', chr(195) . chr(140) => 'I',
                chr(195) . chr(141) => 'I', chr(195) . chr(142) => 'I',
                chr(195) . chr(143) => 'I', chr(195) . chr(145) => 'N',
                chr(195) . chr(146) => 'O', chr(195) . chr(147) => 'O',
                chr(195) . chr(148) => 'O', chr(195) . chr(149) => 'O',
                chr(195) . chr(150) => 'O', chr(195) . chr(153) => 'U',
                chr(195) . chr(154) => 'U', chr(195) . chr(155) => 'U',
                chr(195) . chr(156) => 'U', chr(195) . chr(157) => 'Y',
                chr(195) . chr(159) => 's', chr(195) . chr(160) => 'a',
                chr(195) . chr(161) => 'a', chr(195) . chr(162) => 'a',
                chr(195) . chr(163) => 'a', chr(195) . chr(164) => 'a',
                chr(195) . chr(165) => 'a', chr(195) . chr(167) => 'c',
                chr(195) . chr(168) => 'e', chr(195) . chr(169) => 'e',
                chr(195) . chr(170) => 'e', chr(195) . chr(171) => 'e',
                chr(195) . chr(172) => 'i', chr(195) . chr(173) => 'i',
                chr(195) . chr(174) => 'i', chr(195) . chr(175) => 'i',
                chr(195) . chr(177) => 'n', chr(195) . chr(178) => 'o',
                chr(195) . chr(179) => 'o', chr(195) . chr(180) => 'o',
                chr(195) . chr(181) => 'o', chr(195) . chr(182) => 'o',
                chr(195) . chr(182) => 'o', chr(195) . chr(185) => 'u',
                chr(195) . chr(186) => 'u', chr(195) . chr(187) => 'u',
                chr(195) . chr(188) => 'u', chr(195) . chr(189) => 'y',
                chr(195) . chr(191) => 'y',
                // Decompositions for Latin Extended-A
                chr(196) . chr(128) => 'A', chr(196) . chr(129) => 'a',
                chr(196) . chr(130) => 'A', chr(196) . chr(131) => 'a',
                chr(196) . chr(132) => 'A', chr(196) . chr(133) => 'a',
                chr(196) . chr(134) => 'C', chr(196) . chr(135) => 'c',
                chr(196) . chr(136) => 'C', chr(196) . chr(137) => 'c',
                chr(196) . chr(138) => 'C', chr(196) . chr(139) => 'c',
                chr(196) . chr(140) => 'C', chr(196) . chr(141) => 'c',
                chr(196) . chr(142) => 'D', chr(196) . chr(143) => 'd',
                chr(196) . chr(144) => 'D', chr(196) . chr(145) => 'd',
                chr(196) . chr(146) => 'E', chr(196) . chr(147) => 'e',
                chr(196) . chr(148) => 'E', chr(196) . chr(149) => 'e',
                chr(196) . chr(150) => 'E', chr(196) . chr(151) => 'e',
                chr(196) . chr(152) => 'E', chr(196) . chr(153) => 'e',
                chr(196) . chr(154) => 'E', chr(196) . chr(155) => 'e',
                chr(196) . chr(156) => 'G', chr(196) . chr(157) => 'g',
                chr(196) . chr(158) => 'G', chr(196) . chr(159) => 'g',
                chr(196) . chr(160) => 'G', chr(196) . chr(161) => 'g',
                chr(196) . chr(162) => 'G', chr(196) . chr(163) => 'g',
                chr(196) . chr(164) => 'H', chr(196) . chr(165) => 'h',
                chr(196) . chr(166) => 'H', chr(196) . chr(167) => 'h',
                chr(196) . chr(168) => 'I', chr(196) . chr(169) => 'i',
                chr(196) . chr(170) => 'I', chr(196) . chr(171) => 'i',
                chr(196) . chr(172) => 'I', chr(196) . chr(173) => 'i',
                chr(196) . chr(174) => 'I', chr(196) . chr(175) => 'i',
                chr(196) . chr(176) => 'I', chr(196) . chr(177) => 'i',
                chr(196) . chr(178) => 'IJ', chr(196) . chr(179) => 'ij',
                chr(196) . chr(180) => 'J', chr(196) . chr(181) => 'j',
                chr(196) . chr(182) => 'K', chr(196) . chr(183) => 'k',
                chr(196) . chr(184) => 'k', chr(196) . chr(185) => 'L',
                chr(196) . chr(186) => 'l', chr(196) . chr(187) => 'L',
                chr(196) . chr(188) => 'l', chr(196) . chr(189) => 'L',
                chr(196) . chr(190) => 'l', chr(196) . chr(191) => 'L',
                chr(197) . chr(128) => 'l', chr(197) . chr(129) => 'L',
                chr(197) . chr(130) => 'l', chr(197) . chr(131) => 'N',
                chr(197) . chr(132) => 'n', chr(197) . chr(133) => 'N',
                chr(197) . chr(134) => 'n', chr(197) . chr(135) => 'N',
                chr(197) . chr(136) => 'n', chr(197) . chr(137) => 'N',
                chr(197) . chr(138) => 'n', chr(197) . chr(139) => 'N',
                chr(197) . chr(140) => 'O', chr(197) . chr(141) => 'o',
                chr(197) . chr(142) => 'O', chr(197) . chr(143) => 'o',
                chr(197) . chr(144) => 'O', chr(197) . chr(145) => 'o',
                chr(197) . chr(146) => 'OE', chr(197) . chr(147) => 'oe',
                chr(197) . chr(148) => 'R', chr(197) . chr(149) => 'r',
                chr(197) . chr(150) => 'R', chr(197) . chr(151) => 'r',
                chr(197) . chr(152) => 'R', chr(197) . chr(153) => 'r',
                chr(197) . chr(154) => 'S', chr(197) . chr(155) => 's',
                chr(197) . chr(156) => 'S', chr(197) . chr(157) => 's',
                chr(197) . chr(158) => 'S', chr(197) . chr(159) => 's',
                chr(197) . chr(160) => 'S', chr(197) . chr(161) => 's',
                chr(197) . chr(162) => 'T', chr(197) . chr(163) => 't',
                chr(197) . chr(164) => 'T', chr(197) . chr(165) => 't',
                chr(197) . chr(166) => 'T', chr(197) . chr(167) => 't',
                chr(197) . chr(168) => 'U', chr(197) . chr(169) => 'u',
                chr(197) . chr(170) => 'U', chr(197) . chr(171) => 'u',
                chr(197) . chr(172) => 'U', chr(197) . chr(173) => 'u',
                chr(197) . chr(174) => 'U', chr(197) . chr(175) => 'u',
                chr(197) . chr(176) => 'U', chr(197) . chr(177) => 'u',
                chr(197) . chr(178) => 'U', chr(197) . chr(179) => 'u',
                chr(197) . chr(180) => 'W', chr(197) . chr(181) => 'w',
                chr(197) . chr(182) => 'Y', chr(197) . chr(183) => 'y',
                chr(197) . chr(184) => 'Y', chr(197) . chr(185) => 'Z',
                chr(197) . chr(186) => 'z', chr(197) . chr(187) => 'Z',
                chr(197) . chr(188) => 'z', chr(197) . chr(189) => 'Z',
                chr(197) . chr(190) => 'z', chr(197) . chr(191) => 's',
                // Euro Sign
                chr(226) . chr(130) . chr(172) => 'E',
                // GBP (Pound) Sign
                chr(194) . chr(163) => '');

            $string = strtr($string, $chars);
        } else {
            // Assume ISO-8859-1 if not UTF-8
            $chars['in'] = chr(128) . chr(131) . chr(138) . chr(142) . chr(154) . chr(158)
                . chr(159) . chr(162) . chr(165) . chr(181) . chr(192) . chr(193) . chr(194)
                . chr(195) . chr(196) . chr(197) . chr(199) . chr(200) . chr(201) . chr(202)
                . chr(203) . chr(204) . chr(205) . chr(206) . chr(207) . chr(209) . chr(210)
                . chr(211) . chr(212) . chr(213) . chr(214) . chr(216) . chr(217) . chr(218)
                . chr(219) . chr(220) . chr(221) . chr(224) . chr(225) . chr(226) . chr(227)
                . chr(228) . chr(229) . chr(231) . chr(232) . chr(233) . chr(234) . chr(235)
                . chr(236) . chr(237) . chr(238) . chr(239) . chr(241) . chr(242) . chr(243)
                . chr(244) . chr(245) . chr(246) . chr(248) . chr(249) . chr(250) . chr(251)
                . chr(252) . chr(253) . chr(255);

            $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

            $string = strtr($string, $chars['in'], $chars['out']);
            $double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
            $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
            $string = str_replace($double_chars['in'], $double_chars['out'], $string);
        }

        return $string;
    }

    public static function disableClientCombineScriptFiles()
    {
        if (isset(Yii::$app->clientScript->combineScriptFiles))
            Yii::$app->clientScript->combineScriptFiles = false;
    }

    public static function getBooleanFilter($attribute)
    {
        return array(
            'name' => $attribute,
            'type' => 'boolean',
            'filter' => array(0 => T::mt('No'), 1 => T::mt('Yes'))
        );
    }

    public static function setFlash($type, $msg)
    {
        Yii::$app->session->setFlash($type, $msg);
    }

    public static function setFlashError($msg)
    {
        self::setFlash(self::FLASH_TYPE_ERROR, $msg);
    }

    public static function setFlashSuccess($msg)
    {
        self::setFlash(self::FLASH_TYPE_SUCCESS, $msg);
    }

    /**
     * pobiera tablice wartoßci oddzielonych przecinkami
     */
    public static function getSettingsArray($name, $default = false)
    {
        return explode(',', MgHelpers::getSetting($name, false, $default));
    }

    public static function getOptionsList($modelName, $key = 'id', $value = 'toString', $order = false)
    {
        return CHtml::listData($modelName::model()->findAll(array('order' => $order)), $key, $value);
    }

    public static function getUserNameById($id)
    {
        if ($id != NULL) {
            $user = User::model()->findByPk($id);
            if ($user != NULL) {
                return $user->username;
            } else {
                return $id;
            }
        } else {
            return $id;
        }
    }

    public static function getFilesName($name)
    {
        $files = array();
        $filesId = explode(',', MgHelpers::getSetting($name));
        foreach ($filesId as $id) {
            if ($id != NULL) {
                $file = File::model()->findByPk($id);
                if ($file != NULL) {
                    $files[$file->name] = $file->alt;
                }
            }
        }
        return $files;
    }

    /**
     *
     * @param string $controllerName
     * @param string $moduleSubname
     * @return type
     */
    public static function getBackendGridViewColumnButtons($controllerName, $moduleSubname = 'solano', $template = '{view} {update} {delete}')
    {
        return array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => $template,
            'buttons' => array(
                'view' => array(
                    'url' => 'Yii::$app->createUrl("backend/' . $moduleSubname . '/' . $controllerName . '/view", array("id"=>$data->id))'
                ),
                'update' => array(
                    'url' => 'Yii::$app->createUrl("backend/' . $moduleSubname . '/' . $controllerName . '/update", array("id"=>$data->id))'
                ),
                'delete' => array(
                    'url' => 'Yii::$app->createUrl("backend/' . $moduleSubname . '/' . $controllerName . '/delete", array("id"=>$data->id))'
                ),
            )
        );
    }

    /**
     *
     * @param string $input
     * @return string
     */
    public static function convertCamelCaseToMinusCase($input)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('-', $ret);
    }

    /**
     *
     * @return \app\models\mgcms\db\User
     */
    public static function getUserModel()
    {
        return Yii::$app->user ? Yii::$app->user->identity : null;
    }

    /**
     *
     * @param string $name
     */
    public static function getBackendGridViewColumnWithoutFilter($name, $type = 'text')
    {
        return array(
            'name' => $name,
            'filter' => false,
            'type' => $type
        );
    }

    /**
     *
     * @param type $model
     */
    public static function logErrorSave($model)
    {
        Yii::error(get_class($model) . ', Save error: ' . MgHelpers::getErrorsString($model->getErrors()) . ' object: ' . \yii\helpers\Json::encode($model), 'error', 'system.log');
    }

    /**
     *
     * @param AbstractRecord $model
     * @param type $flash
     */
    public static function saveModelAndLog($model, $flash = true)
    {
        $saved = $model->save();
        if (!$saved) {
            if ($flash) {
                MgHelpers::setFlash(MgHelpers::FLASH_TYPE_ERROR, T::sbt('Error saving') . ' ' . T::sbt(get_class($model)) . ':' . MgHelpers::getErrorsString($model->getErrors()));
            }

            MgHelpers::logErrorSave($model);
        }
        return $saved;
    }

    public static function log($message, $class = 'error')
    {
        Yii::info($message, $class);
    }

    /**
     *
     * @param type $InputVariable
     * @return type
     */
    public static function isArrayEmpty($InputVariable)
    {
        $Result = true;

        if (is_array($InputVariable) && count($InputVariable) > 0) {
            foreach ($InputVariable as $Value) {
                $Result = $Result && self::isArrayEmpty($Value);
            }
        } else {
            $Result = empty($InputVariable);
        }

        return $Result;
    }

    public static function checkAccess($controller, $action)
    {
        return Yii::$app->user->identity ? Yii::$app->user->identity->checkAccess($controller, $action) : false;
    }

    public static function getIdsArrayOfModels($models)
    {
        $ids = array();
        foreach ($models as $model) {
            $ids[] = $model->id;
        }
        return $ids;
    }

    /**
     *
     * @param array() $array
     * @return array
     */
    public static function arrayCombineFromOneArray($array)
    {
        return array_combine($array, $array);
    }

    public static function getWebRoot()
    {
        return \Yii::getAlias('@webroot');
    }

    public static function getWebRootUrl()
    {
        return \yii\helpers\Url::home(true);
    }

    public static function getSettingOptionArray($name, $translated = false)
    {
        $settingArr = MgHelpers::getSettingsArray($name);
        if ($translated) {
            $setting = Yii::t('db', MgHelpers::getSetting($name));
            $settingArr = explode(',', $setting);
        }
        return MgHelpers::translatedSBValueFromArray($settingArr);
    }

    public static function getSettingOptionArrayTranslated($name)
    {
        $settingArr = MgHelpers::getSettingsArray($name);

        $ret = [];
        foreach ($settingArr as $item) {
            $ret[$item] = Yii::t('db', $item);
        }

        return $ret;
    }

    public static function createUrl($params)
    {
        return Yii::$app->urlManager->createUrl($params);
    }

    public static function getClassShortName($object)
    {
        return (new \ReflectionClass($object))->getShortName();
    }

    public static function getLanguage()
    {
        return Yii::$app->language;
    }

    public static function registerJsFile($src, $options = [], $module = fasle)
    {
        if ($module) {
            $src = Yii::$app->getModule($module)->basePath . $src;
        }
        $files = Yii::$app->view->getAssetManager()->publish($src);
        if (isset($files[1])) {
            Yii::$app->view->registerJsFile($files[1]);
        } else {
            self::log('error with publishing js file ' . $src);
        }
    }

    public static function throw404()
    {
        throw new \yii\web\NotFoundHttpException(Yii::t('app', 'Page not found'));
    }

    public static function encrypt($data)
    {
        if(is_array($data)){
            $data = serialize($data);
        }
        return self::base64_url_encode(Yii::$app->getSecurity()->encryptByPassword($data, MgHelpers::getConfigParam('secretKey')));
    }

    public static function decrypt($hash)
    {
        return Yii::$app->getSecurity()->decryptByPassword(self::base64_url_decode($hash), \app\components\mgcms\MgHelpers::getConfigParam('secretKey'));
    }

    public static function base64_url_encode($input)
    {
        return strtr(base64_encode($input), '+/=', '._-');
    }

    public static function base64_url_decode($input)
    {
        return base64_decode(strtr($input, '._-', '+/='));
    }

    public static function getCRUDIdColumn()
    {
        return ['type' => \kartik\builder\TabularForm::INPUT_HIDDEN_STATIC, 'columnOptions' => ['hidden' => true]];
    }

    //Date Should In YYYY-MM-DD Format
    //RESULT FORMAT:
    // '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
    // '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
    // '%m Month %d Day'                                            =>  3 Month 14 Day
    // '%d Day %h Hours'                                            =>  14 Day 11 Hours
    // '%d Day'                                                        =>  14 Days
    // '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
    // '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
    // '%h Hours                                                    =>  11 Hours
    // '%a Days                                                        =>  468 Days
    //////////////////////////////////////////////////////////////////////
    static function dateDifference($date_1, $date_2, $differenceFormat = '%a')
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);
    }

    static function convertNumberToNiceString($n)
    {
        // first strip any formatting;
        $n = (0 + str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) return false;

        // now filter it;
        if ($n > 1000000000000) return round(($n / 1000000000000), 3) . Yii::t('db', ' trl');
        else if ($n > 1000000000) return round(($n / 1000000000), 3) . Yii::t('db', ' bln');
        else if ($n > 1000000) return round(($n / 1000000), 3) . Yii::t('db', ' mln');
        else if ($n > 1000) return round(($n / 1000), 3) . Yii::t('db', ' k');;

        return number_format($n);
    }

    static function isAdmin()
    {
        return MgHelpers::getUserModel()->isAdmin();
    }

    static function getTinyMceOptions($clientOptions = [], $options = [])
    {

        return [
            'options' => \yii\helpers\ArrayHelper::merge(['rows' => 6], $options ),
            'language' => substr(Yii::$app->language, 0, 2),
            'clientOptions' => \yii\helpers\ArrayHelper::merge($clientOptions, [
                'plugins' => [
                    "advlist autolink lists link charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste",
                    "image imagetools visualchars textcolor",
                    "autosave colorpicker hr nonbreaking template"
                ],
                'toolbar1' => "undo redo | styleselect fontselect fontsizeselect forecolor backcolor | bold italic",
                'toolbar2' => "fullscreen | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                'image_advtab' => true,
                'visualblocks_default_state' => false,
                'relative_urls' => false,
                'remove_script_host' => false,
                'convert_urls' => true,
                'images_upload_url' => MgHelpers::createUrl(['backend/mgcms/file/uploadinstorage']),
                // here we add custom filepicker only to Image dialog
                'file_picker_types' => 'image',
                // and here's our custom image picker
                'file_picker_callback' => new \yii\web\JsExpression("function(callback, value, meta) {
                  var input = document.createElement('input');
                  input.setAttribute('type', 'file');
                  input.setAttribute('accept', 'image/*');

                  input.onchange = function() {
                      var file = this.files[0];

                      var reader = new FileReader();
                      reader.readAsDataURL(file);
                      reader.onload = function () {
                          var id = 'blobid' + (new Date()).getTime();
                          var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                          var blobInfo = blobCache.create(id, file, reader.result);
                          blobCache.add(blobInfo);

                          // call the callback and populate the Title field with the file name
                          callback(blobInfo.blobUri(), { title: file.name });
                      };
                  };
                  input.click();
              }")
            ]),
        ];

    }

    static function getAllCountriesArray()
    {
        $countries = array
        (
            'AF' => 'Afghanistan',
            'AX' => 'Aland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua And Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia And Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos (Keeling) Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros',
            'CG' => 'Congo',
            'CD' => 'Congo, Democratic Republic',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => 'Cote D\'Ivoire',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FK' => 'Falkland Islands (Malvinas)',
            'FO' => 'Faroe Islands',
            'FJ' => 'Fiji',
            'FI' => 'Finland',
            'FR' => 'France',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island & Mcdonald Islands',
            'VA' => 'Holy See (Vatican City State)',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran, Islamic Republic Of',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle Of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KR' => 'Korea',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyzstan',
            'LA' => 'Lao People\'s Democratic Republic',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libyan Arab Jamahiriya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia, Federated States Of',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'NL' => 'Netherlands',
            'AN' => 'Netherlands Antilles',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory, Occupied',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthelemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts And Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre And Miquelon',
            'VC' => 'Saint Vincent And Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome And Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia And Sandwich Isl.',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard And Jan Mayen',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'SY' => 'Syrian Arab Republic',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad And Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks And Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'UM' => 'United States Outlying Islands',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Viet Nam',
            'VG' => 'Virgin Islands, British',
            'VI' => 'Virgin Islands, U.S.',
            'WF' => 'Wallis And Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe',
        );
        return $countries;
    }


}
