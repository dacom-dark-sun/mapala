<?php
/* @var $this \yii\web\View */
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use common\models\BlockChain;
/* @var $content string */


use cybercog\yii\googleanalytics\widgets\GATracking;
echo GATracking::widget([
    'trackingId' => 'UA-89551963-1',
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
<script data-skip-moving="true">
        (function(w,d,u,b){
                s=d.createElement('script');r=(Date.now()/1000|0);s.async=1;s.src=u+'?'+r;
                h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://cdn.bitrix24.ru/b3915873/crm/site_button/loader_2_svlwnm.js');
</script>
<?php ENDIF;?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter42784284 = new Ya.Metrika({
                    id:42784284,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    trackHash:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/42784284" style="position:absolute; left:-9999px;" alt=""/></div></noscript>
<!-- /Yandex.Metrika counter -->