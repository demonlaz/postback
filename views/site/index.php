<?php

use yii\bootstrap\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/** @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $searchStatistics \app\models\search\StatisticsSearch */
$this->title = 'Статистика по Post Back';
?>
<div class="site-index">


    <h2><?= $this->title ?></h2>
    <br>

    <div class="body-content">
        <?php
        $form = ActiveForm::begin(['method' => 'get']);
        ?>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($searchStatistics, 'dataStart')->widget(\yii\jui\DatePicker::class, [
                    'language' => 'ru',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => [
                        'class' => 'form-control'
                    ]
                ])->label('Старт'); ?>

            </div>
            <div class="col-md-3">
                <?= $form->field($searchStatistics, 'dataEnd')->widget(\yii\jui\DatePicker::class, [
                    'language' => 'ru',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => [
                        'class' => 'form-control'
                    ]
                ])->label('Конец'); ?>

            </div>
            <div class="col-md-1" style="padding-top: 5px;">
                <br>
                <?= \yii\bootstrap\Html::submitButton('Найти', ['class' => 'btn btn-block btn-success']); ?>
            </div>
            <div class="col-md-2"style="padding-top: 5px;">
                <br>
                <?= \yii\bootstrap\Html::a('Сбросить фильтры',['index'], ['class' => 'btn btn-block btn-warning']); ?>
            </div>

        </div>

        <?php
        $form::end();
        ?>
        <div class="row">
            <div class="col-md-12">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        'campaign_id',
                        'countClick',

                        [
                            'attribute' => 'cRi',
                            'value' => function ($model) {
                                return $model->cRi === null ? 0 : $model->cRi;
                            }
                        ],
                        'countInstall',
                        'countTrial',
                        [
                            'attribute' => 'cRt',
                            'value' => function ($model) {
                                return $model->cRt === null ? 0 : $model->cRt;
                            }
                        ]

                    ]
                ]) ?>
            </div>
        </div>

    </div>
</div>
