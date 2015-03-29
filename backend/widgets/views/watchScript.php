<?php
use	yii\helpers\Html;
echo Html::encode('
	<script type="application/javascript" src="'.\Yii::$app->params['watch_script_url'].'"></script>
	<script type="application/javascript">
		(function(w) {
			if (typeof w.$__Ab_Test === "function") {
				w.$__ab_Test = new w.$__Ab_Test({id: ' . $abTest->id . '});
			}
		})(window);
	</script>
');
