<?php

namespace THS\Utils;

use THS\Utils\Encoder\Type\Utf8;
use THS\Utils\Encoder\Exception\Utf8Exception;

/**
 * Lib para trabalhar com strings.
 * 
 * @author Thiago Hofmeister <thiago.hofmeister@gmail.com>
 */
abstract class Text
{
    /** @var array $singularPluralMap Mapa de singular/plural */
    static private $singularPluralMap = [
        'bonus' => 'bonus',
        'indique_ganhe' => 'indique_ganhe'
    ];

    /**
     * Transforma array em string enumerada
     * @param array $array
     * @param string $separator
     * @param string $lastSeparator
     * @return string
     */
    public static function enum(array $array, $separator = ', ', $lastSeparator = ' e ')
    {
        $last = array_pop($array);

        $enum = implode($separator, $array);

        if ($enum) {
            $enum .= $lastSeparator . $last;
        } else {
            $enum = $last;
        }

        return $enum;
    }

    /**
     * Transforma para singular
     * @param string $value
     * @return string
     */
    static public function singularize($value) {
        $sufixs = ['ns' => 'm', 'oes' => 'ao', 'ores' => 'r', 'ais' => 'al', 's' => null];
        $ignored_sufixs = ['bonus', 'gratis', 'ganhe', 'status'];
        $singulares_map = array_flip(self::$singularPluralMap);
        $value_lowercase = strtolower($value);

        if (isset($singulares_map[$value_lowercase])) {
            return ucfirst($singulares_map[$value_lowercase]);
        }

        foreach ($ignored_sufixs as $sufix) {
            if (substr($value_lowercase, (0 -strlen($sufix))) == $sufix) {
                return $value;
            }
        }

        foreach ($sufixs as $sufix => $append) {
            $sufix_tam = strlen($sufix);
            if (substr($value, 0-$sufix_tam) == $sufix) {
                return substr($value, 0, 0-$sufix_tam) . ($append ? $append : '');
            }
        }

        return $value;
    }

    /**
     * Transforma para plural
     * @param string $value
     * @return string
     */
    static public function pluralize($value)
    {
        $sufixs = ['m' => 'ns', 'ao' => 'oes', 'or' => 'es', 'al' => 'ais'];
        $plurals_map = self::$singularPluralMap;
        $value_lowercase = strtolower($value);

        if (isset($plurals_map[$value_lowercase])) {
            return ucfirst($plurals_map[$value_lowercase]);
        }

        foreach ($sufixs as $sufix => $append) {
            $sufix_tam = strlen($sufix);
            if (substr($value, 0 - $sufix_tam) == $sufix) {
                return substr($value, 0, 0 - $sufix_tam) . ($append ? $append : '');
            }
        }

        $value_last_letter = substr($value, - 1, 1);
        if ($value_last_letter != 's' && !is_numeric($value_last_letter)) {
            return $value . 's';
        }

        return $value;
    }

