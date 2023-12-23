<div class="account-menu">
    <ul class="nav flex-column">

        <li class="nav-item">
            <a class="nav-link active" aria-current="page"
               href="<?= \yii\helpers\Url::to(['account', 'tab' => 'main']) ?>"><?= Yii::t('db', 'Main panel') ?></a>
        </li>

        <li class="nav-item">
            <a class="nav-link " aria-current="page"
               href="<?= \yii\helpers\Url::to(['account', 'tab' => 'campaigns']) ?>"><?= Yii::t('db', 'Campaigns') ?></a>
        </li>

        <li class="nav-item">
            <a class="nav-link " aria-current="page"
               href="<?= \yii\helpers\Url::to(['account', 'tab' => 'investitions']) ?>"><?= Yii::t('db', 'Investitions') ?></a>
        </li>

        <li class="nav-item">
            <a class="nav-link " aria-current="page"
               href="<?= \yii\helpers\Url::to(['account', 'tab' => 'mydata']) ?>"><?= Yii::t('db', 'My data') ?></a>
        </li>

        <li class="nav-item">
            <a class="nav-link " aria-current="page"
               href="<?= \yii\helpers\Url::to(['account', 'tab' => 'password']) ?>"><?= Yii::t('db', 'Change password') ?></a>
        </li>

        <li class="nav-item">
            <a class="nav-link " aria-current="page"
               href="<?= \yii\helpers\Url::to(['account', 'tab' => 'logout33']) ?>"><?= Yii::t('db', 'Log out') ?></a>
        </li>

    </ul>
</div>
