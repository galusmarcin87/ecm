<?
use app\components\mgcms\MgHelpers;
?>

<script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDeGtxbtJfB88Fgff3N_um_SjNBNAROskU&callback=initMap"
        async
        defer
></script>

<script>
    var map;
    function initMap() {
        var myLatLng = {lat: <?=MgHelpers::getSetting('contact_map_lat',false, '52.249502')?>, lng: <?=MgHelpers::getSetting('contact_map_long',false, '21.0435739')?>};
        // Create a map object and specify the DOM element for display.
        map = new google.maps.Map(document.getElementById("map"), {
            center: myLatLng,
            zoom: 15,
            scrollwheel: false,
            mapTypeControl: false,
        });

        // Create a marker and set its position.
        var marker = new google.maps.Marker({
            map: map,
            position: myLatLng,
            title: "",
            icon: 'images/point.png',
        });
    }
</script>
