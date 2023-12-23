<div id="fb-root"></div>
<script>(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id))
      return;
    js = d.createElement(s);
    js.id = id;
    js.src = 'https://connect.facebook.net/<?= Yii::$app->language.'_'. strtoupper(Yii::$app->language) ?>/sdk.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-comments" data-href="<?= \yii\helpers\Url::canonical() ?>" data-num-posts="5" data-width="100%"></div>