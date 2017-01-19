$(document).ready(function(){
  var ri = JSON.parse(localStorage.getItem('ReporteAPH-ReporteInicial'));

  var latitudAmbulancia = ri.ubicacion.latitudAmbulancia;
  var longitudAmbulancia = ri.ubicacion.longitudAmbulancia;
  var latitudEmergencia = ri.ubicacion.latitudEmergencia;
  var longitudEmergencia = ri.ubicacion.longitudEmergencia;

  var map = L.map('map');
  var url = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  var myIconEmer= L.icon({
    iconUrl: '../Img/ReporteAPH/images/marker-icon.png',
    iconSize:     [45, 95],
    shadowSize:   [50, 64],
    iconAnchor:   [10, 10],
    shadowAnchor: [2, 20],
    popupAnchor:  [-3, -76]

  });
  var myIconAmbu = L.icon({
    iconUrl: '../Img/ReporteAPH/images/marker-icon23.png',
    iconSize:     [55, 110],
    shadowSize:   [50, 64],
    iconAnchor:   [22, 94],
    shadowAnchor: [4, 62],
    popupAnchor:  [-3, -76]

  });
  var route = L.Routing.control({
    language: 'sp'
  }).addTo(map);
  route.setWaypoints([L.latLng(latitudEmergencia, longitudEmergencia), L.latLng(latitudAmbulancia, longitudAmbulancia)]);

  L.marker([latitudEmergencia, longitudEmergencia]).addTo(map);
  L.marker([latitudAmbulancia, longitudAmbulancia], {icon:myIconAmbu}).addTo(map);

  L.Icon.Default.imagePath = '../Img/ReporteAPH/images';
})
