<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\select2\Select2; // or kartik\select2\Select2
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $models array */

$this->title = 'Okpd2s';
$this->params['breadcrumbs'][] = $this->title;

app\assets\Okpd2Asset::register($this);

?>
<div class="okpd2-index">
    <div class="body-content">

        <div class="row">
            <div class="col-lg-8">
                <?= $this->render('_list', ['models' => $models]); ?>
            </div>
            <div class="col-lg-4">
                <div id="okpd2-search">
                    <?= Select2::widget([
                            'name' => 'okpd2search',
                            'options' => ['placeholder' => 'Search Okpd2 items ...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 3,
                                'ajax' => [
                                    'url' => "/okpd2/search",
                                    'dataType' => 'json',
                                    'delay' => 250,
                                    //'data' => new JsExpression('function(params) { return {q:params.term, page: params.page}; }'),
                                ],
                            ],
                            'pluginEvents' => [
                                "select2:select" => new JsExpression("function() {window.expandTree(this);}"),
                             ]
                        ]);
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>
<?php
Modal::begin([
    'id' => 'okpd2modal',
    'header' => '<h2>Описание</h2>',
    //'toggleButton' => ['label' => 'click me'],
    //'footer' => 'Низ окна',
]);
echo Html::tag('div', '', ['id' => 'okpd2txt']);
Modal::end();
?>