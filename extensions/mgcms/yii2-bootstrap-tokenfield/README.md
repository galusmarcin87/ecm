Bootstrap Tokenfield
====================
Create elegant taggable fields with copy/paste and keyboard support using Bootstrap Tokefield (http://sliptree.github.io/bootstrap-tokenfield/)

Installation
===================

The preferred way to install this extension is through composer.

**Either run**
```
php composer.phar require --prefer-dist akavov/yii2-bootstrap-tokenfield : "*"
```
**or add**
```
"akavov/yii2-bootstrap-tokenfield": "*"
```

to the require section of your composer.json file.

Usage
=================
Once the extension is installed, simply use it in your code by :
```
<?= \akavov\tokenfield\Tokenfield::widget([
    'name' => 'inputName',
]);
```

**to use autocomplete**
```
<?= \akavov\tokenfield\Tokenfield::widget([
    'name' => 'inputName',
    "pluginOptions" => [
        'delimiter' => '#', // default ',' (comma)
        'showAutocompleteOnFocus' => true,
        'autocomplete' => [
            'source' => ['red','blue','green','yellow','violet','brown','purple','black','white'],
            'delay' => 100
        ],
    ],
]);
```

**to use with ActiveForm**

```
<?= $form->field($model, 'name')->widget(\akavov\tokenfield\Tokenfield::className(), [
    'pluginOptions' => [
        'delimiter' => '#', // default ',' (comma)
        'showAutocompleteOnFocus' => true,
        'autocomplete' => [
            'source' => ['red','blue','green','yellow','violet','brown','purple','black','white'],
            'delay' => 100
        ],
    ],
]); ?>
```

TODO
=============================
1. Add ability to choose between jqueryui and typeahead
2. Test
