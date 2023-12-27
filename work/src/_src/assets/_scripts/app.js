// document.addEventListener( 'DOMContentLoaded', function () {
  $(document).ready(function(){

    if($('.project-roadmap-carousel').length > 0) {
      var swiper = new Swiper(".project-roadmap-carousel", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        coverflowEffect: {
          rotate: 0,
          stretch: 80,
          scale: .7,
          depth: 100,
          modifier: 1,
          slideShadows: false,
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
      });
    }


    if($('#project-thumbnail-carousel').length > 0) {
      
      var main = new Splide( '#project-main-carousel', {
        type      : 'fade',
        rewind    : true,
        pagination: false,
      } );

      var thumbnails = new Splide( '#project-thumbnail-carousel', {
        gap         : 10,
        rewind      : true,
        pagination  : false,
        isNavigation: true,
        focus      : 'center',
        perPage: 5,
        breakpoints : {

          600: {
            perPage:3
          },
        },
      } );

      main.sync( thumbnails );
      main.mount();
      thumbnails.mount();

    }



    if($('.slider-section').length > 0) {
      new Splide( '.slider-section .splide' ).mount();
    }

    $('a.mfp').magnificPopup({
      type: 'image',
      gallery:{
        enabled:true
      }
    });


    var countdowns = document.querySelectorAll('.countdown');
      countdowns.forEach(function(element, index) {
      var efcc_countdown = new countdown({
        target: element,
        dayWord: ' days',
        hourWord: ' hours',
        minWord: ' mins',
        secWord: ' secs'
      });
    });

    var markers = [];
    var open_infobox;

    function pinSymbol(color) {
      return {
        path: 'M 20,0 C 8.9583333,0.01041667 0.01041667,8.9583333 0,20 c 0,14.354167 18.635416,32.34375 19.427084,33.104167 0.322916,0.312499 0.833332,0.312499 1.145833,0 C 21.364584,52.34375 40,34.354167 40,20 39.989583,8.9583333 31.041666,0.01041667 20,0 Z m 0,29.166667 c -5.0625,0 -9.166667,-4.104167 -9.166667,-9.166667 0,-5.0625 4.104167,-9.166667 9.166667,-9.166667 5.0625,0 9.166667,4.104167 9.166667,9.166667 0,5.0625 -4.104167,9.166667 -9.166667,9.166667 z',
        fillColor: color,
        fillOpacity: 1,
        strokeColor: '#000',
        strokeWeight: 0,
        // scale: 1,
        scaledSize: new google.maps.Size(40, 54),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(20,54)
      };
    }
    function restoreColors() {
      for (var i = 0; i < markers.length; i++) {
        markers[i].setIcon(pinSymbol(markers[i].originalColor));
      }
    }
    function changeColor(evt) {
      restoreColors();
      this.setIcon(pinSymbol('#f00'));
    }
    

    if (document.getElementById('googlemap')){


        var stylesArray = [
          {
              "featureType": "administrative",
              "elementType": "labels.text.fill",
              "stylers": [
                  {
                      "color": "#444444"
                  }
              ]
          },
          {
              "featureType": "landscape",
              "elementType": "all",
              "stylers": [
                  {
                      "color": "#f2f2f2"
                  }
              ]
          },
          {
              "featureType": "poi",
              "elementType": "all",
              "stylers": [
                  {
                      "visibility": "off"
                  }
              ]
          },
          {
              "featureType": "poi",
              "elementType": "labels.text",
              "stylers": [
                  {
                      "visibility": "off"
                  }
              ]
          },
          {
              "featureType": "road",
              "elementType": "all",
              "stylers": [
                  {
                      "saturation": -100
                  },
                  {
                      "lightness": 45
                  }
              ]
          },
          {
              "featureType": "road.highway",
              "elementType": "all",
              "stylers": [
                  {
                      "visibility": "simplified"
                  }
              ]
          },
          {
              "featureType": "road.arterial",
              "elementType": "labels.icon",
              "stylers": [
                  {
                      "visibility": "off"
                  }
              ]
          },
          {
              "featureType": "transit",
              "elementType": "all",
              "stylers": [
                  {
                      "visibility": "off"
                  }
              ]
          },
          {
              "featureType": "water",
              "elementType": "all",
              "stylers": [
                  {
                      "color": "#dbdbdb"
                  },
                  {
                      "visibility": "on"
                  }
              ]
          }
      ];

          var mapelement = document.querySelector("#googlemap");
          var lat = mapelement.dataset.lat;
          var lng = mapelement.dataset.lng;
          var zoom = parseInt(mapelement.dataset.zoom);

          var bounds = new google.maps.LatLngBounds();



          var latLng = new google.maps.LatLng(lat, lng),
                markerIcon = {
                  url: '/assets/images/mapmarker.svg',
                  scaledSize: new google.maps.Size(75, 75),
                  origin: new google.maps.Point(0, 0),
                  anchor: new google.maps.Point(38,38)
                };


          var mapOptions = {
              zoom: zoom,
              center: latLng,
              mapTypeId: google.maps.MapTypeId.ROADMAP,
              styles: stylesArray
          };

          var map = new google.maps.Map(document.getElementById("googlemap"), mapOptions);



          var $mapMarkers = $(".map-points > .map-point");
                 var sharedMarkerSettings = {

                   map: map
                 };
                 var pointCount = 0;
         $mapMarkers.each(function() {
           var $this = $(this);
           var data = $this.data();

           var url = '/themes/des/assets/images/mapmarker.svg';

           var individualMarkerSettings = {
             position: new google.maps.LatLng(data.lat, data.lng),
             target: $this,
             icon: pinSymbol('#000'),
             originalColor:'#000'
           };




           var markerSettings = jQuery.extend({}, individualMarkerSettings, sharedMarkerSettings);
           var marker = new google.maps.Marker(markerSettings);

           marker.addListener("click", changeColor);
           google.maps.event.addListener(marker, "click", function(e) {
            console.log(e);
             var target = marker.target;
             
             $(".map-points > .map-point").removeClass('active');
             target.addClass('active');
             if (target.length) {

               $('html, body, document').animate({
                 scrollTop: target.offset().top - 80
               }, 600);
               return false;
             }

          });

          markers.push(marker);
           bounds.extend(marker.position);
           pointCount++;


           
          var infobox_content = $this.data('description');
          var infobox = new InfoBox({
            content: infobox_content,

            // disableAutoPan: true,
            maxWidth: 415,
            alignBottom: false,
            pixelOffset: new google.maps.Size(-156, 10),
            zIndex: null,
            boxStyle: {
              fontSize: "14px",
              lineHeight: "1.8em",
              opacity: 1,
              zIndex: 999,
              width: "312px",
              maxHeight: "200px",
              background: "#fff",
              color: "#000",
              padding: "10px 20px",
              textAlign:'center',
              fontFamily: 'Open Sans'
            },
            // closeBoxMargin: "12px 4px 2px 2px",
            closeBoxURL: "",
            infoBoxClearance: new google.maps.Size(1, 1)
          });
          // infobox.open(map,marker);

          // marker.infobox = infobox;

          

          google.maps.event.addListener(marker, "click", function(e) {
            // DPD.closeInfobxes();

            if (open_infobox instanceof InfoBox) {
              open_infobox.close();
            }

            // if(marker.filtered_content!='') {
            //   infobox.setContent(marker.filtered_content);
            // } else {
            //   infobox.setContent(marker.content);
            // }
            infobox.open(map, this);
            open_infobox = infobox;
          });
          // google.maps.event.addListener( marker, 'click', function() {
          // 	html = "<div class='infobox'><p>"+$this.html()+"</div>";
          // 	DPD.map.panTo(marker.getPosition())
          // });


          });

          if (pointCount > 1) {
                    map.fitBounds(bounds);
                  } else if (pointCount == 1) {
                    map.setCenter(bounds.getCenter());
                    map.setZoom(13);
                  }

      }


  } );