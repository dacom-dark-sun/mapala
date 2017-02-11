<?php

namespace common\models;

use yii\db\Query;
use yii\base\Exception;

abstract class Report
{
    /**
     * @const int Количесвто знаков после запятой
     */
    const ROUND_PRECISION = 0;

    /**
     * @var array $actualWeeks Массив недель, с флагом finished = 1, таблица calendar
     */
    public $actualWeeks;

    /**
     * @var string $date_start Начало даты
     */
    protected $date_start;

    /**
     * @var string $date_start Окончание даты
     */
    protected $date_end;

    abstract protected function combineTeamKeys($arr);

    abstract protected function sortArr($a, $b);

    abstract public function setIntervalDates($calendarId = null);

    abstract public function getReport($investment, $teamTokens, $bountyTokens);

    /**
     * Возвращает уникальные ключи из массивов
     *
     * @param array $args Аргумаеты функции
     * @return array
     */
    protected function getAllUniqueKeys($args)
    {
        $allKeys = [];
        for ($i = count($args) - 1; $i >= 0;  $i--) {
            $allKeys = array_merge($allKeys, array_keys($args[$i]));
        }

        return array_unique($allKeys);
    }

    /**
     * Объединяет ключи name и складывает tokens для таблицы ico
     *
     * @param array $arr Результат выборки метода getInvestment()
     * @return array
     */
    protected function combineInvestmentKeys($arr)
    {
        $combineArr = [];

        for($i = count($arr) - 1; $i >= 0;  $i--) {

            if(!isset($combineArr[$arr[$i]['name']])) {
                $combineArr[$arr[$i]['name']]['tokens'] = $arr[$i]['tokens'];
            } else {
                $combineArr[$arr[$i]['name']]['tokens'] += $arr[$i]['tokens'];
            }
        }

        return $combineArr;
    }

    /**
     * Объединяет ключи name и складывает tokens для таблицы bounty
     *
     * @param array $arr Результат выборки метода getBountyTokens()
     * @return array
     */
    protected function combineBountyTokens($arr)
    {
        $combineArr = [];

        for($i = count($arr) - 1; $i >= 0;  $i--) {
            if(!isset($combineArr[$arr[$i]['name']])) {
                $combineArr[$arr[$i]['name']]['bounty_tokens'] = $arr[$i]['tokens'];
            } else {
                $combineArr[$arr[$i]['name']]['bounty_tokens'] += $arr[$i]['tokens'];
            }
        }

        return $combineArr;
    }

    /**
     * Scope условие where для заданного интервала дат
     *
     * @param Object $queryCommand Объект класса yii\db\Query
     * @return Object
     */
    protected function actualDates($queryCommand)
    {
        return $queryCommand->where(['between','created_at', $this->date_start , $this->date_end]);
    }

    /**
     * Получить tokens за период из таблицы ico
     *
     * @return array
     */
    public function getInvestment()
    {
        $queryCommand = new Query;
        $queryCommand->select('name, tokens')
            ->from('ico')
            ->orderBy(['tokens' => SORT_DESC]);
        $this->actualDates($queryCommand);
        $command = $queryCommand->createCommand();

        return $this->combineInvestmentKeys($command->queryAll());
    }

    /**
     * Получить tokens за период из таблицы team
     *
     * @return array
     */
    public function getTeamTokens()
    {
        $queryCommand = new Query;
        $queryCommand->select('name, tokens, zeroteam')
            ->from('team')
            ->orderBy(['tokens' => SORT_DESC]);
        $this->actualDates($queryCommand);
        $command = $queryCommand->createCommand();

        return $this->combineTeamKeys($command->queryAll());
    }

    /**
     * Получить tokens за период из таблицы bounty
     *
     * @return array
     */
    public function getBountyTokens()
    {
        $queryCommand = new Query;
        $queryCommand->select('name, tokens')
            ->from('bounty')
            ->orderBy(['tokens' => SORT_DESC]);
        $this->actualDates($queryCommand);
        $command = $queryCommand->createCommand();

        return $this->combineBountyTokens($command->queryAll());
    }

    /**
     * Возвращает сумму значений в заданной таблице
     *
     * @param string $tableName Название таблицы
     * @param string $columnName Название колонки
     * @return float
     */
    public function getTotal($tableName, $columnName)
    {
        $queryCommand = new Query;
        $queryCommand->from($tableName);
        $this->actualDates($queryCommand);
        $sum = $queryCommand->sum($columnName);

        return round($sum, self::ROUND_PRECISION);
    }
}