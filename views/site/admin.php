<?php
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Admin Panel';
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="request-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'email',
            'message:ntext',
            'status',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{resolve}',
                'buttons' => [
                    'resolve' => function ($url, $model) {
                        if ($model->status !== 'Resolved') {
                            return Html::a('Resolve', $url, ['class' => 'btn btn-success btn-sm']);
                        }
                        return null;
                    },
                ],
            ],
        ],
    ]); ?>
</div>
