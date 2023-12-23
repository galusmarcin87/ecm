<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use app\components\mgcms\T;
use \app\components\mgcms\MgHelpers;

NavBar::begin([
    'brandLabel' => 'MG CMS',
    'brandUrl' => '/admin',
    'innerContainerOptions' => ['class' => 'container'],
    'options' => [
        'class' => 'navbar-default  navbar-fixed-top',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        ['label' => T::t('Sliders'), 'url' => '/backend/mgcms/slider', 'visible' => MgHelpers::checkAccess('slider', 'index')],
//        ['label' => T::t('Team Members'), 'url' => '/backend/mgcms/team-member', 'visible' => MgHelpers::checkAccess('team-member', 'index')],
        ['label' => T::t('Faq'), 'url' => '/backend/mgcms/faq', 'visible' => MgHelpers::checkAccess('faq', 'index')],
        ['label' => T::t('Projects'), 'url' => '/backend/mgcms/project', 'visible' => MgHelpers::checkAccess('project', 'index')],
        ['label' => T::t('Payments'), 'url' => '/backend/mgcms/payment', 'visible' => MgHelpers::checkAccess('payment', 'index')],
        ['label' => T::t('Articles'), 'url' => '/backend/mgcms/article', 'visible' => MgHelpers::checkAccess('article', 'index')],
        ['label' => T::t('Categories'), 'url' => '/backend/mgcms/category', 'visible' => MgHelpers::checkAccess('category', 'index')],
        ['label' => T::t('Files'), 'url' => '/backend/mgcms/file', 'visible' => MgHelpers::checkAccess('file', 'index')],
//        ['label' => T::t('Galleries'), 'url' => '/backend/mgcms/gallery', 'visible' => MgHelpers::checkAccess('gallery', 'index')],
        ['label' => T::t('Users'), 'url' => '/backend/mgcms/user', 'visible' => MgHelpers::checkAccess('user', 'index')],
        ['label' => T::t('Menu'), 'url' => '/backend/mgcms/menu', 'visible' => MgHelpers::checkAccess('menu', 'index')],
//        ['label' => T::t('Tags'), 'url' => '/backend/mgcms/tag', 'visible' => MgHelpers::checkAccess('tag', 'index')],
        ['label' => T::t('Settings'), 'visible' => MgHelpers::checkAccess('menu', 'Settings'), 'items' => [
            ['label' => T::t('Settings system'), 'url' => '/backend/mgcms/setting', 'visible' => MgHelpers::checkAccess('setting', 'index')],
            ['label' => T::t('Settings text'), 'url' => '/backend/mgcms/setting/index-text', 'visible' => MgHelpers::checkAccess('setting', 'index')],
            ['label' => T::t('Translations'), 'url' => '/backend/mgcms/translate', 'visible' => MgHelpers::checkAccess('translate', 'index')],
            ['label' => T::t('Auths'), 'url' => '/backend/mgcms/auth/manage', 'visible' => MgHelpers::checkAccess('auth', 'manage')],
        ]],
        //\app\components\mgcms\languageSwitcher::getMenuItems(),
        Yii::$app->user->isGuest ? (
        ['label' => 'Login', 'url' => ['/backend/default/login']]
        ) : (
            '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>'
        )
    ],
]);
NavBar::end();
