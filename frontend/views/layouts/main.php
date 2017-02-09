<?php
/* @var $this \yii\web\View */
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
/* @var $content string */
use cybercog\yii\googleanalytics\widgets\GATracking;

echo GATracking::widget([
    'trackingId' => 'UA-89551963-1',
]) ;

$this->beginContent('@frontend/views/layouts/base.php')
?>
    <div class="container-fluid">
        <div class ="container_for_all">
        <?php echo Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?php if(Yii::$app->session->hasFlash('alert')):?>
            <?php echo \yii\bootstrap\Alert::widget([
                'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
                'options'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
            ])?>
        <?php endif; ?>
        <?php if(Yii::$app->session->hasFlash('success')):?>
            <?php echo \yii\bootstrap\Alert::widget([
                'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('success'), 'body'),
                'options'=>ArrayHelper::getValue(Yii::$app->session->getFlash('success'), 'options'),
            ])?>
        <?php endif; ?>
        
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success alert-dismissable">
             <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-check"></i><?php Yii::t('frontend', 'Saved') ?></h4>
            <?= Yii::$app->session->getFlash('success') ?>
            </div>
       <?php endif; ?>

   
        <?php echo $content ?>

    </div>
    </div>
<?php $this->endContent() ?>

<div class ="version">alfa 1.01 <a href="http://mapala.ru">(0-~)</a></div>

<script>
    //function for show one category by Event onclick on the Tree
    function function_a(data){
        $.ajax({
            method: "GET",
            data: {
                categories:data
            },
            url: '/ajax/category',
            success: function(view) {
                $('#article-index').html(view);
                history.pushState('', '',"/category/"+ data);

            }
        });
    }

    $( document ).ready(function() {
        $('.jstree').bind("changed.jstree", function(e, data, x){
            function_a(JSON.stringify(data.selected));
        });
    });
</script>