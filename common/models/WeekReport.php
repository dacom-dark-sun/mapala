<?php

namespace common\models;

use yii\base\Exception;

class WeekReport extends Report
{
    /**
     * @var integer ключ массива выбранной недели
     */
    public $currentWeekId;

    public function __construct(Calendar $calendar)
    {
        try {
            $this->actualWeeks = $calendar->getActualWeeks();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Устанавливает даты начала и конца недели в свойсвто $intervalDates
     *
     * @param integer $calendarId ID недели из таблицы calendar
     * @throws Exception Выбрасывается исключение если неделя не найдена
     */
    public function setIntervalDates($calendarId = null)
    {
        if($calendarId == null) {
            $intervalDates =  end($this->actualWeeks);
        } else {
            $intervalDates = $this->actualWeeks[$calendarId - 1];
        }

        $this->currentWeekId = $intervalDates['id'];

        if(is_null($intervalDates)) {
            throw new Exception('Неделя не найдена');
        }

        $this->date_start = $intervalDates->date_start;
        $this->date_end = $intervalDates->date_end;
    }

    /**
     * Callback функция для сортировки массива
     *
     * @param $a
     * @param $b
     * @return bool
     */
    protected function sortArr($a, $b)
    {
        if ($a['tokens'] === $b['tokens']) return 0;
        return $a['tokens'] < $b['tokens'] ? 1 : -1;
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
            } else {
                $combineArr[$arr[$i]['name']]['team_tokens'] += $arr[$i]['tokens'];
            }
        }

        return $combineArr;
    }

    public function getReport($investment, $teamTokens, $bountyTokens)
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
                $result[$key]['bounty_tokens'] = (isset($bountyTokens[$itemKey])) ? $bountyTokens[$itemKey]['bounty_tokens'] : null;
            }
        }

        uasort($result, array($this, 'sortArr'));

        return array_values($result);
    }
}