    /**
     * Retorna se a string está no padrão UTF-8
     * @param string $value
     * @return boolean
     */
    static public function isUtf8($value)
    {
        return (boolean) preg_match(
            "%(?:
            [\xC2-\xDF][\x80-\xBF]
            |\xE0[\xA0-\xBF][\x80-\xBF]
            |[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}
            |\xED[\x80-\x9F][\x80-\xBF]
            |\xF0[\x90-\xBF][\x80-\xBF]{2}
            |[\xF1-\xF3][\x80-\xBF]{3}
            |\xF4[\x80-\x8F][\x80-\xBF]{2}
            )+%xs",
            $value
        );
    }

    /**
     * Transforma caracteres especiais em seus similares "normais"
     * @param string $value
     * @return string
     */
    public static function noSpecialCharacters($value)
    {
        if (self::isUtf8($value)) {
            $dictonary = [
                "\xC3\x80" => "A",
                "\xC3\x81" => "A",
                "\xC3\x82" => "A",
                "\xC3\x83" => "A",
                "\xC3\x84" => "A",
                "\xC3\x85" => "A",
                "\xC3\x86" => "AE",
                "\xC3\x87" => "C",
                "\xC3\x88" => "E",
                "\xC3\x89" => "E",
                "\xC3\x8A" => "E",
                "\xC3\x8B" => "E",
                "\xC3\x8C" => "I",
                "\xC3\x8D" => "I",
                "\xC3\x8E" => "I",
                "\xC3\x8F" => "I",
                "\xC3\x90" => "D",
                "\xC3\x91" => "N",
                "\xC3\x92" => "O",
                "\xC3\x93" => "o",
                "\xC3\x94" => "O",
                "\xC3\x95" => "O",
                "\xC3\x96" => "O",
                "\xC5\x90" => "O",
                "\xC3\x98" => "O",
                "\xC3\x99" => "U",
                "\xC3\x9A" => "U",
                "\xC3\x9B" => "U",
                "\xC3\x9C" => "U",
                "\xC5\xB0" => "U",
                "\xC3\x9D" => "Y",
                "\xC3\x9E" => "TH",
                "\xC3\x9F" => "ss",
                "\xC3\xA0" => "a",
                "\xC3\xA1" => "a",
                "\xC3\xA2" => "a",
                "\xC3\xA3" => "a",
                "\xC3\xA4" => "a",
                "\xC3\xA5" => "a",
                "\xC3\xA6" => "ae",
                "\xC3\xA7" => "c",
                "\xC3\xA8" => "e",
                "\xC3\xA9" => "e",
                "\xC3\xAA" => "e",
                "\xC3\xAB" => "e",
                "\xC3\xAC" => "i",
                "\xC3\xAD" => "i",
                "\xC3\xAE" => "i",
                "\xC3\xAF" => "i",
                "\xC3\xB0" => "d",
                "\xC3\xB1" => "n",
                "\xC3\xB2" => "o",
                "\xC3\xB3" => "o",
                "\xC3\xB4" => "o",
                "\xC3\xB5" => "o",
                "\xC3\xB6" => "o",
                "\xC5\x91" => "o",
                "\xC3\xB8" => "o",
                "\xC3\xB9" => "u",
                "\xC3\xBA" => "u",
                "\xC3\xBB" => "u",
                "\xC3\xBC" => "u",
                "\xC5\xB1" => "u",
                "\xC3\xBD" => "y",
                "\xC3\xBE" => "th",
                "\xC3\xBF" => "y",
                "\xC2\xA9" => "(c)",
                "\xCE\x91" => "A",
                "\xCE\x92" => "B",
                "\xCE\x93" => "G",
                "\xCE\x94" => "D",
                "\xCE\x95" => "E",
                "\xCE\x96" => "Z",
                "\xCE\x97" => "H",
                "\xCE\x98" => "8",
                "\xCE\x99" => "I",
                "\xCE\x9A" => "K",
                "\xCE\x9B" => "L",
                "\xCE\x9C" => "M",
                "\xCE\x9D" => "N",
                "\xCE\x9E" => "3",
                "\xCE\x9F" => "O",
                "\xCE\xA0" => "P",
                "\xCE\xA1" => "R",
                "\xCE\xA3" => "S",
                "\xCE\xA4" => "T",
                "\xCE\xA5" => "Y",
                "\xCE\xA6" => "F",
                "\xCE\xA7" => "X",
                "\xCE\xA8" => "PS",
                "\xCE\xA9" => "W",
                "\xCE\x86" => "A",
                "\xCE\x88" => "E",
                "\xCE\x8A" => "I",
                "\xCE\x8C" => "O",
                "\xCE\x8E" => "Y",
                "\xCE\x89" => "H",
                "\xCE\x8F" => "W",
                "\xCE\xAA" => "I",
                "\xCE\xAB" => "Y",
                "\xCE\xB1" => "a",
                "\xCE\xB2" => "b",
                "\xCE\xB3" => "g",
                "\xCE\xB4" => "d",
                "\xCE\xB5" => "e",
                "\xCE\xB6" => "z",
                "\xCE\xB7" => "h",
                "\xCE\xB8" => "8",
                "\xCE\xB9" => "i",
                "\xCE\xBA" => "k",
                "\xCE\xBB" => "l",
                "\xCE\xBC" => "m",
                "\xCE\xBD" => "n",
                "\xCE\xBE" => "3",
                "\xCE\xBF" => "o",
                "\xCF\x80" => "p",
                "\xCF\x81" => "r",
                "\xCF\x83" => "s",
                "\xCF\x84" => "t",
                "\xCF\x85" => "y",
                "\xCF\x86" => "f",
                "\xCF\x87" => "x",
                "\xCF\x88" => "ps",
                "\xCF\x89" => "w",
                "\xCE\xAC" => "a",
                "\xCE\xAD" => "e",
                "\xCE\xAF" => "i",
                "\xCF\x8C" => "o",
                "\xCF\x8D" => "y",
                "\xCE\xAE" => "h",
                "\xCF\x8E" => "w",
                "\xCF\x82" => "s",
                "\xCF\x8A" => "i",
                "\xCE\xB0" => "y",
                "\xCF\x8B" => "y",
                "\xCE\x90" => "i",
                "\xC5\x9E" => "S",
                "\xC4\xB0" => "I",
                "\xC4\x9E" => "G",
                "\xC5\x9F" => "s",
                "\xC4\xB1" => "i",
                "\xC4\x9F" => "g",
                "\xD0\x90" => "A",
                "\xD0\x91" => "B",
                "\xD0\x92" => "V",
                "\xD0\x93" => "G",
                "\xD0\x94" => "D",
                "\xD0\x95" => "E",
                "\xD0\x81" => "Yo",
                "\xD0\x96" => "Zh",
                "\xD0\x97" => "Z",
                "\xD0\x98" => "I",
                "\xD0\x99" => "J",
                "\xD0\x9A" => "K",
                "\xD0\x9B" => "L",
                "\xD0\x9C" => "M",
                "\xD0\x9D" => "N",
                "\xD0\x9E" => "O",
                "\xD0\x9F" => "P",
                "\xD0\xA0" => "R",
                "\xD0\xA1" => "S",
                "\xD0\xA2" => "T",
                "\xD0\xA3" => "U",
                "\xD0\xA4" => "F",
                "\xD0\xA5" => "H",
                "\xD0\xA6" => "C",
                "\xD0\xA7" => "Ch",
                "\xD0\xA8" => "Sh",
                "\xD0\xA9" => "Sh",
                "\xD0\xAA" => "",
                "\xD0\xAB" => "Y",
                "\xD0\xAC" => "",
                "\xD0\xAD" => "E",
                "\xD0\xAE" => "Yu",
                "\xD0\xAF" => "Ya",
                "\xD0\xB0" => "a",
                "\xD0\xB1" => "b",
                "\xD0\xB2" => "v",
                "\xD0\xB3" => "g",
                "\xD0\xB4" => "d",
                "\xD0\xB5" => "e",
                "\xD1\x91" => "yo",
                "\xD0\xB6" => "zh",
                "\xD0\xB7" => "z",
                "\xD0\xB8" => "i",
                "\xD0\xB9" => "j",
                "\xD0\xBA" => "k",
                "\xD0\xBB" => "l",
                "\xD0\xBC" => "m",
                "\xD0\xBD" => "n",
                "\xD0\xBE" => "o",
                "\xD0\xBF" => "p",
                "\xD1\x80" => "r",
                "\xD1\x81" => "s",
                "\xD1\x82" => "t",
                "\xD1\x83" => "u",
                "\xD1\x84" => "f",
                "\xD1\x85" => "h",
                "\xD1\x86" => "c",
                "\xD1\x87" => "ch",
                "\xD1\x88" => "sh",
                "\xD1\x89" => "sh",
                "\xD1\x8A" => "",
                "\xD1\x8B" => "y",
                "\xD1\x8C" => "",
                "\xD1\x8D" => "e",
                "\xD1\x8E" => "yu",
                "\xD1\x8F" => "ya",
                "\xD0\x84" => "Ye",
                "\xD0\x86" => "I",
                "\xD0\x87" => "Yi",
                "\xD2\x90" => "G",
                "\xD1\x94" => "ye",
                "\xD1\x96" => "i",
                "\xD1\x97" => "yi",
                "\xD2\x91" => "g",
                "\xC4\x8C" => "C",
                "\xC4\x8E" => "D",
                "\xC4\x9A" => "E",
                "\xC5\x87" => "N",
                "\xC5\x98" => "R",
                "\xC5\xA0" => "S",
                "\xC5\xA4" => "T",
                "\xC5\xAE" => "U",
                "\xC5\xBD" => "Z",
                "\xC4\x8D" => "c",
                "\xC4\x8F" => "d",
                "\xC4\x9B" => "e",
                "\xC5\x88" => "n",
                "\xC5\x99" => "r",
                "\xC5\xA1" => "s",
                "\xC5\xA5" => "t",
                "\xC5\xAF" => "u",
                "\xC5\xBE" => "z",
                "\xC4\x84" => "A",
                "\xC4\x86" => "C",
                "\xC4\x98" => "e",
                "\xC5\x81" => "L",
                "\xC5\x83" => "N",
                "\xC5\x9A" => "S",
                "\xC5\xB9" => "Z",
                "\xC5\xBB" => "Z",
                "\xC4\x85" => "a",
                "\xC4\x87" => "c",
                "\xC4\x99" => "e",
                "\xC5\x82" => "l",
                "\xC5\x84" => "n",
                "\xC5\x9B" => "s",
                "\xC5\xBA" => "z",
                "\xC5\xBC" => "z",
                "\xC4\x80" => "A",
                "\xC4\x92" => "E",
                "\xC4\xA2" => "G",
                "\xC4\xAA" => "i",
                "\xC4\xB6" => "k",
                "\xC4\xBB" => "L",
                "\xC5\x85" => "N",
                "\xC5\xAA" => "u",
                "\xC4\x81" => "a",
                "\xC4\x93" => "e",
                "\xC4\xA3" => "g",
                "\xC4\xAB" => "i",
                "\xC4\xB7" => "k",
                "\xC4\xBC" => "l",
                "\xC5\x86" => "n",
                "\xC5\xAB" => "u"
            ];
        } else {
            $dictonary = [
                "\xC0" => "A",
                "\xC1" => "A",
                "\xC2" => "A",
                "\xC3" => "A",
                "\xC4" => "A",
                "\xC5" => "A",
                "\xC6" => "AE",
                "\xC7" => "C",
                "\xC8" => "E",
                "\xC9" => "E",
                "\xCA" => "E",
                "\xCB" => "E",
                "\xCC" => "I",
                "\xCD" => "I",
                "\xCE" => "I",
                "\xCF" => "I",
                "\xD1" => "N",
                "\xD2" => "O",
                "\xD3" => "O",
                "\xD4" => "O",
                "\xD5" => "O",
                "\xD6" => "O",
                "\xD8" => "O",
                "\xD9" => "U",
                "\xDA" => "U",
                "\xDB" => "U",
                "\xDC" => "U",
                "\xDD" => "Y",
                "\xDF" => "sz",
                "\xE0" => "a",
                "\xE1" => "a",
                "\xE2" => "a",
                "\xE3" => "a",
                "\xE4" => "a",
                "\xE5" => "a",
                "\xE6" => "ae",
                "\xE7" => "c",
                "\xE8" => "e",
                "\xE9" => "e",
                "\xEA" => "e",
                "\xEB" => "e",
                "\xEC" => "i",
                "\xED" => "i",
                "\xEE" => "i",
                "\xEF" => "i",
                "\xF1" => "n",
                "\xF2" => "o",
                "\xF3" => "o",
                "\xF4" => "o",
                "\xF5" => "o",
                "\xF6" => "o",
                "\xF8" => "o",
                "\xF9" => "u",
                "\xFA" => "u",
                "\xFB" => "u",
                "\xFC" => "u",
                "\xFD" => "y",
                "\xFF" => "y"
            ];
        }

        return strtr($value, $dictonary);
    }

    /**
     * Remove todos os caracteres especiais de uma string.
     * Remove todos os caracteres com exceção de números, letras de A à Z e
     * hífen substituindo por hífen
     * @param string $value
     * @return string
     */
    public static function slug($value)
    {
        $value = self::noSpecialCharacters($value);

        $value = strtolower($value);

        $value = preg_replace("~[^0-9a-z]+~", "-", $value);

        $value = preg_replace("~\-+~", "-", $value);

        $value = trim($value, "-");

        return $value;
    }

    /**
     * Converte uma string para lowerCamelCase.
     *
     * @param string $text String a ser convertida.
     *
     * @return string
     */
    public static function toCamelCase($text)
    {
        $text = self::noSpecialCharacters(str_replace([' ', '-', '|', '~', '.', ';'], '_', $text));
        $text = strtolower($text);

        return preg_replace_callback(
            '/_([a-z])/',
            function ($match) {
                return strtoupper($match[1]);
            },
            $text
        );
    }

    /**
     * Converte uma string under case para camel case.
     *
     * @param string $text texto a ser convertido para camel case.
     *
     * @return string
     */
    public static function underToCamel($text)
    {
        $text[0] = strtoupper($text[0]);


        if (!isset($GLOBALS['cmtuncalbckfc'])) {
            $func = create_function('$c', 'return strtoupper($c[1]);');
            $GLOBALS['cmtuncalbckfc'] = $func;
        } else {
            $func =& $GLOBALS['cmtuncalbckfc'];
        }

        $text = preg_replace_callback('/_([a-z])/', $func, $text);

        return $text;
    }

    /**
     * Converte uma string para snake_case.
     *
     * @param string $text String a ser convertida.
     *
     * @return string
     */
    public static function toSnakeCase($text)
    {
        return self::noSpecialCharacters(str_replace([' ', '-', '|', '~', '.', ';'], '_', $text));
    }

    /**
     * Converte uma string em lowerCamelCase para snake_case
     *
     * @param string $text Texto a ser convertido.
     *
     * @return string
     */
    public static function camelToSnake($text)
    {
        $text = self::noSpecialCharacters($text);

        $text = preg_replace_callback(
            '/([A-Z])/',
            function ($match) {
                return '_' . strtolower($match[1]);
            },
            $text
        );

        return $text;
    }

    /**
     * Verifica se um string é um JSON.
     *
     * @param string $string
     *
     * @return bool Verdadeiro se for um JSON, falso caso contrário.
     */
    public static function isJson($string)
    {
        if (!is_string($string)) {
            return false;
        }

        return !preg_match('/[^,:{}\\[\\]0-9.\\-+Eaeflnr-u \\n\\r\\t]/',
            preg_replace('/"(\\.|[^"\\\\])*"/', '', $string));
    }

    /**
     * Removendo caracteres especiais não printáveis.
     *
     * @param string $text Texto a ser formatado.
     *
     * @return bool|string Texto sem os caracteres especiais não printáveis.
     */
    public static function removeUnprintableCharacters($text)
    {
        if (mb_detect_encoding($text) != 'UTF-8') {

            try {
                $text = Utf8::encode($text);

            } catch (Utf8Exception $e) {
                // Previni fatal error
            }
        }

        $pregReturn = preg_replace('~[^[:print:]]~u', '', $text);

        try {
            return ($pregReturn === null) ? $text : Utf8::decode($pregReturn);

        } catch (Utf8Exception $e) {

            return $pregReturn;
        }
    }
}
