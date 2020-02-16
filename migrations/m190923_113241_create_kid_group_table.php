<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%kid_group}}`.
 */
class m190923_113241_create_kid_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%kid_group}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'order' => $this->integer(),
            ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%kid_group}}');
    }
}
