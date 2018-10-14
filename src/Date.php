<?php

namespace THS\Utils;

use DateTime;

/**
 * operações de manipulação de datas
 *
 * @author Thiago Hofmeister <thiago.hofmeister@gmail.com>
 */
class Date
{
    /** @var int Dia da semana segunda-feira. */
    const MONDAY = 1;

    /** @var int Dia da semana terça-feira. */
    const TUESDAY = 2;

    /** @var int Dia da semana quarta-feira. */
    const WEDNESDAY = 3;

    /** @var int Dia da semana quinta-feira. */
    const THURSDAY = 4;

    /** @var int Dia da semana sexta-feira. */
    const FRIDAY = 5;

    /** @var int Dia da semana sábado. */
    const SATURDAY = 6;

    /** @var int Dia da semana domingo. */
    const SUNDAY = 7;

    /**
     * @var string Padrão de formato de datas persistidas pela moovin.
     *             Exemplo: 2016-12-28 10:11:50
     */
    const MOOVIN_FORMAT = 'Y-m-d H:i:s';

    /** @var string Padrão de formato de datas persistidas pelo MongoDB e pelo Javascript. */
    const JAVASCRIPT_ISO_FORMAT = 'o-m-d\TH:i:s.000\Z';

    /** @var string Padrão de formato de datas persistidas pelo MongoDB e pelo Javascript utilizando timezone. */
    const JAVASCRIPT_ISO_TIMEZONE_FORMAT = 'o-m-d\TH:i:s.vO';

    /**
     * @var string Padrão de formato de datas definido em "HTTP-date" do RFC 7231.
     *             Exemplo: Tue, 15 Nov 1994 12:45:26 UTC
     */
    const RFC_7231_FORMAT = 'D, d M Y H:i:s e';

    /** @var array Dias do final de semana, não úteis. */
    protected $weekendDays = [
        self::SATURDAY,
        self::SUNDAY,
    ];

    /** @var array Data dos feriados nacionais no formato 'd/m'. */
    protected $nationalHolidays = [
        '01/01', // Confraternização universal
        '25/03', // Paixão de Cristo
        '21/04', // Tiradentes
        '07/09', // Independência do Brasil
        '12/10', // Nsa. Sra. Aparecida
        '02/11', // Finados
        '15/11', // Proclamação da República
        '25/12', // Natal
    ];

    /** @var DateTime Data de início dos calculos. */
    private $date;

    /** @var array Datas dos feriados no formato 'd/m'.. */
    private $holidays;

    /** @var int[] Dias NÃO úteis da semana. */
    private $nonBusinessDays;

    /**
     * Constroi um calculador de dias úteis.
     * A data recebida não é armazenada por referência, o objeto é clonado.
     *
     * @param DateTime $startDate Data de inicio dos calculos.
     * @param string[] $holidays Array de datas feriados no formato 'd/m'.
     * @param int[] $nonBusinessDays Array de dias não úteis da semana. 1 para
     *                               segunda-feira e 7 para domingo.
     */
    public function __construct(DateTime $startDate, $holidays = [], $nonBusinessDays = [])
    {
        $this->date = clone $startDate;
        $this->holidays = ($holidays) ?: $this->nationalHolidays;
        $this->nonBusinessDays = ($nonBusinessDays) ?: $this->weekendDays;
    }

    /**
     * Retorna dentre duas datas, aquela que for mais antiga
     *
     * @param \DateTime $dateA
     * @param \DateTime $dateB
     *
     * @return DateTime
     */
    public static function getEarliestDate(\DateTime $dateA, \DateTime $dateB)
    {
        return $dateA > $dateB ? $dateB : $dateA;
    }

    /**
     * Retorna dentre duas datas, aquela que for mais atual
     *
     * @param \DateTime $dateA
     * @param \DateTime $dateB
     *
     * @return DateTime
     */
    public static function getNewestDate(\DateTime $dateA, \DateTime $dateB)
    {
        return $dateA < $dateB ? $dateB : $dateA;
    }

    /**
     * Soma dias úteis na data.
     *
     * @param int $howManyDays Quantidade de dias.
     *
     * @return DateTime Data com os dias somados.
     */
    public function addBusinessDays($howManyDays)
    {
        $i = 0;
        $date = $this->date;
        while ($i < $howManyDays) {
            $date->modify("+1 day");
            if ($this->isBusinessDay($date)) {
                $i++;
            }
        }

        return $date;
    }

    /**
     * Verifica se a data é um dia útil.
     *
     * @param DateTime $date
     * @return bool Verdadeiro se for útil, caso contrário falso.
     */
    private function isBusinessDay(DateTime $date)
    {
        if (in_array((int) $date->format('N'), $this->nonBusinessDays)) {
            return false;
        }

        foreach ($this->holidays as $holiday) {
            if ($date->format('d/m') == $holiday) {
                return false;
            }
        }

        return true;
    }

    /**
     * Adiciona uma data ao array de feriados.
     *
     * @param string $holiday Data do feriado no formato 'd/m', sem ano.
     * @return bool Verdadeiro se adicionou o feriado, caso contrário falso.
     */
    public function addHoliday($holiday)
    {
        if (empty($holiday)) {
            return false;
        }


        if (self::isValidDate($holiday, 'd/m')) {
            $this->holidays[] = $holiday;
            return true;
        }

        return false;
    }

    /**
     * Verifica se a data é válida.
     * Valida o formato e os valores. Valor inválido são é dia maior que 31
     * e mês maior que 12.
     *
     * @param string $date Data a ser verificada.
     * @param string $format Formato que a data deve ter.
     *
     * @return bool Verdadeiro se for válida. Falso se for inválida.
     */
    public static function isValidDate($date, $format = 'Y-m-d')
    {
        $dateTime = DateTime::createFromFormat($format, $date);

        $errors = DateTime::getLastErrors();
        if (!empty($errors['warning_count'])) {
            return false;
        }

        return $dateTime !== false;
    }

    /**
     * Compara a data deste objeto com o objeto recebido por parâmetro.
     *
     * @param DateTime $toCompare data na qual será referência da comparação.
     *
     * @return int se as datas forem iguais o valor de retorno é 0, se a data
     *             deste objeto for maior do que a data de referência da comparação
     *             o retorno é 1, se for menor o retorno é -1.
     */
    public function compareTo(DateTime $toCompare)
    {
        $toCompareTimestamp = $toCompare->getTimestamp();
        $dateTimestamp = $this->date->getTimestamp();

        if ($dateTimestamp > $toCompareTimestamp) {
            return (int) 1;
        }
        if ($dateTimestamp < $toCompareTimestamp) {
            return (int) -1;
        }
        if ($dateTimestamp == $toCompareTimestamp) {
            return (int) 0;
        }
    }
}
