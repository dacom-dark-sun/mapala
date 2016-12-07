/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */




//When user click to the map, we get coordinates and put it in the model (hide input)
var marker;
function placeMarker(location, map) {
change_hidden_input(location);

    if ( marker ) {
    marker.setPosition(location);
  } else {
    marker = new google.maps.Marker({
      position: location,
      map: map
    });
  }
}

//Map initialization
function initMap() {
 
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 2,
    center: {lat: 35, lng: 0 }
  });

  map.addListener('click', function(e) {
    placeMarker(e.latLng, map);
  });
}


   //this for filter cities list if user choise the country 
   


