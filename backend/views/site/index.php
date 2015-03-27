<?php
/* @var $this yii\web\View */
$this->title = 'AB Test Admin';
use yii\helpers\Url;
?>
<div class="site-index">
	<div>
		<a href="<?= Url::toRoute('ab-test/new'); ?>" class="btn btn-primary">Создать новый тест</a>
	</div>
    Список всех созданных AB-tests
</div>
