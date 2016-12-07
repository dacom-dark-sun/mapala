<?php

use yii\bootstrap\Nav;

use yii\bootstrap\NavBar;

use yii\widgets\Menu;

?>

<div class = "col-lg-3">

 <div class="clearfix">

 </div>

 <?php

 NavBar::begin(['brandLabel' => 'Каталог',

   'brandOptions' => [

    'class' => 'visible-xs-block',

   ],

   'options' => [

    'class' => 'navbar',

   ],

  ]);

 echo Menu::widget([

   'items' => $data,

   'submenuTemplate' => "\n<ul class='nav nav-pills nav-stacked my_menu' role='menu'>\n{items}\n</ul>\n",

   //'linkTemplate' => ' < a href = "{url}" class = "href_class" id = "href_id" style = "" > {label}</a > ',

   'itemOptions'=>array('id'   =>'item_id','class'=>'nav nav-pills nav-stacked'),

   'activateParents'=>true,

   'options' => [

    'class' => 'nav nav-pills nav-stacked my_menu',

    'id'=>'navbar-id',

    'style'=>'font-size: 14px;',

    'data-tag'=>'yii2-menu',

   ],

  ]);

 NavBar::end();

 ?>

</div>
