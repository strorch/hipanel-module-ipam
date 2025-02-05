<?php

use hipanel\modules\ipam\grid\AggregateGridView;
use hipanel\modules\ipam\menus\AggregateDetailMenu;
use hipanel\modules\ipam\models\Aggregate;
use hipanel\modules\ipam\widgets\TreeGrid;
use hipanel\widgets\IndexPage;
use hipanel\widgets\MainDetails;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Aggregate $model
 * @var ActiveDataProvider[] $childPrefixesDataProvider
 */

$this->title = Html::encode($model->ip);
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel.ipam', 'Aggregates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-md-3">
        <?= MainDetails::widget([
            'title' => $this->title,
            'subTitle' => Yii::t('hipanel.ipam', 'Aggregate'),
            'menu' => AggregateDetailMenu::widget(['model' => $model], [
                'linkTemplate' => '<a href="{url}" {linkOptions}><span class="pull-right">{icon}</span>&nbsp;{label}</a>',
            ]),
        ]) ?>
        <div class="box box-widget">
            <div class="box-body no-padding">
                <?= AggregateGridView::detailView([
                    'boxed' => false,
                    'model' => $model,
                    'columns' => [
                        'family',
                        'rir',
                        'utilization',
                        'note',
                    ],
                ]) ?>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <?php $page = IndexPage::begin(['model' => $model, 'layout' => 'resourceDetail']) ?>

        <?php $page->beginContent('title') ?>
            <h4 class="box-title" style="display: inline-block;"><?= Yii::t('hipanel.ipam', 'Child prefixes') ?></h4>
        <?php $page->endContent() ?>

        <?php $page->beginContent('table') ?>
            <?php $page->beginBulkForm() ?>
                <?= TreeGrid::widget([
                    'dataProvider' => $childPrefixesDataProvider,
                    'showAll' => false,
                    'columns' => ['ip', 'state', 'vrf', 'utilization', 'role', 'text_note'],
                ]) ?>
            <?php $page->endBulkForm() ?>
        <?php $page->endContent() ?>

        <?php $page::end() ?>
    </div>
</div>
