<?php

namespace console\controllers;

use yii\console\Controller;
use common\models\ConsoleReport;
use common\models\Calendar;
use common\models\User;
use common\models\ArrayProcessing;

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




        //print_r($table);
        //print_r($activePayUsers);

        echo 'makeraiting/make' . PHP_EOL;
    }
}