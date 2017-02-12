<?php

namespace console\controllers;

use yii\console\Controller;
use common\models\ConsoleReport;
use common\models\Calendar;
use common\models\User;
use common\models\ArrayProcessing;
use common\models\Raiting;

class MakeraitingController extends Controller
{
    //php console/yii makeraiting/make
    public function actionMake()
    {
        $calendar = new Calendar();
        $report = new ConsoleReport($calendar);
        $user = new User();
        $processing = new ArrayProcessing();

        $report->setIntervalDates();

        $investment = $report->getInvestment();
        $teamTokens = $report->getTeamTokens();
        $bountyTokens = $report->getBountyTokens();

        $activePayUsers = $user->getActivePayUsers();
        $activePayUsers = $processing->setNameAsKey($activePayUsers, 'username');

        $table = $report->getReport($investment, $teamTokens, $bountyTokens);
        $table = $processing->PreparationRaitingArr($table, $activePayUsers);

        //Удаляем старые записи
        Raiting::deleteAll();

        //Добавляем новые
        foreach ($table as $tableItem) {
            $raitingRow = new Raiting();
            $raitingRow->calend_id = $tableItem['calendar_id'];
            $raitingRow->user_id = $tableItem['user_id'];
            $raitingRow->raiting = $tableItem['raiting'];
            $raitingRow->username = $tableItem['username'];
            $raitingRow->save();
        }

        echo 'Данные в таблице raiting обновлнеы' . PHP_EOL;
    }
}