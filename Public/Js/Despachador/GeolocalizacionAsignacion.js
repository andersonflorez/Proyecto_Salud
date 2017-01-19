$(document).ready(function(){
  localStorage.removeItem("Mapa");
  localStorage.removeItem("Ambulancia");
})
var myIcon = L.icon({
  iconUrl: '../Img/Despachador/marker-icon.png',
  iconRetinaUrl: '../Img/Despachador/ambulancia-icono.png',
  iconSize: [38, 95],
  iconAnchor: [41, 81],
  popupAnchor: [-3, -76]
});


var cities = new L.LayerGroup();

//L.marker([6.2554629, -75.5745953]).bindPopup('Sena.').addTo(cities);


var map = L.map('map', {
  center: [6.2555037,-75.5775585],
  zoom: 14
});
var mbUrl = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
  attribution: '© OpenStreetMap contributors'
}).addTo(map);
var point = L.point(200,300);


sessionStorage.clickcount = 0;
var marker = null;
if (sessionStorage.clickcount != null) {
  map.on('click', function(e) {
    localStorage.setItem("Mapa","true");
    validarDatosCompletos(0,false,true);
    if (sessionStorage.clickcount == 0) {
      marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
      var lat = e.latlng.lat;
      var lng = e.latlng.lng;
      $('#TxtLatitud').val(lat);
      $('#TxtLongitud').val(lng);
      sessionStorage.clickcount = 1;
    }else{
      Notificate({
        tipo: 'info',
        titulo: 'información',
        descripcion: 'Para asignar nueva posición reinicie los marcadores.'
      });
    }
  });
}

$('#txtDireccion').keypress(function(e) {
  if (e.keyCode == 13) {

    initialize();
  }
});

var geocoder;

function initialize() {
  geocoder = new google.maps.Geocoder();
  address = document.getElementById('txtDireccion').value

  if (geocoder) {
    if (sessionStorage.clickcount == 0) {
      geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          marker = L.marker([results[0].geometry.location.lat(), results[0].geometry.location.lng()]).addTo(map);
          sessionStorage.clickcount = 1;
        

        }else{
          Notificate({
            tipo: 'info',
            titulo: 'información',
            descripcion: 'Para asignar nueva posición reinicie los marcadores.'
          });
        } });
      }

    }
  }

  $("#txtDireccion").click(function(){
    setTimeout(function(){
      map.eachLayer(function (layer) {

        if(layer._latlng != undefined){
          map.removeLayer(layer);
          sessionStorage.clickcount = 0;

        }
      });

    },10)

  });
  function reseteo(){
    map.eachLayer(function (layer) {

      if(layer._latlng != undefined){
        map.removeLayer(layer);
        sessionStorage.clickcount = 0;
        $('#TxtLatitud').val("");
        $('#TxtLongitud').val("");
        $('#txtDireccion').val("");
      }
    });
  }

L.Icon.Default.imagePath = '../Img/ReporteAPH/images';
  //  google.maps.event.addDomListener(window, 'load', initialize);
