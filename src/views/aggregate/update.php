<?php

/* @var $this yii\web\View */
/* @var $model hipanel\modules\ipam\models\Aggregate */
/* @var $tags array */

$this->title = Yii::t('hipanel', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel.ipam', 'Aggregates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ip, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_form', compact('models', 'model')) ?>
