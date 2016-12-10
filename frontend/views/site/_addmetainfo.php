
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
                echo '<div>';
                echo Yii::t('frontend', 'Languages') . ": ";
                foreach ($meta['languages'] as $lang){
                    echo $lang . ', ';
                }
                echo '</div>';
            break;
          
            case 'contacts':
                echo '<div>';
                echo Yii::t('frontend', 'Contacts') . ": ";
                echo $meta['contacts'][0];
                echo '</div>';
            break;
            
        case 'coordinates':
                echo '<div>';
                $c = json_decode($meta['coordinates'], true);
                $coord = new LatLng(['lat' => $c['lat'], 'lng' => $c['lng']]);
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
                
                echo 'lat: ' . $c['lat'] . ', ' . 'lng: ' . $c['lng']; 
                echo '</div>';
                break;
         }
   
    }

 ?>       
