<?php
return [
    'class' => '\skeeks\yii2\assetsAuto\AssetsAutoCompressComponent',
    'enabled' => true,
    'readFileTimeout' => 9, //Time in seconds for reading each asset file
    'jsCompress' => true, //Enable minification js in html code
    'jsCompressFlaggedComments' => true, //Cut comments during processing js
    'cssCompress' => true, //Enable minification css in html code
    'cssFileCompile' => true, //Turning association css files
    'cssFileRemouteCompile' => true, //Trying to get css files to which the specified path as the remote file, skchat him to her.
    'cssFileCompress' => true, //Enable compression and processing before being stored in the css file
    'cssFileBottom' => false, //Moving down the page css files
    'cssFileBottomLoadOnJs' => false, //Transfer css file down the page and uploading them using js
    'jsFileCompile' => true, //Turning association js files
    'jsFileRemouteCompile' => true, //Trying to get a js files to which the specified path as the remote file, skchat him to her.
    'jsFileCompress' => true, //Enable compression and processing js before saving a file
    'jsFileCompressFlaggedComments' => true, //Cut comments during processing js
    'htmlCompress' => true, //Enable compression html
    'noIncludeJsFilesOnPjax' => true, //Do not connect the js files when all pjax requests
    'htmlCompressOptions' => //options for compressing output result
    [
        'extra' => false, //use more compact algorithm
        'no-comments' => true   //cut all the html comments
    ],
];
