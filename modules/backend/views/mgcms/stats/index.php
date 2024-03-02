<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Auth */

$this->title = Yii::t('db', 'Statistics');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Statistics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <h2>
        <?= Yii::t('db', 'Number of companies added by day') ?>
    </h2>
    <table class="items table">
        <thead>
        <tr>
            <th><?= Yii::t('db', 'Date') ?></th>
            <th><?= Yii::t('db', 'Count') ?></th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($companiesByDay as $item): ?>
            <tr>
                <td><?= $item['date'] ?></td>
                <td><?= $item['cnt'] ?></td>
            </tr>

        <? endforeach; ?>

        </tbody>
    </table>

    <h2>
        <?= Yii::t('db', 'Number of companies added by month') ?>
    </h2>
    <table class="items table">
        <thead>
        <tr>
            <th><?= Yii::t('db', 'Month') ?></th>
            <th><?= Yii::t('db', 'Count') ?></th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($companiesByMonth as $item): ?>
            <tr>
                <td><?= $item['month'] ?></td>
                <td><?= $item['cnt'] ?></td>
            </tr>

        <? endforeach; ?>

        </tbody>
    </table>

    <h2>
        <?= Yii::t('db', 'Number of companies added by quarter') ?>
    </h2>
    <table class="items table">
        <thead>
        <tr>
            <th><?= Yii::t('db', 'Year') ?></th>
            <th><?= Yii::t('db', 'Quarter') ?></th>
            <th><?= Yii::t('db', 'Count') ?></th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($companiesByQuarter as $item): ?>
            <tr>
                <td><?= $item['year'] ?></td>
                <td><?= $item['quarter'] ?></td>
                <td><?= $item['cnt'] ?></td>
            </tr>

        <? endforeach; ?>

        </tbody>
    </table>

</div>
