<?php

namespace app\controllers;

use Yii;
use app\models\Okpd2;
use app\models\Okpd2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\HttpException;
use yii\filters\VerbFilter;

/**
 * Okpd2Controller implements the CRUD actions for Okpd2 model.
 */
class Okpd2Controller extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Okpd2 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $models = Okpd2::find()
            ->select('nlevel(path) as lvl, okpd2.*')
            ->andWhere(['nlevel(path)' => 1])
            ->orderBy(['path' => SORT_ASC])
            ->all();

        if(count($models) == 0 ) {
            throw new HttpException(500, 'База данных пустая.');
        }

        return $this->render('index', [
            'models' => $models,
        ]);
    }

    public function actionGetSubtree($path, $level) {
        $models = Okpd2::find()
            ->select('nlevel(path) as lvl, okpd2.*')
            ->andWhere(['nlevel(path)' => $level + 1])
            ->andWhere("path <@ '$path'")
            ->orderBy(['path' => SORT_ASC])
            ->all();

        return $this->renderAjax('_list', [
            'models' => $models,
        ]);        
    }

    public function actionGetInfo($idx) {
        $model = $this->findModel($idx);
        return $this->renderAjax('info', [
            'model' => $model,
        ]);    
    }

    public function actionGetTreeToElement($idx) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($idx);
        $parents = $model->getParents()->select('path')->asArray()->column();
        return $parents;
    }

    public function actionSearch($q = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = null;//['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $term = \mb_strtolower($q);
            $query = new \yii\db\Query;
            $query->select('idx as id, "idx" || \': \' || "name" AS text')
                ->from('okpd2')
                ->orWhere(['like', 'lower(name)', $term])
                ->orWhere(['like', 'lower(kod)', $term])
                ->orWhere(['like', 'lower(idx)', $term])
                ->orWhere(['like', 'lower(nomdescr)', $term])
                ->orderBy(['path' => SORT_ASC])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        return $out;
    }

    /**
     * Finds the Okpd2 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Okpd2 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idx)
    {
        if (($model = Okpd2::findOne(['idx' => $idx])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
