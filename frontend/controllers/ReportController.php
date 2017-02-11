<?php

namespace frontend\controllers;

use common\models\FullReport;
use Yii;
use common\models\WeekReport;
use common\models\Calendar;

class ReportController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $calendar = new Calendar();
        $weekReport = new WeekReport($calendar);
        $fullReport = new FullReport($calendar);

        if (Yii::$app->request->get()) {
            $currentWeek = Yii::$app->request->get('weekid');
        } else {
            $currentWeek = null;
        }

        //week report
        $weekReport->setIntervalDates($currentWeek);
        
        $weekInvestment = $weekReport->getInvestment();
        $weekTeamTokens = $weekReport->getTeamTokens();
        $weekBountyTokens = $weekReport->getBountyTokens();

        $weekTable = $weekReport->getReport($weekInvestment, $weekTeamTokens, $weekBountyTokens);
        $totalWeekTokens = $weekReport->getTotal('ico', 'tokens');
        $totalWeekBounty = $weekReport->getTotal('bounty', 'tokens');
        $totalWeekTeam = $weekReport->getTotal('team', 'tokens');

        //full report
        $fullReport->setIntervalDates($currentWeek);

        $fullInvestment = $fullReport->getInvestment();
        $fullTeamTokens = $fullReport->getTeamTokens();
        $fullBountyTokens = $fullReport->getBountyTokens();

        $fullTable = $fullReport->getReport($fullInvestment, $fullTeamTokens, $fullBountyTokens);
        $totalFullTokens = $fullReport->getTotal('ico', 'tokens');
        $totalFullBounty = $fullReport->getTotal('bounty', 'tokens');
        $totalFullTeam = $fullReport->getTotal('team', 'tokens');
        $totalFullReport = $fullReport->getTotalReport($fullTable);
        $totalFullZeroteam = $fullReport->getTotalZeroteam();

        //echo "<pre>".print_r($fullTable, true)."</pre>";

        return $this->render('index', [
            'weekTable' => $weekTable,
            'totalWeekTokens' => $totalWeekTokens,
            'totalWeekTeam' => $totalWeekTeam,
            'totalWeekBounty' => $totalWeekBounty,
            'fullTable' => $fullTable,
            'totalFullZeroteam' => $totalFullZeroteam,
            'totalFullReport' => $totalFullReport,
            'totalFullTokens' => $totalFullTokens,
            'totalFullBounty' => $totalFullBounty,
            'totalFullTeam' => $totalFullTeam,
            'actualWeeks' => array_reverse($weekReport->actualWeeks),
            'currentWeek' => $weekReport->currentWeekId,
        ]);
    }

}