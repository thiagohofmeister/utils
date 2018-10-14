<?php

namespace MDW\Utils\Converter\Type;

use MDW\Utils\Converter\Contract\ConvertableArray;
use MDW\Utils\Converter\Exception\JsonException;
use MDW\Utils\Encoder\Exception\Utf8Exception;
use MDW\Utils\Encoder\Type\Utf8;

/**
 * Trata das conversões de JSON para array ou vice versa.
 *
 * @author Thiago Hofmeister <thiago.hofmeister@gmail.com>
 */
class Json implements ConvertableArray
{
    /**
     * Converte pra array os dados recebidos pelo parâmetro do tipo do conversor
     *
     * @param string $data Json a ser convertido para array.
     *
     * @return array JSON decode do array.
     *
     * @throws JsonException Caso ocorra algum erro na hora de fazer o decode.
     */
    public static function toArray($data)
    {
        $mustReturnArray = true;

        $array = json_decode($data, $mustReturnArray);

        self::jsonLastError($data);

        if (!is_array($array)) {
            $array = json_decode($array, $mustReturnArray);

            self::jsonLastError($data);
        }

        return $array;
    }

    /**
     * Converte para JSON o array recebido noparâmetro.
     *
     * @param array $data Array a ser convertido para json.
     *
     * @return string JSON encode do array.
     *
     * @throws JsonException Caso ocorra algum erro na hora de fazer o encode.
     * @throws Utf8Exception
     */
    public static function fromArray($data)
    {
        $json_file = json_encode($data);

        try {
            self::jsonLastError($data);
        } catch(JsonException $exception) {
            if (json_last_error() == JSON_ERROR_UTF8) {
                $json_file = json_encode(Utf8::encode($data));
            } else {
                throw $exception;
            }
        }

        return $json_file;
    }

    /**
     * Trata dos erros causados na hora de fazer o json_decode ou json_encode.
     * Lança uma exceção JsonException sendo na mensagem da exceção a mensagem
     * sugerida do erro no link.
     *
     * @see http://php.net/manual/pt_BR/function.json-last-error.php#refsect1-function.json-last-error-returnvalues
     *
     * @param mixed $data
     *
     * @throws JsonException Se o número do json_last_error for algum erro.
     */
    private static function jsonLastError($data)
    {
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return;
                break;
            case JSON_ERROR_DEPTH:
                $jsonException = new JsonException('A profundidade máxima da pilha foi excedida');
                $jsonException->setData($data);
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $jsonException =  new JsonException('JSON inválido ou mal formado');
                $jsonException->setData($data);
                break;
            case JSON_ERROR_CTRL_CHAR:
                $jsonException = new JsonException('Erro de caractere de controle, possivelmente codificado incorretamente');
                $jsonException->setData($data);
                break;
            case JSON_ERROR_SYNTAX:
                $jsonException = new JsonException('Erro de sintaxe');
                $jsonException->setData($data);
                break;
            case JSON_ERROR_UTF8:
                $jsonException = new JsonException('caracteres UTF-8 malformado , possivelmente codificado incorretamente');
                $jsonException->setData($data);
                break;
            default:
                $jsonException = new JsonException('Erro desconhecido');
                $jsonException->setData($data);
                break;
        }

        throw $jsonException;
    }
}
