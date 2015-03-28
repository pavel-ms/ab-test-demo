<?php
/* @var $this yii\web\View */
$this->title = 'AB Test Admin';
use yii\helpers\Url;
?>
<div class="site-index">
    <div class="row">
        <div class="col-md-4">
            <h1>Ваши AB тесты:</h1>
        </div>
        <div class="col-md-4">
            <div style="margin-top: 25px;">
                <a href="<?= Url::toRoute('ab-test/new'); ?>" class="btn btn-primary">Создать новый тест</a>
            </div>
        </div>
    </div>


    <?php if (is_array($tests)) { ?>
        <?php foreach ($tests as $t) { ?>
            <div>
                <h3>
                    <a href="<?= Url::toRoute(['ab-test/view', 'id' => $t->id]); ?>">
                        <?= $t->name; ?>
                    </a>
                </h3>
            </div>
        <?php } ?>
    <?php } ?>
</div>
