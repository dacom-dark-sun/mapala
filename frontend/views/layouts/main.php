<?php
/* @var $this \yii\web\View */
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use common\models\BlockChain;
/* @var $content string */
use cybercog\yii\googleanalytics\widgets\GATracking;
echo GATracking::widget([
    'trackingId' => 'UA-89551963-1',
]) ;

    $this->registerMetaTag([
        'name' => 'og_title',
        'content' => Yii::t('common','Mappala.net invite you to join the worldwide community')
    ]); 
    $this->registerMetaTag([
        'name' => 'og_description',
        'content' => Yii::t('common','Mapala.net sweeping the planet and inviting you to join. The project will be released soon. Hurry up!')
    ]); 
    $this->registerMetaTag([
        'name' => 'og_url',
        'content' => Yii::t('common','https://mapala.net')
    ]); 
    $this->registerMetaTag([
        'name' => 'og_image',
        'content' => Yii::t('common','http://mapala.dev/frontend/web/img/logo_small.png')
    ]); 
$this->beginContent('@frontend/views/layouts/base.php')
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"></script>


<script>
   
</script>

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

<div class ="version">alfa 1.02 <a href="http://mapala.ru">(0-~)</a></div>

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

<?php IF (BlockChain::get_blockchain_from_locale() == 'golos'):?>
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'N3juWrQX6S';var d=document;var w=window;function l(){
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/geo-widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>
<!-- {/literal} END JIVOSITE CODE -->
<?php ENDIF;?>
<!-- Yandex.Metrika counter -->
