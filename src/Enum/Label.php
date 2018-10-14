<?php

namespace App\Enum;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Abstrata para Enums.
 *
 * @author Thiago Hofmeister <thiago.hofmeister@gmail.com>
 */
abstract class Label extends AbstractEnumeration
{
    public function getLabel()
    {
        $labels = $this->getLabels();

        return !empty($labels[$this->value()]) ? $labels[$this->value()] : 'Nada';
    }

    /**
     * Retorna array com todos os Labels.
     *
     * @return array
     */
    abstract protected function getLabels();
}