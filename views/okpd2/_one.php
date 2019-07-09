<?php
use kartik\icons\Icon;
use yii\helpers\Html;

Icon::map($this);

?>
<div class="to-highlight level<?= $model->lvl ?>" style="padding-left: <?= ($model->lvl > 1 ? 40 : 0) ?>px;">
    <div class="pull-left">
        <?php if($model->getChilds()->count() > 0) :?>
            <?= Html::button(Icon::show('plus', ['framework' => Icon::FAS, 'class'=> 'plus-btn',]) 
                . Icon::show('minus', ['framework' => Icon::FAS,'class'=> 'minus-btn',]),
                [
                    'class'=>'js__get_sub_tree btn not_active get_tree', 
                    'data' => [
                        'path' => $model->path,
                        'level' => $model->lvl,
                    ]
                ]); ?>
        <?php else:?>
        <?= Html::button(Icon::show('circle', ['framework' => Icon::FAS,]),[
            'class' => 'btn btn-default',
            'data' => [
                'path' => $model->path,
                'level' => $model->lvl,
            ],
        ]) ; ?>
        <?php endif; ?>
    </div>
    <div class="">
        <?= $model->idx . ': ' . $model->name ?>
        <?= Html::button(Icon::show('info', ['framework' => Icon::FAS]),
            [
                //'class'=>'js__info btn btn-info', 
                'class'=>'btn btn-info js__info', 
                'data' => [
                    'idx' => $model->idx,
                    'modal-text' => $this->render('info', ['model' => $model]),
                ]            ]); ?>
    </div>
    <div class="subtree">
    </div>
</div>
<p class="clearfix"></p>
