<?php

namespace common\models;

use yii\base\Exception;
use yii\db\Query;

class FullReport extends Report
{
    const START_DATE = '2017-01-01 00:00:01';

    public function __construct(Calendar $calendar)
    {
        try {
            $this->actualWeeks = $calendar->getActualWeeks();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
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
        if ($a['sum'] === $b['sum']) return 0;
        return $a['sum'] < $b['sum'] ? 1 : -1;
    }

    /**
     * Проверяет условие, если zeroteam, то значение таблицы team.tokens записывается в zeroteam
     *
     * @param array $arr
     * @return array
     */
    protected function combineTeamKeys($arr)
    {
        $combineArr = [];

        for($i = count($arr) - 1; $i >= 0;  $i--) {

            if(!isset($combineArr[$arr[$i]['name']])) {
                if($arr[$i]['zeroteam']) {
                    $combineArr[$arr[$i]['name']]['zeroteam'] = $arr[$i]['tokens'];
                    $combineArr[$arr[$i]['name']]['team_tokens'] = 0;
                } else {
                    $combineArr[$arr[$i]['name']]['team_tokens'] = $arr[$i]['tokens'];
                    $combineArr[$arr[$i]['name']]['zeroteam'] = 0;
                }
            } else {
                if($arr[$i]['zeroteam']) {
                    $combineArr[$arr[$i]['name']]['zeroteam'] += $arr[$i]['tokens'];
                } else {
                    $combineArr[$arr[$i]['name']]['team_tokens'] += $arr[$i]['tokens'];
                }
            }
        }

        return $combineArr;
    }

    /**
     * Высчитывает рейтинг
     *
     * @param int $currentraiting Текущий рейтинг
     * @param string $username Имя пользователя
     * @param int $previousWeekRaiting Рейтинг за прошлую неделю
     * @return array
     */
    protected function calculateRaiting($currentraiting, $username, $previousWeekRaiting)
    {
        $result = [];

        if(!isset($previousWeekRaiting[$username]['raiting'])) {
            $number = 'new';
            $color = 'default';
        } else {
            $number = $currentraiting - $previousWeekRaiting[$username]['raiting'];
            if($number > 0) {
                $number = "+" . $number;
                $color = 'green';
            } elseif($number == 0) {
                $number = '-';
                $color = 'green';
            } else {
                $color = 'red';
            }
        }
        $result['number'] = $number;
        $result['color'] = $color;

        return $result;
    }

    /**
     * Устанавливает даты начала и конца недели в свойсвто $intervalDates
     *
     * @param integer $calendarId ID недели из таблицы calendar
     * @throws Exception Выбрасывается исключение если неделя не найдена
     */
    public function setIntervalDates($calendarId = null)
    {
        $firstWeek = current($this->actualWeeks);
        $lastWeek = end($this->actualWeeks);

        $this->date_start = self::START_DATE;
        $this->date_end = $lastWeek->date_end;
    }

    public function getReport($investment, $teamTokens, $bountyTokens, $previousWeekRaitng)
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

            $result[$key]['raiting'] = $this->calculateRaiting($key, $itemKey, $previousWeekRaitng);
        }

        uasort($result, array($this, 'sortArr'));

        return array_values($result);
    }

    /**
     * Складывает значения всех полей sum
     *
     * @param array $arr
     * @return int
     */
    public function getTotalReport($arr)
    {
        $totalResult = 0;

        foreach ($arr as $item) {
            $totalResult += $item['sum'];
        }

        return $totalResult;
    }

    public function getTotalZeroteam()
    {
        $queryCommand = new Query;
        $queryCommand->from('team');
        $this->actualDates($queryCommand);
        $queryCommand->andWhere(['zeroteam' => 1]);
        $sum = $queryCommand->sum('tokens');

        return round($sum, static::ROUND_PRECISION);
    }
}