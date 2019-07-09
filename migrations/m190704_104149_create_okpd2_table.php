<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%okpd2}}`.
 */
class m190704_104149_create_okpd2_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%okpd2}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(1024)->notNull(),
            'razdel' => $this->string(10)->notNull(),
            'global_id' => $this->integer(),
            'idx' => $this->string(15),
            'kod'=> $this->string(15),
            'nomdescr' => $this->string(10000),
        ]);
        $connection = Yii::$app->getDb();

        $connection->createCommand("alter table okpd2 add column path ltree")->execute();
        
        $this->createIndex('idx-okpd2-idx', '{{%okpd2}}', 'idx');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%okpd2}}');
    }
}
