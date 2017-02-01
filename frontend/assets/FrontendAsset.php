<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use common\models\BlockChain;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/style.css',
    ];

    public $js = [
          "js/cryptico.min.js",
        'js/key_op.js',
      
         'js/crypto.js',
         'js/tr.js',
        'js/common.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\assets\Html5shiv',
    ];
     public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

     
       public function init()
    {
        parent::init();
        $blockchain = BlockChain::get_blockchain_from_locale();
        if ($blockchain == 'steem'){
            $this->js[] = "js/steem.min.js"; // dynamic file added
        }

        if ($blockchain == 'golos'){
           $this->js[] = "js/golos.min.js"; // dynamic file added
        }

        
        
    }
     
     
     
}
