<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
?>
<div class="container">

    <div class="pagination">
        <ul class="list-group">
            <?php foreach ($actualWeeks as $weekItem):?>
                <?php if($currentWeek == $weekItem['id']):?>
                    <li class="list-group-item active">
                        <a href="<?=Url::to(['report/index', 'weekid' => $weekItem['id']])?>">
                            <?=$weekItem['date_start']?> - <?=$weekItem['date_end']?>
                        </a>
                    </li>
                <?php else:?>
                    <li class="list-group-item">
                        <a href="<?=Url::to(['report/index', 'weekid' => $weekItem['id']])?>">
                            <?=$weekItem['date_start']?> - <?=$weekItem['date_end']?>
                        </a>
                    </li>
                <?php endif;?>
            <?php endforeach;?>
        </ul>
    </div>

    <div class="first-report">
        <h3>Таблица 1</h3>
        <p>Распределение токенов, эмитированных за эту неделю выглядит следующим образом:</p>
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Ник</th>
                    <th>Инвестиция</th>
                    <th>Работа</th>
                    <th>Баунти</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($weekTable as $key=>$item):?>
                    <tr>
                        <td><?=$key + 1?></td>
                        <td><?=$item['username']?></td>
                        <td><?=round($item['tokens'], 3)?></td>
                        <td><?=round($item['team_tokens'], 3)?></td>
                        <td><?=round($item['bounty_tokens'], 3)?></td>
                    </tr>
                <?php endforeach;?>
                    <tr>
                        <td></td>
                        <td><b>Итого за неделю</b></td>
                        <td><?=$totalWeekTokens?></td>
                        <td><?=$totalWeekTeam?></td>
                        <td><?=$totalWeekBounty?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="second-report">
        <h3>Таблица 2</h3>
        <p>Общее распределение:</p>
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th></th>
                    <th>Ник</th>
                    <th>Инвестиция</th>
                    <th>Работа</th>
                    <th>Баунти</th>
                    <th>Zero-team</th>
                    <th>Итого</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($fullTable as $key => $item):?>
                    <tr>
                        <td><?=$key + 1?></td>
                        <td><span class="<?= $item['raiting']['color']?>"><?= $item['raiting']['number']?></span></td>
                        <td><?=$item['username']?></td>
                        <td><?=round($item['tokens'], 3)?></td>
                        <td><?=round($item['team_tokens'], 3)?></td>
                        <td><?=round($item['bounty_tokens'], 3)?></td>
                        <td><?=round($item['zeroteam'], 3)?></td>
                        <td><?=round($item['sum'], 3)?></td>
                    </tr>
                <?php endforeach;?>
                <tr>
                    <td></td>
                    <td></td>
                    <td><b>Итого</b></td>
                    <td><?=$totalFullTokens?></td>
                    <td><?=$totalFullTeam?></td>
                    <td><?=$totalFullBounty?></td>
                    <td><?=$totalFullZeroteam?></td>
                    <td><?=$totalFullReport?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
