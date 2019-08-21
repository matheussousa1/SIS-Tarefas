 <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
 <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdM89QPA_FFa4ZwgbZoTUWuImigCVaC3Y&callback=initMap" type="text/javascript"></script> -->
<script type="text/javascript">
// $(document).ready( function () {



//     var locations = [
//       ['Bondi Beach', -33.890542, 151.274856],
//       ['Coogee Beach', -33.923036, 151.259052],
//       ['Cronulla Beach', -34.028249, 151.157507],
//       ['Manly Beach', -33.80010128657071, 151.28747820854187],
//       ['Maroubra Beach', -33.950198, 151.259302]
//     ];

//     var map = new google.maps.Map(document.getElementById('map'), {
//       zoom: 10,
//       center: new google.maps.LatLng(-33.92, 151.25),
//       mapTypeId: google.maps.MapTypeId.ROADMAP
//     });

//     var infowindow = new google.maps.InfoWindow();

//     var marker, i;

//     for (i = 0; i < locations.length; i++) {  
//       marker = new google.maps.Marker({
//         position: new google.maps.LatLng(locations[i][1], locations[i][2]),
//         map: map
//       });

//       google.maps.event.addListener(marker, 'click', (function(marker, i) {
//         return function() {
//           infowindow.setContent(locations[i][0]);
//           infowindow.open(map, marker);
//         }
//       })(marker, i));
//     }    

// });
$(document).ready(function () {
    var map;
    var elevator;
    var myOptions = {
        zoom: 10,
        center: new google.maps.LatLng(0, 0),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map($('#map_canvas')[0], myOptions);

    var addresses = ['Rua Sargento George Teles Sampaio, Crato', 'Rua Doutor Miguel Lima Verde, Crato'];

    for (var x = 0; x < addresses.length; x++) {
        $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+addresses[x]+'&sensor=false', null, function (data) {
            var p = data.results[0].geometry.location
            var latlng = new google.maps.LatLng(p.lat, p.lng);
            new google.maps.Marker({
                position: latlng,
                map: map
            });

        });
    }

});
</script>

<section id="content">
  <div class="page col-md-12">   
    <section class="boxs">
      <div class="boxs-header">
        <h3 class="custom-font hb-cyan">
          <strong>Mapa</strong></h3>
      </div>
      <div class="boxs-body">
        <div id="map_canvas" style="width: 100%; min-height: 500px;"></div>
      </div>
    </section>
  </div>
</section>
        <!--form-kantor-modal-->
  </div>
