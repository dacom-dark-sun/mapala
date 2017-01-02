
<?php
/**
 * @var $this yii\web\View
 * @var $model common\models\Article
 */
use yii\helpers\Html;
use yii\bootstrap\Collapse;
use talma\widgets\JsTreeAsset;
?>
    <div class='categories-scroll'>
<?= \talma\widgets\JsTree::widget([
    'attribute' => 'attribute_name',
    'name' => 'modek',
    'core' => [
        'themes' =>  [
                'name' => 'proton',
                'url' => "frontend/web/themes/proton/style.css",
                'dots' => true,
                'icons' => true,
            ],
        
        'data' => $data,
    ],
    'plugins' => ['sort','state','wholerow','search', 'unique', 'massload', "dnd"],
    

]);


?> 
</div>
