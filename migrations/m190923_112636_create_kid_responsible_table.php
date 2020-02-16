<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%kid_responsible}}`.
 */
class m190923_112636_create_kid_responsible_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%kid_responsible}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%kid_responsible}}');
    }
}
