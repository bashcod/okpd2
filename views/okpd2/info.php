<?php

?>
<div style="border: 1px solid gray; padding: 5px;">
    <p><b>Положение в иерархии:</b></p>
    <?php 
        $parents = $model->getParents()->all();
        $k = count($parents); 
    ?>
    <?php foreach($parents as $i => $parent): ?>
    <?php if($k-1 > $i): ?>
        <p style="padding-left:<?= ($i) * 15 ?>px; font-size: 12px;"><?= $parent->idx . ': ' . $parent->name ?></p>
    <?php else:?>
        <p style="padding-left:<?= ($i) * 15 ?>px; color: #730096; text-decoration: underline;"><b><?= $parent->idx . ': ' . $parent->name ?></b></p>
    <?php endif;?>
    <?php endforeach;?>
</div>
<div>
    <p></p>
    <p><b>Наименование:</b> <?= $model->name?></p>
    <p><b>Описание:</b> <?= $model->nomdescr?></p>
    <p><b>Раздел:</b> <?= $model->razdel?></p>
    <p><b>Global Id:</b> <?= $model->global_id?></p>
    <p><b>Idx:</b> <?= $model->idx?></p>
    <p><b>Код:</b> <?= $model->kod?></p>
</div>