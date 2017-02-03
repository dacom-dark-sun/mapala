
<?php
use \yii2mod\comments;
use yii\widgets\Pjax;
use dosamigos\editable\EditableAddressAsset;
use dosamigos\editable\Editable;
use common\models\Art;
use yii\helpers\Html;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;

$meta = Art::explode_meta($model);
    foreach ($meta as $m => $name){
         switch ($m){
        
             case 'languages':
                echo '<div class="row-meta">';
                echo Yii::t('frontend', 'Languages') . ": ";
                foreach ($meta['languages'] as $lang){
                    echo $lang . ', ';
                }
                echo '</div>';
            break;
            
            case 'date_until_leave':
                echo '<div class="row-meta">';
                echo Yii::t('frontend', 'Departure date') . ": ";
                echo $meta['date_until_leave'];
                echo '</div>';
            break;
       
             case 'free':
                echo '<div class="row-meta">';
                if ($meta['free'] == 1) {
                   echo Yii::t('frontend', 'Free');
                } else {
                   echo Yii::t('frontend', 'Payment required') . ': ' . $meta['cost'];
         
                }
                echo '</div>';
            break;
       
          
            case 'contacts':
                echo '<div class="row-meta">';
                echo Yii::t('frontend', 'Contacts') . ": ";
                echo $meta['contacts'][0];
                echo '</div>';
            break;
            
        case 'coordinates':
            if ($meta['coordinates'] != ''){
                echo '<div class="row-meta">';
            
                $c = explode(',', $meta['coordinates']);
                $coord = new LatLng(['lat' => $c['0'], 'lng' => $c['1']]);
                $map = new Map([
                    'center' => $coord,
                    'zoom' => 5,
                    'width' => '100%',
                ]);
                $marker = new Marker([
                    'position' => $coord,
                    'title' => $model->title,
                ]);
                $map->addOverlay($marker);
                echo $map->display();
                
                echo 'lat: ' . $c[0] . ', ' . 'lng: ' . $c[1]; 
                echo '</div>';
                break;
         }
       }
    }

 ?>       
