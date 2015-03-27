<?php
use yii\helpers\Html;
?>

<h1>Тест <?= $abTest->name; ?></h1>

<h3>Данные</h3>
<div class="well">

	<div class="row">
		<div class="col-md-3">
			Начальный URL
		</div>
		<div class="col-md-8">
			<b><?= $abTest->bootstrap_url; ?></b>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
			Первый вариант (A)
		</div>
		<div class="col-md-8">
			<b><?= $abTest->a_url; ?></b>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
			Первый вариант (B)
		</div>
		<div class="col-md-8">
			<b><?= $abTest->b_url; ?></b>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
			URL достижения цели
		</div>
		<div class="col-md-8">
			<b><?= $abTest->success_url; ?></b>
		</div>
	</div>

</div>

<h3>Скрипт отслеживания для вставки на страницу</h3>
<div class="well">
	<?=
		backend\widgets\WatchScriptWidget::widget([
			'abTest' => & $abTest
		]);
	?>
</div>