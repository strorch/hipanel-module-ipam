<?php

namespace hipanel\modules\ipam\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
use hipanel\filters\EasyAccessControl;
use hipanel\modules\ipam\actions\TreeGridRowsAction;
use hipanel\modules\ipam\models\Prefix;
use hiqdev\hiart\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use Yii;

class AggregateController extends CrudController
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => EasyAccessControl::class,
                'actions' => [
                    'create' => 'admin',
                    'update' => 'admin',
                    'delete' => 'admin',
                    '*' => 'ip.read',
                ],
            ],
        ]);
    }

    public function actions()
    {
        return array_merge(parent::actions(), [
            'index' => [
                'class' => IndexAction::class,
            ],
            'view' => [
                'class' => ViewAction::class,
                'data' => static function ($action) {
                    $childDataProvider = new ActiveDataProvider([
                        'query' => Prefix::find()->andWhere(['ip_cnts_eql' => $action->getCollection()->first->ip])->noParent()->limit(-1),
                    ]);

                    return ['childPrefixesDataProvider' => $childDataProvider];
                },
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('hipanel.ipam', 'Aggregate was created successfully'),
                'error' => Yii::t('hipanel.ipam', 'An error occurred when trying to add an aggregate'),
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel.ipam', 'IP address was updated successfully'),
                'error' => Yii::t('hipanel.ipam', 'An error occurred when trying to update an aggregate'),
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel.ipam', 'Aggregate was deleted successfully'),
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
            'set-note' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel.ipam', 'Description was changed'),
                'error' => Yii::t('hipanel.ipam', 'Failed to change description'),
            ],
            'get-tree-grid-rows' => [
                'class' => TreeGridRowsAction::class,
                'columns' => ['ip', 'state', 'vrf', 'utilization', 'role', 'text_note'],
            ],
        ]);
    }
}
