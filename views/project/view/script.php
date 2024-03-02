<?
use app\models\mgcms\db\Project;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model Project */

?>
<script>
    var map;
    function initContactMap() {
        var myLatLng = { lat: <?=$model->gps_lat?>, lng: <?=$model->gps_long?> };
        // Create a map object and specify the DOM element for display.
        map = new google.maps.Map(document.getElementById("map"), {
            center: myLatLng,
            zoom: 15,
            scrollwheel: false,
            mapTypeControl: false
        });

        // Create a marker and set its position.
        var marker = new google.maps.Marker({
            map: map,
            position: myLatLng,
            title: "",
            icon: "/images/point.png"
        });
    }
</script>

<script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDeGtxbtJfB88Fgff3N_um_SjNBNAROskU&callback=initContactMap"
        async
        defer
></script>