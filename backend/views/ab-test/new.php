<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<h1>Создание нового AB теста</h1>
<?php
$form = ActiveForm::begin([
	'layout' => 'horizontal',
	'fieldConfig' => [
		'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
		'horizontalCssClasses' => [
			'label' => 'col-md-2 label-left',
			'offset' => '',
			'wrapper' => 'col-md-6',
			'error' => '',
			'hint' => '',
		],
	],
]);
?>

	<div>
		<?= $form->field($abTestForm, 'name')->textInput(['placeholder' => 'My Awesome AB Test']); ?>
		<?= $form->field($abTestForm, 'domain')->textInput(['placeholder' => 'example.com']); ?>
		<?= $form->field($abTestForm, 'bootstrap_url')->textInput(['placeholder' => '/test/start']); ?>
		<?= $form->field($abTestForm, 'a_url')->textInput(['placeholder' => '/test/variant-a']); ?>
		<?= $form->field($abTestForm, 'b_url')->textInput(['placeholder' => '/test/variant-b']); ?>
		<?= $form->field($abTestForm, 'success_url')->textInput(['placeholder' => '/test/success']); ?>

		<div class="col-md-4 col-md-offset-4">
			<?= Html::submitButton('Создать тест', [
				'class' => 'btn btn-success btn-lg btn-block'
			]); ?>
		</div>
	</div>

<?php ActiveForm::end(); ?>