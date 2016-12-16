<?php

use kartik\widgets\ActiveForm;

use yii\web\JsExpression;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
            if ($model->coordinates == '') $key = false;
              else $key = true;

              
              
              $js = '
                function(c){
                var map = jQuery(c).locationpicker("map").map;
                jQuery(c).locationpicker("map").marker.visible = true;
                              
                google.maps.event.addListener(map, "click", function(e) {
                var marker = jQuery(c).locationpicker("map").marker;
                var pos = e.latLng;
                jQuery(c).locationpicker("map").marker.visible = true;
             
                jQuery(c).locationpicker("location" , {latitude: pos.lat(), longitude: pos.lng()});
                google.maps.event.trigger(marker, "dragend");
                // e.stopPropagation();
              });
        };';
        
                  
                  
                      
            
                echo $form->field($model, 'coordinates')->widget('\pigolab\locationpicker\CoordinatesPicker' , [
                    'key' => 'AIzaSyC9PkCzTGG3Ial2tkDuSmmZvV2joFfzj0Y' ,   // require , Put your google map api key
                    'valueTemplate' => '{latitude},{longitude}' , // Optional , this is default result format
                    'options' => [
                        'style' => 'width: 100%; height: 500px',  // map canvas width and height
                   
                    ] ,
                    'enableSearchBox' => true , // Optional , default is true
                    'searchBoxOptions' => [ // searchBox html attributes
                        'style' => 'width: 90%;', // Optional , default width and height defined in css coordinates-picker.css
                    ],
                    'searchBoxPosition' => new JsExpression('google.maps.ControlPosition.TOP_LEFT'), // optional , default is TOP_LEFT
                    'mapOptions' => [
                        // google map options
                        // visit https://developers.google.com/maps/documentation/javascript/controls for other options
                        'mapTypeControl' => true, // Enable Map Type Control
                        'mapTypeControlOptions' => [
                              'style'    => new JsExpression('google.maps.MapTypeControlStyle.HORIZONTAL_BAR'),
                              'position' => new JsExpression('google.maps.ControlPosition.TOP_LEFT'),
                        ],
                        'streetViewControl' => true, // Enable Street View Control
                    ],
                    'clientOptions' => [
                        'zoom' => 2,
                        'location' => [
                            'latitude'  => 40,
                            'longitude' => -35,
                      
                        ],
                        // jquery-location-picker options
                        'radius'    => 300,
                        "markerVisible" => $key,
                        'addressFormat' => 'street_number',
                        'oninitialized' => new JsExpression($js),
                        
                    ]
                ]);
            