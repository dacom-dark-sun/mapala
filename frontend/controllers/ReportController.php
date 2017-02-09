<?php

namespace frontend\controllers;

use Yii;
use common\models\Report;
use common\models\Calendar;
use yii\base\Exception;

class ReportController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $report = new Report();
        $calendar = new Calendar();

        try {
            $actualWeeks = $calendar->getActualWeeks();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        if (Yii::$app->request->get()) {
            $currentWeek = Yii::$app->request->get('weekid');
        } else {
            $currentWeek = $actualWeeks[0]['id'];
        }

        try {
            $report->setIntervalDates($currentWeek);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $investment = $report->getInvestment();
        $teamTokens = $report->getTeamTokens();
        $bountyTokens = $report->getBountyTokens();

        $firstReport = $report->getFirstReport($investment, $teamTokens, $bountyTokens);
        $totalTokens = $report->getTotalTokens();
        $totalTeam = $report->getTotalTeam();
        $totalBounty = $report->getTotalBounty();

        $secondReport = $report->getSecondReport($investment, $teamTokens, $bountyTokens);
        $totalSecondReport = $report->getTotalSecondReport($secondReport);
        $totalZeroteam = $report->getTotalZeroteam();

        return $this->render('index', [
            'firstReport' => $firstReport,
            'totalTokens' => $totalTokens,
            'totalTeam' => $totalTeam,
            'totalBounty' => $totalBounty,
            'secondReport' => $secondReport,
            'totalZeroteam' => $totalZeroteam,
            'totalSecondReport' => $totalSecondReport,
            'actualWeeks' => $actualWeeks,
            'currentWeek' => $currentWeek,
            'firstKey' => 0,
            'secondKey' => 0,
        ]);
    }

}