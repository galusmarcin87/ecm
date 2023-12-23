<div id="glt-translate-trigger" class="pressed"><span class="notranslate"><?= Yii::t('db', 'Translate') ?> »</span>
</div>
<div class="tool-container tool-top toolbar-primary animate-standard translateFlags"
     style="opacity: 1; left: 20px; top: 853.406px; right: auto; position: fixed; z-index: 120; display: none;">
    <div class="tool-items">
        <a href="#" title="Spanish" class="nturl notranslate es flag Spanish tool-item" data-lang="Spanish"></a>
        <a href="#" title="English" class="nturl notranslate en flag united-states tool-item" data-lang="English"></a>
        <a href="#" title="Polish" class="nturl notranslate pl flag Polish tool-item" data-lang="Polish"></a>
    </div>
    <div class="arrow" style="left: 41.8047px; right: 50%;"></div>
</div>

<div id="google_translate_element" style="display: none" class="default-language-pl"></div>
<script type="text/javascript"
        src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script type="text/javascript">
    function googleTranslateElementInit () {
        new google.translate.TranslateElement({ pageLanguage: 'pl' }, 'google_translate_element');
    }

</script>


<script>
    function GLTFireEvent (lang_pair, lang_dest) {
        try {
            if (document.createEvent) {
                var event = document.createEvent('HTMLEvents');
                event.initEvent(lang_dest, true, true);
                lang_pair.dispatchEvent(event);
            }
            else {
                var event = document.createEventObject();
                lang_pair.fireEvent('on' + lang_dest, event);
            }
        }
        catch (e) {}
    }

    function doGoogleLanguageTranslator (lang_pair) {
        if (window.glt_request_uri) {
            return true;
        }
        if (lang_pair.value) {
            lang_pair = lang_pair.value;
        }
        if (lang_pair == '') {
            return;
        }
        var lang_dest = lang_pair.split('|')[1];
        var event;
        var classic = jQuery('.goog-te-combo');
        var simple = jQuery('.goog-te-menu-frame:first');
        if(typeof lang_text == 'undefined'){
            var lang_text = lang_dest;
        }
        var simpleValue = simple.contents().find('.goog-te-menu2-item span.text:contains(' + lang_text + ')');
        if (classic.length == 0) {for (var i = 0; i < simple.length; i++) {event = simple[i];}}
        else {for (var i = 0; i < classic.length; i++) {event = classic[i];}}
        if (document.getElementById('google_translate_element') != null) {
            if (classic.length != 0) {
                if (lang_prefix != default_lang) {
                    event.value = lang_dest;
                    GLTFireEvent(event, 'change');
                }
                else {jQuery('.goog-te-banner-frame:first').contents().find('.goog-close-link').get(0).click();}
            }
            else {
                event.value = lang_dest;
                if (lang_prefix != default_lang) {simpleValue.click();}
                else {jQuery('.goog-te-banner-frame:first').contents().find('.goog-close-link').get(0).click();}
            }
        }
    }

    jQuery(function ($) {
        $('#flags a, a.single-language, .tool-items a').
          each(function () {$(this).attr('data-lang', $(this).attr('title'));});
        $(document.body).on('click', 'a.flag', function () {
            lang_text = $(this).attr('data-lang');
            default_lang = window.glt_default_lang || $('#google_translate_element').attr('class').split('-').pop();
            lang_prefix = $(this).attr('class').split(' ')[2];
            lang_prefix == default_lang ? l() : n();

            function l () {doGoogleLanguageTranslator(default_lang + '|' + default_lang);}

            function n () {doGoogleLanguageTranslator(default_lang + '|' + lang_prefix);}

            $('.tool-container').hide();
        });
        if (window.glt_request_uri) {
            $('#google_language_translator select').
              on('change', function () {doGLTTranslate($(this).val());});
        }
        $('#glt-translate-trigger').
          on('click',
            function (event) { $('.tool-container').show();});

        <?if(Yii::$app->language != 'pl'):?>
        setTimeout(function (){
            $('.tool-items .<?=Yii::$app->language?>').click();
        },1000)


        <?endif;?>
    });
</script>
