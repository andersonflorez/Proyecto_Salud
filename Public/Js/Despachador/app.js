var map = L.map('map');

// Add OSM layer
var OpenStreetMap_Mapnik = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
	attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
});
OpenStreetMap_Mapnik.addTo(map);

//Check if the lat and lng parameters are set:
params = location.search.substring(1);
if( params.length > 0 && params.indexOf("lat") > -1 ){
  marker_from_url(params);
} else {
  center_map_on_location();
}

var loadedLocation = false;
function center_map_on_location(){
  //Hack for Geolocation in Firefox
  // https://github.com/Leaflet/Leaflet/issues/1070
  var isFirefox = typeof InstallTrigger !== 'undefined';

  if( isFirefox ){
    navigator.geolocation.getCurrentPosition(firefox_success, firefox_error);
    setTimeout(function(){
      if( !loadedLocation ){
        use_geoip_plugin();
      }
    }, 3000);
  } else {
    // Center on current location
    map.locate({setView: true});

    //If we can't find our current location, try the plugin:
    map.on('locationerror', function(){
      use_geoip_plugin();
    });
  }
}

function firefox_success(position){
  loadedLocation = false;
  map.setView(
    [position.coords.latitude, position.coords.longitude],
    15

  );

}

function firefox_error(error){
  use_geoip_plugin();
}

function use_geoip_plugin(){
  console.log("Location not found, trying GeoIP");
  L.GeoIP.centerMapOnPosition(map, 15);
}


function marker_from_url(params){
  var myIcon = L.icon({
    iconUrl: './js/images/marker-icon-green.png',
    iconRetinaUrl: './js/images/marker-icon-2x-green.png',
    iconSize: [25, 41],
    iconAnchor: [25, 41],
    popupAnchor: [-3, -76],
    shadowUrl: './js/images/marker-shadow.png',
  });
  lat = /lat=(-?[0-9\.]+)/.exec(params)[1];
  long = /lng=(-?[0-9\.]+)/.exec(params)[1];
  map.setView([lat,long], 20);
  marker = L.marker([lat, long], {icon: myIcon}).addTo(map);
$("#latitud").val(lat);
  $("#longitud").val(long);
}
  
marker.on('click', function(){
  map.removeLayer(marker);
});

// Add address search
var geoSearchController = new L.Control.GeoSearch({
    provider: new L.GeoSearch.Provider.OpenStreetMap(),
    position: 'topcenter', 
    showMarker: true
}).addTo(map);


setTimeout(function(){
  var d = document.getElementById("buscar").value;
  geoSearchController.geosearch(d);
  console.log(d);
}, 1000)