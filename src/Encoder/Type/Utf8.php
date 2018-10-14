<?php

namespace MDW\Utils\Encoder\Type;

use MDW\Utils\Encoder\Contract\Codifiable;
use MDW\Utils\Encoder\Exception\Utf8Exception;
use stdClass;

/**
 * Trata das codificações de tipo Utf8.
 *
 * @author Thiago Hofmeister <thiago.hofmeister@gmail.com>
 */
class Utf8 implements Codifiable
{

    /**
     * {@inheritdoc}
     *
     * @throws Utf8Exception Caso ocorra algum erro na hora de fazer o decode.
     */
    public static function decode($data)
    {
        $returnData = true;
        $trim = false;
        $index = true;
        if ($data) {
            if (is_string($data)) {
                if (self::isUtf8($data)) {
                    if ($returnData) {
                        if ($trim) {
                            if (is_string($trim)) {
                                return trim(utf8_decode($data), $trim);
                            } else {
                                return trim(utf8_decode($data));
                            }
                        } else {
                            return utf8_decode($data);
                        }
                    } elseif ($trim) {
                        if (is_string($trim)) {
                            $data = trim(utf8_decode($data), $trim);
                        } else {
                            $data = trim(utf8_decode($data));
                        }
                    } else {
                        $data = utf8_decode($data);
                    }
                } elseif ($returnData) {
                    if ($trim) {
                        if (is_string($trim)) {
                            return trim($data, $trim);
                        } else {
                            return trim($data);
                        }
                    } else {
                        return $data;
                    }
                }
            } elseif (is_array($data)) {
                if ($returnData) {
                    $decoded = [];
                    if ($index) {
                        foreach ($data as $key => &$text) {
                            $decoded[self::decode($key)] = self::decode($text, $trim, $index);
                        }
                    } else {
                        foreach ($data as $key => &$text) {
                            $decoded[$key] = self::decode($text, $trim, $index);
                        }
                    }

                    return $decoded;
                } elseif ($index) {
                    foreach ($data as $key => &$text) {
                        self::decode($text, $trim, $index);
                        if (($tmpkey = self::decode($key)) != $key) {
                            $data[$tmpkey] = $data[$key];
                            unset($data[$key]);
                        }
                    }
                } else {
                    foreach ($data as $key => &$text) {
                        self::decode($text, $trim, $index);
                    }
                }
            } elseif (is_object($data)) {
                if ($returnData) {
                    $decoded = new stdClass();
                    if ($index) {
                        foreach ($data as $key => &$text) {
                            self::decode($key);
                            $decoded->$key = self::decode($text, $trim, $index);
                        }
                    } else {
                        foreach ($data as $key => &$text) {
                            $decoded->$key = self::decode($text, $trim, $index);
                        }
                    }

                    return $decoded;
                } elseif ($index) {
                    foreach ($data as $key => &$text) {
                        self::decode($text, $trim, $index);
                        if (($tmpkey = self::decode($key)) != $key) {
                            $data->$tmpkey = $data->$key;
                            unset($data->$key);
                        }
                    }
                } else {
                    foreach ($data as $key => &$text) {
                        self::decode($text, $trim, $index);
                    }
                }
            } elseif ($returnData) {
                return $data;
            }

            return true;
        } elseif ($returnData) {
            return $data;
        } else {
            throw new Utf8Exception('Não foi possível decodificar de Utf8');
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param boolean $trim
     * @param boolean $index
     *
     * @throws Utf8Exception Caso ocorra algum erro na hora de fazer o encode.
     */
    public static function encode($data, $trim = false, $index = true)
    {
        $returnData = true;
        $trim = false;
        $index = true;
        if ($data) {
            if (is_string($data)) {
                if (!self::isUtf8($data)) {
                    if ($returnData) {
                        if ($trim) {
                            if (is_string($trim)) {
                                return trim(utf8_encode($data), $trim);
                            } else {
                                return trim(utf8_encode($data));
                            }
                        } else {
                            return utf8_encode($data);
                        }
                    } elseif ($trim) {
                        if (is_string($trim)) {
                            $data = trim(utf8_encode($data), $trim);
                        } else {
                            $data = trim(utf8_encode($data));
                        }
                    } else {
                        $data = utf8_encode($data);
                    }
                } elseif ($returnData) {
                    if ($trim) {
                        if (is_string($trim)) {
                            return trim($data, $trim);
                        } else {
                            return trim($data);
                        }
                    } else {
                        return $data;
                    }
                }
            } elseif (is_array($data)) {
                if ($returnData) {
                    $encoded = [];
                    if ($index) {
                        foreach ($data as $key => &$text) {
                            $encoded[self::encode($key)] = self::encode($text, $trim, $index);
                        }
                    } else {
                        foreach ($data as $key => &$text) {
                            $encoded[$key] = self::encode($text, $trim, $index);
                        }
                    }

                    return $encoded;
                } elseif ($index) {
                    foreach ($data as $key => &$text) {
                        self::encode($text, $trim, $index);
                        if (($tmpkey = self::encode($key)) != $key) {
                            $data[$tmpkey] = $data[$key];
                            unset($data[$key]);
                        }
                    }
                } else {
                    foreach ($data as $key => &$text) {
                        self::encode($text, $trim, $index);
                    }
                }
            } elseif (is_object($data)) {
                if ($returnData) {
                    $encoded = new stdClass();
                    if ($index) {
                        foreach ($data as $key => &$text) {
                            self::encode($key);
                            $encoded->$key = self::encode($text, $trim, $index);
                        }
                    } else {
                        foreach ($data as $key => &$text) {
                            $encoded->$key = self::encode($text, $trim, $index);
                        }
                    }

                    return $encoded;
                } elseif ($index) {
                    foreach ($data as $key => &$text) {
                        self::encode($text, $trim, $index);
                        if (($tmpkey = self::encode($key)) != $key) {
                            $data->$tmpkey = $data->$key;
                            unset($data->$key);
                        }
                    }
                } else {
                    foreach ($data as $key => &$text) {
                        self::encode($text, $trim, $index);
                    }
                }
            } elseif ($returnData) {
                return $data;
            }

            return true;
        } elseif ($returnData) {
            return $data;
        } else {
            throw new Utf8Exception('Não foi possível codificar para Utf8');
        }
    }

    /**
     * Verifica se a string passar é encodada em UTF-8.
     *
     * @param string $string Texto a ser verificado se é UTF8.
     *
     * @return int 1 se for UTF8, 0 caso contrário.
     */
    private static function isUtf8($string)
    {
        return preg_match("%(?:
                            [\xC2-\xDF][\x80-\xBF]
                            |\xE0[\xA0-\xBF][\x80-\xBF]
                            |[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}
                            |\xED[\x80-\x9F][\x80-\xBF]
                            |\xF0[\x90-\xBF][\x80-\xBF]{2}
                            |[\xF1-\xF3][\x80-\xBF]{3}
                            |\xF4[\x80-\x8F][\x80-\xBF]{2}
                            )+%xs", $string);
    }
}
