<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%okpd2}}".
 *
 * @property int $id
 * @property string $name
 * @property string $razdel
 * @property int $global_id
 * @property string $idx
 * @property string $kod
 * @property string $nomdescr
 */
class Okpd2 extends \yii\db\ActiveRecord
{
    public $lvl; 

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%okpd2}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'razdel', 'path'], 'required'],
            [['global_id'], 'default', 'value' => null],
            [['global_id'], 'integer'],
            [['name'], 'string', 'max' => 1024],
            [['razdel'], 'string', 'max' => 10],
            [['idx', 'kod'], 'string', 'max' => 15],
            [['nomdescr'], 'string', 'max' => 10000],
            [['global_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'razdel' => 'Razdel',
            'global_id' => 'Global ID',
            'idx' => 'Idx',
            'kod' => 'Kod',
            'nomdescr' => 'Nomdescr',
        ];
    }

    public function getChilds() {
        return self::find()
            ->where("path <@ '{$this->path}'")
            ->andWhere(['nlevel(path)' => $this->lvl + 1])
            ->orderBy(['path' => SORT_ASC]);
    }
    public function getParents() {
        return self::find()
            ->where("path @> '{$this->path}'")
            ->orderBy(['path' => SORT_ASC]);
    }

    /**
     * {@inheritdoc}
     * @return Okpd2Query the active query used by this AR class.
     */
    public static function find()
    {
        return new Okpd2Query(get_called_class());
    }

    public static function importXml(string $fileName) {
        $dom_xml = new \SimpleXMLElement(\file_get_contents($fileName));

        $transaction = Yii::$app->db->beginTransaction();
        try{
            $i = 0;
            foreach($dom_xml->array as $item) {
                $model = new self;
                $model->name = (string)$item->Name;
                $model->global_id = $item->global_id;
                $model->razdel = (string)$item->Razdel;
                $model->idx = (string)$item->Idx;
                $model->kod = (string)$item->Kod;
                $model->nomdescr = (string)$item->Nomdescr;
                if(strlen($model->idx) == 2 && substr($model->idx, 1,1) == '.')
                {
                    $treeText = substr($model->idx, 0,1);
                } elseif(strlen($model->idx) == 4 || strlen($model->idx) == 6) {
                    $treeText = $model->idx;
                } elseif(strlen($model->idx) == 7 || strlen($model->idx) == 9) {
                    $treeText = substr($model->idx, 0, 6) . '.' . substr($model->idx, 6);
                } elseif(strlen($model->idx) == 10) {
                    $treeText = substr($model->idx, 0, 6) . '.' . substr($model->idx, 6, 3)  . '.' . substr($model->idx, 9);
                } elseif(strlen($model->idx) == 14 && substr($model->idx, 13) == '0') {
                    $treeText = substr($model->idx, 0, 6) . '.' . substr($model->idx, 6, 3)  . '.' . substr($model->idx, 9, 4);
                } elseif(strlen($model->idx) == 14 && substr($model->idx, 13) != '0') {
                    $treeText = substr($model->idx, 0, 6) . '.' . substr($model->idx, 6, 3)  . '.' . substr($model->idx, 9, 4) . '.' . substr($model->idx, 13);
                }
                $model->path = $treeText;
                //A.01.11.11.122
                if(!$model->save()) {
                    print_r($model->toArray());
                    print_r($model->errors);
                    $transaction->rollback();
                }
            }
            $transaction->commit();
            return true;
        } catch(\Exception $e) {
            $transaction->rollback();
            Yii::error($e);
        }
        
    }
}
