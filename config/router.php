<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '' => '/',
        '/admin' => '/backend/default',
        [
            'encodeParams' => false,
            'pattern' => '/art/<categorySlug:.*>/<slug:[a-z0-9\-_\.]+>',
            'route' => '/article/view',
        ],
        '/art/<slug>' => '/article/view',
        [
            'encodeParams' => false,
            'pattern' => '/cat<categorySlug:.*>',
            'route' => '/article/category',
        ],
        '/gallery/<slug>' => '/gallery/view',
        '/my-account' => '/site/account',
        '/tag/<tagSlug>' => '/article/tag',
        '/buy/<slug>' => '/project/buy',
        '/login' => '/site/login',
        [
            'class' => 'geertw\Yii2\TranslatableUrlRule\TranslatableUrlRule',
            'patterns' => [
                'en' => '/project/<id>',
                'pl' => '/projekt/<id>',
            ],
            'route' => '/project/view',
        ],
        [
            'class' => 'geertw\Yii2\TranslatableUrlRule\TranslatableUrlRule',
            'patterns' => [
                'en' => '/projects',
                'pl' => '/projekty',
            ],
            'route' => '/project',
        ],
        [
            'class' => 'geertw\Yii2\TranslatableUrlRule\TranslatableUrlRule',
            'patterns' => [
                'en' => '/contact',
                'pl' => '/kontakt',
            ],
            'route' => '/site/contact',
        ],

        [
            'class' => 'geertw\Yii2\TranslatableUrlRule\TranslatableUrlRule',
            'patterns' => [
                'en' => '/about-us',
                'pl' => '/o-nas',
            ],
            'route' => '/site/about-us',
        ],
    ],
];
