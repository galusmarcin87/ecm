<?
/* @var $model \app\models\ContactForm */

?>

<h1><?= Yii::t('db', 'Contact'); ?></h1>

<p>Imię i nazwisko: <?= $model->name ?></p>
<p>E-mail: <?= $model->email ?></p>
<p>Telefon: <?= $model->phone ?></p>
<p>Wiadomość: <?= $model->body ?></p>
