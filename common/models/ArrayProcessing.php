<?php

namespace common\models;

/**
 * ArrayProcessing Class Служит для обработки различных массивов
 *
 */
class ArrayProcessing
{
    /**
     * Подгодовка массива для записи в таблицу raiting
     *
     * @param array $arr массив результатов метода getReport
     * @param array $users массив пользователей
     *
     * @return array
     */
    public function PreparationRaitingArr($arr, $users)
    {
        $result = [];
        $arr = array_values($arr);



        foreach ($arr as $key => $item) {
            $username = $item['username'];

            if(!isset($users[$username])) {
                $username = ucfirst($username);
            }

            $result[$key]['raiting'] = $key;
            $result[$key]['username'] = $username;
            $result[$key]['calendar_id'] = $item['calendar_id'];

            if(isset($users[$username])) {
                $result[$key]['user_id'] = $users[$username]['id'];
            } else {
                $result[$key]['user_id'] = null;
            }
        }



        return $result;
    }

    /**
     * Устанавливает ключи массива из значения массива
     *
     * @param array $arr Исходный массив
     * @param string $keyName Название для ключа
     * @return array
     */
    public function setNameAsKey($arr, $keyName)
    {
        $result = [];

        foreach ($arr as $item) {
            $key = $item[$keyName];
            $result[$key] = $item;
        }

        return $result;
    }
}