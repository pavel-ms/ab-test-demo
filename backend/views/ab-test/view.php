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

<h3>Аналитика</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Вариант страницы</th>
            <th>Показы страницы</th>
            <th>Достижение успеха</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>A</td>
            <td><?= $analytics['show']['a']; ?></td>
            <td><?= $analytics['success']['a']; ?></td>
        </tr>
        <tr>
            <td>B</td>
            <td><?= $analytics['show']['b']; ?></td>
            <td><?= $analytics['success']['b']; ?></td>
        </tr>
    </tbody>
</table>

<h3>Скрипт отслеживания для вставки на страницу</h3>
<div class="well">
	<?=
		backend\widgets\WatchScriptWidget::widget([
			'abTest' => & $abTest
		]);
	?>
</div>