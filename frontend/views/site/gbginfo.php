<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *  В данный момент существующие объёмы торгов не позволяют быстро конвертировать GBG в BTC. Поэтому мы продаём GBG в частном порядке с коэффициентом 0,85, и при этом ориентируемся на эталонный курс 1 мг золота.')<br>
В случае появления лучших предложений по выкупу у нас GBG или повышения ликвидности GBG на биржах мы пересмотрим данное правило по конвертации.
 */

?>

<b>1.</b> <?= Yii::t('frontend', 'For investment in SBD you need to go into your purse on Steemit and select <b> Menu </b> -> <b> Transfer </b>.') ?> <br>
<img src="/img/transfergbg.png"><br>
<b>2.</b> <?= Yii::t('frontend', 'Enter account <b>mapala.ico</b>, enter the amount and in the note specify the account name on Mapala.net, which you want to enroll tokens from this payment;') ?><br><br>
<img src="/img/transfergbg2.png"><br><br>
<b>3.</b> <?= Yii::t('frontend', 'A few minutes later the transaction will appear in your personal Mapala account;') ?> <br>
<b>4.</b> <?= Yii::t('frontend','All of our internal accounting is conducted in Bitcoins, so in enrollment investment SBD will be converted on the BTC / SBD rate.') ?><br>
<br>

<?= Yii::t('frontend', 'For each day of the week there are bonuses:</b><br><br>Saturday:  +6% <br>Sunday: +5%<br>Monday: +4%<br>Tuesday: +3%<br>Wednesay:  +2%<br>Thursday: +1%<br>Friday: 0%<br>');?>
