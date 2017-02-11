<?php

namespace common\models;

use common\models\Calendar;
use yii\base\Exception;
use yii\db\Query;

class ReportOld
{
    /**
     * @var object Query Объект класса yii\db\Query
     */
    protected $query;

    /**
     * @var integer $intervalDates Интервал даты для определенной недели недели
     */
    protected $intervalDates;

    public function __construct()
    {
        $this->query = new Query;
    }

    /**
     * Устанавливает даты начала и конца недели в свойсвто $intervalDates
     *
     * @param integer $calendarId ID недели из таблицы calendar
     * @throws Exception Выбрасывается исключение если неделя не найдена
     */
    public function setIntervalDates($calendarId)
    {
        $this->intervalDates = Calendar::find()
            ->select('date_start, date_end')
            ->where('id = :id', [':id' => $calendarId])
            ->one();

        if(is_null($this->intervalDates)) {
            throw new Exception('Неделя не найдена');
        }
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
     * Объединяет ключи name и складывает tokens для таблицы team
     *
     * @param array $arr Результат выборки метода getTeamTokens()
     * @return array
     */
    protected function combineTeamKeys($arr)
    {
        $combineArr = [];

        for($i = count($arr) - 1; $i >= 0;  $i--) {

            if(!isset($combineArr[$arr[$i]['name']])) {
                $combineArr[$arr[$i]['name']]['team_tokens'] = $arr[$i]['tokens'];
                $combineArr[$arr[$i]['name']]['zeroteam'] = $arr[$i]['zeroteam'];
            } else {
                $combineArr[$arr[$i]['name']]['team_tokens'] += $arr[$i]['tokens'];
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
     * Callback функция для сортировки массива метода getFirstReport
     *
     * @param $a
     * @param $b
     * @return bool
     */
    protected function sortArrFirstReport($a, $b)
    {
        if ($a['tokens'] === $b['tokens']) return 0;
        return $a['tokens'] < $b['tokens'] ? 1 : -1;
    }

    /**
     * Callback функция для сортировки массива метода getSecondReport
     *
     * @param $a
     * @param $b
     * @return bool
     */
    protected function sortArrSecondReport($a, $b)
    {
        if ($a['sum'] === $b['sum']) return 0;
        return $a['sum'] < $b['sum'] ? 1 : -1;
    }

    /**
     * Получить tokens за неделю из таблицы ico
     *
     * @return array
     */
    public function getInvestment()
    {
        $queryCommand = new Query;
        $queryCommand->select('name, tokens')
            ->from('ico')
            ->where(['between','created_at', $this->intervalDates->date_start , $this->intervalDates->date_end])
            ->orderBy(['tokens' => SORT_DESC]);
        $command = $queryCommand->createCommand();

        return $this->combineInvestmentKeys($command->queryAll());
    }

    /**
     * Получить tokens за неделю из таблицы team
     *
     * @return array
     */
    public function getTeamTokens()
    {
        $queryCommand = new Query;
        $queryCommand->select('name, tokens, zeroteam')
            ->from('team')
            ->where(['between','created_at', $this->intervalDates->date_start , $this->intervalDates->date_end])
            ->orderBy(['tokens' => SORT_DESC]);
        $command = $queryCommand->createCommand();

        return $this->combineTeamKeys($command->queryAll());
    }

    /**
     * Получить tokens за неделю из таблицы bounty
     *
     * @return array
     */
    public function getBountyTokens()
    {
        $queryCommand = new Query;
        $queryCommand->select('name, tokens')
            ->from('bounty')
            ->where(['between','created_at', $this->intervalDates->date_start , $this->intervalDates->date_end])
            ->orderBy(['tokens' => SORT_DESC]);
        $command = $queryCommand->createCommand();

        return $this->combineBountyTokens($command->queryAll());
    }

    /**
     * Формирование массива для таблицы 1
     *
     * @param array $investment Массив tokens из таблицы ico
     * @param array $teamTokens Массив tokens из таблицы team
     * @param array $bountyTokens Массив tokens из таблицы bounty
     * @return array
     */
    public function getFirstReport($investment, $teamTokens, $bountyTokens)
    {
        $args = func_get_args();
        $allKeys = $this->getAllUniqueKeys($args);
        $result = [];

        $key = 0;

        // В начале выводятся поля с ненулевым полем "инвестиция"
        foreach ($allKeys as $itemKey) {
            if(isset($investment[$itemKey]['tokens'])) {
                $key++;
                $result[$key]['username'] = $itemKey;
                $result[$key]['tokens'] = $investment[$itemKey]['tokens'];
                $result[$key]['team_tokens'] = (isset($teamTokens[$itemKey])) ? $teamTokens[$itemKey]['team_tokens'] : null;
                $result[$key]['zeroteam'] = (isset($teamTokens[$itemKey])) ? $teamTokens[$itemKey]['zeroteam'] : null;
                $result[$key]['bounty_tokens'] = (isset($bountyTokens[$itemKey])) ? $bountyTokens[$itemKey]['bounty_tokens'] : null;
            }
        }

        // Затем все остальные
        foreach ($allKeys as $itemKey) {
            if(!isset($investment[$itemKey]['tokens'])) {
                $key++;
                $result[$key]['username'] = $itemKey;
                $result[$key]['tokens'] = (isset($investment[$itemKey])) ? $investment[$itemKey]['tokens'] : null;
                $result[$key]['team_tokens'] = (isset($teamTokens[$itemKey])) ? $teamTokens[$itemKey]['team_tokens'] : null;
                $result[$key]['zeroteam'] = (isset($teamTokens[$itemKey])) ? $teamTokens[$itemKey]['zeroteam'] : null;
                $result[$key]['bounty_tokens'] = (isset($bountyTokens[$itemKey])) ? $bountyTokens[$itemKey]['bounty_tokens'] : null;
            }
        }

        uasort($result, array($this, 'sortArrFirstReport'));

        return $result;
    }



    public function getSecondReport($investment, $teamTokens, $bountyTokens)
    {
        $args = func_get_args();
        $allKeys = $this->getAllUniqueKeys($args);
        $result = [];

        foreach ($allKeys as $key => $itemKey) {
            $result[$key]['username'] = $itemKey;
            $result[$key]['tokens'] = (isset($investment[$itemKey])) ? $investment[$itemKey]['tokens'] : null;
            $result[$key]['team_tokens'] = (isset($teamTokens[$itemKey])) ? $teamTokens[$itemKey]['team_tokens'] : null;
            $result[$key]['zeroteam'] = (isset($teamTokens[$itemKey])) ? $teamTokens[$itemKey]['zeroteam'] : null;
            $result[$key]['bounty_tokens'] = (isset($bountyTokens[$itemKey])) ? $bountyTokens[$itemKey]['bounty_tokens'] : null;
            $result[$key]['sum'] =
                $result[$key]['tokens'] +
                $result[$key]['team_tokens'] +
                $result[$key]['zeroteam'] +
                $result[$key]['bounty_tokens'];
        }

        uasort($result, array($this, 'sortArrSecondReport'));

        return $result;
    }

    public function getTotalTokens()
    {
        return round(
            $this->query
                ->from('ico')
                ->where(['between','created_at', $this->intervalDates->date_start , $this->intervalDates->date_end])
                ->sum('tokens'),
            0);
    }

    public function getTotalTeam()
    {
        return round(
            $this->query
                ->from('team')
                ->where(['between','created_at', $this->intervalDates->date_start , $this->intervalDates->date_end])
                ->sum('tokens'),
            3);
    }

    public function getTotalBounty()
    {
        return round(
            $this->query
                ->from('bounty')
                ->where(['between','created_at', $this->intervalDates->date_start , $this->intervalDates->date_end])
                ->sum('tokens'),
            3);
    }

    public function getTotalZeroteam()
    {
        return $this->query
            ->from('team')
            ->where(['between','created_at', $this->intervalDates->date_start , $this->intervalDates->date_end])
            ->sum('zeroteam');
    }

    public function getTotalSecondReport($arr)
    {
        $totalResult = 0;

        foreach ($arr as $item) {
            $totalResult += $item['sum'];
        }

        return $totalResult;
    }
}