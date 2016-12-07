<?php
/* @var $this \yii\web\View */
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

/* @var $content string */

$this->beginContent('@frontend/views/layouts/base.php')
?>
    <div class="container">

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
<?php $this->endContent() ?>



<script>

 function function_a(data){  //function for show one category by Event onclick on the Tree
   $.ajax({
         method: "GET",
         data: {categories:data
         },
         url: '<?php echo Yii::$app->request->baseUrl . '/ajax/show_by_category' ?>',
         success: function(view) {
             $('#article-index').html(view);
              history.pushState('', '',"category?categories="+ data);
         
         }
     });
}


</script>