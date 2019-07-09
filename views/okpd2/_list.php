<?php foreach ($models as $model): ?>
    <?= $this->render('_one', ['model' => $model]); ?>
<?php endforeach; ?>